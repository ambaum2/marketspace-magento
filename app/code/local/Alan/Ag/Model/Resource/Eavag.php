<?php
class Alan_Ag_Model_Resource_Eavag extends Mage_Eav_Model_Entity_Abstract
{
    protected function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('ag_eavag');
        $this->setConnection(
            $resource->getConnection('ag_read'),
            $resource->getConnection('ag_write')
        );
    }
} 