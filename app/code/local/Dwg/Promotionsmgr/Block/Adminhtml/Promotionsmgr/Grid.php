<?php
 
class Dwg_Promotionsmgr_Block_Adminhtml_Promotionsmgr_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('promotionsmgrGrid');
        // This is the primary key of the database
       //$this->setDefaultSort('name');
       // $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
     }
 
    protected function _prepareCollection()
    {
		$collection = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection();
		/*
		echo "Jim: Ignore this. It is for debugging <br />". $collection->joinLeft(array('regionNm'=>'eav_attribute_option_value'),
		'main_table.region = regionNm.option_id',array('regionName'=>'regionNm.value'))->joinLeft(array('pos'=>'promotionsmgr_data'),
		'main_table.position = pos.entity_id',array('positionName'=>'pos.value'))
		->where('regionNm.store_id=0');*/
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('promotionsmgr_id', array(
            'header'    => Mage::helper('promotionsmgr')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'promotionsmgr_id',
        ));
 
        $this->addColumn('position', array(
            'header'    => Mage::helper('promotionsmgr')->__('Position'),
            'align'     =>'left',
            'index'     => 'position',
            'type' => 'text',
            'width'	=> '100px',
        ));
        $this->addColumn('region', array(
            'header'    => Mage::helper('promotionsmgr')->__('Region'),
            'align'     =>'left',
            'index'     => 'region_name',
            'width'	=> '100px',
        ));
 
        $this->addColumn('category_name', array(
            'header'    => Mage::helper('promotionsmgr')->__('Category'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'text',
            //'default'   => '--',
            'index'     => 'category_name',
        ));
        $this->addColumn('product_id', array(
            'header'    => Mage::helper('promotionsmgr')->__('Product Id'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'text',
            'default'   => '--',
            'index'     => 'product_id',
        ));		
		$this->addColumn('start_time', array(
            'header'    => Mage::helper('promotionsmgr')->__('Begin Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'start_time',
        ));   
        $this->addColumn('end_time', array(
            'header'    => Mage::helper('promotionsmgr')->__('End Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'end_time',
        ));   
        $this->addColumn('updated_time', array(
            'header'    => Mage::helper('promotionsmgr')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'updated_time',
        ));   
 
        $this->addColumn('status', array(
            'header'    => Mage::helper('promotionsmgr')->__('Status'),
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