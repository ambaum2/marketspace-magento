<?php

class MS_Template_Model_Attachments_Types extends Mage_Core_Model_Abstract
{
    public $attribute_type;
    public $product_quantity;
    public $product;
    /**
     * get all attachment types
     */
    public function get($type = '') {
        $types = array(
            16 => 'MS_Template_Model_Attachments_Types_Coupons',
            17 => 'MS_Template_Model_Attachments_Types_Tickets',
            10 => 'MS_Template_Model_Attachments_Types_Reservations'
        );
        if(!empty($type)) {
            if($types[$type]) {
                $result = $types[$type];
            } else {
                $result = false;
            }
        } else {
            $result = $types;
        }
        return $result;
    }
}