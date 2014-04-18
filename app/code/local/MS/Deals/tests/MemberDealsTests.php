<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class MS_MemberDeals_Tests extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        Mage::app();
    }

    public function test_get_attribute_by_code() {
        /*$model = Mage::getModel("deals/memberdeals")
            ->setProductId(33)
            ->setUserId(2)
            ->setQuantity(2)
            ->setCreated(time())
            ->setModified(time())
            ->save();
        $this->assertGreaterThan(0, $model->getId());*/

    }

    public function test_getAllMembersDealsTotalByProductId() {
        $sql = new MS_Deals_Model_SqlAdapter();
        $result = $sql->getAllMembersDealsTotalByProductId(53, 6);
        $this->assertEquals(0, $result);
        $this->assertTrue(is_int((int)$result));
        print (int)$result;
    }

    public function test_user_add_to_cart_limit() {
        $product = Mage::getModel('catalog/product')->load(53);
        $deals = new MS_Deals_Model_Observer();
        //Mage::getSingleton('core/session')->addError("You may only purchase " . print_r($this->Members->customer, true));
        $deals->MemberDeals->user_id = $this->Members->customer['entity_id'];
        $deals->MemberDeals->product_id = $product['entity_id'];
        if(($deals->MemberDeals->getTotalDeals()) >= $product['ms_members_deals_limit']) {

            //Mage::throwException('You cannot use this deal. You have exceeded the limit of ' . $product['ms_member_deals_limit']
            //    . ' deal(s). Error: DOCAA200' . $product['entity_id'] . " " . (int)$this->MemberDeals->getTotalDeals() . ' user: ' . $this->Members->customer['entity_id']);
        }
    }
}


