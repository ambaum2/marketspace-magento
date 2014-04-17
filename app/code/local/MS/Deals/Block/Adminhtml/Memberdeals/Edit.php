<?php
	
class MS_Deals_Block_Adminhtml_Memberdeals_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "deals";
				$this->_controller = "adminhtml_memberdeals";
				$this->_updateButton("save", "label", Mage::helper("deals")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("deals")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("deals")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("memberdeals_data") && Mage::registry("memberdeals_data")->getId() ){

				    return Mage::helper("deals")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("memberdeals_data")->getId()));

				} 
				else{

				     return Mage::helper("deals")->__("Add Item");

				}
		}
}