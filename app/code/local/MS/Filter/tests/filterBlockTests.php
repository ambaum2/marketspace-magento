<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Dwg_Filter_Block_Tests extends PHPUnit_Framework_TestCase
{
	function __construct()
	{
		Mage::app();
	}
	/**
	 * get all products that have 
	 * the given marketspace owner id
	 */
	public function testgetProductsByMarketspaceOwnerAttribute() {
			$msFilter = new MS_Filter_Block_Index;
			$productData = $msFilter->getProductsByMarketspaceOwnerId(2);
			/** getData IMPORTANT **/
			//getData is pretty restrictive really you want to foreach the collection
			$this->assertTrue(is_object($productData));
	}
	
	public function testGetProductsField() {
    $collection_of_products = Mage::getModel('catalog/product')->getCollection();
    $collection_of_products->addFieldToFilter('marketspace_owner', 2);
    $collection_of_products->addAttributeToSelect(array('name', 'url_key', 'thumbnail'));
    //another neat thing about collections is you can pass them into the count      //function.  More PHP5 powered goodness
    //echo "Our collection now has " . count($collection_of_products) . ' item(s)';
    //note getData
    //foreach($collection_of_products as $key => $value) {
    	//echo $key . "\n";
			//print_r($value);
			
    //}
	}
}