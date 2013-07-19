<?php
 
	class Dwg_Featuredprod_Block_Adminhtml_Featuredprod_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'featuredprod';
        $this->_controller = 'adminhtml_featuredprod';
 
        $this->_updateButton('save', 'label', Mage::helper('featuredprod')->__('Save Item'));
        //$this->_updateButton('delete', 'label', Mage::helper('featuredprod')->__('Delete Item'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('featuredprod_data') && Mage::registry('featuredprod_data')->getId() ) {
            return Mage::helper('featuredprod')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('featuredprod_data')->getName())); //changed from getTitle
        } else {
            //return Mage::helper('featuredprod')->__('Add Item(in edit php)');
        }
    }
    protected function _prepareLayout() {
 	parent::_prepareLayout();
	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
 	}
    } 
}