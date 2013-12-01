<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Model_ProductRequestTest extends PHPUnit_Framework_TestCase
{
  /* given an iv and data. 
   * data going through encryption process should be exactly 
   * the same
   */
	public function testEncryption() {
	  Mage::app();
	  $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
		$text = "a42342963283bb395a0430346e4d49ad";
    $time = time();
    $text = $text . "|" . $time;
    //iv random iv
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $iv_base64 = base64_encode($iv); //encode iv so don't get an invalid header
		$encryptedData = $apiAuth->encryptBase64($text, $iv);
		$decryptedData = $apiAuth->decryptBase64($encryptedData, $iv);
    $this->assertEquals($text, $decryptedData);
	}
  /*
   * 
   * @TODO make test more robust and test the different 
   *  error responses. add a foreach and loop through an 
   * array of the scenarios. like corect secret/incorrrect secret, bad iv
   * etc
   * 
   * shoudl test for multiple params like attribute/type/data/code/product_type/param2/value2/param3/value3
   * and should test ?key=value
   */
  public function testApiAuthentication() {
    Mage::app();
    $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
    //$responseCheck = '{"":"","7":"Coupon \u2013 Buy","4":"Item for Sale","5":"Profile \u2013 Request","6":"Profile \u2013 Standard","3":"Ticket"}';
    $responseCheck = '"{\"\":\"\",\"7\":\"Coupon \\\u2013 Buy\",\"4\":\"Item for Sale\",\"5\":\"Profile \\\u2013 Request\",\"6\":\"Profile \\\u2013 Standard\",\"3\":\"Ticket\"}"';
    $secret = "a42342963283bb395a0430346e4d49ad";
    //$secret = "a42342963283bb395a0430346e4d49ad333";
    $time = time();
    $text = $secret . "|" . $time;
    
    $iv = $apiAuth->createIv();
    $encryptedText = $apiAuth->encryptBase64($text, $iv);
    $ivBase64 = base64_encode($iv);
    //echo "iv: $iv token: $encryptedText text: $text";
    $url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/type/options/code/product_type");
    //$url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/type/data/code/product_type");
    $handle = curl_init();
    $headers = array("Content-Type: application/json", "authtoken:$encryptedText", "authiv:$ivBase64");
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($handle, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLINFO_HEADER_OUT, true); //can be taken out in production only needed for curl_getinfo
    $data = curl_exec($handle);
    //$headers_raw = curl_getinfo($handle);
    curl_close($handle);
    $data = json_encode($data);
    $this->assertEquals($responseCheck, $data);  
  }
  
  public function testGetAttribute() {
  	Mage::app();
		$apiAuth = new Alan_MspaceApi_Model_ApiAuth;
    $responseCheck = '"{\"\":\"\",\"7\":\"Coupon \\\u2013 Buy\",\"4\":\"Item for Sale\",\"5\":\"Profile \\\u2013 Request\",\"6\":\"Profile \\\u2013 Standard\",\"3\":\"Ticket\"}"';
    $secret = "a42342963283bb395a0430346e4d49ad";
    $time = time();
    $text = $secret . "|" . $time;
    $iv = $apiAuth->createIv();
    $encryptedText = $apiAuth->encryptBase64($text, $iv);
    $ivBase64 = base64_encode($iv);
    //$url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attributeSet/type/options//");
    //$url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/type");
    $url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/code/1");
    $handle = curl_init();
    $headers = array("Content-Type: application/json", "authtoken:$encryptedText", "authiv:$ivBase64");
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLINFO_HEADER_OUT, true); //can be taken out in production only needed for curl_getinfo
    $data = curl_exec($handle);
    curl_close($handle);
    $data = json_encode($data);	
		print_r($data);	
		/*$entityType = Mage::getModel('catalog/product')->getResource()->getTypeId();
		$collection = Mage::getResourceModel('eav/entity_attribute_set_collection')->setEntityTypeFilter($entityType);
		$file = new SplFileObject("collection.txt", "w");
		$file->fwrite(print_r($collection,true));
		$allSet = array();
		foreach($collection as $coll){
	    $attributeSet['name'] = $coll->getAttributeSetName();
	    $attributeSet['id'] = $coll->getAttributeSetId();
	    $allSet[] = $attributeSet;
		}
		print_r($allSet);
		echo $entityType;*/
		
  }
}
?>