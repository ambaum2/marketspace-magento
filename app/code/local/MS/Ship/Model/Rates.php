<?php

class MS_Ship_Model_Rates extends Mage_Core_Model_Abstract
{
  var $price;
  var $cost;
  var $display;
  var $type;
  var $line_item_info = array(); //array of line items
    /** 
     * get shipping rate information
     * @param $request object object of a rate request
     * @return object MS_Ship_Model_Shipping_Rates
     */
    public function get($request) {
      $result = array();
      $this->total_price = 0;
      $this->total_cost = 0;
      $this->display = false;
      $types = new MS_Ship_Model_Rates_Types;
      foreach ($request->getAllItems() as $_item) {
        $_product = $_item->getProduct();
        $_product = Mage::getModel('catalog/product')->load($_product->getId()); //you must load the product model to get its data may do a collection instead to save memory
        if ($type = $types->get($_product['ms_shipping_type']))
        {
          $this->type = $type;
          
          $this->display = true;
          $Rate_Total = new $type;
          $result = $Rate_Total->get($_item, $_product);
          $this->cost += $result->cost;
          $this->price += $result->price;
          $this->line_item_info[] = $result->line_item_info;
        }
      }
      return $this;
    }
}