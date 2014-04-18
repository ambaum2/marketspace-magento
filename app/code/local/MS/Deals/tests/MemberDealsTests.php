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
        $result = $sql->getAllMembersDealsTotalByProductId(53, 5);
        $this->assertEquals(1, $result);
    }

}


