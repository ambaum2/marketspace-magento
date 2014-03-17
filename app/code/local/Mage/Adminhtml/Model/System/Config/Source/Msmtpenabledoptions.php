<?php
class Mage_Adminhtml_Model_System_Config_Source_Msmtpenabledoptions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => 'enabled', 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => 'disabled', 'label'=>Mage::helper('adminhtml')->__('No'))
        );
    }

}
