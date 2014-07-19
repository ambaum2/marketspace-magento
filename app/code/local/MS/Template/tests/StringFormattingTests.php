<?php
/**
 * Created by PhpStorm.
 * User: abaum
 * Date: 3/18/14
 * Time: 5:57 PM
 */
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class StringFormattingTest extends PHPUnit_Framework_TestCase {
    public $sellerProfile;
    public $sellerProfileModel;
    function __construct()
    {
        Mage::app();
        $this->product = Mage::getModel('catalog/product')->load(69);
    }
    public function testGetParagraphs() {
        $String = new MS_Template_Model_StringFormatting();
        $result = $String->ExtractParagraphs($this->product['description'], 2);
        print $String->GetParagraphString($result);
    }
}
 