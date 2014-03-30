<?php for($i = 1; $i <= $order_quantity; $i++) : ?>
    <table style="border:2px solid #bebcb7;margin-bottom: 20px;">
        <tr>
            <td><img src="<?php print Mage::getBaseDir('media') . "/email/logo/" .  Mage::getStoreConfig('design/email/logo'); ?>" /></td>
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
        <tr>
            <td colspan="3">
                <p>Description</p>
                <?php if($description = $product->getData('description')) : ?>
                    <?php print $description; ?>
                <?php else : ?>

                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p>Seller Terms</p>
                <?php if($terms = $product->getData('seller_terms_refund')) : ?>
                    <?php print $terms; ?>
                <?php else : ?>
                    <p>Default Terms</p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p>Market Space Terms</p>
                <?php if($terms = $product->getData('ms_terms_products')) : ?>
                    <?php print $terms; ?>
                <?php else : ?>
                    <p>None</p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
<?php endfor; ?>