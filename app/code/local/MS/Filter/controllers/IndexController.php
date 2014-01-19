<?php
class MS_Filter_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
		  $this->loadLayout();
			$owner_id  = (int) $this->getRequest()->getParam('id');
		  $this->getLayout()->getBlock("head")->setTitle($this->__("All Our Products"));
	    $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("all our products", array(
                "label" => $this->__("All Our Products"),
                "title" => $this->__("All Our Products")
		   ));
			$content = $this->getLayout()->getBlock('filter_index');
			$content->setOwnerId($owner_id);
      $this->renderLayout(); 
	  
    }
}