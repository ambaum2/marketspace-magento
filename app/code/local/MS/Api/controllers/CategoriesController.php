<?php
class MS_Api_CategoriesController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        //@TODO use get class methods to output a map of all available methods
        //with documentation
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody("No Info");
    }

    public function TreeAction() {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', '1');
        $app = new Phalcon\Mvc\Micro();

        $app->get('(/.*)*', function() {
            $json = array("result" => "api info");
            return json_encode($json);
        });

        $json = $app->get('/ms-api/categories/tree/lists/{ListName}/{parent_id:[0-9]+}/{depth:[0-9]+}}',
            function($ListName = "Nested", $parent_id, $depth = 0) {
            try {
                /*$Authentication = new MS_Api_Model_ApiTokenAuth();
                $Authentication->Iv = $_SERVER['HTTP_AUTHIV'];
                $Authentication->Text = $_SERVER['HTTP_AUTHTOKEN'];*/
                $Authentication = new MS_Api_Model_ApiNoneAuth();
                $ModelResolver = new MS_Api_Model_ModelResolver($Authentication, $_SERVER["REQUEST_METHOD"]);
                $ModelName = "MS_Api_Model_Categories_Tree_Lists_" . $ListName;
                $Model = $ModelResolver->ResolveModelName($ModelName);
                $Model->parentCategory = $parent_id;
                $Model->maxDepth = $depth;
                $result = $ModelResolver->Call($Model);
                $json = json_encode($result);
            } catch(Exception $e) {
                $json = array("error" => $e->getMessage());
            }
            return $json;
        });
        $json = $app->get('/ms-api/categories/tree/lists/filtered/{ListName}/{parent_id:[0-9]+}/{depth:[0-9]+}/{categories_filter:([0-9]+(,[0-9]+)*)}',
            function($ListName = "Nested", $parent_id, $depth = 0, $categories_filter = array()) {
                try {
                    /*$Authentication = new MS_Api_Model_ApiTokenAuth();
                    $Authentication->Iv = $_SERVER['HTTP_AUTHIV'];
                    $Authentication->Text = $_SERVER['HTTP_AUTHTOKEN'];*/
                    $Authentication = new MS_Api_Model_ApiNoneAuth();
                    $ModelResolver = new MS_Api_Model_ModelResolver($Authentication, $_SERVER["REQUEST_METHOD"]);
                    $ModelName = "MS_Api_Model_Categories_Tree_Lists_" . $ListName;
                    $Model = $ModelResolver->ResolveModelName($ModelName);
                    $Model->parentCategory = $parent_id;
                    $Model->categories = explode(',', $categories_filter);
                    $Model->maxDepth = $depth;
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