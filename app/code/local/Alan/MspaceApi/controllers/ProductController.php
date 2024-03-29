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
    	
		$request = explode('/', substr($path, strpos($path, 'mspaceapi') + strlen('mspaceapi')));
    
    //run some authentication on a header token
    $authenticated = false;
    //check http_authtoken $_SERVER['HTTP_AUTHTOKEN"]
    if(isset($_SERVER['HTTP_AUTHTOKEN']) && isset($_SERVER['HTTP_AUTHIV'])) {
    $authenticated = $apiAuth->validateAuthToken($_SERVER['HTTP_AUTHTOKEN'], $_SERVER['HTTP_AUTHIV']);
      if($authenticated) {
    		if(isset($request[3]) && isset($request[2])) { //if version(request[2]) and model type(request[3]) are set then try to find class
      		if(class_exists($ModulePackageClassName . "_model_" . strtolower($request[2]) . "_" . strtolower($request[3]))) {
      			try {
	      			$class = $ModulePackageClassName . "_model_" . strtolower($request[2]) . "_" . strtolower($request[3]);
	            $object = new $class;
	            //get the requested method         
	            $methodName = $apiAuth->getMethod($object, $class, $request);
	            $params = $apiAuth->getRequestParamsArray($request);
	            $result = $object->$methodName($params);
	            
	            $json = json_encode($result);
	            $this->getResponse()->setHeader('Content-type', 'application/json');
	            $this->getResponse()->setBody($json);
						} catch(exception $e){
							//log exception
						}
      		} else {
      			//throw new Exception("This entity does not exist" . $ModulePackageClassName . "_model_" . strtolower($request[2]) . "_" . strtolower($request[3]), 1); 		
      			$this->getResponse()->setHeader('Content-type', 'application/json');
						if(class_exists("Alan_MspaceApi_Model_V1_AttributeSet", FALSE))
							$good = "BUT IT DOES HERE";
            $this->getResponse()->setBody("This entity does not exist" . $ModulePackageClassName . "_Model_" . $request[2] . "_" . $request[3] . " " . $good);  		
      		}
        }
      } else {
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody("Not Authenticated");           
      }
    } else {
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody("Headers Not Set");    
    }
      

  }

	/*
	 * Action For V1 of the public products
	 * api
	 */
	public function pV1Action() {
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', '1');
		$method = $_SERVER['REQUEST_METHOD'];
    $ModulePackageClassName = Mage::app()->getRequest()->getControllerModule();
    $path = Mage::helper('core/url')->getCurrentUrl();
		$request = explode('/', substr($path, strpos($path, 'mspaceapi') + strlen('mspaceapi')));
		if(isset($request[3]) && isset($request[2])) {
			if(class_exists($ModulePackageClassName . "_model_" . strtolower($request[2]) . "_" . strtolower($request[3]))) {
				$class = $ModulePackageClassName . "_model_" . strtolower($request[2]) . "_" . strtolower($request[3]);
        $params = $apiAuth->getRequestParamsArray($request);
        $result = $object->$methodName($params);
        
        $json = json_encode($result);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($json);
			}
		}
	}	
}