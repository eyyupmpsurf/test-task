<?php

require __DIR__ . "\base\BaseClass.php";
require __DIR__ . "\orders\Orders.php";
require __DIR__ . "\purchases\Purchases.php";

$orders  = new Orders();
$purchases  = new Purchases();

$product_1 = 1;
$product_2 = 2;

/* Добавление заказа */
//$order_id = 4;
$order_id = $orders->getNextOrderId();
$orders->addOrder($order_id, $product_1, 3);
$orders->addOrder($order_id, $product_2, 5);
/* _________________ */

/* рассчитать стоимость оплаты для покупателя  */
$sum = $purchases->costPayment($order_id);
print_r($sum . "\n");

/* Оплата товара */
$purchases->paymentOrder($order_id, $product_1, 0);
$purchases->paymentOrder($order_id, $product_2, 2);
/* __________________ */

/* стоимость оставшихся товаров в магазине */
$buyerRefused = $purchases->buyerRefused($order_id);
print_r($buyerRefused);
