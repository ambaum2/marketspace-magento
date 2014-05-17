<?php

class MS_Api_Model_ModelResolver {
    public $Adapter;
    public $Auth;
    public $RequestMethod;

    /**
     * @param $AuthType
     * @param $RequestMethod
     */
    function __construct(MS_Api_Model_ApiAuth $AuthMethod, $RequestMethod) {
        $this->Auth = $AuthMethod;

        if(empty($RequestMethod)) {
            $this->RequestMethod = "GET";
        } else {
            $this->RequestMethod = $RequestMethod;
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
        $result = false;
        try {
            $result = $this->Auth->Validate();
        } catch(Exception $e) {
            throw new Exception("Access denied " . $e->getMessage());
        }
        return $result;
    }

    /**
     * @param MS_Api_Service $Model
     * @return array
     */
    public function Call(MS_Api_Model_Service $Model) {
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