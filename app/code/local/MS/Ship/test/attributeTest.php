<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class MS_Attribtute_Tests extends PHPUnit_Framework_TestCase
{
  function __construct()
  {
    Mage::app();
  }
  
  public function test_get_attribute_by_code() {
    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ms_shipping_type');
    print $attribute['attribute_id'];
  }
  
  public function test_getproductbyid() {
    $product = Mage::getModel('catalog/product')->load(47);
    print '\n' . $product["product_id"];
  }

  public function test_get_free_products_shipping() {
    $free = new MS_Ship_Model_Products_Rates_Totals_Free();
    $types = new MS_Ship_Model_Products_Rates_Types;
  }
}