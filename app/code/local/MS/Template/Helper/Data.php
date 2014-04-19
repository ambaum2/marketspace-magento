<?php
class MS_Template_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * get theme information for a product
     * @param $product
     * @return array
     * @todo refactor the structure of MS_members and Ms_deals observers the below is not sustainable
     */
    public function getMsProductThemeInfo($product) {
        $Ms_Members = new MS_Members_Model_Observer();
        $item = array('qty' => 0); //hardcode for now
        if($Ms_Members->isMemberProduct($product)) {
            $result = $Ms_Members->getTemplateInfo($product, $item);
        } else {
            $Ms_Deals = new MS_Deals_Model_Observer();
            $result = $Ms_Deals->getTemplateInfo($product, $item);
        }

        return $result;
    }
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

    /**
     * @param $agent_string
     * @param $current_url
     */
    public function redirectUnsupportedBrowser($agent_string, $current_url) {
        if(!(strpos($current_url, "unsupported-browser") > 0)) {
            $UserBrowser = new MS_Template_Model_UserBrowser();
            if($UserBrowser->getUnsupported($agent_string)) {
                header("Location: " . Mage::getBaseUrl() . "unsupported-browser");
            }
        }
    }
}
	 