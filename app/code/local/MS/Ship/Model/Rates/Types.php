<?php

class MS_Ship_Model_Rates_Types extends Mage_Core_Model_Abstract
{
    /** 
     * calculate total of all items
     * @param $type int
     * @return mixed string class name or false
     */
    public function get($type) {
      $types = array(
        1 => 'MS_Ship_Model_Rates_Totals_Product',
        2 => 'MS_Ship_Model_Rates_Totals_Order',
        3 => 'MS_Ship_Model_Rates_Totals_Product_By_Weight',
        4 => 'MS_Ship_Model_Rates_Totals_Free',
      );
      if($types[$type]) {
        $result = $types[$type];
      } else {
        $result = false;
      }
      return $result;
    }
}