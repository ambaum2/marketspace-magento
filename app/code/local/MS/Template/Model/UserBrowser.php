<?php

class MS_Template_Model_UserBrowser extends Mage_Core_Model_Abstract
{
    public function getUnsupported($agent_string) {
        $browser_supported = true;
        preg_match('/MSIE (.*?);/', $agent_string, $matches);

        if (count($matches)>1){
            //Then we're using IE
            $version = $matches[1];

            switch(true){
                case ($version<=8):
                    $browser_supported = false;
                    break;

                case ($version==9):
                    //IE9!
                    break;

                default:
                    //You get the idea
            }
        }
        return $browser_supported;
    }
}
