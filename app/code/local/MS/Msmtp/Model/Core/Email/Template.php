<?php
class MS_Msmtp_Model_Core_Email_Template extends Mage_Core_Model_Email_Template
{
    protected $_filedata = array(); //(by dw)

    public function setEmAttachments($attachments)
    {
        $this->setOrderAttachments($attachments);
    }

    public function getEmAttachments()
    {
        return $this->getOrderAttachments();
    }

    public function setOrderAttachments($attachments)
    {
        $this->_filedata = $attachments;
        return $this;
    }

    public function getOrderAttachments()
    {
        return $this->_filedata;
    }
    /**
     * Retrieve mail object instance
     *
     * @return Zend_Mail
     */
    public function getMail()
    {
        if (is_null($this->_mail)) {
            if (!Mage::helper('msmtp')->isEnabled()) {
                return parent::getMail();
            } else {
                $helper = new MS_Msmtp_Helper_Data();
                $transport = $helper->getTransport();
                Zend_Mail::setDefaultTransport($transport);
            }

            $this->_mail = new Zend_Mail('utf-8');
        }
        return $this->_mail;
    }
    /**
     * Send mail to recipient
     *
     * @param   array|string       $email        E-mail(s)
     * @param   array|string|null  $name         receiver name(s)
     * @param   array              $variables    template variables
     * @return  boolean
     **/
    public function send($email, $name = null, array $variables = array())
    {
        if (!$this->isValidForSend()) {
            Mage::logException(new Exception('This letter cannot be sent.')); // translation is intentionally omitted
            return false;
        }

        $emails = array_values((array)$email);
        $names = is_array($name) ? $name : (array)$name;
        $names = array_values($names);
        foreach ($emails as $key => $email) {
            if (!isset($names[$key])) {
                $names[$key] = substr($email, 0, strpos($email, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);

        ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

        $mail = $this->getMail();

        $setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
        switch ($setReturnPath) {
            case 1:
                $returnPathEmail = $this->getSenderEmail();
                break;
            case 2:
                $returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
                break;
            default:
                $returnPathEmail = null;
                break;
        }

        if ($returnPathEmail !== null) {
            $mailTransport = new Zend_Mail_Transport_Sendmail("-f".$returnPathEmail);
            Zend_Mail::setDefaultTransport($mailTransport);
        }

        foreach ($emails as $key => $email) {
            $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');
        }

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);

        if($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $mail->setBodyHTML($text);
        }

        $mail->setSubject('=?utf-8?B?' . base64_encode($this->getProcessedTemplateSubject($variables)) . '?=');
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());
        //add attachments
        $atInfo = $this->getEmAttachments();
        if(!empty($atInfo))
        {
            $_file = $mail->createAttachment($atInfo['fileContents']);
            $_file->type = 'application/pdf'; //the type should be as per your file
            $_file->filename = $atInfo['fileName'];
        }
        try {
            $mail->send();
            $this->_mail = null;
        }
        catch (Exception $e) {
            $this->_mail = null;
            Mage::logException($e);
            return false;
        }

        return true;
    }

}
		