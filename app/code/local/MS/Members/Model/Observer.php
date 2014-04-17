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
     * On Cart Quantity update...prevent an existing member from adding a product or
     * prevent a non member from adding more than 1 (or whatever is specified)
     * @param Varien_Event_Observer $observer
     * getInfo() = array([product_id] => array('qty'=>x, 'before_suggest_qty' => x))
     */
    public function cartMembershipCheck(Varien_Event_Observer $observer) {
        //Mage::getSingleton('core/session')->addError("You may only purchase " . print_r($customer, true));
        foreach($observer->getEvent()->getInfo() as $key => $item) {
            $order_item = $observer->getEvent()->getCart()->getQuote()->getItemById($key);
            $product = $order_item->getProduct();
            if(in_array($product['entity_id'], $this->membership_products)) {
                if($item['qty'] > $this->membership_products_data[$product['entity_id']]['max_quantity']) {
                    $order_item->setQty($this->membership_products_data[$product['entity_id']]['max_quantity']);
                    $order_item->save();
                    Mage::getSingleton('core/session')->addError("You may only purchase "
                        . $this->membership_products_data[$product['entity_id']]['max_quantity']
                        . " item for " . $product['name']);
                    //Mage::throwException('You can only buy ' . $this->membership_products_data[$key]['max_quantity'] . ' product at a time.');
                }
            }
        }
    }
    /**
     * On Add to Cart...prevent an existing member from adding a product or
     * prevent a non member from adding more than 1 (or whatever is specified)
     * @param Varien_Event_Observer $observer
     */
    public function cartMembershipProductAddCheck(Varien_Event_Observer $observer) {
        if(!Mage::helper('customer')->isLoggedIn()) {
            Mage::throwException('You must register and login in to become a member');
        } else {
            $order_item = $observer->getEvent()->getQuoteItem();
            if(in_array($order_item->getProductId(), $this->membership_products)) {
                if(!$this->isMember($this->customer)) {
                    if($order_item->getQty() > $this->membership_products_data[$order_item->getProductId()]['max_quantity']) {
                        $order_item->setQty($this->membership_products_data[$order_item->getProductId()]['max_quantity']);
                        $order_item->save();
                        Mage::getSingleton('core/session')->addError("You may only purchase "
                            . $this->membership_products_data[$order_item->getProductId()]['max_quantity']
                            . " item for " . $order_item->getName());
                    }
                } else {
                    Mage::throwException('You already a member. error id: #P0000' . $order_item->getProductId());
                }
            }
        }
    }

    /**
     * Add membership for non member after order is complete
     * sales_order_place_after
     * @param Varien_Event_Observer $observer
     *
     */
    public function addMembership(Varien_Event_Observer $observer) {
        if(!Mage::helper('customer')->isLoggedIn()) {
            Mage::throwException('You must register and login in to become a member');
        } else {
            if(!$this->isMember($this->customer)) {
                foreach ($observer->getEvent()->getOrder()->getAllItems() as $item) {
                    if(in_array($item->getProductId(), $this->membership_products)) {
                        $customer = Mage::getSingleton('customer/session')->getCustomer();
                        $customer->setMsMemberTypes(1);
                        $customer->setMsMemberSignupDate(date('Y-m-d H:i:s', time()));
                        $customer->save();
                    }
                }
            } else {
                Mage::throwException('You already a member please remove membership item from cart');
            }
        }
    }
}
