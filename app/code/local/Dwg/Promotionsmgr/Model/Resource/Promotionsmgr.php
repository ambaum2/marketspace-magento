<?php
class Dwg_Promotionsmgr_Model_Resource_Eavag extends Mage_Eav_Model_Entity_Abstract
{
    protected function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('promotionsmgr_promotionsmgr');
        $this->setConnection(
            $resource->getConnection('promotionsmgr_read'),
            $resource->getConnection('promotionsmgr_write')
        );
    }
} 