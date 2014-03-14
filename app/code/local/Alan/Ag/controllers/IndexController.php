<?php
class Alan_Ag_IndexController extends Mage_Core_Controller_Front_Action {        

  public function indexAction() {
  	error_reporting(E_ALL);
		ini_set("display_errors", 1);
    $weblog2 = Mage::getModel('ag/eavag');
		
    $weblog2->load(1);
    var_dump($weblog2);
	}
}