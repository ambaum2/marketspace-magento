<?php

class Dwg_Promotionsmgr_Model_Mysql4_Promotionsmgr_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract 
{
	public function _construct() 
	{
		parent::_construct();
		$this->_init('promotionsmgr/promotionsmgr');
	}
}