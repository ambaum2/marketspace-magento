<?php
class MS_Members_Model_Observer
{
    //@TODO - ideally these would be in a database
    var $membership_products = array(
        'deals' => 42,
        //'woman' => 39,
    );
    var $membership_products_data = array(
        //45 => array('id' => 45, 'max_quantity' => 1),
        42 => array('id' => 42, 'max_quantity' => 1),
    );
    var $member_types = array(
        'deals' => 1,
    );
    public $customer;

    public function __construct() {
        $this->customer = Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getTemplateInfo($product, $item) {
        $result = array('can_add' => true,
            'is_membership' => false,
            'is_deal' => false,
            'error' => '',
            'available_text' => 'Available',
            'show_add_to_cart' => true,
            'show_quantity' => true,
        );
        //do a check for membership products
        if($this->isMemberProduct($product)) {
            $result['is_membership'] = true;
            if(!Mage::helper('customer')->isLoggedIn()) {
                $result['can_add'] = false;
                $result['show_add_to_cart'] = false;
                $result['error'] = 'Please Login';
                $result['available_text'] = "<a href='/customer/account/login'>Please Login Or Register</a>";
            } elseif($item['qty'] > $this->membership_products_data[$item['product_id']]['max_quantity']) {
                $result['can_add'] = false;
                $result['error'] = 'You may not purchase multiple memberships';
                $result['available_text'] = "Available";
            } elseif(!$this->isMember($this->customer)) {
                $result['available_text'] = "Available";
            } else {
                $result['can_add'] = false;
                $result['show_add_to_cart'] = false;
                $result['error'] = 'You are already a member. Please remove item from cart.';
                $result['available_text'] = "Already a Member";
            }
        }

        return $result;
    }
    /**
     * is product a member type product
     * @param $product
     * @return bool
     */
    public function isMemberProduct($product) {
        $result = false;
        if(in_array($product['entity_id'], $this->membership_products)) {
            $result = true;
        }
        return $result;
    }
    /**
     * is the customer a member
     * @param Mage_Customer_Model_Customer $customer
     * @return bool
     */
    public function isMember(Mage_Customer_Model_Customer $customer) {
        $result = false;
        if(in_array($customer->getMsMemberTypes(), $this->member_types)) {
            $result = true;
        }
        return $result;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function MsSaveBefore(Varien_Event_Observer $observer) {
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
        //Mage::getSingleton('core/session')->addError($result['error']);
        return $this;
    }
    /**
     * On Cart Quantity update...prevent an existing member from adding a product or
     * prevent a non member from adding more than 1 (or whatever is specified)
     * @param Varien_Event_Observer $observer
     * checkout_cart_update_items_after
     */
    public function cartMembershipUpdateAfter(Varien_Event_Observer $observer) {
        foreach($observer->getEvent()->getInfo() as $key => $item) {
            $item = $observer->getEvent()->getCart()->getQuote()->getItemById($key);
            $product = $product = Mage::getModel('catalog/product')->load($item['product_id']);
            $result = $this->getTemplateInfo($product, $item);
            if(!$result['can_add']) {
                $item->setQty($this->membership_products_data[$item['product_id']]['max_quantity']);
                $item->save();
                Mage::throwException($result['error']);
            }
        }
    }
    /**
     * On Add to Cart...prevent an existing member from adding a product or
     * prevent a non member from adding more than 1 (or whatever is specified)
     * @param Varien_Event_Observer $observer
     * @todo checkout_cart_save_after may be a better observer because it may allow you to actually
     * remove the item
     */
    public function cartMembershipProductAddCheck(Varien_Event_Observer $observer) {
        $item = $observer->getEvent()->getQuoteItem();
        $product = Mage::getModel('catalog/product')->load($item['product_id']);
        $result = $this->getTemplateInfo($product, $item);
        if(!$result['can_add']) {
            Mage::throwException($result['error']);
        }
        /*if(in_array($order_item->getProductId(), $this->membership_products)) {
            if(!Mage::helper('customer')->isLoggedIn())
                Mage::throwException('You must register and login in to become a member');
            if(!$this->isMember($this->customer)) {
                if($order_item->getQty() > $this->membership_products_data[$order_item->getProductId()]['max_quantity']) {
                    $order_item->setQty($this->membership_products_data[$order_item->getProductId()]['max_quantity']);
                    $order_item->save();
                    Mage::getSingleton('core/session')->addError("You may only purchase "
                        . $this->membership_products_data[$order_item->getProductId()]['max_quantity']
                        . " item for " . $order_item->getName());
                }
            } else {
                Mage::throwException('You already a member. error id: #P0000' . $order_item->getProductId() . " ID: " . $order_item->getId());
            }
        }*/
    }

    /**
     * Add membership for non member after order is complete
     * sales_order_place_after
     * @param Varien_Event_Observer $observer
     */
    public function addMembership(Varien_Event_Observer $observer) {
        foreach ($observer->getEvent()->getOrder()->getAllItems() as $item) {
            if(in_array($item->getProductId(), $this->membership_products)) {
                if(!Mage::helper('customer')->isLoggedIn()) {
                    Mage::throwException('You must register and login in to become a member');
                }
                if(!$this->isMember($this->customer)) {
                    $customer = Mage::getSingleton('customer/session')->getCustomer();
                    $customer->setMsMemberTypes(1);
                    $customer->setMsMemberSignupDate(date('Y-m-d H:i:s', time()));
                    $customer->save();
                } else {
                    Mage::throwException('You already a member please remove membership item from cart');
                }
            }
        }
    }
}
