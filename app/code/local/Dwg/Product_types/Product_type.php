<?php

class Dwg_Product_types_Model_Product_types extends Mage_Core_Model_Abstract
{
	public function _construct() {
		parent::_construct();
		$this->_init('dwg_product_types/template');
	}	
}
	