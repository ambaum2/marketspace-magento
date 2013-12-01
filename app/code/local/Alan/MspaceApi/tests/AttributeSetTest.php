<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Model_ProductRequestTest extends PHPUnit_Framework_TestCase
{
  public function testGetMethod() {
    $request = array (
    	array(array('Alan_MspaceApi_Model_V1_Attribute', 'result'=>'getTypeOptions', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'type', 5 => 'options', 6 => 'code', 7 => 'product_type'))),
			array(array('Alan_MspaceApi_Model_V1_Attributeset','result'=>'entityCollection', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attributeSet', 4 => 'collection', 5 => 'collection', 6 => 'junk', 7 => ''))),
			array(array('Alan_MspaceApi_Model_V1_Attributeset','result'=>'entityCollection', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attributeset', 4 => 'Collection', 5=>'collection'))),
			array(array('Alan_MspaceApi_Model_V1_Attributeset','result'=>'entityCollection', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attributeset'))),
			array(array('Alan_MspaceApi_Model_V1_Attribute','result'=>'entityCollection', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute'))),
			array(array('Alan_MspaceApi_Model_V1_Attribute','result'=>'entityCollection', 'values'=>array(0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'set', 5=>'options'), 6=> 'id', 7=>4)),
		);
    Mage::app();
    $apiAuth = new Alan_MspaceApi_Model_ApiAuth;      
    //$object = new Alan_MspaceApi_Model_V1_Attribute;
		foreach($request as $key=>$item) {
    	$class = $item[0][0];
			$requestData = $item[0]['values'];
			$object = new $class;
    	$method = $apiAuth->getMethod($object, $class, $requestData);
    	$this->assertEquals($item[0]['result'], $method);
		}
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
    $url = str_replace("phpunit/", "", Mage::getBaseUrl() . "mspaceapi/product/v1/attributeSet/");
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
		$this->assertEquals($responseCheck, $data);		
  }
	public function testClassExists() {
		Mage::app();
		$class = array(
			'Alan_MspaceApi_Model_V1_AttributeSet',
			'Alan_MspaceApi_Model_V1_Attributeset',
			'Alan_MspaceApi_Model_v1_attributeset',
			'Alan_MspaceApi_Model_v1_attributeset',
			'Alan_MspaceApi_Model_v1_Attributeset',
			'Alan_MspaceApi_Model_v1_AttributeSet',
		);
		foreach($class as $item) {
			$this->assertTrue(class_exists($item, false));
		}
	}
}
?>