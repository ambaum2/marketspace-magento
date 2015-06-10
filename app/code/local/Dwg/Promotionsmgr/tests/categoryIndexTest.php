<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class categoryIndexTest extends PHPUnit_Framework_TestCase
{
  function __construct()
  {
    Mage::app();
  }

	
	public function testGetCategories() {
		$stores = Mage::app()->getStores();
    $a = new Algolia_Algoliasearch_Model_Algolia();
    $a->rebuildIndex();
    foreach($stores as $s) {
      print_r($s->getData());
    }

	}
}
  