<?php
class MS_Deals_Model_Observer
{
    public $MemberDeals;
    public $Members;
    public function __construct() {
        $this->MemberDeals = new MS_Deals_Model_Memberdeals();
        $this->Members = new MS_Members_Model_Observer();
    }

    /**
     * if product is a deal validate that the
     * user is authorized to use the deal
     * @param $product
     * @return array
     */
    public function getTemplateInfo($product, $item) {
        $result = array(
            'can_add' => true,
            'is_deal' => false,
            'error' => '',
            'available_text' => 'Available',
            'show_add_to_cart' => true,
            'show_quantity' => true,
        );
        //check all other products to see if deals
        if($this->MemberDeals->isDeal($product['product_type']) && isset($product['ms_member_deals_limit'])) {
            $result['is_deal'] = true;
            if(!Mage::helper('customer')->isLoggedIn()) {
                $result['can_add'] = false;
                $result['available_text'] = "<a href='/customer/account/login'>Please Login</a>";
                $result['show_add_to_cart'] = false;
                $result['show_quantity'] = false;
                $result['error'] = 'You must register and login in to add a deal';
            } else {
                $this->MemberDeals->user_id = $this->Members->customer['entity_id'];
                $this->MemberDeals->product_id = $product['entity_id'];
                $user_deals_total = $this->MemberDeals->getTotalDeals();
                if(!$this->Members->isMember($this->Members->customer)) {
                    $result['can_add'] = false;
                    $result['available_text'] = "<a href='/join/become-member.html'>Join to Use Deal</a>";
                    $result['show_add_to_cart'] = false;
                    $result['show_quantity'] = false;
                    $result['error'] = 'You cannot use this deal. You are not a member.'; //Error: DOCAA1000' . $product['entity_id']
                } elseif($user_deals_total >= $product['ms_member_deals_limit']) {
                    $result['can_add'] = false;
                    $result['available_text'] = "Already Used Deal";
                    $result['show_add_to_cart'] = false;
                    $result['show_quantity'] = false;
                    $result['error'] = 'You cannot use this deal. You have exceeded the limit of ' . $product['ms_member_deals_limit']
                        . ' deal(s). You have used ' . $user_deals_total . ' deal(s).'; //Error: DOCAA200' . $product['entity_id']
                } elseif($item['qty'] > ($product['ms_member_deals_limit'] - $user_deals_total)) {
                    $result['can_add'] = false;
                    $result['error'] = 'You cannot add more than ' . $product['ms_member_deals_limit'] . ' deal(s) for '
                        . $product['name'];
                } else {
                  //this user was a member and is not over any limit
                }
            }
        }
        return $result;
    }
    /**
     * @param Varien_Event_Observer $observer
     * checkout_cart_save_after
     */
    public function addDealToCartSaveBefore(Varien_Event_Observer $observer) {
       //Mage::getSingleton('core/session')->addError('nothing<pre>' . $observer->getEvent()->getQuote().' </pre>item id ');
        $cart = $observer->getEvent()->getCart();
        $session = Mage::getSingleton('checkout/session');
        $cartHelper = Mage::helper('checkout/cart');
        $quote = $session->getQuote();
        $cartItems = $cart->getItems();
        foreach($cartItems as $item) {
            $product = Mage::getModel('catalog/product')->load($item['product_id']);
            $result = $this->getTemplateInfo($product, $item);
            if(!$result['can_add']) {
                $quote->removeItem($item->getId())->save();
                Mage::getSingleton('core/session')->addError($result['error']);
            }
        }
        return $this;
    }
    /**
     * after product add event
     * check if the user is logged in and is
     * a valid member before letting them add.
     * if they are a member do nothing. if they are
     * not a member and the product is deal then
     * throw an exception
     * checkout_cart_product_add_after
     * @TODO - should I really be throwing an exception?
     * item to cart
     * @param Varien_Event_Observer $observer
     * checkout_cart_product_add_after
     */
    public function addDealToCart(Varien_Event_Observer $observer)
    {
        $item = $observer->getEvent()->getQuoteItem();
        $product = Mage::getModel('catalog/product')->load($item['product_id']);
        $result = $this->getTemplateInfo($product, $item);
        if(!$result['can_add']) {
            Mage::throwException($result['error']);
        }
    }

    /**
     * on update quantity make sure
     * @param Varien_Event_Observer $observer
     * checkout_cart_update_items_after
     */
    public function updateDealQuantity(Varien_Event_Observer $observer) {
        foreach($observer->getEvent()->getInfo() as $key => $item) {
            $item = $observer->getEvent()->getCart()->getQuote()->getItemById($key);
            $product = $item->getProduct();
            $product = Mage::getModel('catalog/product')->load($product->getId());
            $result = $this->getTemplateInfo($product, $item);
            if(!$result['can_add']) {
                $item->setQty($product['ms_member_deals_limit'] - $this->MemberDeals->getTotalDeals());
                $item->save();
                Mage::getSingleton('core/session')->addError($result['error']);
            }
        }
    }
    /**
     * on checkout do the checks to make sure the
     * user is a member and for any deals add them to
     * the ms_member_deals table
     * @param Varien_Event_Observer $observer
     * sales_order_place_after
     */
    public function addDealsOnOrderComplete(Varien_Event_Observer $observer)
    {
        foreach ($observer->getEvent()->getOrder()->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $result = $this->getTemplateInfo($product, $item);
            if($result['is_deal'] && $result['can_add']) {
                $model = Mage::getModel("deals/memberdeals")
                    ->setProductId($item->getProductId())
                    ->setUserId($this->Members->customer['entity_id'])
                    ->setQuantity($item->getQtyOrdered())
                    ->setCreated(time())
                    ->setModified(time())
                    ->save();

            } elseif($result['is_deal'] && !$result['can_add']) {
                Mage::getSingleton('core/session')->addError($result['error']);
            } else {

            }
        }
    }

}
