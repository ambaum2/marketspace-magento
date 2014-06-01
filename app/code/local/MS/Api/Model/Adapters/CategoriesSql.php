<?php

class MS_Api_Model_Adapters_CategoriesSql extends Mage_Core_Model_Abstract {
    protected $coreResource;
    protected $conn;
    public function __construct() {
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }

    /**
     * @param array $filter
     * @return mixed
     */
    public function GetCategoriesTree($parentId = null, $store = null) {
        /*$category = new Mage_Catalog_Model_Category_Api();
        return $category->tree(null, null);*/
        /*$category = new Mage_Catalog_Model_Category_Api();
        return $category->level(null, null, 2);*/
        /*$collection = Mage::getModel('catalog/category')->getCollection()
            //->setStoreId($this->_getStoreId($store))
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');
        return $collection->getData();*/
        /* @var $tree Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Tree */
        $tree = Mage::getResourceSingleton('catalog/category_tree')
            ->load();

        $root = $tree->getNodeById(1);

        if($root && $root->getId() == 1) {
            $root->setName(Mage::helper('catalog')->__('Root'));
        }

        $collection = Mage::getModel('catalog/category')->getCollection()
            //->setStoreId($this->_getStoreId($store))
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');

        $tree->addCollectionData($collection, true);

        return $this->SortCategoriesTree($root);
    }

    public function SortCategoriesTree(Varien_Data_Tree_Node $node, &$result = array()) {
        // Only basic category data
        $result[$node->getId()]['category_id'] = $node->getId();
        $result[$node->getId()]['parent_id']   = $node->getParentId();
        $result[$node->getId()]['name']        = $node->getName();
        $result[$node->getId()]['is_active']   = $node->getIsActive();
        $result[$node->getId()]['position']    = $node->getPosition();
        $result[$node->getId()]['level']       = $node->getLevel();

        $children = $node->getChildren();

        if($children->count() > 0) {
            $result[$node->getId()]['has_children'] = true;
        } else {
            $result[$node->getId()]['has_children'] = false;
        }
        foreach ($children as $child) {
            $this->SortCategoriesTree($child, $result);
        }

        return $result;
    }

    /**
     * @param $category_id
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
        $subcategory_ids = $category->getChildren();
        $categoryCollection = Mage::getModel('catalog/category')->getCollection();
        $categoryCollection->addAttributeToSelect('name');
        $categoryCollection->addAttributeToSelect('url_path');
        $categoryCollection->addIdFilter($subcategory_ids);
        $categoryCollection->addIsActiveFilter();
        return $categoryCollection;
    }
}