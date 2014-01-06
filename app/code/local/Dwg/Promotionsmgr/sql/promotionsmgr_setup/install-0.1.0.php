<?php 
 	$installer = $this;
	$installer->startSetup();
	/*$installer->addEntityType('promotionsmgr_promotionsmgr', array(
	    //entity_mode is the URI you'd pass into a Mage::getModel() call
	    'entity_model'    => 'promotionsmgr/promotionsmgr',
	    'table'           =>'promotionsmgr/promotionsmgr',
	));
  
  $installer->createEntityTables(
    $this->getTable('promotionsmgr/promotionsmgr')
	);
	$this->addAttribute('promotionsmgr_promotionsmgr', 'title', array(
	    //the EAV attribute type, NOT a MySQL varchar
	    'type'              => 'varchar', //varchar default
	    'label'             => 'Title',//label by default
	    'input'             => 'text', //text default
	    'class'             => '', //null default
	    'backend'           => '', //null default
	    'frontend'          => '', //null default
	    'source'            => '', //null default
	    'required'          => true,//true default
	    'user_defined'      => true, //false default
	    'default'           => '', //null string by default
	    'unique'            => false, //false by default
	));
 	$this->addAttribute('ag_eavag', 'badge_image', array(
      'type'              => 'varchar',
      'label'             => 'Badge Image',
      'input'             => 'text',
      'user_defined'			=> 'true',
  ));
  $this->addAttribute('ag_eavag', 'created', array(
      'type'              => 'datetime',
      'label'             => 'Create Date',
      'input'             => 'datetime',
      'required'          => true,
  ));
  $this->addAttribute('ag_eavag', 'modified', array(
      'type'              => 'datetime',
      'label'             => 'Modified Date',
      'input'             => 'datetime',
      'required'          => true,
  ));
	$installer->endSetup(); */

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('promotionsmgr')};
CREATE TABLE {$this->getTable('promotionsmgr')} (
	`promotionsmgr_id` int(11) unsigned NOT NULL auto_increment,
	`status` int(1) NOT NULL,
	`position` varchar(20) NOT NULL,
	`item_order` int(4) NOT NULL,
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
	