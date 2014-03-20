<?php
/**
 * Created by PhpStorm.
 * User: abaum
 * Date: 3/18/14
 * Time: 5:57 PM
 */
require '../dompdf/vendor/autoload.php';
define('DOMPDF_ENABLE_AUTOLOAD', false);
require_once '../dompdf/vendor/dompdf/dompdf/dompdf_config.inc.php';
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class MS_Template_Model_Seller_ProfileTest extends PHPUnit_Framework_TestCase {
    function __construct()
    {
        Mage::app();
    }

    public function test_get() {
        $_item = Mage::getModel('catalog/product')->load(54);
        $Seller_Profile = new MS_Template_Model_SellerProfile();
        $result = $Seller_Profile->get($_item);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, strlen($result['name']));
    }
    public function test_get_profile_helper() {
        $_item = Mage::getModel('catalog/product')->load(54);
        $this->assertGreaterThan(0, strlen(Mage::helper('ms_template')->getSellerProfile($_item)));
        print Mage::helper('ms_template')->getSellerProfile($_item);
    }

    public function test_dompdf() {
        $dompdf = new DOMPDF();
        $dompdf->load_html("<p>hello</p>");
        $dompdf->render();
        $output = $dompdf->output();
        //print $output;
        $mailerover = new MS_Template_Model_Core_Email_Template_Mailer();
        $mail_template = new MS_Template_Model_Core_Email_Template();
        $sales_order = new MS_Template_Model_Sales_Order();
    }
}
 