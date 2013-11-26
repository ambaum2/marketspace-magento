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
			$text = "fuckdaklsdfjladfj8383423332d%^#&*#()"; 
      //iv random iv
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
			$encryptedData = $apiAuth->encryptBase64($text, $iv);
			$decryptedData = $apiAuth->decryptBase64($encryptedData, $iv);
      $this->assertEquals($text, $decryptedData);
		}
}
?>