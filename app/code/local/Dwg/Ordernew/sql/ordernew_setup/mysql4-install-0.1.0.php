<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('ordernew')};
CREATE TABLE {$this->getTable('ordernew')} (
  `sales_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(11) unsigned NOT NULL,
  `exp_maker_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 