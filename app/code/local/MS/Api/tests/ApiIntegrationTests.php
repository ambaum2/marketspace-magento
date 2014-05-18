<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Api_Integration_Tests extends PHPUnit_Framework_TestCase {
    function __construct()
    {
        Mage::app();
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }
    public function testApiAuthentication() {
        $apiAuth = new MS_Api_Model_ApiTokenAuth();
        $secret = "a42342963283bb395a0430346e4d49ad";
        $time = time();
        $text = $secret . "|" . $time;
        $apiAuth->Iv = $apiAuth->CreateIv();
        $apiAuth->Text = $text;
        $encryptedText = $apiAuth->Encrypt();
        $ivBase64 = base64_encode($apiAuth->Iv);
        $url = str_replace("phpunit/", "", Mage::getBaseUrl() . "ms-api/product/users/2/lists/ProductType");
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
        $data = json_decode($data);
        print_r($data);
        $this->assertGreaterThan(2, count($data));
    }
}

