<?php
class MS_Msmtp_Model_Core_Email_Template extends Mage_Core_Model_Email_Template
{
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

}
		