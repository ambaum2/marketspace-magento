<?php

class MS_Api_Model_Products_Users_Lists_ProductType extends Mage_Core_Model_Abstract implements MS_Api_Model_Service {
    public $Adapter;
    public $Uid;
    protected $Daa;
    function __construct() {
        if(isset($this->Adapter)) {
            $this->Daa = new $this->Adapter;
        } else {
            $this->Daa = new MS_Api_Model_Adapters_ProductsSql();
        }
    }

    public function get()
    {
        return $this->Daa->GetUsersListProductType($this->Uid);
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