<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class promotionsTest extends PHPUnit_Framework_TestCase
{
  function __construct()
  {
    Mage::app();
  }

  public function testJoinSalesOrderAndProductModels() {
    /*$items = Mage::getModel('sales/order_item')
      ->getCollection()
      ->addAttributeToSelect('product_id')
      ->addAttributeToSelect('product_type')
      ->addAttributeToSelect('created_at')
      ->addAttributeToSelect('updated_at')
      ;*/
    
    //$items->getSelect()->join( array('sales_order'=>Mage::getSingleton('core/resource')->getTableName('sales/order')), 'main_table.order_id = sales_order.entity_id', array('sales_order.state'));
    //$items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id', array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
    //$items->getSelect()->where('attribute_id=?', 136);
    
  }
  /*public function testgetImageRotatorImages() {
		$productData = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection()
			->addFilter('position','Slide')
			->addFilter('status', 1)
			->setOrder('item_order', 'ASC')
			->setPageSize(10)
			->getData();		
    //print_r($productData);
  }*/
  public function testgetProductGrid() {
  	$promo = new Dwg_Promotionsmgr_Block_Promotionsmgr;
		$images = $promo->productGrid();
		foreach($images as $key => $value) {
			//$_product =  Mage::getModel('catalog/product')
		}
  }
	public function testgetImageRotatorImages() {
		$promo = new Dwg_Promotionsmgr_Block_Promotionsmgr;
		$options = array('category_id' => 1);
		$images = $promo->getImageRotatorImages($options);
		$this->assertTrue(!empty($images));
		//print_r($images);
	}
	
	public function testgetAdImagesByPosition() {
		$promo = new Dwg_Promotionsmgr_Block_Promotionsmgr;
		$options = array('category_id' => 37, 'position' => 'right_top');
		$images = $promo->getAdImagesByPosition($options);
		//print_r($images);
	}
}
  