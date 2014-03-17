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
		
            array('value' => 'tls', 'label'=>Mage::helper('adminhtml')->__('TLS')),
            array('value' => 'ssl', 'label'=>Mage::helper('adminhtml')->__('SSL')),
            array('value' => 'none', 'label'=>Mage::helper('adminhtml')->__('None')),
        );
    }

}
