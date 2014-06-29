<?php

class MS_Template_Model_SalesNotifications extends Mage_Core_Model_Abstract
{
    public $type; /* @todo put an interface in for this */
    public $mailer;
    public $items; /* @var $items all items in the order */
    public $order_id;
    public $order;
    public $address;
    public $sales_order;
    public $order_created_at;
    /**
     * @param $items
     * @param $mailer a class that implents iMS_Template_Model_Core_Email_Template_Mailer
     * @internal param \an $products object of products
     */
    function __construct($items, $sales_order) {
        $this->items = $items;
        $this->sales_order = $sales_order;
    }

    public function VendorNotification() { //vendor_email
        $sales_order = $this->sales_order;
        $address = $this->address;
        foreach($this->items as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            ($product->getVendorEmail()) ? $vendor_emails = explode(',', str_replace(" ", "", $product->getVendorEmail())) : $vendor_emails = array('sales_copy@communitymarketspace.com');
            ob_start();
            require(Mage::getModuleDir('templates', 'MS_Template') . '/templates/VendorEmail.php');
            $html = ob_get_clean();
            $email = new MS_Msmtp_Model_Email($html, $vendor_emails, 'ambaum2@gmail.com', 'Community MarketSpace: New Order # ' . $sales_order->getRealOrderId());
            $email->SendEmail();
        }
    }
}