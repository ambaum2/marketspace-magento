<?php
/*
 * controller that 
 * 
 * url routes should be in this form:
 * frontname/controller/ApiVersion/type(public private?)/Model/method/token/token_value/param1/value1/param2/value2/paramN/valueN
 * so for index actino would be
 * mspaceapi/product/V1/attribute/
 * mspaceapi/product/pV1/attribute (so model is PublicAttribute)
 * actions: get (for single item), set, create, 
 * collection, or a custom rpc method
 * 
 * 
 */
class Alan_MspaceApi_ProductController extends Mage_Core_Controller_Front_Action {
  	        
	/**
	 * @todo add a map of all available methods
	 */
  public function indexAction() {
  	
	}
	/*
	 * Action For V1 of the non-public products
	 * api. This looks at the incoming request and 
	 * authenticates the user through a secret key
	 * encryped 
	 * parses the model necessary
	 * 
	 * @TODO at some point a permission system will 
	 * need to be put in place to make sure that
	 * the user making the call has the appropriate 
	 * permission. This will probably be based on a 
	 * database table of api permissions but not sure yet
	 * since if we used a config file it should be faster
	 */
	public function V1Action() {
		//turn off in productino
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', '1');
		$test = new Alan_MspaceApi_Model_AttributeTest;
    $ModulePackageClassName = Mage::app()->getRequest()->getControllerModule();
		//get the request paramters
		$apiAuth = new Alan_MspaceApi_Model_ApiAuth;
		$dummy_request = 
		//$apiAuth->encryptApiRequest()
		$path = Mage::helper('core/url')->getCurrentUrl();
		$request = explode('/', substr($path, strpos($path, 'mspaceapi') + strlen('mspaceapi')));
		echo "<pre>". print_r($request,true) . "</pre>";
		
		if(class_exists($ModulePackageClassName . "_model_attribute")) {
			
			//echo "<pre>" . print_r(get_class_methods('Alan_MspaceApi_Model_Attribute'), true) . "</pre>";
			//echo json_encode(Mage::helper('core/url')->getCurrentUrl());
			echo "<pre>reqest" . print_r(Mage::app()->getRequest(), true); "</pre>";
			$object = new Alan_MspaceApi_Model_Attribute;
			echo json_encode($object->getProductTypeAttribute());
			//echo $this->toJson($object->getProductTypeAttribute());
			echo "<pre>" . print_r($object->getProductTypeAttribute(), true) . "</pre>";
		} else {
			echo "Alan_MspaceApi_Model_Attribute DNE";
		}

  }

	/*
	 * Action For V1 of the public products
	 * api
	 */
	public function pV1Action() {
		
	}	
}