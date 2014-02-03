<?php
/* 
1. determine where the user came from. Experience guide page, 
experience page (register or venue tickettype), or a general 
request (get all exp guides)
2.
*/
class Dwg_Template_Model_Media extends Mage_Catalog_Model_Product
{
	public function _construct() {
		parent::_construct();
		//$this->_init('template/media');
	}
	/**
	 * get non image and thumbnail images
	 * @param product
	 * 	object of type product model 
	 * @return array
	 * 	an array of images
	 */
	public function getProductImageRotatorImages($product) {
		$remove_images = array($product->getThumbnail(), $product->getImage());
		if(count($product->getMediaGalleryImages()) > 0) {
			$images = new Varien_Data_Collection();
			foreach ($product->getMediaGalleryImages() as $image) {				
				if ($image['disabled'] || in_array($image['file'], $remove_images)) {
				    continue; //don't return images if they are disabled or a thumbnail or main image
				}
				$image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
				$image['id'] = isset($image['value_id']) ? $image['value_id'] : null;
				$image['path'] = $this->getMediaConfig()->getMediaPath($image['file']);
			  $images->addItem(new Varien_Object($image));
			}
			$this->setData('media_gallery_images', $images);
		}
		return $this->getData('media_gallery_images');
	}
	/**
	 * get profile link from a profile attribute set
	 * for a given marketspace owner id
	 * @param _product
	 *  product model object
	 * @return array
	 * 	return product array 
	 */
	public function getProfileUrl($_product) {
		$result = array();
		if($_product->getAttributeSetId() != 12) {
	    $product = Mage::getModel("catalog/product")
	    	->getCollection()
				->addAttributeToSelect('url_path')
				->addAttributeToSelect('caption_for_see_all_products')
				->addAttributeToSelect('caption_for_link_to_profile')
				->addFieldToFilter('attribute_set_id', 12)
				->addFieldToFilter('marketspace_owner', $_product->getMarketspaceOwner())
				->getFirstItem();
			$result = $product->getData();
		}
		return $result;
	}
	/**
	 * get see all products link name
	 * @param _product
	 * 	product model object
	 * @return array
	 * return product array
	 */
	public function getSeeAllProductsUrl($_product) {
		$result = array();
    $product = Mage::getModel("catalog/product")
    	->getCollection()
			->addAttributeToSelect('url_path')
			->addAttributeToSelect('caption_for_see_all_products')
			->addFieldToFilter('marketspace_owner', $_product->getMarketspaceOwner())
			->getFirstItem();
		$result = $product->getData();
		return $result;		
	}
}