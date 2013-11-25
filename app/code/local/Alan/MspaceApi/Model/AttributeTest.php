<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Model_AttributeTest extends PHPUnit_Framework_TestCase
{
    public function testGetProductTypeAttribute()
    {
    		$base_product_types = array('Ticket', 'Profile – Standard', 'Profile – Request', 'Item for Sale', 'Coupon – Buy');
    		Mage::app();
				$attributeApi = new Alan_MspaceApi_Model_Attribute;
				$types = $attributeApi->getProductTypeAttribute();
				foreach($base_product_types as $type) {
					$this->assertContains($type, $types);
				}
    }
}
?>