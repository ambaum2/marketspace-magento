<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class ProductSqlTest extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        Mage::app();
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }


    public function testGetUsersListProductType() {
        $Uid = 2;
        /*$select = $this->conn->select()
            ->from(array('f' => 'catalog_product_flat_1'), array('type_id', "pv.value as shit", 'pi.value as imageurl'))
            ->innerJoin(array('pv' => 'catalog_product_entity_varchar'), 'pv.entity_id = f.entity_id and pv.attribute_id = 136')
            ->innerJoin(array('pi' => 'catalog_product_entity_varchar'), 'pi.entity_id = f.entity_id and pi.attribute_id = 98')
            ->where('pv.value = ?', $Uid);
        $productData = $this->conn->fetchAll($select);
        print_r($productData);*/
        $Model = new MS_Api_Model_Adapters_ProductsSql();
        $collection = $Model->GetUsersListProductType(2);
        //print_r($collection);
    }
    public function testGetProductsByType() {
        $Uid = 2;
        /*$select = $this->conn->select()
            ->from(array('f' => 'catalog_product_flat_1'), array('type_id', "pv.value as shit", 'pi.value as imageurl'))
            ->innerJoin(array('pv' => 'catalog_product_entity_varchar'), 'pv.entity_id = f.entity_id and pv.attribute_id = 136')
            ->innerJoin(array('pi' => 'catalog_product_entity_varchar'), 'pi.entity_id = f.entity_id and pi.attribute_id = 98')
            ->where('pv.value = ?', $Uid);
        $productData = $this->conn->fetchAll($select);
        print_r($productData);*/
        $Model = new MS_Api_Model_Adapters_ProductsSql();
        $collection = $Model->GetProductsByType();
        print_r(array_shift($collection));
    }
}