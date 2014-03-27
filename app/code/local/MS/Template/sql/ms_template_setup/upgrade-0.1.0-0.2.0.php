<?php
//programmatically create browser unsupported page
$installer = $this;
$installer->startSetup();
$cmsPageData = array(
    'title' => 'Please Upgrade Your Browser',
    'root_template' => 'one_column',
    'meta_keywords' => 'browser,southern illinois, marketspace',
    'meta_description' => 'southern illinois marketspace',
    'identifier' => 'unsupported-browser',
    'content_heading' => 'Browser Not Supported',
    'stores' => array(0),//available for all store views
    'content' => "<h2>Please upgrade your browser to use this site.</h2>"
        . "<a href = 'http://windows.microsoft.com/en-us/internet-explorer/download-ie'>Internet Explorer</a>"
        . "<br />",
);

Mage::getModel('cms/page')->setData($cmsPageData)->save();

$installer->endSetup();