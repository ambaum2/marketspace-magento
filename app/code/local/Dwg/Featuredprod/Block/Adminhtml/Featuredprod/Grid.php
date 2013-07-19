<?php
 
class Dwg_Featuredprod_Block_Adminhtml_Featuredprod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('featuredprodGrid');
        // This is the primary key of the database
       //$this->setDefaultSort('name');
       // $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
     }
 
    protected function _prepareCollection()
    {
    	$user = Mage::getSingleton('admin/session');
    	$adminEmail = $user->getUser()->getEmail();
        //make featuredprod your collection adn join against product flat table - if you want search
//$collection = Mage::getModel('featuredprod/featuredprod')->getCollection();//->addAttributeToSelect('*');
//$collection = Mage::getModel('featuredprod/featuredprod')->getCollection()->addAttributeToSelect('*');

//echo "hello".$collection->getSelect();
      //$resource = Mage::getSingleton('core/resource');
        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
       //$collection->getSelect()->joinLeft(array('feat' => 'featuredprod'), 'e.entity_id = feat.entity_id',array('feat.feat_status','feat.feat_order','feat.feat_type','feat.featuredprod_id'));
        //$collection->getSelect()->joinRight(array('prod' => 'catalog_product_flat_1'), 'e.entity_id = prod.entity_id',array('name'=>'prod.name'));
        $collection->joinField('feat_order','featuredprod','feat_order','entity_id=entity_id',null,'left');
        $collection->joinField('feat_status','featuredprod','feat_status','entity_id=entity_id',null,'left');
		//$collection->joinOtherEntityBy($feat_id);
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('featuredprod')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));
 
        $this->addColumn('name', array(
            'header'    => Mage::helper('featuredprod')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
            'width'	=> '400px',
        ));
         $this->addColumn('feat_status', array(
            'header'    => Mage::helper('featuredprod')->__('Featured'),
            'align'     =>'left',
            'index'     => 'feat_status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Featured',
                0 => 'Not Featured',
            ),
        ));

 
        $this->addColumn('feat_order', array(
            'header'    => Mage::helper('featuredprod')->__('Order'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'text',
            //'default'   => '--',
            'index'     => 'feat_order',
        ));
 
        $this->addColumn('updated_time', array(
            'header'    => Mage::helper('featuredprod')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'updated_at',
        ));   
 
 
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('featuredprod')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
 
}