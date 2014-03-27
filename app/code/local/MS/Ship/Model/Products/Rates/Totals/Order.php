<?php

class MS_Ship_Model_Products_Rates_Totals_Order extends Mage_Core_Model_Abstract
{
  var $price;
  var $cost;
  var $line_item_info; //array of line items
    /** 
     * calculate order total, cost, and format a line item display
     * @param $_item object shipping rate request object
     * @param $product object product model
     * @return object MS_Ship_Model_Shipping_Rates
     */
    public function get($_item, $_product) {
      try {    
        $this->price = $_product['ms_shipping_cost'];
        $this->cost = $_product['ms_shipping_cost'];
        $this->line_item_info['label'] = $_product['name'];
        $this->line_item_info['quantity'] = $_item->getQtyOrdered();
        $this->line_item_info['price'] = Mage::helper('core')->formatPrice($this->price, true);
        return $this;
      } catch (Exception $e) {
          $error = "";
          if(!isset($_product['ms_shipping_cost']))
            $error = "shipping cost not set";
          throw new Exception("Error Processing Request. " . $error, 1);
        }
      }
    
    
}
  