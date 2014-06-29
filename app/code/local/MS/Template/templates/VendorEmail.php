<div>

    <?php $columns = array('order item id', 'product', 'price', 'weight', 'quantity', 'tax', 'order total'); ?>
    <?php $info = array($item['order_id'], $product->getData('name'), $sales_order->formatPrice($item->getPrice()), $item['weight'],
        $item->getQtyOrdered(), $sales_order->formatPrice($item['tax_amount']), $sales_order->formatPrice(($item['base_row_total'] + $item['tax_amount'])));
    ?>
    <?php $address_data = array($sales_order->getCustomerName(), $sales_order->getBillingAddress()->getStreet1(),
        $sales_order->getBillingAddress()->getCity() . ' ' . $sales_order->getBillingAddress()->getRegion() . ', '
        . $sales_order->getBillingAddress()->getPostcode(), $sales_order->getBillingAddress()->getTelephone()); ?>
    <?php
    $shipping_address_data = array();
    if($sales_order->getShippingAddress()) {
        $shipping_address_data = array($sales_order->getCustomerName(), $sales_order->getShippingAddress()->getStreet1(),
            $sales_order->getShippingAddress()->getCity() . ' ' . $sales_order->getShippingAddress()->getRegion() . ', '
            . $sales_order->getShippingAddress()->getPostcode(), $sales_order->getShippingAddress()->getTelephone());
    }
    ?>
    <table>
        <tbody>
            <tr>
                <table>
                    <thead>
                        <tr>
                            <span style="font-weight: 800">Billing Address</span>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($address_data as $adr) : ?>
                            <tr>
                                <td><?php print $adr; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(!empty($shipping_address_data)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <span style="font-weight: 800">Shipping Address</span>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($address_data as $adr) : ?>
                                <tr>
                                    <td><?php print $adr; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </tr>
            <tr>
                <table>
                    <thead>
                        <tr>
                            <?php foreach($columns as $col) : ?>
                                <td style="background:#EAEAEA;font-size: 13px; padding: 3px  9px;"><?php print $col; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach($info as $attr) : ?>
                                <td style="font-size: 11px; padding: 3px  9px; border-bottom: 1px  dotted  #CCCCCC;"><?php print $attr; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </tr>
        </tbody>
    </table>
</div>