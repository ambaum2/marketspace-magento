<?php

class MS_Api_Model_Adapters_ProductsSql extends Mage_Core_Model_Abstract {
    protected $coreResource;
    protected $conn;
    public function __construct() {
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }
    /**
     * @param $product_id
     * @param $user_id
     * @return mixed
     */
    public function GetUsersListProductType($Uid) {
        $collection = Mage::getModel('catalog/product')->getCollection();

        $collection->addAttributeToFilter('marketspace_owner', array(
            'eq' => $Uid,
        ));

        $collection->addAttributeToSelect('name', true);
        $collection->addAttributeToSelect('thumbnail', true);
        $collection->addAttributeToSelect('product_type', true);
        return $collection->getData();
    }
}