<?php

/**
 * PACKT News Model
 *
 * @category   PACKT
 * @package    PACKT_News
 * @author     Nurul Ferdous <ferdous@dynamicguy.com>
 */
class Dwg_Ordernew_Model_Ordernew extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('ordernew/ordernew');
    }

}