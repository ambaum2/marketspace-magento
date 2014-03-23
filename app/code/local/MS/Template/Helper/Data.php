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

    public function sellerProfileHasProducts($_item) {
        $result = false;
        $SellerProfile = new MS_Template_Model_SellerProfile();
        $products = $SellerProfile->hasProducts($_item);
        if(!empty($products)) {
            $result = true;
        }
        return $result;
    }

    public function getSellerProfileUrl($_item) {
        $result = false;
        $SellerProfile = new MS_Template_Model_SellerProfile();
        $profile = $SellerProfile->getProfileUrl($_item);
        if(!empty($profile)) {
            (empty($profile['caption_for_link_to_profile'])) ? $profile['caption_for_link_to_profile'] = 'View Profile' : '';
            $result = $profile;
        }
        return $result;
    }

    public function getSeeAllProductsUrl($_item) {
        $result = false;
        $SellerProfile = new MS_Template_Model_SellerProfile();

        $profile = $SellerProfile->getSeeAllProductsUrl($_item);
        if(!empty($profile)) {
            (empty($profile['caption_for_link_to_profile'])) ? $profile['caption_for_link_to_profile'] = 'View Profile' : '';
            $result = $profile;
        }
        return $result;
    }
}
	 