<?php


class Purchases extends BaseClass
{
    private string $tableName = 'purchases';

    /**
     * Оплата заказа
     * @param int $order_id
     * @param int $product_id
     * @param int $quanity
     * @return array
     */
    public function paymentOrder(int $order_id, int $product_id, int $quanity): array
    {
        $purchased_sum = $this->getProductSum($product_id, $quanity);

        $sql = "INSERT INTO `$this->tableName` (`order_id`, `product_id`, `product_purchased_count`, `purchased_sum`)
                    VALUES (:order_id, :product_id, :product_purchased_count, :purchased_sum); ";

        $params = [
            'order_id' => $order_id,
            'product_id' => $product_id,
            'product_purchased_count' => $quanity,
            'purchased_sum' => $purchased_sum
        ];

        $result = $this->db->query($sql, $params);

        $changeStatus = "UPDATE orders SET status = 1 WHERE order_id = $order_id AND product_id = $product_id; ";
        $this->db->query($changeStatus);

        return $result;
    }

    /**
     * Получение общей стоимости по заказу
     * @param int $order_id
     * @return float
     */
    public function costPayment(int $order_id): float
    {
        $getOrders = "SELECT * FROM orders WHERE order_id = $order_id; ";
        $orders = $this->db->query($getOrders);

        $sum = 0;

        foreach ($orders as $order) {
            $sum += ($this->getProductSum($order['product_id'], $order['product_count']));
        }

        return $sum;
    }

    /**
     * Получаем стоимость товара умноженное на нужное количество тоовара
     * @param $product_id
     * @param $count
     * @return float
     */
    private function getProductSum($product_id, $count): float
    {
        $product = "SELECT price FROM products WHERE id = $product_id; ";
        $price = $this->db->query($product);

        return $price[0]['price'] * $count;
    }

    /**
     * Стоимость товаров от которых отказался покупатель
     * order_id - номер заказа
     * product_id - номер проодукта
     * product_order_count - количество заказанных штук товара
     * product_purchased_count - количество купленных штук товара
     * buyerRefused - сена разницы заказанных и купленных штук
     * @param $order_id
     * @return array
     */
    public function buyerRefused($order_id): array
    {
        $sql = "
            SELECT o.order_id AS order_id, o.product_id AS product_id, o.product_count AS product_order_count,
                   IFNULL(p.product_purchased_count, 0) AS product_purchased_count,
                   IF(o.status = 1, p2.price * (o.product_count - p.product_purchased_count), p2.price * o.product_count) AS buyerRefused
            FROM orders AS o
            LEFT JOIN purchases p ON o.order_id = p.order_id AND o.product_id = p.product_id
            JOIN products p2 ON o.product_id = p2.id
            WHERE o.order_id = $order_id;";

        return $this->db->query($sql);
    }
}
