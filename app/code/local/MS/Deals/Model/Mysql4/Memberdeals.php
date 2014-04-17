<?php
class MS_Deals_Model_Mysql4_Memberdeals extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("deals/memberdeals", "id");
    }
}