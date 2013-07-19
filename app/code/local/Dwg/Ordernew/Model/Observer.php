<?php
class Dwg_Ordernew_Model_Observer
{
    public function __construct()
    {
    }
    /**
     * Applies the special price percentage discount
     * @param   Varien_Event_Observer $observer
     * @return  Xyz_Catalog_Model_Price_Observer
     */
    public function newSalesOrder($observer)
    {
      $event = $observer->getData();
      $order = $observer->getEvent()->getOrder();
      $orderId = $order->getIncrementId();
      if(Mage::getSingleton('admin/session')->isLoggedIn()) {
      	$adminId = Mage::getSingleton('admin/session')->getUser()->getId();
      	Mage::getModel('ordernew/ordernew')->setOrderId($orderId)->setExpMakerId($adminId)->save();
      } else {
      	//foreach($order->getAllItems() as $item) {
      		//$adminId .= $item->getVendorEmail();
      		//if(isset($adminId)) {
      		//$adminId .=$item->getVendorEmail();
      		//Mage::getModel('ordernew/ordernew')->setOrderId($orderId)->setExpMakerId($adminId)->save();
      		//}
      	//}
      }
      
      //$somevar = $observer->getEvent()->getOrder();
      $somevar = "Order#: ". $orderId . " and Admin Id: " . $adminId;
        //$orderAdmin = Mage::getSingleton('admin/session')->getUser();
    	$emailTemplate  = Mage::getModel('core/email_template')->loadByCode("contact_form");
    	$emailTemplateVariables['orderinfo'] = $somevar;
        $emailTemplate->setSenderName("Escape Locally");
        $emailTemplate->setTemplateSubject("Thank you". $adminId);
        $emailTemplate->setSenderEmail("experience@escapelocally.com");
        $emailTemplate->setReturnPath("admin@escapelocally.com");
	//$emailTemplate->send("ambaum2@gmail.com", "Alan Test",$emailTemplateVariables);    
      return $this;
    }
}