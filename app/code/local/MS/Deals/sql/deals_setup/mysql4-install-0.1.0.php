<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table IF NOT EXISTS ms_member_deals(
    id int not null auto_increment,
    product_id int(11) unsigned NOT NULL COMMENT 'product id',
    user_id int(11) unsigned NOT NULL COMMENT 'user id',
    quantity int(11) unsigned NOT NULL COMMENT 'quantity of deals ordered',
    created int(11) unsigned NOT NULL COMMENT 'time created timestamp',
    modified int(11) unsigned NOT NULL COMMENT 'time modified timestamp',
    primary key(id));
SQLTEXT;

$installer->run($sql);
$installer->addAttribute("catalog_product", "ms_member_deals_limit",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "group"    => "",
    "label"    => "Deals Limit",
    "input"    => "text",
    "class"    => "",
    "source"   => "",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => true,
    "default" => "1",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => "If this is a deals product type then this must be entered. It is the maximum amount of times this deal can be activated/purchased by a user."

	));
$installer->endSetup();
	 