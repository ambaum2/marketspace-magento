<?php 
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('featuredprod')};
CREATE TABLE {$this->getTable('featuredprod')} (
	`featuredprod_id` int(11) unsigned NOT NULL auto_increment,
	`status` int(3) NOT NULL,
	`feat_type` int(3) NOT NULL,
	`feat_order` int(4) NOT NULL,
	`entity_id` int(11) NOT NULL,
	`updated_time` datetime NULL,
	
	PRIMARY KEY (`featuredprod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	");
	
$installer->endSetup();
	