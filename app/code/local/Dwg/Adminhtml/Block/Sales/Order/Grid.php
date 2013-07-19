<?php
class Dwg_Adminhtml_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
    }
    public function setCollection($collection) {
    	//$mycollection = Mage::getModel('sales/order')->getCollection()->addAttributeToSelect('*')->joinTable("ordernew","order_id=increment_id")
    	$adminuser = Mage::getModel('admin/session');//->getUser()->getRoles();
        $adminId = $adminuser->getUser()->getUserId();
	$roleId = implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
	$roleName = Mage::getModel('admin/roles')->load($roleId)->getRoleName();
    	if($roleName == "Administrators") {
	    	//echo $adminuser->getUser()->getRoles() . "";
	    	
	    	Mage_Adminhtml_Block_Widget_Grid::setCollection($collection);
    	} else {
    		//use a join on the exp_makers_sales table against the sales/order model to find
    		//the matching sales by order id in each filtered by this users id
		//$mycollection = Mage::getModel('sales/order')->getCollection()->addAttributeToSelect('*');
//$mycollection = Mage::getModel('ordernew/ordernew')->getCollection();
//$mycollection->getSelect()->join(array('product_cat' => 'sales_flat_order'), 'main_table.order_id = product_cat.increment_id', array('product_cat.increment_id'))->where('main_table.exp_maker_id = 2');

$mycollection = Mage::getModel('sales/order')->getCollection();

//echo $mycollection->getSelect();
//echo $mycollection->getSelect()->join(array('admin_orders' => 'ordernew'), 'main_table.increment_id = admin_orders.order_id', array('admin_orders.exp_maker_id','CONCAT(main_table.customer_firstname," ",main_table.customer_lastname) as billing_name','main_table.shipping_address_id as shipping_id_new'))->join(array('sales_shipping'=>'sales_flat_order_address'),'main_table.entity_id=sales_shipping.parent_id',array('CONCAT(sales_shipping.firstname," ",sales_shipping.lastname) as shipping_name'))->where('admin_orders.exp_maker_id = '.$adminId);

$mycollection->getSelect()->join(array('admin_orders' => 'ordernew'), 'main_table.increment_id = admin_orders.order_id', array('admin_orders.exp_maker_id','CONCAT(main_table.customer_firstname," ",main_table.customer_lastname) as billing_name','main_table.shipping_address_id as shipping_id_new'))->where('admin_orders.exp_maker_id = '.$adminId);
//$mycollection->getSelect()->join(array('product_cat2' => 'sales_flat_order_grid'), 'main_table.increment_id = product_cat2.increment_id', array('product_cat2.billing_name'));
		
//$mycollection2 = $mycollection->join( array('ordernew'=>$this->getTable('ordernew/ordernew')), 'sales_flat_order.increment_id = ordernew.order_id', array('ordernew.*'), 'ordernew');
                //->joinTable("ordernew","order_id=increment_id");//joinAttribute('ordersadmin', 'ordernew/ordernew','order_id',null, 'inner');;
		//$mycollection = Mage::getModel('sales/order')->getCollection()->joinTable('ordernew/ordernew','order_id',null, 'inner');
		//$mycollection = $mycollection->joinTable('ordernew/ordernew','order_id',null, 'inner');
		//->join(array('adminorder'=>'ordernew'),'adminorder.order_id=main_table.increment_id')->joinTable("ordernew","order_id=increment_id");
		//echo $mycollection->getSelect();
		//print_r($mycollection->getData());
//print_r($mycollection->getData());//join( array('table_alias'=>$this->getTable('ordernew/ordernew')), 'main_table.increment_id = table_alias.order_id', array('table_alias.*'), 'table_alias'));
//echo $mycollection->join( array('table_alias'=>$this->getTable('ordernew/ordernew')), 'main_table.increment_id = table_alias.order_id', array('table_alias.*'), 'table_alias')->getLastItem();
	
		//echo $mycollection;
    		parent::setCollection($mycollection);
    		//echo $roleName . " and id " . $adminId;
    	}
    }
    protected function _prepareColumns()
    {
	parent::_prepareColumns();
        $this->addColumn('exp_maker_id', array(
            'header'=> Mage::helper('sales')->__('Add Guide'),
            'index' => 'exp_maker_id',
            'renderer'  => 'Dwg_Adminhtml_Block_Widget_Grid_Column_Renderer_Expguide',
        ));
        return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
        parent::_exportIterateCollection();
    }

}

