<?php
/**
 * Class exists and magento don't mix - so that is 
 * why this class is not in camel notation
 *
 *  logic for working with attributes right
 * now mainly getters
 * 
 * @TODO - Remember a good api is about things not actions
 * ADD more things not actions. The below would be considered bad
 * design. You should instead have two classes (add two things) 
 * an AttributeOptions and AttributeData class and they should have
 * a single get, post, delete, etc 
 */

class Alan_MspaceApi_Model_V1_Type extends Mage_Core_Model_Abstract
{
  
  /**
   * get the attribute set collection
   * and all as key value array
   * example:
   * mspaceapi/product/v1/attributeset/collection
   * @param request
   * @return array
   * 
   */
  public function entityCollection($request) {
    $result = array();
    foreach (Mage_Catalog_Model_Product_Type::getOptionArray() as $type=>$label) {
        $result[$type] = $label;
    }
    return $result;
  }
}
