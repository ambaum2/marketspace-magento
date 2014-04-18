<?php

class MS_Deals_Model_Memberdeals extends Mage_Core_Model_Abstract
{
    public $id;
    public $product_id;
    public $user_id;
    public $created;
    public $modified;
    public $daa;
    private $deal_products = array(
        8,
        9,
    );
    protected function _construct(){
       $this->_init("deals/memberdeals");
       $this->daa = new MS_Deals_Model_SqlAdapter();
    }

    /**
     * is product type a deal type product
     * @param $product_type_id
     * @return bool
     */
    public function isDeal($product_type_id) {
        $result = false;
        if(in_array($product_type_id, $this->deal_products)) {
            $result = true;
        }
        return $result;
    }

    public function getTotalDeals() {
        try {
            $result = $this->daa->getAllMembersDealsTotalByProductId($this->product_id, $this->user_id);
        } catch(Exception $e) {
            throw new Exception("Error Processing Request");
        }
        return $result;
    }
}
	 