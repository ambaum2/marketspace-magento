<?php

class Dwg_Featuredprod_Model_Mysql4_Featuredprod_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract 
{
	public function _construct() 
	{
		parent::_construct();
		$this->_init('featuredprod/featuredprod');
	}
}