<?php
class MS_Msmtp_Adminhtml_MsmtpbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Email"));
	   $this->renderLayout();
    }
}