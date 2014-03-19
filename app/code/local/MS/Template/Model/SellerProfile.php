<?php

class MS_Template_Model_SellerProfile extends Mage_Core_Model_Abstract
{
    public function get($_item) {
        $result = array();
        if($_item->getAttributeSetId() != 12) {
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
}