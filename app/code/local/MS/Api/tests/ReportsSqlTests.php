<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class ReportsSqlTest extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        Mage::app();
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }


    public function testGetAllOwnersOrders() {
        $Uid = 2;
        $Report = new MS_Api_Model_Adapters_ReportsSql();
        $collection = $Report->GetAllOwnersOrders($Uid);
        print_r($collection);
    }

    /*public function testGetOwnersOrder() {
        $Uid = 2;
        $Id = 38;
        $Report = new MS_Api_Model_Adapters_ReportsSql();
        //print_r($Report->GetOwnersOrder($Id));
    }
    public function testGetOwnersOrdersProductCount() {
        $Uid = 2;
        $Report = new MS_Api_Model_Adapters_ReportsSql();
        $collection = $Report->GetOwnersOrdersProductCount($Uid);
        //print_r($collection);
    }
    public function testGetOwnersOrdersProductsCountByMonth() {
        $Uid = 2;
        $Report = new MS_Api_Model_Adapters_ReportsSql();
        $collection = $Report->GetOwnersOrdersProductsCountByMonth($Uid, array(45, 39));
        //print_r($collection);
        //print json_encode($collection);
    }*/
}