<?php
/**
 *  
 */

class Alan_MspaceApi_Model_V1_Sales_Orders_Owners extends Mage_Core_Model_Abstract
{
  /**
   * get a marketspace owners orders
   */
  public function get($request) {
    $method = $this->getGetRequestType($request);
    try {
      return $this->{$method}($request);
    } catch(exception $e) {
      throw Exception("Method Not Found");
    }
  }
  /**
   * get all orders for a marketspace owner
   * by marketspace_owner_id
   * @param id 
   *  mixed integer or string
   */
  public function getItem($request) {
    $items = Mage::getModel('sales/order_item')
      ->getCollection()
      ->addAttributeToSelect('product_id')
      ->addAttributeToSelect('product_type')
      ->addAttributeToSelect('created_at')
      ->addAttributeToSelect('updated_at')
      ;
    
    $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id', array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
    $items->getSelect()->where('attribute_id=?', 136);
    $items->getSelect()->where('product.value=?', $request['url_param']);
    return $items->getData();  
  }
  /**
   * get all marketspace owners orders
   */
  public function getItemCollection($request) {
    $items = Mage::getModel('sales/order_item')
      ->getCollection()
      ->addAttributeToSelect('product_id')
      ->addAttributeToSelect('product_type')
      ->addAttributeToSelect('created_at')
      ->addAttributeToSelect('updated_at')
      ;
    
    $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id', array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
    $items->getSelect()->where('attribute_id=?', 136);
    return $items->getData();
  }
  /**
   * if a single item was requested then that 
   * takes precedence. 
   */
  public function getGetRequestType($request) {
    $type = 'getItem';
    if(isset($request['params']) || !isset($request['url_param'])) {
      $type = 'getItemCollection';
    }
    return $type;
  }
  public function post($request) {
    throw new Exception("Post Not Implemented", 1);
  }
  
  public function put($request) {
    throw new Exception("Put Not Implemented", 1);
  }
 
  public function delete($request) {
    throw new Exception("Put Not Implemented", 1);
  }
}
  