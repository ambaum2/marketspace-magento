<?php

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
    public function GetAllOwnersOrders($Uid) {
        $items = Mage::getModel('sales/order_item')
            ->getCollection()
            ->addFieldToSelect('product_id')
            ->addFieldToSelect('product_type')
            ->addFieldToSelect('updated_at')
            ->addFieldToSelect('created_at')
            ->addFieldToSelect('qty_ordered')
        ;

        $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id',
            array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
        $items->getSelect()->where('attribute_id=?', 136);
        $items->getSelect()->where('product.value=?', $Uid);
        //print $items->getSelect();
        return $items->getData();
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
        $items->getSelect()->join( array('product'=>'catalog_product_entity_varchar'), 'main_table.product_id = product.entity_id',
            array('product.value as marketspace_owner', 'main_table.row_total as sale_price'));
        $items->getSelect()->where('attribute_id=?', 136);
        $items->getSelect()->where('product.value=?', $Uid);
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
                'layout' => 'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
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