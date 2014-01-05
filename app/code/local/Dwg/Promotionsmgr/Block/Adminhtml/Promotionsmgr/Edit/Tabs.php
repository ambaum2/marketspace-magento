<?php
 
class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('promotionsmgr_tabs'); //the id for the system
        $this->setDestElementId('edit_form');  //where (what form) the tabs should go under
        $this->setTitle(Mage::helper('promotionsmgr')->__('Promotions Manager'));
    }
 
    protected function _beforeToHtml()
    { 
        $this->addTab('form_section', array(
            'label'     => Mage::helper('promotionsmgr')->__('Placement'),
            'title'     => Mage::helper('promotionsmgr')->__('Placement'),
            'content'   => $this->getLayout()->createBlock('promotionsmgr/adminhtml_promotionsmgr_edit_tab_form')->toHtml(),
        ));

       $this->addTab('associations', array(
            'label'     => Mage::helper('promotionsmgr')->__('Product Associations & Settings'), //name in admin
            'title'     => Mage::helper('promotionsmgr')->__('Product Associations'), //name of tab for system
            'content'   => $this->getLayout()->createBlock('promotionsmgr/adminhtml_promotionsmgr_edit_tab_associations')->toHtml(), //call to individual form Tab/Form1, Tab/Form2 etc
        ));
        return parent::_beforeToHtml();
    }
}