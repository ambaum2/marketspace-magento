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
}