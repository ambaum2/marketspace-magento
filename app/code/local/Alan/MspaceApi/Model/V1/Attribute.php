<?php
/**
 *  logic for working with attributes right
 * now mainly getters
 * 
 * @TODO - Remember a good api is about things not actions
 * ADD more things not actions. The below would be considered bad
 * design. You should instead have two classes (add two things) 
 * an AttributeOptions and AttributeData class and they should have
 * a single get, post, delete, etc 
 */

class Alan_MspaceApi_Model_V1_Attribute extends Mage_Core_Model_Abstract
{
  
  /**
   * get the product_type attribute (custom attribute)
   * and all of its option values
   * example:
   * mspaceapi/product/v1/attribute/type/options/code/product_type
   * @param request
   * @return array
   * 
   */
  public function getTypeOptions($request) {
    
    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $request);
    $attributeInfo = array();
    foreach ($attribute->getSource()->getAllOptions(true, true) as $instance) {
      $attributeInfo[$instance['value']] = $instance['label'];
    }
    return $attributeInfo;
  }
  
  /**
   * gets the makeup of data
   */
  public function getTypeData($request) {
    //$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $request[0]);
    $attributeValue = Mage::getModel('eav/config')->getAttribute('catalog_product', $request);
    $attributeInfo = array();
    $data = $attributeValue->getData();
    unset($data['entity_type']);
    return $data;
  }
}