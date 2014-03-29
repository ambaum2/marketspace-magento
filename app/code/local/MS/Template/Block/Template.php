<?php
class MS_Template_Block_Template extends Mage_Core_Block_Template {
    public $ProfileModel;
    function __construct($model = "") {
        if($model) {
            $this->ProfileModel = new $model;
        }
        $this->ProfileModel = new MS_Template_Model_SellerProfile();
    }

    /**
     * if product and not a profile then display see
     * all products. if product and is a profile check to
     * see if profile has at least one product and return
     * see all products url info
     * @param $_product
     * @return array|bool
     */
    public function getSeeAllProductUrl($_product) {
        if($result = $this->ProfileModel->getDisplaySellerProfileData($_product)) {

        } else {
            $result = false;
        }
        return $result;
    }

    public function getProfileUrl($_product) {
        if($result = $this->ProfileModel->getProfileUrl($_product)) {

        } else {
            $result = false;
        }
        return $result;
    }
}