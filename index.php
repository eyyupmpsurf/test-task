<?php

require __DIR__ . "\base\BaseClass.php";
require __DIR__ . "\history\PriceHistory.php";
require __DIR__ . "\orders\Orders.php";
require __DIR__ . "\purchases\Purchases.php";

$priceHistory  = new PriceHistory();
$orders  = new Orders();
$purchases  = new Purchases();

$priceHistory->addHistory(100);

$currentPrice = $priceHistory->getCurrentPrice();

$orders->addOrder(5);

$getOrders = $orders->getOrders();

$sum = $purchases->costPayment(3);

$sum = $purchases->paymentOrder(3);





