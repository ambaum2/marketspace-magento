<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_Sales_Orders_OwnersTest extends PHPUnit_Framework_TestCase
{
  function __construct()
  {
    Mage::app();
  }
  public function testgetMarketSpaceOwnersOrders() {
    $salesModel=Mage::getModel("sales/order");
    $salesCollection = $salesModel->getCollection();
    
    foreach($salesCollection as $order)
    {
      //print_r($order);
      //die;
      $orders[]['order_id'] = $order->getIncrementId();
       
    }    
  }
  public function testJoinSalesOrderAndProductModels() {
    $items = Mage::getModel('sales/order_item')
      ->getCollection()
      ->addAttributeToSelect('product_id')
      ->addAttributeToSelect('product_type')
      ->addAttributeToSelect('created_at')
      ->addAttributeToSelect('updated_at')
      ;
    
    //$items->getSelect()->join( array('sales_order'=>Mage::getSingleton('core/resource')->getTableName('sales/order')), 'main_table.order_id = sales_order.entity_id', array('sales_order.state'));
    $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id', array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
    $items->getSelect()->where('attribute_id=?', 136);
    //$items->getSelect()->where('state!=?','canceled');
    //echo $items->getSelect();// will print sql query
    //print_r($items->getData()); // will print order into array format
    //print_r($collection->getSelect()->join( array('order_item'=> catalog_product_entity_varchar), 'order_item.entity_id = main_table.entity_id', array('order_item.sku')));
    
  }
  public function testgetProfileByOwnerId() {
    $product = Mage::getModel("catalog/product")
    	->getCollection()
			->addAttributeToSelect('url_path')
			->addFieldToFilter('attribute_set_id', 12)
			->addFieldToFilter('marketspace_owner', 2)
			->getFirstItem()
		;
		echo $product->getSelect();
    print_r($product->getData());

  }
}
  