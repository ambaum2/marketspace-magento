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
      print_r($types);
    }
}
?>