<?php
require "../../../../../Mage.php";
require 'PHPUnit/Autoload.php';
class Alan_MspaceApi_Path_Tests extends PHPUnit_Framework_TestCase
{
	function __construct()
	{
		Mage::app();
	}

  public function testgetApiClassData() {
    $api_path = new Alan_MspaceApi_Model_ApiPath;
    $paths = $this->getTestData();
    for($i = 0; $i < count($paths); $i++) {
      $result = $api_path->getApiClassData($api_path->processRequest($paths[$i]));
      $this->assertEquals($paths[$i]['result'], $result['class_name']);
      $this->assertEquals($paths[$i]['num_url_params'], count($result['url_params']));
    }     
  }
	public function testgetRequestClass() {
		$api_path = new Alan_MspaceApi_Model_ApiPath;
		$paths = $this->getTestData();
    for($i = 0; $i < count($paths); $i++) {
      $result = $api_path->processRequest($paths[$i], $version = 'v1');
      $this->assertTrue(is_array($result));
    }
  }
  public function getTestData() {
    return array(
      0 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/sales/orders?param1=33&param2=555&', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'GET', 'num_url_params' => 0, 'num_params' => 2, 'params' => 'param1=33&param2=555'),
      1 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/sales/orders/?param1=66/&', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'get', 'num_url_params' => 0, 'num_params' => 1, 'params' => 'param1=33'),
      2 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/V1/sales/Orders', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'get', 'num_url_params' => 0, 'num_params' => 0, 'params' => ''),
      3 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/Sales/orders/', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'get', 'num_url_params' => 0, 'num_params' => 0, 'params' => ''),
      4 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/V1/sales/orders/3/', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'get', 'num_url_params' => 1, 'num_params' => 0, 'params' => '3'),
      5 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/Sales/orders/55', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'get', 'num_url_params' => 1,'num_params' => 0, 'params' => '55'),
      6 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/sales/orders/junkclass/55', 'result' => 'Alan_MspaceApi_Model_V1_Sales_Orders', 'request_type' => 'GET', 'num_url_params' => 2, 'num_params' => 0, 'params' => '55'),
      6 => array('url' => 'http://test.communitymarketspace.com/mspaceapi/reports/v1/sale/orders/junkclass/55', 'result' => '', 'request_type' => 'GET', 'num_url_params' => 4, 'num_params' => 0, 'params' => '55'),
    );
  }
/*		for($i = 0; $i < count($paths); $i++) {
		  $params = array();
      $version = 'v1';
			$request = substr($paths[$i]['request'], strpos(strtoupper($paths[$i]['request']), strtoupper($version) . '/') + strlen(strtoupper($version) .'/'));
			if(strpos($request, '?') > 0) {
				$params = explode('&', substr($request, strpos($request, '?') + 1, strlen($request)));
				$params_length = count($params);
				for($k = 0; $k < $params_length; $k++) {
          $equals_pos = strpos($params[$k], '=');
					$params[substr($params[$k], 0, $equals_pos)] = substr($params[$k], $equals_pos + 1, (strlen($params[$k]) - $equals_pos));
					unset($params[$k]);
				}
				$request = substr($request, 0, strpos($request, '?'));
			}
      $this->assertEquals($paths[$i]['num_params'], count($params));
			$request = explode('/', $request);
			$class = $this->getApiClass($request);
      $this->assertEquals($paths[$i]['result'], $class['class_name']);
      if($class['class_name'] != '') {
        if(count($params)) {
          $class['params'] = $params;
        }
        $object = new $class['class_name'];
        $method = $paths[$i]['request_type'];
        $object->{$method}($class);
      }
		}
	}*/
  /*public function testGetClassExists() {
    print "\n check class: " . class_exists("Alan_MspaceApi_Model_V1_Sales_Orders ") . " class found? \n";
    print "\n check class: " . class_exists("Alan_MspaceApi_Model_V1_Sales_Orders") . " class found? \n";
  }*/
  /**
   * scan request and find a valid class
   * url may have 1 param in the url. this is why we 
   * check original vs new when we get to the end of 
   * the request. if using original then that means the 
   * class has a param so the original then is the right 
   * class path. if class not found set class name empty
   * 
   * @param request
   *  array of a url reqest params
   * @return array
   *  return class_name and url_param if there is 
   * a param. returning an empty string for class name means
   * not found
   */
	/*public function getApiClass($request) {
		$class['original'] = "Alan_MspaceApi_Model_V1";
		$class['new'] = "";
		$request_length = count($request);
		for($i = 0; $i < $request_length; $i++) {
      $class['new'] = ($class['original'] . '_' . ucfirst($request[$i]));
			if(($i + 1) == $request_length) {
				if(class_exists(trim($class['new']))) {
					$class['class_name'] = $class['new'];
				} else {
					if(!class_exists(trim($class['original']))) {
					  $class['class_name'] = '';
					} else {
					  $class['class_name'] = $class['original'];
					  !empty($request[$i]) ? $class['url_param'] = $request[$i] : ''; //if old class was used means the latest class had a param in it or was empty
					}
				}
			}
      $class['original'] = $class['new']; //now set original to new
		}
		return $class;
	}*/
}