<?php
 
class Dwg_Featuredprod_Block_Adminhtml_Featuredprod_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('featuredprod_tabs');
        $this->setDestElementId('edit_form'); 
        $this->setTitle(Mage::helper('featuredprod')->__('Client Data Management'));
    }
 
    protected function _beforeToHtml()
    { 
        $this->addTab('form_section', array(
            'label'     => Mage::helper('featuredprod')->__('Item Management'),
            'title'     => Mage::helper('featuredprod')->__('Item Management'),
            'content'   => $this->getLayout()->createBlock('featuredprod/adminhtml_featuredprod_edit_tab_form')->toHtml(),
        ));

               $this->addTab('form_section', array(
            'label'     => Mage::helper('featuredprod')->__('Item Management'),
            'title'     => Mage::helper('featuredprod')->__('Item Management'),
            'content'   => $this->getLayout()->createBlock('featuredprod/adminhtml_featuredprod_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}