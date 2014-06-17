<?php

class MS_Api_Model_Adapters_CategoriesSql extends Mage_Core_Model_Abstract {
    protected $coreResource;
    protected $conn;
    public function __construct() {
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }

    /**
     * Get All descendents of a category -
     * defaults to root category (id 1)
     * @param int $parentId
     * @return mixed
     */
    public function GetCategoriesTree($parentId = 1, $categories = array(), $max_depth = -1) {
        /* @var $tree Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Tree */
        $tree = Mage::getResourceSingleton('catalog/category_tree')
            ->load();
        $root = $tree->getNodeById($parentId);
        if($root && $root->getId() == 1) {
            $root->setName(Mage::helper('catalog')->__('Root'));
        }

        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection */
        $collection = Mage::getModel('catalog/category')->getCollection();
        $collection->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');
        //(!empty($categories)) ? $collection->addAttributeToFilter('entity_id', array('in' => $categories)) : '';
        $tree->addCollectionData($collection, true);
        ($max_depth >= 0) ? $max_level = $max_depth + $root->getLevel() : $max_level = false;
        if(empty($categories)) {
            $result = $this->SortCategoriesTree($root, $max_level);
        } else {
            $result = $this->FilteredSortCategoriesTree($root, $categories, $max_level);
        }
        return $result;
    }

    /**
     * get all categories and subcategories of parent recursively
     * @param Varien_Data_Tree_Node $node
     * @param $max_level
     * @param array $result
     * @param $count
     * @return array
     */
    public function SortCategoriesTree(Varien_Data_Tree_Node $node, $max_level, &$result = array(), &$count = -1) {
        // Only basic category data up to the specied max level unless max level is false
        if(($node->getLevel() <= $max_level || !$max_level)) {
            $count++;
            $children = $node->getChildren();
            if($node->getIsActive() == 1 || $node->getId() == 1) {
                $result[$count]['category_id'] = $node->getId();
                $result[$count]['parent_id']   = $node->getParentId();
                $result[$count]['name']        = $node->getName();
                $result[$count]['is_active']   = $node->getIsActive();
                $result[$count]['position']    = $node->getPosition();
                $result[$count]['level']       = $node->getLevel();

                if($children->count() > 0) {
                    $result[$count]['has_children'] = true;
                } else {
                    $result[$count]['has_children'] = false;
                }
                foreach ($children as $child) {
                    $this->SortCategoriesTree($child, $max_level, $result, $count);
                }
            }
        }
        return $result;
    }

    /**
     * get all categories and subcategories of parent recursively
     * @param Varien_Data_Tree_Node $node
     * @param $categories
     * @param $max_level
     * @param array $result
     * @param $count
     * @internal param $max_level
     * @internal param array $result
     * @internal param $count
     * @return array
     */
    public function FilteredSortCategoriesTree(Varien_Data_Tree_Node $node, $categories, $max_level, &$result = array(), &$count = -1) {
        // Only basic category data up to the specied max level unless max level is false
        if(($node->getLevel() <= $max_level || !$max_level) ) {
            $children = $node->getChildren();
            if(in_array($node->getId(), $categories) && $node->getIsActive() == 1) {
                $count++;
                $result[$count]['category_id'] = $node->getId();
                $result[$count]['parent_id']   = $node->getParentId();
                $result[$count]['name']        = $node->getName();
                $result[$count]['is_active']   = $node->getIsActive();
                $result[$count]['position']    = $node->getPosition();
                $result[$count]['level']       = $node->getLevel();
                if($children->count() > 0) {
                    $result[$count]['has_children'] = true;
                } else {
                    $result[$count]['has_children'] = false;
                }
            }
            foreach ($children as $child) {
                $this->FilteredSortCategoriesTree($child, $categories, $max_level, $result, $count);
            }
        }
        return $result;
    }
    /**
     * @param Mage_Catalog_Model_Category $category
     * @return object
     * @internal param $category_id
     */
    public function GetCategoryFirstChildrenList(Mage_Catalog_Model_Category $category) {
        /* @var $collection Mage_Catalog_Model_Resource_Category_Collection */
        /*$collection = Mage::getModel('catalog/category')->getCollection();
            //->setStoreId($this->_getStoreId($store))

            $collection
                ->addAttributeToSelect('children')
                ->addAttributeToSelect('name')
                ->addAttributeToFilter('parent_id', array('eq' => $category->getId()))
            ;
        return $collection;*/
        /*$category = new Mage_Catalog_Model_Category_Api();
return $category->tree(null, null);*/
        /*$category = new Mage_Catalog_Model_Category_Api();
        return $category->level(null, null, 2);*/
        /*$collection = Mage::getModel('catalog/category')->getCollection()
            //->setStoreId($this->_getStoreId($store))
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');
        return $collection->getData();*/
        $subcategory_ids = $category->getChildren();
        $categoryCollection = Mage::getModel('catalog/category')->getCollection();
        $categoryCollection->addAttributeToSelect('name');
        $categoryCollection->addAttributeToSelect('url_path');
        $categoryCollection->addIdFilter($subcategory_ids);
        $categoryCollection->addIsActiveFilter();
        return $categoryCollection;
    }
}