<?php
/**
 *  logic for working with attributes right
 * now mainly getters
 */

class Alan_MspaceApi_Model_Attribute extends Mage_Core_Model_Abstract
{
	
	/*
	 * get the product_type attribute (custom attribute)
	 * and all of its option values
	 */
	public function getProductTypeAttribute() {
		$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'product_type');
		$attributeInfo = array();
		foreach ($attribute->getSource()->getAllOptions(true, true) as $instance) {
			$attributeInfo[$instance['value']] = $instance['label'];
		}
		 
		return $attributeInfo;
	}
	
}
	