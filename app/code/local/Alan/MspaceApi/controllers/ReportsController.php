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
class Alan_MspaceApi_ReportsController extends Mage_Core_Controller_Front_Action {
  	        
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
		$ApiPath = new Alan_MspaceApi_Model_ApiPath;
    $apiAuth = new Alan_MspaceApi_Model_ApiAuth;
    $ModulePackageClassName = Mage::app()->getRequest()->getControllerModule();
    $request['url'] = Mage::helper('core/url')->getCurrentUrl();
    $request['type'] = $_SERVER['REQUEST_METHOD']; //get is post, get, put, etc
    //run some authentication on a header token
    $authenticated = false;
    //if(isset($_SERVER['HTTP_AUTHTOKEN']) && isset($_SERVER['HTTP_AUTHIV'])) {
    //$authenticated = $apiAuth->validateAuthToken($_SERVER['HTTP_AUTHTOKEN'], $_SERVER['HTTP_AUTHIV']);
      if($authenticated || true) {
  			try {
          $result = $ApiPath->executeApiRequestMethod($request);
          $json = json_encode($result);
          $this->getResponse()->setHeader('Content-type', 'application/json');
          $this->getResponse()->setBody($json);
				} catch(exception $e){
    			$this->getResponse()->setHeader('Content-type', 'application/json');
          $this->getResponse()->setBody("This entity does not exist" . $ModulePackageClassName . "_Model_" . $request[2] . "_" . $request[3] . " " . $good);  		
  		  }
      } else {
          $this->getResponse()->setHeader('Content-type', 'application/json');
          $this->getResponse()->setBody("Not Authenticated");           
      }
    /*} else {
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody("Headers Not Set. No Auth Token.");    
    }*/
  }
}