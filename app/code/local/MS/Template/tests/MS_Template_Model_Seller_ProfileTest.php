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
    public $sellerProfile;
    public $sellerProfileModel;
    function __construct()
    {
        Mage::app();
        $this->sellerProfile = Mage::getModel('catalog/product')->load(54);
        $this->hasProducts = false;
        $this->sellerProfileModel = new MS_Template_Model_SellerProfile();
    }
    public function test_getTerms() {
        //print_r($this->sellerProfile->getData());
        print $this->sellerProfile->getMsTermsProducts();
    }
    public function test_getModel() {
        $profile_model = $this->sellerProfileModel->getModel($this->sellerProfile);
        //print_r($profile_model);
        $this->assertTrue(!empty($profile_model));
        $this->assertGreaterThan(0, $profile_model->getId());
    }
    public function test_get() {
        $sellerProfile = $this->sellerProfileModel;
        $result = $sellerProfile->get($this->sellerProfile);
        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, strlen($result['name']));
    }

    public function test_profile_has_products() {
        $result = $this->sellerProfileModel->hasProducts($this->sellerProfile);
        $has_products = false;
        if(count($result) > 0) {
            $has_products = true;
        }
        $this->assertEquals($this->hasProducts, $has_products);
    }
    public function test_get_seller_profile_url() {
        $result = $this->sellerProfileModel->getProfileUrl($this->sellerProfile);
        $this->assertTrue(!empty($result));
    }

    public function test_get_seller_profile_see_all_products_url() {
        $result = $this->sellerProfileModel->getSeeAllProductsUrl($this->sellerProfile);
        //print_r($result);
        $this->assertTrue(!empty($result));
    }
    public function test_get_profile_display_data() {
        //print_r($this->sellerProfileModel->getDisplaySellerProfileData($this->sellerProfile));
        $this->assertGreaterThan(0, count($this->sellerProfileModel->getDisplaySellerProfileData($this->sellerProfile)));
    }


    public function test_dompdf() {
        $dompdf = new DOMPDF();
        $dompdf->load_html("<p>hello</p>");
        $dompdf->render();
        $output = $dompdf->output();
        //print $output;
        $mailerover = new MS_Template_Model_Core_Email_Template_Mailer();
        //$mail_template = new MS_Template_Model_Core_Email_Template();
        $sales_order = new MS_Template_Model_Sales_Order();
    }
}
 