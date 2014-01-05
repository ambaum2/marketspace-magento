<?php
 
class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        //These properties are from the parent class
        $this->_controller = 'adminhtml_promotionsmgr';
        $this->_blockGroup = 'promotionsmgr';
        $this->_headerText = Mage::helper('promotionsmgr')->__('Item Manager2');      
        parent::__construct();
        //_removeButton is called in the parent constructor so we have to remove it 
        // after the constructor is called. Notice the 'add' id is defined in the 
        // constructor - that is why it is hard coded here. I saw no way of dynamically
        // calling it
        //$this->_removeButton('add');
        
    }
	/*
	 *getActiveCategories
	 * returns an array of active categories and subcategories 
	 * the tree model is an array of subcategories for a category
	 * that goes from lowest category to highest category
	 * example: array(cat1level3, cat2level3, cat3level2)
	 */
	public function getActiveCategories() {
		$category = Mage::getModel('catalog/category')->getCollection()->setStoreId(1)
			->addAttributeToSelect('*')->addAttributeToSort('position','ASC')
			->addAttributeToFilter('is_active',1)->addAttributeToFilter('level',2); //get all level2 categories that are active
			$i=1;
			$categoryArr = array();
			$categoryArr[0]['label'] = "Homepage";//@todo make a seperate module for cms page elements
			$categoryArr[0]['value'] = "1"; //base category id (1) is on level 1 so should not be a conflict
			foreach($category as $cat) { //loop through level 2 categories
			    $categoryArr[$i]['label'] = $cat->getName();//set label and value for level 2 so it shows up first
			    $categoryArr[$i]['value'] = $cat->getId();
				$i++;   
				if($cat->getChildrenCount() > 0) {
					//if a category has children get the tree model 
					$children = $cat->getTreeModelInstance()->load()->getChildren($cat->getId());
					$children = array_reverse($children); //to display the parent categories before children
						foreach($children as $sub) { //loop through and set subcategories
					   		$subCat = Mage::getModel('catalog/category')->load($sub);
							$categoryArr[$i]['label'] = str_repeat("-",$subCat->getLevel()) . $subCat->getName();
							$categoryArr[$i]['value'] = $subCat->getId();   
							$i++;
						}
				} 
			}
		return $categoryArr;
	}
}