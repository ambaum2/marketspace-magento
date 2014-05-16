<?php

class MS_Api_Model_ModelResolver {
    public $Adapter;
    public $AuthType;
    public $Auth;
    public $RequestMethod;

    function __construct() {
        if(isset($this->AuthType)) {
            $AuthClass = "MS_Api_Model_" . $this->AuthType;
            $this->Auth = new $AuthClass;
        }

        if(empty($this->RequestMethod)) {
            $this->RequestMethod = "GET";
        }
    }

    /**
     * @param String $Name
     * @return mixed
     */
    public function ResolveModelName(String $Name) {
        try {
            $Model = new $Name;
        } catch(Exception $e) {
            throw new Exception("Model Does Not Exist");
        }
        return $Model;
    }
    /**
     * @return bool
     */
    public function Authenticate() {
        try {
            $result = $this->Auth->Validate();
        } catch(Exception $e) {
            $result = false;
        }
        return $result;
    }

    /**
     * @param MS_Api_Service $Model
     * @return array
     */
    public function Call(MS_Api_Model_Service $Model) {
        $result = array("error" => "Api Call Failed");
        try {
            $Authorized = true;
            if(isset($this->Auth)) {
                $Authorized = $this->Authenticate();
            }
            if($Authorized) {
                if(isset($Model->Adapter))
                    $Model->Adapter = $this->Adapter;
                $method = $this->RequestMethod;
                $result = $Model->$method();
            }
        } catch(Exception $e) {
            $result = array('error' => $e->getMessage());
        }
        return $result;
    }
}