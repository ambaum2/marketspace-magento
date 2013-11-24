<?php
class Alan_MspaceApi_IndexController extends Mage_Core_Controller_Front_Action {        

  public function indexAction() {

      echo 'Hello Index! Again bet this dont work (I left out the single quote purposley)';

  }
	public function paramsAction() {
		 // header("Content-Type: text/xml");
			//header('Content-Type: application/json');
			header('Content-Type: application/javascript');
      //$this->outputHeaders(); 
			//key url decode use logic and check for valid key by known key (add check to check if sent in last 5 seconds)?
			//echo $this->getRequest()->getParam('key');
			if($this->getRequest()->getParam('key') == "1234") {
  	    //echo '<dl>';
  	    $array = array();
  	    foreach($this->getRequest()->getParams() as $key=>$value) {
  	        $array[$key] = $value;
  	        //echo '<dt><strong>Value: </strong>'.$value.'</dt>';
  	    }
  	    //echo '</dl>';
  	    print json_encode($array);
			} else {
				echo "failed";
			}

	}
  private function outputConfig() {
      die(Mage::app()->getConfig()->getNode()->asXML());
  }
}