<?php
class MS_Msmtp_Adminhtml_MsmtpbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Email"));
       $helper = new MS_Msmtp_Helper_Data("");
       $helper->sendTestEmail("jim@thedotworldgroup.com");
	   $this->renderLayout();
    }
}