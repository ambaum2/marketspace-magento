<?php

class MS_Template_Model_EmailAttachments extends Mage_Core_Model_Abstract
{
    public $type;
    public $mailer;
    public $items;
    public $order_id;
    public $order_created_at;
    /**
     * @param $items
     * @param $mailer a class that implents iMS_Template_Model_Core_Email_Template_Mailer
     * @internal param \an $products object of products
     */
    function __construct($items, $order, $mailer) {
        $this->mailer = $mailer;
        $this->items = $items;
        $this->order_id = $order['order_id'];
        $this->order_created_at = $order['order_created_at'];
        $this->type = new MS_Template_Model_Attachments_Types();
    }
    /**
     * process a given orders items and
     * create attachments for any valid products like
     * coupons and tickets. Then Add the attachments to the
     * mailer
     */
    public function put() {
        $pdfs = array();
        foreach($this->items as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            if($type = $this->type->get($product->getAttributeSetId())) { //probably should add an if to check that type is not an array next
                $AttachmentType = new $type;
                $AttachmentType->product = $product;
                $AttachmentType->order_id = $this->order_id;
                $AttachmentType->order_created_at = $this->order_created_at;
                $AttachmentType->order_quantity = $item->getQtyOrdered();
                $dompdf = new DOMPDF(); //create the pdf
                $html = $AttachmentType->get();
                $dompdf->load_html($html);
                $dompdf->render();
                $pdfs[$product->getName()] = $dompdf->output();
                $fp = fopen('data.txt', 'a+');
                fwrite($fp, $product->getName() . "hello \n");
                fclose($fp);
                //$this->mailer->addAttachment($output, $product->getName().".pdf");
            }
        }
        return $pdfs;
    }
}
