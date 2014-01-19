<?php   
class MS_Filter_Block_Index extends Mage_Core_Block_Template{   

	public function getProductsByMarketspaceOwnerId($owner_id) {
		$productData = Mage::getModel('catalog/product')
			->getCollection()
			->addAttributeToSelect(array('name', 'url_key', 'url_path', 'thumbnail'))
			->addFieldToFilter('marketspace_owner', $owner_id);
		return $productData;
	}



}