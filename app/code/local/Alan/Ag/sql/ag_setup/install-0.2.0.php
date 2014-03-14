 <?php
 $installer = $this;
	$installer->startSetup();
	$installer->addEntityType('ag_eavag', array(
	    //entity_mode is the URI you'd pass into a Mage::getModel() call
	    'entity_model'    => 'ag/eavag',
	    'table'           =>'ag/eavag',
	));
  
  $installer->createEntityTables(
    $this->getTable('ag/eavag')
	);
	$this->addAttribute('ag_eavag', 'title', array(
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
	$installer->endSetup(); 