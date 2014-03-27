<?php

class MS_Ship_Model_ProductRates extends Mage_Core_Model_Abstract
{
    var $price;
    var $cost;
    var $display;
    var $type;
    var $line_item_info; //array of shipping info
    /**
     * get shipping rate information
     * @param $_item object object of a rate request
     * @return object MS_Ship_Model_Shipping_Rates
     */
    public function get($_item) {
        $this->price = 0;
        $this->cost = 0;
        $this->display = false;
        $types = new MS_Ship_Model_Products_Rates_Types;
        $_product = Mage::getModel('catalog/product')->load($_item->getProductId()); //you must load the product model to get its data may do a collection instead to save memory
        if ($type = $types->get($_product['ms_shipping_type']))
        {
            $this->type = $type;
            $this->display = true;
            $Rate_Total = new $type;
            $result = $Rate_Total->get($_item, $_product);
            $this->cost += $result->cost;
            $this->price += $result->price;
            $this->line_item_info = $result->line_item_info;
        }
        return $this;
    }
}
  