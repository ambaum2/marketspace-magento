<?php

class MS_Template_Model_Attachments_Types_Coupons extends Mage_Core_Model_Abstract
{
    public $product;
    public $order_id;
    public $order_quantity;
    public $template_path = "/templates/CouponAttachment.php";
    /**
     * get the template html
     */
    public function get() {
        $product = $this->product;
        $order_id = $this->order_id;
        $order_quantity = $this->order_quantity;
        $terms = "some terms";
        ob_start();
        include(Mage::getModuleDir('', 'MS_Template') . $this->template_path);
        $output = ob_get_clean();
        return $output;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->template_path;
    }

    /**
     * @param string $template_path
     */
    public function setTemplatePath($template_path)
    {
        $this->template_path = $template_path;
    }
}