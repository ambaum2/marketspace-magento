<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Dwg_Template_MediaTest extends PHPUnit_Framework_TestCase
{
	function __construct()
	{
		Mage::app();
	}
	
	public function testgetProductImageRotatorImages() {
		$product = Mage::getModel('catalog/product')->load(30); //a product with 4 images 2 main and thumbnail 2 regular
		$media = new Dwg_Template_Model_Media;
		$images = $media->getProductImageRotatorImages($product);
		$this->assertEquals(2, count($images));
		$product = Mage::getModel('catalog/product')->load(33); //test a product with just two images that are a main and a thumbnail
		$images = $media->getProductImageRotatorImages($product);
		$this->assertEquals(0, count($images));
	}
	
	public function testGetProductNonThumbnailOrMainImageMedia() {
		$product = Mage::getModel('catalog/product')->load(30);
		//$product_types_media = Mage::getModel('template/media');
		$product_types_media = class_exists("Dwg_Template_Model_Media", true);
		if($product_types_media) {
			$product_types_media = new Dwg_Template_Model_Media;
			//$product_types_media->hell();
		} else {
			//print "not found \n";
		}		
		$remove_images = array($product->getThumbnail(), $product->getImage());
		$images = $product->getMediaGalleryImages();
		$i = 0;
		foreach($images as $key => $value) {
			if(!in_array($value['file'], $remove_images)) {
				//print $value['file'] . " key $key \n";
			}
			$i++;
		}
		//$media = new Mage_Catalog_Block_Product_View_Media;
		//$h = fopen("productOutput.txt", "w+");
	}
	public function getMediaTestData() {
		return (array(
		   '_items' =>
		  array (
		    74 =>
		    (array(
		       '_data' =>
		      array (
		        'value_id' => '74',
		        'file' => '/c/o/cocktail_orange_sm.jpg_4.jpg',
		        'label' => '',
		        'position' => '1',
		        'disabled' => '0',
		        'label_default' => NULL,
		        'position_default' => '1',
		        'disabled_default' => '0',
		        'url' => 'http://test.communitymarketspace.com/media/catalog/product/c/o/cocktail_orange_sm.jpg_4.jpg',
		        'id' => '74',
		        'path' => '/var/www/test.communitymarketspace.com/media/catalog/product/c/o/cocktail_orange_sm.jpg_4.jpg',
		      ),
		       '_hasDataChanges' => false,
		       '_origData' => NULL,
		       '_idFieldName' => NULL,
		       '_isDeleted' => false,
		       '_oldFieldsMap' =>
		      array (
		      ),
		       '_syncFieldsMap' =>
		      array (
		      ),
		    )),
		    68 =>
		    (array(
		       '_data' =>
		      array (
		        'value_id' => '68',
		        'file' => '/H/i/Hi_I_am_Bear.jpg_3.jpg',
		        'label' => '',
		        'position' => '3',
		        'disabled' => '0',
		        'label_default' => NULL,
		        'position_default' => '3',
		        'disabled_default' => '0',
		        'url' => 'http://test.communitymarketspace.com/media/catalog/product/H/i/Hi_I_am_Bear.jpg_3.jpg',
		        'id' => '68',
		        'path' => '/var/www/test.communitymarketspace.com/media/catalog/product/H/i/Hi_I_am_Bear.jpg_3.jpg',
		      ),
		       '_hasDataChanges' => false,
		       '_origData' => NULL,
		       '_idFieldName' => NULL,
		       '_isDeleted' => false,
		       '_oldFieldsMap' =>
		      array (
		      ),
		       '_syncFieldsMap' =>
		      array (
		      ),
		    )),
		    75 =>
		    (array(
		       '_data' =>
		      array (
		        'value_id' => '75',
		        'file' => '/s/t/stock-photo-composition-with-raw-vegetables-and-wicker-basket-isolated-on-white-74030590.jpg_3.jpg',
		        'label' => '',
		        'position' => '4',
		        'disabled' => '0',
		        'label_default' => NULL,
		        'position_default' => '4',
		        'disabled_default' => '0',
		        'url' => 'http://test.communitymarketspace.com/media/catalog/product/s/t/stock-photo-composition-with-raw-vegetables-and-wicker-basket-isolated-on-white-74030590.jpg_3.jpg',
		        'id' => '75',
		        'path' => '/var/www/test.communitymarketspace.com/media/catalog/product/s/t/stock-photo-composition-with-raw-vegetables-and-wicker-basket-isolated-on-white-74030590.jpg_3.jpg',
		      ),
		       '_hasDataChanges' => false,
		       '_origData' => NULL,
		       '_idFieldName' => NULL,
		       '_isDeleted' => false,
		       '_oldFieldsMap' =>
		      array (
		      ),
		       '_syncFieldsMap' =>
		      array (
		      ),
		    )),
		    76 =>
		    (array(
		       '_data' =>
		      array (
		        'value_id' => '76',
		        'file' => '/B/l/BlueSkySBathSink.jpg_5.jpg',
		        'label' => '',
		        'position' => '5',
		        'disabled' => '0',
		        'label_default' => NULL,
		        'position_default' => '5',
		        'disabled_default' => '0',
		        'url' => 'http://test.communitymarketspace.com/media/catalog/product/B/l/BlueSkySBathSink.jpg_5.jpg',
		        'id' => '76',
		        'path' => '/var/www/test.communitymarketspace.com/media/catalog/product/B/l/BlueSkySBathSink.jpg_5.jpg',
		      ),
		       '_hasDataChanges' => false,
		       '_origData' => NULL,
		       '_idFieldName' => NULL,
		       '_isDeleted' => false,
		       '_oldFieldsMap' =>
		      array (
		      ),
		       '_syncFieldsMap' =>
		      array (
		      ),
		    )),
		  ),
		   '_itemObjectClass' => 'Varien_Object',
		   '_orders' =>
		  array (
		  ),
		   '_filters' =>
		  array (
		  ),
		   '_isFiltersRendered' => false,
		   '_curPage' => 1,
		   '_pageSize' => false,
		   '_totalRecords' => NULL,
		   '_isCollectionLoaded' => NULL,
		   '_cacheKey' => NULL,
		   '_cacheTags' =>
		  array (
		  ),
		   '_cacheLifetime' => 86400,
		   '_flags' =>
		  array (
		  ),
		));
	}
}