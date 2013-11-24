<?php
/*
 * controller that 
 */
class Alan_MspaceApi_ProductController extends Mage_Core_Controller_Front_Action {        

  public function indexAction() {
			//header('Content-Type: application/javascript');
      //echo 'Hello Product Controller';
			if(class_exists("Alan_MspaceApi_Model_Attribute")) {
				//echo "alan attribute Alan_MspaceApi_Model_Attribute class exists!!!";
				//echo "<pre>" . print_r(get_class_methods('Alan_MspaceApi_Model_Attribute'), true) . "</pre>";
				$object = new Alan_MspaceApi_Model_Attribute;
				echo json_encode($object->getProductTypeAttribute());
				//echo "<pre>" . print_r($object->getProductTypeAttribute(), true) . "</pre>";
			} else {
				echo "Alan_MspaceApi_Model_Attribute DNE";
			}
  }
	
}