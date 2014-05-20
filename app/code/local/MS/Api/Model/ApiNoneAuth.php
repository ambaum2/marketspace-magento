<?php

class MS_Api_Model_ApiNoneAuth extends Mage_Core_Model_Abstract implements MS_Api_Model_ApiAuth {
    /**
     * as of right now this would allow
     * anyone to use this. However, in the
     * future business rules may be needed
     * (possibly block ip addresses or other situations)
     * that is the reason this exists
     * @return bool
     */
    public function Validate()
    {
        return true;
    }

    public function GetAuthInfo()
    {
        // TODO: Implement GetAuthInfo() method.
    }

    public function Encrypt()
    {
        // TODO: Implement Encrypt() method.
    }

    public function Decrypt()
    {
        // TODO: Implement Decrypt() method.
    }

    public function Request()
    {
        // TODO: Implement Request() method.
    }
}