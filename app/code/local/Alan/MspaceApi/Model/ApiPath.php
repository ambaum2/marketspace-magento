<?php

class Alan_MspaceApi_Model_ApiPath extends Mage_Core_Model_Abstract {
	
  public function getRequestInfo($request_data, $version = 'v1') {
    $request_result = $this->processRequest($request_data, $version);
    $request = $this->getApiClassData($request_result);
    return $request;
  }
  /** 
   * process request url and return an array 
   * of urls and add an array of parameters
   * if they exist
   * @param request_data
   * @param version
   */
	public function processRequest($request_data, $version = 'v1') {
    $params = array();
    $request = substr($request_data['url'], strpos(strtoupper($request_data['url']), strtoupper($version) . '/') + strlen(strtoupper($version) . '/')); //lowercase so version upper or lower case does not matter
    if(strpos($request, '?') > 0) { //if request url has parameters
      $params = explode('&', substr($request, strpos($request, '?') + 1, strlen($request)));
      $params_length = count($params);
      for($k = 0; $k < $params_length; $k++) {
        $equals_pos = strpos($params[$k], '=');
        $params[substr($params[$k], 0, $equals_pos)] = substr($params[$k], $equals_pos + 1, (strlen($params[$k]) - $equals_pos));
        unset($params[$k]);
      }
      $request = substr($request, 0, strpos($request, '?'));
    }
    $request = explode('/', $request);
    $request['params'] = $params;
    return $request;
  }		
  /**
   * 
   * @param request
   *  array that has a url in the url key
   * 
   */
  public function executeApiRequestMethod($request) {
    $class = $this->getRequestInfo($request);
    if($class['class_name'] != '') {
      if(count($params)) {
        $class['params'] = $params;
      }
      $object = new $class['class_name'];
      $method = $request['type'];
      return $object->{$method}($class);
    } else {
      return array('error', 'class does not exist');
    }
  }
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
   *  return class_name and url_params if there are
   *  parameters between slashes
   *  returning an empty string for class name means
   *  class not found
   */
  public function getApiClassData($request, $version = 'v1') {
    $class = array();
    $class['params'] = $request['params'];
    unset($request['params']);
    $class['previous'] = "Alan_MspaceApi_Model_" . strtoupper($version);
    $class['class_name'] = "";
    $class['current'] = "";
    $request_length = count($request);
    for($i = 0; $i < $request_length; $i++) {
      $class['current'] = ($class['previous'] . '_' . ucfirst($request[$i]));
      if(mageFindClassFile($class['current'])) { //if the class is good then set class_name equal to the checked class name
        $class['class_name'] = $class['current'];
        $class['url_params'] = array(); //empty url params because 
      } else { //assume request element was a param since it did not make a valid class
        if(!empty($request[$i])) //don't add empty values - this may not be desired
          $class['url_params'][] = $request[$i];
      }
      $class['previous'] = $class['current'];
    }
    return $class;
  }	
}
