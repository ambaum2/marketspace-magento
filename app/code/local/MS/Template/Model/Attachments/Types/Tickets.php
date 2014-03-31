<?php

class MS_Template_Model_Attachments_Types_Tickets extends Mage_Core_Model_Abstract
{
    public $product;
    public $order_id;
    public $order_quantity;
    public $order_created_at;
    public $template_path = "/templates/TicketAttachment.php";
    /**
     * get the template html
     */
    public function get() {
        $product = $this->product;
        $order_id = $this->order_id;
        $order_quantity = $this->order_quantity;
        $order_created_at = $this->order_created_at;
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