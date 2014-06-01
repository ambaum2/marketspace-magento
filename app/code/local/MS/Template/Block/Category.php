<?php
class MS_Template_Block_Category extends Mage_Core_Block_Template {

    /**
     * @param Mage_Catalog_Model_Category $category
     * @return object
     */
    public function GetChildrenForNavigationLinks(Mage_Catalog_Model_Category $category) {
        $Model = new MS_Api_Model_Adapters_CategoriesSql();

        /* @var $collection Mage_Catalog_Model_Resource_Category_Collection */
        $collection = $Model->GetCategoryFirstChildrenList($category);
        return $collection;
    }
}