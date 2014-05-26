<?php

/**
 * Class MS_Api_Model_Adapters_ReportsSql
 */
class MS_Api_Model_Adapters_ReportsSql extends Mage_Core_Model_Abstract {
    protected $coreResource;
    protected $conn;
    public function __construct() {
        $this->coreResource = Mage::getSingleton('core/resource');
        $this->conn = $this->coreResource->getConnection('core_read');
    }

    /**
     * Get all orders for a marketspace owner
     * @param $Uid
     * @return mixed
     */
    public function GetAllOwnersOrdersItems($Uid) {
        $items = Mage::getModel('sales/order_item')
            ->getCollection()
            ->addFieldToSelect('product_id')
            ->addFieldToSelect('product_type')
            ->addFieldToSelect('updated_at')
            ->addFieldToSelect('created_at')
            ->addFieldToSelect('qty_ordered')

        ;

        $items->getSelect()->join( array('owner'=>'catalog_product_entity_varchar'), 'main_table.product_id = owner.entity_id',
            array('owner.value as marketspace_owner', 'main_table.row_total as sale_price'));
        $items->getSelect()->where('owner.attribute_id=?', 136);
        $items->getSelect()->where('owner.value=?', $Uid);
        $items->getSelect()->join( array('pname'=>'catalog_product_entity_varchar'), 'main_table.product_id = pname.entity_id',
            array('pname.value as name'));
        $items->getSelect()->where('pname.attribute_id=?', 71);
        //print $items->getSelect();
        return $items->getData();
    }

    /**
     * Get all owners order items
     * this has shipping and item information
     * so can be used in a detail and list view
     * @todo create a seperate list view and detail type
     * for mobile
     * @param $Uid
     * @return array
     */
    public function GetAllOwnersOrders($Uid) {
        $orders = new Mage_Sales_Model_Order();
        /** @var $collection Mage_Core_Model_Mysql4_Collection_Abstract */
        $collection = $orders->getCollection();
        $collection
            ->addFieldToSelect('entity_id')
            ->addFieldToSelect('created_at')
            ->addFieldToSelect('updated_at')
            ->addFieldToSelect('status')
            ->addFieldToSelect('state')
            ->addFieldToSelect('increment_id')
            ->addFieldToSelect('customer_email')
            ->addFieldToSelect('customer_firstname')
            ->addFieldToSelect('customer_lastname')
        ;
        $collection->getSelect()->joinInner( array('order_item'=>'sales_flat_order_item'), 'main_table.entity_id = order_item.order_id',
            array('main_table.is_virtual', 'order_item.item_id', 'order_item.name as name', 'order_item.sku as sku', 'order_item.weight'
            , 'order_item.qty_ordered as qty', 'order_item.price as price', 'tax_amount as tax', 'row_total as total'
            , 'base_price_incl_tax as total_incl_tax'));
        $collection->getSelect()->joinInner(array('payment' => 'sales_flat_order_payment'), 'main_table.entity_id = payment.parent_id',
            array('payment.method'));
        $collection->getSelect()->joinLeft(array('address' => 'sales_flat_order_address'), 'address.parent_id = main_table.entity_id
            and address.address_type = "shipping"', array('address.fax', 'address.region', 'postcode', 'street', 'city', 'telephone', 'country_id'));
        $collection->getSelect()->joinInner( array('owner'=>'catalog_product_entity_varchar'), 'order_item.product_id = owner.entity_id',
            array('owner.value as marketspace_owner', 'order_item.row_total as sale_price'));
        $collection->getSelect()->where('owner.attribute_id=?', 136);
        $collection->getSelect()->where('owner.value=?', $Uid);
        return $collection->getData();
    }

    public function GetOwnersOrder($id) {
        $order = new Mage_Sales_Model_Order_Item();
        $orderItem = $order->load($id);
        return $orderItem->getData();
    }
    /**
 * Get the total ordered grouped by
 * product id
 * @param $Uid
 * @return mixed
 */
    public function GetOwnersOrdersProductCount($Uid) {
        $items = Mage::getModel('sales/order_item')
            ->getCollection()
            ->addFieldToSelect('product_id')
            ->addFieldToSelect('product_type')
            ->addFieldToSelect('updated_at')
            ->addFieldToSelect('created_at')
        ;
        $items->getSelect()->group('product_id');
        $items->getSelect()->columns(array('total_ordered' => 'SUM(qty_ordered)'));
        $items->getSelect()->join( array('owner'=>'catalog_product_entity_varchar'), 'main_table.product_id = owner.entity_id',
            array('owner.value as marketspace_owner', 'main_table.row_total as sale_price'));
        $items->getSelect()->where('owner.attribute_id=?', 136);
        $items->getSelect()->where('owner.value=?', $Uid);
        $items->getSelect()->join( array('pname'=>'catalog_product_entity_varchar'), 'main_table.product_id = pname.entity_id',
            array('pname.value as name'));
        $items->getSelect()->where('pname.attribute_id=?', 71);
        $items->getSelect()->join( array('thumbnail'=>'catalog_product_entity_varchar'), 'main_table.product_id = thumbnail.entity_id',
            array('thumbnail.value as thumbnail'));
        $items->getSelect()->where('thumbnail.attribute_id=?', 87);
        return $items->getData();
    }

    /**
     * Get the total ordered grouped by month and
     * product id for a 12 month time period
     * product id
     * @param $Uid
     * @return mixed
     */
    public function GetOwnersOrdersProductsCountByMonth($Uid, $products) {
        $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
            'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $report = array(
            'title' => array(
                'text' => 'Product Sales',
                'x' => -20
            ),
            'subtitle' => array(
                'text' => 'Community Marketspace',
                'x' => -20
            ),
            'xAxis' => array(
                'categories' => $months,
            ),
            'yAxis' => array(
                'title' => array(
                    'text' => 'Total Orders'
                ),
                'allowDecimals' => false,
                'min' => 0,
                'plotLines' => array(
                    array('value' => 0),
                    array('width' => 1),
                    array('color' => '#808080')
                ),
            ),
            'tooltip' => array(
                'suffix' => ' orders',
            ),
            'legend' => array(
                'layout' => 'horizontal',
                'align' => 'center',
                'verticalAlign' => 'bottom',
                'borderWidth' => 0
            ),
        );
        foreach($products as $key => $product_id) {
            $items = Mage::getModel('sales/order_item')
                ->getCollection()
                ->addFieldToSelect('product_id')
                ->addFieldToSelect('product_type')
                ->addFieldToSelect('updated_at')
                ->addFieldToSelect('created_at')
                ->addFieldToFilter('product_id', array('=' => $product_id))
            ;
            $items->getSelect()->group('product_id');
            $items->getSelect()->group('month_ordered');
            $items->getSelect()->order(array('product_id ASC', 'updated_at ASC'));
            //$items->getSelect()->order(array('updated_at ASC'));
            $items->getSelect()->columns(array('total_ordered' => 'SUM(qty_ordered)', 'month_ordered' => 'DATE_FORMAT(updated_at, "%b")'));
            $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id',
                array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
            $items->getSelect()->where('product.attribute_id=?', 136);
            $items->getSelect()->where('product.value=?', $Uid);
            $items->getSelect()->join( array('pname'=>'catalog_product_entity_varchar'), 'main_table.product_id = pname.entity_id',
                array('pname.value as name'));
            $items->getSelect()->where('pname.attribute_id=?', 71);
            $orders = $items->getData();
            $total_order_rows = count($orders);
            if($total_order_rows > 0) {
                $report['series'][$key]['name'] = $orders[0]['name'];
                for($i = 0; $i < 12; $i++) {
                    $found = false;
                    for($j = 0; $j < $total_order_rows; $j++) {
                        if($months[$i] == $orders[$j]['month_ordered']) {
                            $report['series'][$key]['data'][] = (int)$orders[$j]['total_ordered'];
                            $found = true;
                        }
                    }
                    if($found === false) {
                        $report['series'][$key]['data'][] = 0;
                    }
                }
            }
        }
        return $report;
    }
}