<?php

class MS_Template_Model_StringFormatting extends Mage_Core_Model_Abstract
{
    /**
     * @param String $html_string
     * @param int $number_of_paragraphs
     * @return array
     */
    public function ExtractParagraphs($html_string, $number_of_paragraphs = 1) {
        $paragraph = array();
        $position = 0;
        for($i = 0; $i < $number_of_paragraphs; $i++) {
            $paragraph[] = substr($html_string, $position, (strpos($html_string, "</p>", $position) + 4) - $position);
            $position = (strpos($html_string, "</p>", $position) + 4);
        }
        return $paragraph;
    }

    /**
     * @param array $paragraphs
     * @param array $allowTags
     * @return string
     */
    public function GetParagraphString($paragraphs, $allowTags = array('p', 'span', 'strong')) {
        $result = "";
        $filter = new Zend_Filter_StripTags(array('allowTags'=>$allowTags));
        foreach($paragraphs as $p) {
            $result .= $p;
        }
        return $filter->filter($result);
    }

    /**
     * @param String $html_string
     * @param Int $number_of_paragraphs
     * @return mixed
     */
    public static function ExtractParagraphString($html_string, $number_of_paragraphs = 1) {
        $paragraphs = self::ExtractParagraphs($html_string, $number_of_paragraphs);
        return self::GetParagraphString($paragraphs);
    }
}