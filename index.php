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

$costPayment = $purchases->costPayment(3);

$purchases->paymentOrder(3);

$buyerRefused = $purchases->buyerRefused();
