<?php
class Mage_Adminhtml_Model_System_Config_Source_Diyoptions13950630430
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(

            "none" => Mage::helper('adminhtml')->__('None (ignore username/password)'),
            "login" => Mage::helper('adminhtml')->__('Login'),
            "plain" => Mage::helper('adminhtml')->__('Plain')
        );
    }

}
