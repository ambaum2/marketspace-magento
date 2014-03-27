<?php

class MS_Ship_Model_ShippingRates extends Mage_Core_Model_Abstract
{
  var $total_price;
  var $total_cost;
  var $display;
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
        if ($type = $types->get($_item['ms_shipping_type']))
        {
          if(isset($_item['ms_shipping_cost'])) {
            
          }
          //$this->display = true;
          //$Rate_Total = new $type;
          //$Rate_Total = $Rate_Total->get($_item);
          //$Rate_Total
           //print "f off" . $_item['sku']; 
           //print "<p>QTY" . $_item->getQty() . "</p>"; //print "<p>Name: " . $_item->getName() . "</p>"; }
        }
      }
      return $this;
    }
    
    
}
  