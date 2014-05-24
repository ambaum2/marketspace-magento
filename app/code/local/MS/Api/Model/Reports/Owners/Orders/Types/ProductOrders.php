<?php

class MS_Api_Model_Reports_Owners_Orders_Types_ProductOrders extends Mage_Core_Model_Abstract implements MS_Api_Model_Service {
    public $Adapter;
    public $Uid;
    /**
     * @var - array of products
     */
    public $Products;
    protected $Daa;
    function __construct() {
        if(isset($this->Adapter)) {
            $this->Daa = new $this->Adapter;
        } else {
            $this->Daa = new MS_Api_Model_Adapters_ReportsSql();
        }
    }

    /**
     * returns an array formatted in report form
     * for highchartsJS
     * @return mixed
     */
    public function get()
    {
        if(empty($this->Uid))
            throw new Exception('Uid not set');
        $result = $this->Daa->GetOwnersOrdersProductsCountByMonth($this->Uid, $this->Products);
        return $result;
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