<?php
/**
 *  
 */

class Alan_MspaceApi_Model_V1_Sales_Orders extends Mage_Core_Model_Abstract
{
  
  public function get($request) {
    $method = $this->getGetRequestType($request);
    try {
      return $this->{$method}($request);
    } catch(exception $e) {
      throw Exception("Method Not Found");
    }
  }
  /**
   * get a single item by id 
   * or code
   * @param id 
   *  mixed integer or string
   */
  public function getItem($request) {
    return '';
  }
  
  public function getItemCollection($request) {
    return '';
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
    throw new Exception("Delete Not Implemented", 1);
  }
}
  