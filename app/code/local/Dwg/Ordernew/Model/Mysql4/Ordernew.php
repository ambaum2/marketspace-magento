<?php

/**
 * PACKT News Model specialized for MySQL4
 *
 * @category   PACKT
 * @package    PACKT_News
 * @author     Nurul Ferdous <ferdous@dynamicguy.com>
 */
class Dwg_Ordernew_Model_Mysql4_Ordernew extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        // Note that the news_id refers to the key field in your database table.
        $this->_init('ordernew/ordernew', 'sales_id');
    }

}