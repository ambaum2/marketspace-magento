<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Product_types_Model_Product_typesTest extends PHPUnit_Framework_TestCase
{
	function __construct()
	{
		Mage::app();
	}
	public function testGetAttributeSet() {
			$productData = Mage::getModel('catalog/product')
				->getCollection()
				->addAttributeToSelect('*')
				->getData();
				//->addFieldToFilter('attribute_set_id',$attributeSetId);		
			//print_r($productData);
			
			//$product = Mage::getModel('catalog/product')->load(12);
			//print_r($productData);
	}
	public function testGetAllAttributeSets() {
		$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection') ->load();
		
		foreach ($attributeSetCollection as $id=>$attributeSet) {
		  $entityTypeId = $attributeSet->getEntityTypeId();
		  $name = $attributeSet->getAttributeSetName();
		 	//print $name .  "-$id";
		}
		//$h = fopen("attrsetoutput.txt", "w+");
		//fwrite($h, print_r(Mage::getResourceModel('eav/entity_attribute_set_collection')->load(), true));
	}
	public function testGetAllAttributeOptions() {
		$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'product_type');
		$options_array = array();
		if ($attribute->usesSource()) {
			$options = $attribute->getSource()->getAllOptions(false);
			foreach($options as $key => $value) {
				$options_array[$value['value']] = array('id' => $value['value'], 'label' => $value['label']
				, 
				'context' => array(
		    	'grid_view_price' => array(
		    		'show' => 1,
		    		'format' => '{price}'
					),
					'view_available' => array(
						'show' => 1,
						'format' => '{available}'
					),
				)
				);
			}
		}
		//var_export($options_array);
	}
	public function testIsLoggedIn() {
$session = Mage::getSingleton('customer/session', array('name'=>'frontend'));
$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
$group = Mage::getModel ('customer/group')->load($groupId);
$groupName = $group->getCode();
$loggedIn = false;
if ($session->isLoggedIn() && $groupName == "Retailer") { 
$loggedIn = true;
} else { //echo "not logged in"; 
}
	}
	public function testfalseandfalse() {
		$_product = Mage::getModel('catalog/product')->load(12);
		print $_product->getProductType();
		print $_product['product_type'];
		if(false && false) {
			print "true";
		} else {
			print "false";
		}
	}
	public function testLoadProductById() {
		$product = Mage::getModel('catalog/product')->load(12);
		$attribute_set_id = $product->getAttributeSetId();
		//print_r(Mage::getModel("eav/entity_attribute_set")->load($product->getAttributeSetId()));
		$attr_set = new Mage_Eav_Model_Entity_Attribute_Set;
		//print_r(get_class_methods("Mage_Eav_Model_Entity_Attribute_Set"));
	}
	/**
	 * given a product model and context determine
	 * if I should display information in this 
	 * context
	 * @param product
	 * 	object the product model object
	 * @param context
	 * 	string 
	 * 
	 * @TODO the context should eventually be 
	 * stored in some database with 1 or 0 to 
	 * determine if should be displayed. This
	 * would replace the case statement
	 */
	public function testShowProductType() {
		$product = Mage::getModel('catalog/product')->load(12);
		/*$founder_deal = array('grid' => array('show' => 1, 'display' => array('attribute' => 'price')));
		$rule_grid_price = array('')
		switch ($context) {
			case 'value':
				
				break;
			
			default:
				
				break;
		}*/
	}
	public function attributeSetConfig() {
return array (
  8 =>
  array (
    'id' => '8',
    'label' => 'Founders Product Deal - In-Store',
    'context' => array(
    	'grid_view_price' => array(
    		'show' => 1,
    		'format_custom' => '',
			),
			'view_available' => '',
    ),
  ),
  9 =>
  array (
    'id' => '9',
    'label' => 'Founders Product Deal - Online',
  ),
  4 =>
  array (
    'id' => '4',
    'label' => 'Product - Online',
  ),
  7 =>
  array (
    'id' => '7',
    'label' => 'Product - In-Store',
  ),
  5 =>
  array (
    'id' => '5',
    'label' => 'Profile â Seller',
  ),
  6 =>
  array (
    'id' => '6',
    'label' => 'Profile â Partner',
  ),
  10 =>
  array (
    'id' => '10',
    'label' => 'Hospitality - Reservation',
  ),
  3 =>
  array (
    'id' => '3',
    'label' => 'Hospitality - Purchase',
  ),
);
	}
}
	