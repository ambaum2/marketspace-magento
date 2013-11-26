<?php

class Alan_MspaceApi_Model_ApiAuth extends Mage_Core_Model_Abstract {
	
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
