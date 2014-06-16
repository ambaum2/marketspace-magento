<?php

class MS_Api_Model_Categories_Tree_Lists_Nested extends Mage_Core_Model_Abstract implements MS_Api_Model_Service {
    public $Adapter;
    public $parentCategory; //var int
    public $categories;
    public $maxDepth;
    protected $Daa;
    function __construct() {
        if(isset($this->Adapter)) {
            $this->Daa = new $this->Adapter;
        } else {
            $this->Daa = new MS_Api_Model_Adapters_CategoriesSql();
        }
    }

    public function get()
    {
        !is_array($this->categories) ? $this->categories = array() : '';
        //!empty($this->maxDepth) ? $this
        return $this->Daa->GetCategoriesTree($this->parentCategory, $this->categories, $this->maxDepth);
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function put()
    {
        // TODO: Implement put() method.
    }

    public function GetJson()
    {
        // TODO: Implement GetJson() method.
    }
}