<?php

class MS_Deals_Block_Adminhtml_Memberdeals_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("memberdealsGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("deals/memberdeals")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("deals")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("product_id", array(
				"header" => Mage::helper("deals")->__("Product Id"),
				"index" => "product_id",
				));
				$this->addColumn("user_id", array(
                    "header" => Mage::helper("deals")->__("User Id"),
                    "index" => "user_id",
				));
                $this->addColumn('created', array(
                    'header'    => Mage::helper('deals')->__('Created Date'),
                    'index'     => 'created',
                    'type'      => 'datetime',
                ));
                $this->addColumn('modified', array(
                    'header'    => Mage::helper('deals')->__('Modified Date'),
                    'index'     => 'modified',
                    'type'      => 'datetime',
                ));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_memberdeals', array(
					 'label'=> Mage::helper('deals')->__('Remove Memberdeals'),
					 'url'  => $this->getUrl('*/adminhtml_memberdeals/massRemove'),
					 'confirm' => Mage::helper('deals')->__('Are you sure?')
				));
			return $this;
		}
			

}