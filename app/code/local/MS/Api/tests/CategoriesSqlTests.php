<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class CategoriesSqlTest extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        Mage::app();
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }

    public function testGetCategoriesNestedTree() {
        $Model = new MS_Api_Model_Adapters_CategoriesSql();
        $collection = $Model->GetCategoriesTree(1, array(98, 57, 91, 51), 10);
        //print_r($collection);
    }
    public function testGetCategoriesTree() {
        $Uid = 2;
        /*$select = $this->conn->select()
            ->from(array('f' => 'catalog_product_flat_1'), array('type_id', "pv.value as shit", 'pi.value as imageurl'))
            ->innerJoin(array('pv' => 'catalog_product_entity_varchar'), 'pv.entity_id = f.entity_id and pv.attribute_id = 136')
            ->innerJoin(array('pi' => 'catalog_product_entity_varchar'), 'pi.entity_id = f.entity_id and pi.attribute_id = 98')
            ->where('pv.value = ?', $Uid);
        $productData = $this->conn->fetchAll($select);
        print_r($productData);*/
        $Model = new MS_Api_Model_Adapters_CategoriesSql();
        $category = Mage::getModel('catalog/category');
        $category->load(49);
        $collection = $Model->GetCategoryFirstChildrenList($category);
        foreach($collection as $cat) {
            //print $cat['name'] . ' path: ' . $cat['url_path'] . "\n";
        }
    }
    public function testGetCategoriesMenu() {
      $sub_category_2 = Mage::getModel('catalog/category')->getCollection()
        ->addAttributeToSelect(array('name', 'url_path', 'thumbnail'))
       // ->addAttributeToFilter('parent_id',$cat->getId()) //$link["id"])
        ->addAttributeToFilter('is_active',1)
        ->addAttributeToFilter('level',2)
        ->setPageSize(1)
        ->addAttributeToSort('position','ASC');
      print count($sub_category_2);
      print "\n product count| " . $sub_category_2->getProductCount();
    }
}