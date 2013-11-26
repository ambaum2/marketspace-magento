<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Model_ApiAuthTests extends PHPUnit_Framework_TestCase
{
    public function testEncryption() {
      Mage::app();
      $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
      $text = "fuckdaklsdfjladfj8383423332d%^#&*#()sdlfjsdlkfjasdklfjasdlkjfklasdjflkasdjflksdjafkljasd823uy4892ufo;idnfwejfjv lejwvnrjrweorwer83wrnwoebnweorwbno347827535ubb5u3||||}:EROLGP{DJDJ \"sdfkds\"}}[]"; 
      //iv random iv
      $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
      $encryptedData = $apiAuth->encryptBase64($text, $iv);
      $decryptedData = $apiAuth->decryptBase64($encryptedData, $iv);
      $this->assertEquals($text, $decryptedData);
    }
    
    public function testGetMethod() {
      $request = array ( 0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'type', 5 => 'options', 6 => 'code', 7 => 'product_type');
      Mage::app();
      $apiAuth = new Alan_MspaceApi_Model_ApiAuth;      
      $object = new Alan_MspaceApi_Model_V1_Attribute;
      $class = 'Alan_MspaceApi_Model_V1_Attribute';
      $method = $apiAuth->getMethod($object, $class, $request);
      $this->assertEquals('getTypeOptions', $method);
    }
    public function testCreateMethodNameString() {
      Mage::app();
      $apiAuth = new Alan_MspaceApi_Model_ApiAuth;         
      $methodName = "get";
      $identifier = 6;
      $request = array ( 0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'type', 5 => 'options', 6 => 'code', 7 => 'product_type');
      $string = $apiAuth->createMethodNameString($methodName, $request, $identifier);
      $this->assertEquals('getTypeOptions', $string);
    }
    
    public function testGetArrayKey() {
      Mage::app();
      $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
      $keys = array('code', 'id');
      $subject = array ( 0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'type', 5 => 'options', 6 => 'code', 7 => 'product_type');
      $key = $apiAuth->getArrayKey($keys, $subject);
      $this->assertEquals('6', $key);
    }
    
    public function testGetRequestParamsArray() {
      Mage::app();
      $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
      $keys = array('code', 'id');
      $request = array ( 0 => '', 1 => 'product', 2 => 'v1', 3 => 'attribute', 4 => 'type', 5 => 'options', 6 => 'code', 7 => 'product_type');
      $params_array = $apiAuth->getRequestParamsArray($request);
      $this->assertEquals(array('code'=>'product_type'), $params_array);      
    }
}
?>