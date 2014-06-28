<?php
class MS_Msmtp_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getSMTP() {
        return Mage::getStoreConfig('system/msmtp/smtp_type') == "smtp";
    }

    public function isEnabled() {
        return Mage::getStoreConfig('system/msmtp/smtp_enabled') != "disabled";
    }
    /**
     * get the config settings from system and setup email settings
     * @param null $id
     * @return Zend_Mail_Transport_Smtp
     */
    public function getTransport($id = null) {
        if($this->getSMTP()){
            $username = Mage::getStoreConfig('system/msmtp/username', $id);
            $password = Mage::getStoreConfig('system/msmtp/password', $id);
            $host = Mage::getStoreConfig('system/msmtp/host', $id);
            $port = Mage::getStoreConfig('system/msmtp/port', $id);
            $ssl = Mage::getStoreConfig('system/msmtp/ssl', $id);
            $auth = Mage::getStoreConfig('system/msmtp/authentication', $id);

            // Set up the config array

            $config = array();

            if ($auth != "none") {
                $config['auth'] = $auth;
                $config['username'] = $username;
                $config['password'] = $password;
            }

            if ($port) {
                $config['port'] = $port;
            }

            if ($ssl != "none" ) {
                $config['ssl'] = $ssl;
            }

            $transport = new Zend_Mail_Transport_Smtp($host, $config);
        }

        return $transport;
    }

    /**
     * @param string $recipient
     * @param string $from
     */
    public function sendTestEmail($recipient = 'ambaum2@gmail.com', $from = "info@communitymarketspace.com") {
        $to = $recipient;//Mage::getStoreConfig('contacts/email/recipient_email', $websiteModel->getId());

        $mail = new Zend_Mail();
        $sub = "Test Email From Marketspace Module";
        $body =
            "Marketspace Smtp Email Module Test ";

        $mail->addTo($to)
            ->setFrom($from)
            ->setSubject($sub)
            ->setBodyText($body);

        $transport = $this->getTransport();

        $mail->send($transport);
    }
}
	 