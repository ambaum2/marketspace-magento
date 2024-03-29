<?php
class MS_Deals_Block_Adminhtml_Memberdeals_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("memberdeals_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("deals")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("deals")->__("Item Information"),
				"title" => Mage::helper("deals")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("deals/adminhtml_memberdeals_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
