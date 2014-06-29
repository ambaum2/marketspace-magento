<?php

class MS_Msmtp_Model_Email extends Mage_Core_Model_Abstract
{
    public $body;
    public $cc; /* @var $cc array of emails */
    public $to;
    public $subject;
    public $from;
    public $host; /* @var $host should come from HTTP_HOST */
    public function __construct($body = "", $cc = array(), $to = "", $subject = "") {
        $this->setHost();
        $this->setFrom();
        $this->setCc($cc);
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setBody($body);
    }

    /**
     * @param string $from
     */
    public function SendEmail($from = "sales@communitymarketspace.com") {
        $mail = new Zend_Mail();

        $mail->addTo($this->to)
            ->addCc($this->cc)
            //->addBcc("sales_copy@communitymarketspace.com")
            ->setFrom($this->from)
            ->setSubject($this->subject)
            ->setBodyHtml($this->body);

        $transport = $this->getTransport();

        $mail->send($transport);
    }

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
     * @param string $body
     */
    public function setBody($body)
    {
        if(!empty($body)) {
            $this->body = $body;
        } else {
            $this->to = "error@communitymarketspace.com";
            $this->body = "blank body field for email";
        }
    }

    /**
     * @param mixed $cc
     */
    public function setCc($cc)
    {
        $this->cc = array();
        if($this->host !== 'test') { //if not test server @todo change this to something more modular and reliable
            $this->cc = $cc;
        } else {
            /*$test_cc = array();
            foreach($cc as $copy) {
                if(in_array($copy, array('abaum@aaortho.org', 'jim@thedotworldgroup.com')))
                    $test_cc[] = $copy;//'sales_copy@communitymarketspace.com');
            }*/
            $this->cc = $cc;
        }
    }

    /**
     * @param array $to
     */
    public function setTo($to)
    {
        $this->to = "sales_copy@communitymarketspace.com";
        //if not in test server
        if(!empty($to)) {
            if($this->host === 'test') {
                $this->to = "error@communitymarketspace.com";
            } else {
                $this->to = $to;
            }
        }
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        if(!empty($subject) && $this->host !== 'test') {
            $this->subject = $subject;
        } elseif($this->host === 'test') {
            $this->subject = 'Test Email ' . $subject;
        } else {
            $this->subject = "no subject error";
            $this->to = "error@communitymarketspace.com";
        }
    }

    /**
     *
     */
    public function setHost()
    {

        if(!isset($this->host) && strpos($_SERVER['HTTP_HOST'], 'test') === FALSE) {
            $this->host = $_SERVER['HTTP_HOST'];
        } else {
            $this->host = "test";
        }
    }

    /**
     *
     */
    public function setFrom()
    {
        if(!isset($this->from)) {
            $this->from = "sales@communitymarketspace.com";
        }
    }
}