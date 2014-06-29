<?php

define('DOMPDF_ENABLE_AUTOLOAD', false);
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class MS_Email_Test extends PHPUnit_Framework_TestCase {
    function __construct()
    {
        Mage::app();
    }
    public function test_send_email() {
        print $_SERVER["HTTP_HOST"];
        $email = new MS_Msmtp_Model_Email("hello", array('al2@thedotworldgroup.com'), "ambaum2@gmail.com", "test email");
        //$email->SendEmail();
    }
}