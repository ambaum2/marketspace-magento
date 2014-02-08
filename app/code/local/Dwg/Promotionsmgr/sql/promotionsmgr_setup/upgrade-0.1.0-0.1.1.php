<?php
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `promotionsmgr`
	ADD COLUMN `image_alt_tag` VARCHAR(155) NULL AFTER `image_url`;");
$installer->endSetup();
