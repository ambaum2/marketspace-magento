<?php
 
	class Dwg_Featuredprod_Block_Adminhtml_Featuredprod_Edit_Tab_Form extends Mage_Adminhtml_Block_Catalog_Form
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
        $fieldset = $form->addFieldset('featuredprod_form', array('legend'=>Mage::helper('featuredprod')->__('Item information')));
         $fieldset->addField('entity_id', 'hidden', array(
            'label'     => Mage::helper('featuredprod')->__('product id'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'entity_id',
            
        ));
         $fieldset->addField('featuredprod_id', 'hidden', array(
            'label'     => Mage::helper('featuredprod')->__('Record id'),
            'class'     => '',
            'required'  => false,
            'name'      => 'featuredprod_id',
            
        ));
	/* to prefill a select you must: 
	 1. Have the 'name' below the same as the key of the array being passed with setValues (at the bottom of this code)
	 2. the values array must have a corresponding value that matches the key=>value pair in the array
	*/
         $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('featuredprod')->__('Status'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'status',
            'values'	=> array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('featuredprod')->__('Featured'),
                ),
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('featuredprod')->__('Not Featured'),
                ),
 
            ),


        ));
         $fieldset->addField('feat_order', 'text', array(
            'label'     => Mage::helper('featuredprod')->__('Order 1 to ... if '),
            'class'     => '',
            'required'  => false,
            'name'      => 'feat_order',
            
        ));
         $fieldset->addField('feat_type', 'select', array(
            'label'     => Mage::helper('featuredprod')->__('Type'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'feat_type',
            'values'	=> array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('featuredprod')->__('Frontpage'),
                ),
 
            ),
        ));

        

        if ( Mage::getSingleton('adminhtml/session')->getFeaturedprodData() )
        {
		$form->setValues(Mage::getSingleton('adminhtml/session')->getFeaturedprodData());
	        Mage::getSingleton('adminhtml/session')->setFeaturedprodData(null);
        } elseif ( Mage::registry('featuredprod_data') ) {
	        $featuredprodData = Mage::registry('featuredprod_data')->getData();
	        $features = Mage::getModel('featuredprod/featuredprod')->getCollection()->addFilter('entity_id',$featuredprodData['entity_id'])->getFirstItem()->getData();
		//prefills form values
		//to make sure we get correct values from featureprod model $features must be second to override the product model array members
		// with matching keys.
		$featuredprodData = array_merge($featuredprodData,$features);
	        $form->setValues($featuredprodData);
        }
        return parent::_prepareForm();
    }
}
