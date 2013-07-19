<?php
$product_id = $_Post['id'];
$qty = $_Post['qty'];
$product = Mage::getModel('catalog/product');
$product->load($product_id);
$stockData = $product->getStockData();
$stockData['qty'] = $qty;
$product->setStockData($stockData);
$product->save();
?>