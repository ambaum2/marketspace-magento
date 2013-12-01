<?php
/**
 *  logic for working with attributes right
 * now mainly getters
 * 
 * @TODO - Remember a good api is about things not actions
 * ADD more things not actions. The below would be considered bad
 * design. You should instead have two classes (add two things) 
 * an AttributeOptions and AttributeData class and they should have
 * a single get, post, delete, etc 
 */

class Alan_MspaceApi_Model_V1_Inventory extends Mage_Core_Model_Abstract
{
	/**
	 * Loading stock item data by product
	 *
	 * @param Mage_CatalogInventory_Model_Stock_Item $item
	 * @param int $productId
	 * @return Mage_CatalogInventory_Model_Resource_Stock_Item
	 */
	public function loadByProductId(Mage_CatalogInventory_Model_Stock_Item $item, $productId)
	{
	    $select = $this->_getLoadSelect('product_id', $productId, $item)
	        ->where('stock_id = :stock_id');
	    $data = $this->_getReadAdapter()->fetchRow($select, array(':stock_id' => $item->getStockId()));
	    if ($data) {
	        $item->setData($data);
	    }
	    $this->_afterLoad($item);
	    return $this;
	}
		
}