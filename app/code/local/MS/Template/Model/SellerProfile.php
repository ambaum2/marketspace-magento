<?php

class MS_Template_Model_SellerProfile extends Mage_Core_Model_Abstract
{
    /**
     * get this products seller profile
     * name and id by marketspace owner id. even if
     * it is the seller profile
     * @param $_item
     * @return array
     */
    public function get($_item) {
        $product = Mage::getModel("catalog/product")
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('product_id')
            ->addFieldToFilter('attribute_set_id', 12)
            ->addFieldToFilter('marketspace_owner', $_item->getMarketspaceOwner())
            ->getFirstItem();
        $result = $product->getData();
        return $result;
    }
    /**
     * get this products seller profile
     * model. even if
     * it is the seller profile
     * @param $_item
     * @return array
     */
    public function getModel($_item) {
        try {
            $result = $this->get($_item);
            $result = Mage::getModel('catalog/product')->load($result['entity_id']);
        } catch(Exception $e) {
            throw new Exception("Failed to load product");
        }
        return $result;
    }

    /**
     * get the data for a seller profile given a
     * product. this will return null if seller
     * profile has no products. returns a link and
     * other data otherwise
     * @param $_product
     * @return array
     */
    public function getDisplaySellerProfileData($_product) {
        $result = array();
        if($profile = $this->getModel($_product)) {
            if($this->hasProducts($profile)) {
                $result = $this->getSeeAllProductsUrl($profile);
            }
        }
        return $result;
    }
    /**
     * return all profile attribute set ids
     * @todo put this in some data repository
     * @return array
     */
    public function getProfileAttributeSets() {
        return array(12);
    }

    /**
     * check if the item is a seller profile
     * @param $_item
     * @return bool
     */
    public function isProfile($_item) {
        $profiles = $this->getProfileAttributeSets();
        $result = false;
        if(in_array($_item->getAttributeSetId(), $profiles)) {
            $result = true;
        }
        return $result;
    }

    /**
     * does this seller profile have products
     * @param $_item
     * @return array
     */
    public function hasProducts($_item) {
        $result = array();
        if($this->isProfile($_item)) {
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