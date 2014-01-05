<?php

class Dwg_Promotionsmgr_Model_Mysql4_Promotionsmgr extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('promotionsmgr/promotionsmgr', 'promotionsmgr_id');
	}
}