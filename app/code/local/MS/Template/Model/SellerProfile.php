<?php

class MS_Template_Model_SellerProfile extends Mage_Core_Model_Abstract
{
    public function get($_item) {
        $result = array();
        if(!($this->isProfile($_item))) {
            $product = Mage::getModel("catalog/product")
                ->getCollection()
                ->addAttributeToSelect('name')
                ->addFieldToFilter('attribute_set_id', 12)
                ->addFieldToFilter('marketspace_owner', $_item->getMarketspaceOwner())
                ->getFirstItem();
            $result = $product->getData();
        }
        return $result;
    }
    public function getProfileAttributeSets() {
        return array(12);
    }
    public function isProfile($_item) {
        $profiles = $this->getProfileAttributeSets();
        $result = false;
        if(in_array($_item->getAttributeSetId(), $profiles)) {
            $result = true;
        }
        return true;
    }

    /**
     * does this seller profile have products
     * @param $_item
     * @return array
     */
    public function hasProducts($_item) {
        $result = array();
        if(!($this->isProfile($_item))) {
            $product = Mage::getModel("catalog/product")
                ->getCollection()
                ->addAttributeToSelect('name')
                ->addFieldToFilter('attribute_set_id', array('neq' => 12))
                ->addFieldToFilter('marketspace_owner', $_item->getMarketspaceOwner())
                ->getFirstItem();
            $result = $product->getData();
        }
        return $result;
    }
    /**
     * get profile link from a profile attribute set
     * for a given marketspace owner id
     * @param _product
     *  product model object
     * @return array
     * 	return product array
     */
    public function getProfileUrl($_product) {
        $result = array();
        if(!($this->isProfile($_product))) {
            $product = Mage::getModel("catalog/product")
                ->getCollection()
                ->addAttributeToSelect('url_path')
                ->addAttributeToSelect('caption_for_see_all_products')
                ->addAttributeToSelect('caption_for_link_to_profile')
                ->addFieldToFilter('attribute_set_id', 12)
                ->addFieldToFilter('marketspace_owner', $_product->getMarketspaceOwner())
                ->getFirstItem();
            $result = $product->getData();
        }
        return $result;
    }
    /**
     * get see all products link name
     * @param _product
     * 	product model object
     * @return array
     * return product array
     */
    public function getSeeAllProductsUrl($_product) {
        $result = array();
        $product = Mage::getModel("catalog/product")
            ->getCollection()
            ->addAttributeToSelect('url_path')
            ->addAttributeToSelect('caption_for_see_all_products')
            ->addFieldToFilter('marketspace_owner', $_product->getMarketspaceOwner())
            ->getFirstItem();
        $result = $product->getData();
        return $result;
    }
}