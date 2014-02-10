<?php
 
	class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Edit_Tab_Form extends Mage_Adminhtml_Block_Catalog_Form
{
    protected function _prepareForm()
    {
	     //echo Mage::getSingleton('adminhtml/url')->getUrl('*/cms_wysiwyg_images/index');
	     //$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false, 'add_widgets' => false,'files_browser_window_url'=>'http://www.esmkt.thedotworldgroup.com/romance'));
	     $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
	     array( 
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
	   	$fieldset->addField('promotionsmgr_id', 'hidden', array(
	        'label'     => Mage::helper('promotionsmgr')->__('promotions id'),
	        'class'     => '',
	        'required'  => false,
	        'name'      => 'promotionsmgr_id',
	    ));

			/* to prefill a select you must: 
			 1. Have the 'name' below the same as the key of the array being passed with setValues (at the bottom of this code)
			 2. the values array must have a corresponding value that matches the key=>value pair in the array
			*/
       $fieldset->addField('status', 'select', array(
         'label' => Mage::helper('promotionsmgr')->__('Status'),
         'class' => 'required-entry',
         'required' => true,
         'name' => 'status',
         'value' => 1,
         'values'	=> array(
            array(
              'value' => 1,
            	'label' => Mage::helper('promotionsmgr')->__('Enabled'),
            ),
            array(
              'value' => 0,
              'label' => Mage::helper('promotionsmgr')->__('Disabled'),
          	),
        	),
    		));

       $fieldset->addField('position', 'select', array(
          'label'     => Mage::helper('promotionsmgr')->__('Position'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'position',
          'values'	=> array(
						array(
	            'value' => 'featured',
	            'label' => Mage::helper('promotionsmgr')->__('Featured Product'),
	          ),
	          array(
	          	'value' => 'right_top',
	            'label' => Mage::helper('promotionsmgr')->__('Right Sidebar Image')
						),
						array(
	            'value' => 'Slide',
	            'label' => Mage::helper('promotionsmgr')->__('Main Rotator')
						),
						array(
	            'value' => 'Experience Guide',
	            'label' => Mage::helper('promotionsmgr')->__('Experience Guide'),
	          ),
          ),
    		));
			 $order_values = array();
			 for($i=0; $i < 17; $i++) {
			   $order_values[] = array('value' => $i, 'label' => $i);
			 }
       $fieldset->addField('item_order', 'select', array(
         'label'     => Mage::helper('promotionsmgr')->__('Order from 1 to 16 '),
         'class'     => 'required-entry',
         'required'  => true,
         'name'      => 'item_order',
         'values'	=> $order_values,//array(array('value' => '3335', 'label' => 'default region'))
       ));		
		
       $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product','escape_region');
	 		 $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
		
       $fieldset->addField('region', 'select', array(
         'label'     => Mage::helper('promotionsmgr')->__('Region'),
         'class'     => 'required-entry',
         'required'  => false,
         'name'      => 'region',
         'values'	=> array_merge(array(array('value' => '0', 'label' => 'default region')), $attribute->getSource()->getAllOptions(false)), 
         'after_element_html' => '<small>We are not currently using this. We used to have an attribute called escape_region that 
        	was going to make it possible to have multiple region slideshows, featured products, etc<small>',         
        ));

        $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('promotionsmgr')->__('Category'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'category_id',
          'values'	=> Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr::getActiveCategories(),
        ));

        $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('promotionsmgr')->__('Link'),
          'class'     => '',
          'required'  => false,
          'name'      => 'link',
        ));

				$fieldset->addField('image_url', 'file', array(
					'label'     => Mage::helper('promotionsmgr')->__('Upload Image'),
					'required'  => false,
					'name'      => 'image_url',
					'after_element_html' => (!(empty($promotionsmgrData['image_url'])) ? "Current Image:<a href='".Mage::getBaseUrl('media') . DS 
						. "promotions" . DS . $promotionsmgrData['image_url'] ."' target='_blank'><img src='".Mage::getBaseUrl('media') . DS 
						. "promotions" . DS . $promotionsmgrData['image_url'] ."' width='50' height='50' /></a>": ''),
				));

        $fieldset->addField('image_alt_tag', 'text', array(
          'label'     => Mage::helper('promotionsmgr')->__('Image Alt Tag (description)'),
          'class'     => '',
          'required'  => false,
          'name'      => 'image_alt_tag',
        ));
	
		$requestInfo = $this->getRequest()->getBeforeForwardInfo();
		
        if ( isset($requestInfo) && $requestInfo['action_name'] == "new" )	{ //have a blank form if this is the new page//Mage::getSingleton('adminhtml/session')->getPromotionsmgrData()
       
        } elseif ( Mage::registry('promotionsmgr_data') ) {
	        $promotionsmgrData = Mage::registry('promotionsmgr_data')->getData();
	        $form->setValues($promotionsmgrData);			
        }
        return parent::_prepareForm();
    }
}
