<?php
class MS_Deals_Model_Observer
{
    /*public $MemberDeals;
    public $Members;
    public function __construct() {
        $this->MemberDeals = new MS_Deals_Model_Memberdeals();
        $this->Members = new MS_Members_Model_Observer();
    }*/
    /**
     * check if the user is logged in and is
     * a valid member before letting them add.
     * if they are a member do nothing. if they are
     * not a member and the product is deal then
     * throw an exception
     * @TODO - should I really be throwing an exception?
     * item to cart
     * @param Varien_Event_Observer $observer
     */
    public function addDealToCart(Varien_Event_Observer $observer)
    {
        Mage::throwException('HITT!! must register and login in to add a deal');
        if(!Mage::helper('customer')->isLoggedIn()) {
            Mage::throwException('You must register and login in to add a deal');
        } else {
            $item = $observer->getEvent()->getQuoteItem();
            Mage::getSingleton('core/session')->addError("You may only purchase " . print_r($this->Members->customer, true));
            if($this->MemberDeals->isDeal($item['product_type']) && isset($item['ms_member_deals_limit'])) {
                if(!$this->Members->isMember($this->Members->customer)) {
                    Mage::throwException('You cannot use this deal. You are not a member. Error: 1000' . $item['product_id']);
                } /*elseif($this->MemberDeals->getTotalDeals() >= $item['ms_member_deals_limit']) {
                    Mage::throwException('You cannot use this deal. You have exceeded your limit. Error: 2000' . $item['product_id']);
                }*/
            }
        }

    }

    /**
     * on checkout do the checks to make sure the
     * user is a member and for any deals add them to
     * the ms_member_deals table
     * @param Varien_Event_Observer $observer
     */
    public function addDealsOnOrderComplete(Varien_Event_Observer $observer)
    {
        Mage::throwException('HITT!!2 must register and login in to add a deal');
    }

}
