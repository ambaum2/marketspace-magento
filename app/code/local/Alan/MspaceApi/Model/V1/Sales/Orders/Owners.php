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
  
  }
  /**
   * get all marketspace owners orders
   */
  public function getItemCollection($request) {
    $salesModel=Mage::getModel("sales/order");
    $salesCollection = $salesModel->getCollection();
    $orders = array();
    foreach($salesCollection as $order)
    {
      $orders[]['order_id'] = $order->getIncrementId();
       
    }
    return $orders;
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
  