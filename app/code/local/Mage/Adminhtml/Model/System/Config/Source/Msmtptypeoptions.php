<?php
class Mage_Adminhtml_Model_System_Config_Source_Msmtptypeoptions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => 'smtp', 'label'=>Mage::helper('adminhtml')->__('smtp')),
            array('value' => 'disabled', 'label'=>Mage::helper('adminhtml')->__('disabled'))
        );
    }

}
