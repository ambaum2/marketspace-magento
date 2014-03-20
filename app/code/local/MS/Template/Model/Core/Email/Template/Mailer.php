<?php

class MS_Template_Model_Core_Email_Template_Mailer extends Mage_Core_Model_Email_Template_Mailer
{
    protected $_afile = array();

    /**
     * @param $fileContents
     * @param $fileName
     * @return $this
     */
    public function addAttachment($fileContents,$fileName)
    {
        $tmp = array();
        $tmp['fileContents'] = $fileContents;
        $tmp['fileName'] = $fileName;
        $this->_afile = $tmp;
        return $this;
    }

    /**
     * Send all emails from email list
     * @see self::$_emailInfos
     *
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function send()
    {
        $emailTemplate = Mage::getModel('core/email_template');
        // Send all emails from corresponding list
        while (!empty($this->_emailInfos)) {
            $emailInfo = array_pop($this->_emailInfos);
            // Handle "Bcc" recepients of the current email
            $emailTemplate->addBcc($emailInfo->getBccEmails());
            if(!empty($this->_afile)) //add attachments to email
            {
                $emailTemplate->setEmAttachments($this->_afile); //(by dw)
            }
            // Set required design parameters and delegate email sending to Mage_Core_Model_Email_Template
            $emailTemplate->setDesignConfig(array('area' => 'frontend', 'store' => $this->getStoreId()))
                ->sendTransactional(
                    $this->getTemplateId(),
                    $this->getSender(),
                    $emailInfo->getToEmails(),
                    $emailInfo->getToNames(),
                    $this->getTemplateParams(),
                    $this->getStoreId()
                );
        }
        return $this;
    }
}