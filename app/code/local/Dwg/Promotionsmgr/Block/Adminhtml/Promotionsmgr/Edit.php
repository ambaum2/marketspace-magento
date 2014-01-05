<?php
 
	class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'promotionsmgr';
        $this->_controller = 'adminhtml_promotionsmgr';
 
        $this->_updateButton('save', 'label', Mage::helper('promotionsmgr')->__('Save Item'));
        //$this->_updateButton('delete', 'label', Mage::helper('promotionsmgr')->__('Delete Item'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('promotionsmgr_data') && Mage::registry('promotionsmgr_data')->getId() ) {
            return Mage::helper('promotionsmgr')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('promotionsmgr_data')->getName())); //changed from getTitle
        } else {
            return Mage::helper('promotionsmgr')->__('Add Item(in edit php)');
        }
    }
    protected function _prepareLayout() {
	 	parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	 	}
    } 
}