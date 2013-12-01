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
 * @TODO - add stock inventory attributes to the output
 */

class Alan_MspaceApi_Model_V1_Attribute extends Mage_Core_Model_Abstract
{
    /**
     * Default ignored attribute codes
     *
     * @var array
     */
    protected $_ignoredAttributeCodes = array('entity_id', 'attribute_set_id', 'entity_type_id');

    /**
     * Default ignored attribute types
     *
     * @var array
     */
    protected $_ignoredAttributeTypes = array();

    /**
     * Field name in session for saving store id
     * @var string
     */
    protected $_storeIdSessionField   = 'store_id';

    /**
     * Name of resource model in ACL list
     * @var string
     */
    protected $_resourceAttributeAclName = 'catalog/category/attributes/field_'; 
  /**
   * Retrieve inventory item options (used in config)
   *
   * @return array
   */
  public function getInventoryAttributes()
  {
    return array(
  		'qty' => array('group'=>'Inventory', 'type' => 'textfield'),
      'min_qty' => array('group'=>'Inventory', 'type' => 'textfield'),
      'is_in_stock' => array('group'=>'Inventory', 'type' => 'select', 'options' => array(1 => 'In Stock', 0 => 'Out Of Stock')),
      //'backorders',
      //'min_sale_qty',
      //'max_sale_qty',
      //'notify_stock_qty',
      'manage_stock' => array('group'=>'Inventory','type' => 'select', 'options' => array(1 => 'Yes', 0 => 'No')),
      //'enable_qty_increments',
      //'qty_increments',
      //'is_decimal_divided',
    );
  }
	
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
  	//if(in_array($request, $this->getInventoryAttributes())) {
    $attributeValue = Mage::getModel('eav/config')->getAttribute('catalog_product', $request);
    $attributeInfo = array();
    $data = $attributeValue->getData();
    unset($data['entity_type']);
    return $data;
  }
    /**
     * Retrieve attributes from specified attribute set
     *
     * @param setId | int
     * @return array
     */
    public function entityCollection($request)
    {
	    $attributes = Mage::getModel('catalog/product')->getResource()
        ->loadAllAttributes();
        //->getSortedAttributes($request);
	    $result = array();
	
	    foreach ($attributes as $attribute) {
        if ((!$attribute->getId()) && $this->_isAllowedAttribute($attribute)) {
					$result[$attribute->getAttributeCode] = $attribute->getAttributeCode . " (" . $attribute->getFrontendLabel . ")";  				
	            /*$result[] = array(
	                'attribute_id' => $attribute->getId(),
	                'code' => $attribute->getAttributeCode(),
	                'type' => $attribute->getFrontendInput(),
	                'required' => $attribute->getIsRequired(),
	                'scope' => $scope
	            );*/
        }
	    }
	
	    return $result;
    }
	/**
	 * get all attribute set attributes
	 * 
	 * @param request | array
	 * 	request must contain request['id'] and 
	 *  is numeric. Should be a valid set id
	 * @return array
	 */
	public function getSetOptions($request) {
		if($request['id'] > 0) {
	    $attributes = Mage::getModel('catalog/product')->getResource()
	      ->loadAllAttributes()
	      ->getSortedAttributes($request['id']);
			
	   $result = array();
	   foreach ($attributes as $attribute) {
	      if ((!$attribute->getId() || $attribute->isInSet($request['id'])) && $this->_isAllowedAttribute($attribute)) {
					$result[$attribute->getAttributeCode()] = $attribute->getAttributeCode() . " (" . $attribute->getFrontendLabel() . ")";
	      }
	    }

	    return $result;
		}
	}
    /**
     * Check is attribute allowed
     *
     * @param Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param array $attributes
     * @return boolean
     */
    protected function _isAllowedAttribute($attribute, $attributes = null)
    {

        if (Mage::getSingleton('api/server')->getApiName() == 'rest') {
            if (!$this->_checkAttributeAcl($attribute)) {
                return false;
            }
        }

        if (is_array($attributes)
            && !( in_array($attribute->getAttributeCode(), $attributes)
                  || in_array($attribute->getAttributeId(), $attributes))) {
            return false;
        }

        return !in_array($attribute->getFrontendInput(), $this->_ignoredAttributeTypes)
               && !in_array($attribute->getAttributeCode(), $this->_ignoredAttributeCodes);
    }
}