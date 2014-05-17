<?php
class MS_Api_ProductController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        //@TODO use get class methods to output a map of all available methods
        //with documentation
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody("No Info");
    }

    public function UsersAction() {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', '1');
        $app = new Phalcon\Mvc\Micro();

        $app->get('(/.*)*', function() {
            $json = array("result" => "api info");
            return json_encode($json);
        });

        $json = $app->get('/ms-api/product/users/{Uid:[0-9]+}/lists/{ListName}', function($Uid, $ListName = "ProductType") {
            try {
                $Authentication = new MS_Api_Model_ApiTokenAuth();
                $Authentication->Iv = $_SERVER['HTTP_AUTHIV'];
                $Authentication->Text = $_SERVER['HTTP_AUTHTOKEN'];

                $ModelResolver = new MS_Api_Model_ModelResolver($Authentication, $_SERVER["REQUEST_METHOD"]);
                $ModelName = "MS_Api_Model_Products_Users_Lists_" . $ListName;
                $Model = $ModelResolver->ResolveModelName($ModelName);
                $Model->Uid = $Uid;
                $result = $ModelResolver->Call($Model);
                $json = json_encode($result);
            } catch(Exception $e) {
                $json = array("error" => $e->getMessage());
            }
            return $json;
        });

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($app->handle());

    }
}