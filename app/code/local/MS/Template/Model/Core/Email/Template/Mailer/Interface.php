<?php

/**
 * Created by PhpStorm.
 * User: alan
 * Date: 3/29/14
 * Time: 8:19 PM
 */
interface MS_Template_Model_Core_Email_Template_Mailer_Interface
{
    /**
     * @param $fileContents
     * @param $fileName
     * @return $this
     */
    public function addAttachment($fileContents, $fileName);

    /**
     * Set template id
     *
     * @param int $templateId
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function setTemplateId($templateId);

    /**
     * Overwrite data in the object.
     *
     * $key can be string or array.
     * If $key is string, the attribute value will be overwritten by $value
     *
     * If $key is an array, it will overwrite all the data in the object.
     *
     * @param string|array $key
     * @param mixed $value
     * @return Varien_Object
     */
    public function setData($key, $value = null);

    /**
     * Add data to the object.
     *
     * Retains previous data in the object.
     *
     * @param array $arr
     * @return Varien_Object
     */
    public function addData(array $arr);

    /**
     * Send all emails from email list
     * @see self::$_emailInfos
     *
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function send();
}