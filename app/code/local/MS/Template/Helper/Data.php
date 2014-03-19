<?php
class MS_Template_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getSellerProfile($_item) {
        $SellerProfile = new MS_Template_Model_SellerProfile();
        $result = "Community MarketSpace";
        $ProfileName = $SellerProfile->get($_item);
        if(!empty($ProfileName)) {
            $result = $ProfileName['name'];
        }
        return $result;
    }

}
	 