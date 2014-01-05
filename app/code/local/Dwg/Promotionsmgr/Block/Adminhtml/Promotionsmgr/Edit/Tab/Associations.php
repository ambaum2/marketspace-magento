<?php
 
	class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Edit_Tab_Associations extends Mage_Adminhtml_Block_Catalog_Form
{
    protected function _prepareForm()
    {
    //echo Mage::getSingleton('adminhtml/url')->getUrl('*/cms_wysiwyg_images/index');
     //$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false, 'add_widgets' => false,'files_browser_window_url'=>'http://www.esmkt.thedotworldgroup.com/romance'));
     $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array( 
		'add_images' => true, 
		'add_variables' => false,
		'add_widgets' => false,
		'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'), 
		'files_browser_window_width' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'), 
		'files_browser_window_height'=> (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height'),

)); 
        $form = new Varien_Data_Form();
        $this->setForm($form);
		$promotionsmgrData = Mage::registry('promotionsmgr_data')->getData();
        

        $fieldset = $form->addFieldset('promotionsmgr_form', array('legend'=>Mage::helper('promotionsmgr')->__('Item information')));
		$fieldset->addField('guide_id', 'text', array(
            'label'     => Mage::helper('promotionsmgr')->__('Guide Id'),
            'class'     => '',
            'required'  => false,
            'name'      => 'guide_id',
        ));
		
		$fieldset->addField('product_id', 'text', array(
            'label'     => Mage::helper('promotionsmgr')->__('Product Id'),
            'class'     => '',
            'required'  => false,
            'name'      => 'product_id',
            'after_element_html' => '<small>Manually enter in the product id for a featured product
            	until i refactor the api</small>',
        ));
		
         $fieldset->addField('credits_link', 'text', array(
            'label'     => Mage::helper('promotionsmgr')->__('Credits Link'),
            'class'     => '',
            'required'  => false,
            'name'      => 'credits_link',
        ));

        $fieldset->addField('start_time', 'text', array(
            'label'     => Mage::helper('promotionsmgr')->__('Start Date'),
            'class'     => 'admin-date-picker',
            'required'  => false,
						'input_format' => Varien_Date::DATE_INTERNAL_FORMAT, 
            'name'      => 'start_time',
        ));
        $fieldset->addField('end_time', 'text', array(
            'label'     => Mage::helper('promotionsmgr')->__('End Date'),
            'class'     => 'admin-date-picker',
            'required'  => false,
						'input_format' => Varien_Date::DATE_INTERNAL_FORMAT, 
            'name'      => 'end_time',
        ));


		
		$requestInfo = $this->getRequest()->getBeforeForwardInfo();
		
        if ( isset($requestInfo) && $requestInfo['action_name'] == "new" )	{ //have a blank form if this is the new page//Mage::getSingleton('adminhtml/session')->getPromotionsmgrData()
	       // Mage::getSingleton('adminhtml/session')->setPromotionsmgrData(null);
        } elseif ( Mage::registry('promotionsmgr_data') ) {
	        $promotionsmgrData = Mage::registry('promotionsmgr_data')->getData();
	        $form->setValues($promotionsmgrData);	
        }
        return parent::_prepareForm();
    }
}
