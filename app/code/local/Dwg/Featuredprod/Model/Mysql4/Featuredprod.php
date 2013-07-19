<?php

class Dwg_Featuredprod_Model_Mysql4_Featuredprod extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('featuredprod/featuredprod', 'featuredprod_id');
	}
}