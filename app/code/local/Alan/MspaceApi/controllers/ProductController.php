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
		$apiAuth = new Alan_MspaceApi_Model_ApiAuth;
    
    $ModulePackageClassName = Mage::app()->getRequest()->getControllerModule();
    $path = Mage::helper('core/url')->getCurrentUrl();
    
    //echo "<pre>" . print_r($_SERVER, true) . "</pre>";
    //echo "<p>" . $_SERVER['REQUEST_METHOD'] . "</p>";
		$helloreg = "hello";
		$data = $apiAuth->encryptBase64("hello");		
		$request = explode('/', substr($path, strpos($path, 'mspaceapi') + strlen('mspaceapi')));
    
    //run some authentication on a header token
    $authenticated = true;
    //check http_authtoken $_SERVER['HTTP_AUTHTOKEN"]
    
    if($authenticated) {
  		if(isset($request[3]) && isset($request[2])) { //if version(request[2]) and model type(request[3]) are set then try to find class
    		if(class_exists($ModulePackageClassName . "_model_" . $request[2] . "_" . $request[3])) {
    			$class = $ModulePackageClassName . "_model_" . $request[2] . "_" . $request[3];
          $object = new $class;
          //get the requested method         
          $methodName = $apiAuth->getMethod($object, $class, $request);
          $params = $apiAuth->getRequestParamsArray($request);
          $result = $object->$methodName($params);
          
          $json = json_encode($result);
          $this->getResponse()->setHeader('Content-type', 'application/json');
          $this->getResponse()->setBody($json);
    		} else {
    			throw new Exception("This entity does not exist", 1);
  				
    		}
      }
    }

  }

	/*
	 * Action For V1 of the public products
	 * api
	 */
	public function pV1Action() {
		
	}	
}