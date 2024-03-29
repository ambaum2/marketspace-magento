<?php

/**
 * Class MS_Deals_Model_SqlAdapter
 * please read http://www.vortexcommerce.com/blog/magento-direct-sql/
 * for information on how to use zend queries
 */
class MS_Deals_Model_SqlAdapter extends Mage_Core_Model_Abstract {
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
    public function getAllMembersDealsTotalByProductId($product_id, $user_id) {
        $select = $this->conn->select()
            ->from(array('d' => $this->coreResource->getTableName('deals/memberdeals')), new Zend_Db_Expr('SUM(d.quantity)'))
            ->where('d.user_id = ?', $user_id)
            ->where('d.product_id = ?', $product_id);
        $count = $this->conn->fetchOne($select);
        return (int)$count;
    }
}