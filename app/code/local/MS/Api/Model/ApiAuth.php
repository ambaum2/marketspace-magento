<?php

interface MS_Api_Model_ApiAuth {
    public function Validate();
    public function GetAuthInfo();
    public function Encrypt();
    public function Decrypt();
    public function Request();
}
