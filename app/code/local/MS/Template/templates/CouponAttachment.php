<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" href="<?php print Mage::getDesign()->getSkinBaseDir() . DS . "css/bootstrap.min.css"; ?>" rel="stylesheet" />
    <style>
        div { width: 100%; margin: .25em; }
        span { width: 33%; display: inline-block; }
        h2 {padding-bottom: 5px;margin-bottom:5px;}
        h5 {font-weight: 900;}
        h5 span {font-weight: 200;}
        div#footer { text-align: right; page-break-before: always; }
    </style>
</head>
<body>
<?php for($i = 1; $i <= $order_quantity; $i++) : ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php print Mage::getBaseDir('media') . "/email/logo/" .  Mage::getStoreConfig('design/email/logo'); ?>" />
            </div>
            <div class="col-md-3">
                <h5>CM Coupon - Bring to redeem</h5>
            </div>
            <div class="col-md-3">
                <h5>Date Issued: <span><?php print date("D, j M, Y", strtotime($order_created_at)); ?></span></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>
                    <?php print $product->getName(); ?>
                </h2>
            </div>
            <div class="col-md-6">
                <h3>Order #: <?php print $order_id . "-" . $i; ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Description</h5>
                <?php if($description = $product->getData('description')) : ?>
                    <?php print $description; ?>
                <?php else : ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Seller Terms</h5>
                <?php if($terms = $product->getData('seller_terms_refund')) : ?>
                    <?php print $terms; ?>
                <?php else : ?>
                    <p>Default Terms</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Market Space Terms</h5>
                <?php if($terms = $product->getData('ms_terms_products')) : ?>
                    <?php print $terms; ?>
                <?php else : ?>
                    <p>None</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="footer">
    </div>
<?php endfor; ?>
</body>
</html>