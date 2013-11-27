<?php

class Alan_MspaceApi_Model_ApiAuth extends Mage_Core_Model_Abstract {
	var $entityRequestPosition = 4; //urls will be in the format frontname/controller/version/entity/ so entity must be at position 4
	var $request_identifiers = array('code', 'id');
  private $error_code = 1100;
  protected static $secret = "a42342963283bb395a0430346e4d49ad";
  /**
   * validate the given token by unencrypting and inspecting the secret key
   * to make sure it matches the secret key on file
   * 
   * @param authtoken | string
   *  the encrypted secret key and timestamp to be 
   *  validated
   * @param iv | string
   *  base64 encoded iv used to encrypt the token
   * @return boolean
   *  true if token is valid false otherwise
   */
  public function validateAuthToken($authtoken, $iv) {
    $ivBase64Decoded = base64_decode($iv);
    $unencrypted = $this->decryptBase64($authtoken, $ivBase64Decoded);
    $authInfo = $this->getAuthInfoArray($unencrypted);
    if(isset($authInfo[1])) {
      if($authInfo[0] == self::$secret) {
        if((time() - $authInfo[1]) < 600) {
          return true;
        } else {
          throw new Exception("Request Token Expired Error ", 1);
        }
      }
    } else {
      throw new Exception("Bad Token 1100t", 1);
    }
    return false;
    //throw new Exception("Bad Token " . $authInfo[0], 1);
  }
  
  /**
   * return an array of secret and timestamp from
   * unencrypted auth token
   * @param text
   * @return array
   */
  protected function getAuthInfoArray($text) {
    $authInfo = explode("|", $text);
    
    return $authInfo;
  }
	/**
	 * decrypt data
	 * data will come over url encoded 
	 * but no need to urldecode that happens
	 * automatically with arg
	 * @param string 
	 * 	base64 encoded string encrypted 
	 * 	with ecb
	 * @return string
	 * return decrypted string
	 */
	public function decryptBase64($text, $iv, $key = "18a1a224151413a53056b609a85d1085") { 
	  return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($text), MCRYPT_MODE_CBC, $iv));

	}
	
	/**
	 * urlencrypt data
	 *
	 * @param data | mixed
	 * @return string
	 * 	returns a base 64 encoded string from secret key
	 */
	public function encryptBase64($text, $iv, $key = "18a1a224151413a53056b609a85d1085") { 
	  return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_CBC, $iv)));	  	
	}
	/**
	 *	encrypt data with a timestamp, ECB, and 
	 * then base64 encode and urlencode
	 * 
	 * @param requestData | array or object
	 * 	array or object keyed according to api methods 
	 * instructions
	 * @return string
	 * 	encrypted baset64 and url encoded string
	 */
	public function encryptApiRequest($request_data) {
    $request_data['request_time'] = time();
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
		$data = json_encode($request_data);
		$base64_encoded_data = $this->encryptBase64($data, $iv);
    $data_url_encode = urlencode($base64_encoded_data);
		return $data_url_encode;
	}
  /**
   * find class method if it exists from the 
   * data given in the request
   * 
   * @param object | object
   *  the object found
   * @param class | string
   *  the class the object is in
   * @param request | array
   *  array of url params
   * @return string or boolean
   *  if method is found return the method name
   *  else return false or throw an exception
   */
  public function getMethod($object, $class, $request) {
    if($identifierPosition = $this->getArrayKey($this->request_identifiers, $request)) {
      $methodName = "get"; //assume all are get right now later change this
      $methodName = $this->createMethodNameString($methodName, $request, $identifierPosition);
      if(method_exists($object, $methodName)) {
        return $methodName;
      } else {
        throw new Exception("There was a method error when processing your request please contact the admin: error 100", 1);        
      }
    } else { //no code or id is found then return a collection 
      //put in logic to find a collection
    }
    
    return false; //bad data - may want an exception
  }
  /**
   * create iv for encryption
   * @return string
   *  return an iv 
   */
  public function createIv() {
    return mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
  }
  /**
   * find class method if it exists from the 
   * data given in the request
   * 
   * @param identifierPosition | integer
   *  how are we requesting the information by code, id, etc
   * @param methodName | string
   *  name of method that we are creating
   * @param request | array
   *  array of url params
   * @return string 
   *  name of method
   */  
  public function createMethodNameString(&$methodName, $request, $identifierPosition) {
    
    for($i=$this->entityRequestPosition; $i < $identifierPosition; $i++) {
      $methodName .= ucfirst($request[$i]); //uppercase first letter since we use Camel notation
    }
    return $methodName;
  }
  /**
   * get request params as key value pairs
   * request parameters will be everything 
   * after identifiers code or id (at this time)
   * @param request | array
   *  array of url params
   * @return array
   *  return an associative array of key
   *  value pairs of any parameters including and 
   *  after code
   */
  public function getRequestParamsArray($request) {
    if($key = $this->getArrayKey($this->request_identifiers, $request)) {
      try {
        $params_array = array();
        //loop through and store key value pairs in array  
        for($i = $key; $i < count($request); $i = $i + 2) {
          $params_array[$request[$i]] = $request[$i + 1]; //key and value ($key + 1)
        }
        return $params_array;
      } catch(exception $e) {
        throw new Exception("url parameters malformed or odd number of parameters", 1);       
      }
    }
    return false;    
  }
  /**
   * find an array key 
   * @param keys | array
   * @param subject | array
   * @return integer or boolean
   *  return the key of the first
   *  array value found or false 
   * otherwise
   */
  public function getArrayKey($keys, $subject) {
    foreach($keys as $key) {
      if($key = array_search($key, $subject))
        return $key;
    }
    return false;
  }
	/**
	 *	encrypt data with a timestamp, ECB, and 
	 * then base64 encode and urlencode
	 * 
	 * @param requestData | array or object
	 * 	array or object keyed according to api methods 
	 * instructions
	 * @param iv | int
	 * 	the iv used to encode the request
	 * @return string
	 * 	encrypted baset64 and url encoded string
	 */
	public function decryptApiRequest($request_data, $iv) {
		
		$data = json_encode($request_data);
		$base64_encoded_data = $this->encryptBase64($data, $request_data['iv']);
    $data_url_encode = urlencode($base64_encoded_data);
		return $data_url_encode;
	}
	/**
	 * get drupal session cookie. This 
	 * must be run on the same domain as the
	 * drupal site and with https
	 * 
	 * @param cookie | array
	 * 	cookie array to loop through and find
	 * the drupal session cookie
	 */
	public function getDrupalSessionCookie($cookie) {
		foreach($_COOKIE as $key=>$val) {
		
		  if(strstr($key, "SSESS")) { //if cookei contains ssess then it is the sid so that value is what we will check against aaoinfo.org's session table
		     //if key exists check against members site with rest service (curl)
		    $timestamp = time();
		
		    $data = $val . "|" . $timestamp;
		    $encrypted = mcrypt_encrypt(MCRYPT_BLOWFISH, '18a1a224151413a53056b609a85d1085', $data, MCRYPT_MODE_ECB, null);
		    $base64_encoded_data = base64_encode($encrypted);
		    $data_url_encode = urlencode($base64_encoded_data);
		    //send data by curl
		
		    $url = "https://www.cms.communitymarketspace.com/marketspace/authorize/authcheck?sso_request=" . $data_url_encode;
		    $handle = curl_init();
		    curl_setopt($handle, CURLOPT_URL, $url);
		    curl_setopt($handle, CURLOPT_HTTPHEADER, array('aaoic:'));
		    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		    $data = curl_exec($handle);
		    curl_close($handle);
		    $user_data = json_decode($data);
		     //if good then redirect back to magento with encryped timestamped key in url (the cms will then check it)
		  }
		}		
	}
}
