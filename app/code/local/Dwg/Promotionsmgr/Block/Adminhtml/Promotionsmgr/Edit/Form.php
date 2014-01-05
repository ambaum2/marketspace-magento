<?php
 //create a new file like this for each form to have a tab. make each with a unique id
class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
	            'id' => 'edit_form',
	            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
	            'method' => 'post',
	            'enctype' => 'multipart/form-data',
	         )
        );
 
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}