<?php

class MS_Template_Model_Attachments_Types_Tickets extends Mage_Core_Model_Abstract
{
    public $product;
    public $order;
    public $template_path = "/templates/TicketAttachment.php";
    /**
     * get the template html
     */
    public function get() {
        $product = $this->product;
        $order = $this->order;
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