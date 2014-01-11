<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Product_types_Model_Product_typesTest extends PHPUnit_Framework_TestCase
{
	public function testGetAttributeSet() {
			$productData = Mage::getModel('catalog/product')
				->getCollection()
				->addAttributeToSelect('*');
				//->addFieldToFilter('attribute_set_id',$attributeSetId);		
			print_r($productData);
	}
}
	