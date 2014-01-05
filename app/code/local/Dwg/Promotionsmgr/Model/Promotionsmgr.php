<?php
/* 
1. determine where the user came from. Experience guide page, 
experience page (register or venue tickettype), or a general 
request (get all exp guides)
2.
*/
class Dwg_Promotionsmgr_Model_Promotionsmgr extends Mage_Core_Model_Abstract
{
	public function _construct() {
		parent::_construct();
		$this->_init('promotionsmgr/promotionsmgr');
	}
	public function getProductFormData($productId = null) {

		if($productId != null) {
			$product = Mage::getModel('catalog/product')->load($productId);	
			$validTicketTypes = array("register-venue","register-experience","information");
			$attributeSetName = Mage::getModel("eav/entity_attribute_set")
				->load($product->getAttributeSetId())
				->getAttributeSetName();
			if($attributeSetName == "Experience Guide") {
				$productData = array($product->getVendorEmail(),$product->getEscapeRegion(),$product->getExperienceCategories());	
			} elseif(array_search($product->getTicketType(),$validTicketTypes)!==false) {
				$productData = array($product->getVendorEmail(),$product->getEscapeRegion(),$product->getExperienceCategories());
			}		
		}
		if(!(isset($productData))) {
			$productData = $this->getAllProductsByAttributeSet('Experience Guide');
		}
		return $productData;
	}
	//get all products by attribute set return array
	public function getAllProductsByAttributeSet($attributeSetName) {
			$attributeSetId = Mage::getModel('eav/entity_attribute_set')
				->load($attributeSetName)
				->getAttributeSetId();
			$productData = Mage::getModel('catalog/product')
				->getCollection()
				->addAttributeToSelect('*')
				->addFieldToFilter('attribute_set_id',$attributeSetId);
			return $productData;
	}
	
	public function getAttributeOptionName($attribute,$optionId) {
		$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product',$attribute);
 		$attributeModel = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
		foreach($attributeModel->getSource()->getAllOptions(false) as $opt) {
			if($opt['value'] == $optionId) {
				return $opt['label'];
			}
		}
	}
	
	public function getAllAttributeOptions($attribute) {
		$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product',$attribute);
 		$attributeModel = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
		return $attributeModel->getSource()->getAllOptions(false);
	}
}