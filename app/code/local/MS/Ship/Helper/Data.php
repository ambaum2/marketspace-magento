<?php
class MS_Ship_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getShippingCost($_item) {
        $RateCalculate = new MS_Ship_Model_Rates;
        $RateInfo = $RateCalculate->get($_item);
        return $RateInfo;
    }
}
	 