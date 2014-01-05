<?php 
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('promotionsmgr')};
CREATE TABLE {$this->getTable('promotionsmgr')} (
	`promotionsmgr_id` int(11) unsigned NOT NULL auto_increment,
	`status` int(1) NOT NULL,
	`position` int(2) NOT NULL,
	`order` int(4) NOT NULL,
  `region` int(7) NOT NULL,
	`category_id` int(7) NOT NULL,
	`product_id` int(11) NULL,
  `image_url` varchar(50) NOT NULL,
  `link` varchar(75) NOT NULL,
  `start_time` datetime NULL,
  `end_time` datetime NULL,
	`updated_time` datetime NULL,
	
	PRIMARY KEY (`promotionsmgr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	");
	
$installer->endSetup();
	