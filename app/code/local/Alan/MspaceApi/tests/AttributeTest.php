<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Model_AttributeTest extends PHPUnit_Framework_TestCase
{
  public function testGetProductTypeAttribute()
  {
  		$base_product_types = array('Ticket', 'Profile – Standard', 'Profile – Request', 'Item for Sale', 'Coupon – Buy');
  		Mage::app();
			$attribute = new Alan_MspaceApi_Model_V1_Attribute;
			$types = $attribute->getTypeOptions('product_type');
			foreach($base_product_types as $type) {
				$this->assertContains($type, $types);
			}
  }
  
  public function testGetTypeData() {
    Mage::app();
    $attribute = new Alan_MspaceApi_Model_V1_Attribute;
    $types = $attribute->getTypeData('short_description');     
    //print_r($types);
  }
  public function testGetAttribute() {
  	//$file = new SplFileObject("collection.txt", "w");
		//$file->fwrite(print_r($collection,true));
  	Mage::app();
		$apiAuth = new Alan_MspaceApi_Model_ApiAuth;
    $responseCheck = '"{\"4\":\"Default\"}"';
    $secret = "a42342963283bb395a0430346e4d49ad";
    $time = time();
    $text = $secret . "|" . $time;
    $iv = $apiAuth->createIv();
    $encryptedText = $apiAuth->encryptBase64($text, $iv);
    $ivBase64 = base64_encode($iv);
    //$url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/set/options/id/4");
    //$url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/type/data/code/product_type");
    $url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attribute/type/data/code/tax_class_id");
    
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
		$this->assertEquals($responseCheck, $data);
  }
}
?>