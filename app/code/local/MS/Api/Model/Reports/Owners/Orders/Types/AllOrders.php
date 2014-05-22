<?php

class MS_Api_Model_Reports_Owners_Orders_Types_AllOrders extends Mage_Core_Model_Abstract implements MS_Api_Model_Service {
    public $Adapter;
    public $Uid;
    protected $Daa;
    function __construct() {
        if(isset($this->Adapter)) {
            $this->Daa = new $this->Adapter;
        } else {
            $this->Daa = new MS_Api_Model_Adapters_ReportsSql();
        }
    }

    public function get()
    {

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