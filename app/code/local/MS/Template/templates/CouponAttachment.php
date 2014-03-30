<?php for($i = 1; $i <= $order_quantity; $i++) : ?>
    <table>
        <tr>
            <td></td>
            <td>CM Coupon - Bring to redeem</td>
            <td>Date Issued</td>
        </tr>
        <tr>
            <td>
                <?php print $product->getName(); ?>
            </td>
            <td>
                Order #: <?php print $order_id . "-" . $i; ?>
            </td>
            <td>Total Items: <?php print $order_quantity; ?></td>
        </tr>

    </table>
<?php endfor; ?>