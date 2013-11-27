<?php
class Alan_MspaceApi_IndexController extends Mage_Core_Controller_Front_Action {        

  public function indexAction() {
		//@TODO use get class methods to output a map of all available methods
		//with documentation
  }
	public function serverTimeAction() {
			header('Content-Type: application/javascript');
			//key url decode use logic and check for valid key by known key (add check to check if sent in last 5 seconds)?
			if($this->getRequest()->getParam('key') == "long") {
  	    $array = array();
				$array['time'] = date('%M %D %Y %G:%m:%i %a', time());
  	    print json_encode($array);
			} else {
				echo "specify a format: long, short, or time";
			}

	}
  private function outputConfig() {
      die(Mage::app()->getConfig()->getNode()->asXML());
  }
}