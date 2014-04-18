<?php
class MS_Deals_Model_Observer
{
    public $MemberDeals;
    public $Members;
    public function __construct() {
        $this->MemberDeals = new MS_Deals_Model_Memberdeals();
        $this->Members = new MS_Members_Model_Observer();
    }

    public function addDealToCartSaveAfter(Varien_Event_Observer $observer) {
        Mage::getSingleton('core/session')->addError('nothing<pre>' . $observer->getEvent()->getQuote().' </pre>item id ');
        $cart = $observer->getEvent()->getCart();
        $session = Mage::getSingleton('checkout/session');
        $cartHelper = Mage::helper('checkout/cart');
        $quote = $session->getQuote();
        $cartItems = $cart->getItems();
        foreach($cartItems as $item) {
            $cartHelper->getCart()->removeItem($item->getItemId())->save();
            /*$cart->removeItem($item->getItemId());
            $quote->removeItem($item->getId())->save();
            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
            $cart->init();*/
        }
    }
    /**
     * after product add event
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
        $item = $observer->getEvent()->getQuoteItem();
        $product = Mage::getModel('catalog/product')->load($item['product_id']);
        //Mage::getSingleton('core/session')->addError("You may only purchase " . print_r($this->Members->customer, true));
        if($this->MemberDeals->isDeal($product['product_type']) && isset($product['ms_member_deals_limit'])) {
            if(!Mage::helper('customer')->isLoggedIn())
                Mage::getSingleton('core/session')->addError('You must register and login in to add a deal');
            $this->MemberDeals->user_id = $this->Members->customer['entity_id'];
            $this->MemberDeals->product_id = $product['entity_id'];
            if(!$this->Members->isMember($this->Members->customer)) {
                Mage::getSingleton('core/session')->addError('You cannot use this deal. You are not a member. Error: 1000' . $product['entity_id']);
            } elseif($this->MemberDeals->getTotalDeals() >= $product['ms_members_deals_limit']) {
                $cartHelper = Mage::helper('checkout/cart');
                $cartHelper->getCart()->removeItem($item->getId())->save();
                Mage::getSingleton('core/session')->addError('You cannot use this deal. You have exceeded your limit. Error: 2000' . $product['entity_id']);
            }
        }
        Mage::getSingleton('core/session')->addError('nothing' . $item['product_id'] . ' item id ' . $item->getId());
    }

    /**
     * on update quantity make sure
     * @param Varien_Event_Observer $observer
     */
    public function updateDealQuantity(Varien_Event_Observer $observer) {
        foreach($observer->getEvent()->getInfo() as $key => $item) {
            $quote_item = $observer->getEvent()->getCart()->getQuote()->getItemById($key);
            $product = $quote_item->getProduct();
            $product = Mage::getModel('catalog/product')->load($product->getId());
            if($this->MemberDeals->isDeal($product['product_type']) && isset($product['ms_member_deals_limit'])) {
                $this->MemberDeals->user_id = $this->Members->customer['entity_id'];
                $this->MemberDeals->product_id = $product->getId();
                if(($product['ms_member_deals_limit'] - $this->MemberDeals->getTotalDeals()) > 0) {
                    $quote_item->setQty($product['ms_member_deals_limit'] - $this->MemberDeals->getTotalDeals());
                    $quote_item->save();
                    Mage::getSingleton('core/session')->addError("You have  "
                        . $product['ms_member_deals_limit'] . ' deals remaining. item quote id <pre>' . print_r($item, true) . "</pre>"
                        . " for " . $product['name']);
                } elseif($this->MemberDeals->getTotalDeals() >= $product['ms_member_deals_limit']) {
                    $cartHelper = Mage::helper('checkout/cart');
                    $cartHelper->getCart()->removeItem($key)->save();
                    Mage::getSingleton('core/session')->addError("You are over the limit of  "
                        . $product['ms_member_deals_limit'] . ' deals. item quote id <pre>' . print_r($item, true) . "</pre>"
                        . " for " . $product['name']);
                }
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
        foreach ($observer->getEvent()->getOrder()->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            if($this->MemberDeals->isDeal($product['product_type']) && isset($product['ms_member_deals_limit'])) {
                if(!Mage::helper('customer')->isLoggedIn())
                    Mage::throwException('You must register and login in to become a member before using deals');

                if($this->Members->isMember($this->Members->customer)) {
                    $model = Mage::getModel("deals/memberdeals")
                        ->setProductId($item->getProductId())
                        ->setUserId($this->Members->customer['entity_id'])
                        ->setQuantity($item->getQtyOrdered())
                        ->setCreated(time())
                        ->setModified(time())
                        ->save();
                } else {
                    Mage::throwException('You are not a member please register for a membership');
                }
            }
        }
    }

}
