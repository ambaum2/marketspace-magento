<?php


class MS_Deals_Block_Adminhtml_Memberdeals extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_memberdeals";
	$this->_blockGroup = "deals";
	$this->_headerText = Mage::helper("deals")->__("Memberdeals Manager");
	$this->_addButtonLabel = Mage::helper("deals")->__("Add New Item");
	parent::__construct();
	
	}

}