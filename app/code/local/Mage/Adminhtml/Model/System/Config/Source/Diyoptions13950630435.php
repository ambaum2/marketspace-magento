<?php
class Mage_Adminhtml_Model_System_Config_Source_Diyoptions13950630435
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('TLS')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('SSL')),
        );
    }

}
