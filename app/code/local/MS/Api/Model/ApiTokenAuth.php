<?php

class MS_Api_Model_ApiTokenAuth extends Mage_Core_Model_Abstract implements MS_Api_ApiAuth {
    public $Text;
    public $Iv;
    public $Request;
    protected static $secret = "a42342963283bb395a0430346e4d49ad";
    protected $Key = "18a1a224151413a53056b609a85d1085";

    /**
     * validate the given token by unencrypting and inspecting the secret key
     * to make sure it matches the secret key on file
     *
     * @throws Exception
     * @internal param $ authtoken | string
     *  the encrypted secret key and timestamp to be
     *  validated
     * @internal param $ iv | string
     *  base64 encoded iv used to encrypt the token
     * @return boolean
     *  true if token is valid false otherwise
     */
    public function Validate() {
        if(!isset($this->iv) && !isset($this->Text))
            throw new Exception("IV or Token Not Set");

        $this->Iv = base64_decode($this->Iv);
        $Unencrypted = $this->Decrypt($this->Text);
        $AuthInfo = $this->getAuthInfoArray($Unencrypted);
        if(isset($AuthInfo[1])) {
            if($AuthInfo[0] == self::$secret) {
                if((time() - $AuthInfo[1]) < 600) {
                    return true;
                } else {
                    throw new Exception("Request Token Expired Error ", 1);
                }
            }
        } else {
            throw new Exception("Bad Token 1100t", 1);
        }
        return false;
    }

    /**
     * return an array of secret and timestamp from
     * unencrypted auth token
     * @param text
     * @return array
     */
    public function GetAuthInfo() {
        $authInfo = explode("|", $this->Text);
        return $authInfo;
    }
    /**
     * decrypt data
     * data will come over url encoded
     * but no need to urldecode that happens
     * automatically with arg
     * @param text string
     * 	base64 encoded string encrypted
     * 	with ecb
     * @return string
     * return decrypted string
     */
    public function Decrypt() {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->Key, base64_decode($this->Text), MCRYPT_MODE_CBC, $this->Iv));
    }

    /**
     * urlencrypt data
     *
     * @param data | mixed
     * @return string
     * 	returns a base 64 encoded string from secret key
     */
    public function Encrypt() {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->Key, $this->Text, MCRYPT_MODE_CBC, $this->Iv)));
    }
    /**
     *	encrypt data with a timestamp, ECB, and
     * then base64 encode and urlencode
     *
     * @param requestData | array or object
     * 	array or object keyed according to api methods
     * instructions
     * @return string
     * 	encrypted baset64 and url encoded string
     */
    public function Request() {
        $this->Request['request_time'] = time();
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $data = json_encode($this->Request);
        $base64_encoded_data = $this->encryptBase64($data, $iv);
        $data_url_encode = urlencode($base64_encoded_data);
        return $data_url_encode;
    }
}