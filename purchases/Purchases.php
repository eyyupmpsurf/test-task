<?php


class Purchases extends BaseClass
{
    private string $tableName = 'purchases';

    /**
     * Оплата заказа
     * @param int|null $product_purchased_count Если не передать параметр то функция вернет количество товара в заказе
     * умнженное на актуальную цену. Иначе указанное количество умнженное на актуальную цену.
     * @return array
     */
    public function paymentOrder(int $product_purchased_count = null): array
    {
        $checkStatus = "SELECT * FROM `orders` WHERE status = 0 ORDER BY id DESC LIMIT 1; ";

        $resultCheckStatus = $this->db->query($checkStatus)[0] ?? null;

        if (empty($resultCheckStatus))
            die('Актуальных заказов нет');

        if (!empty($product_purchased_count) && $resultCheckStatus['product_count'] < $product_purchased_count)
            die('Количество товаров в заказе меньше чем вы пытаетесь купить');

        $purchased_sum = $this->costPayment($product_purchased_count);

        $sql = "INSERT INTO `$this->tableName` (`order_id`, `product_purchased_count`, `purchased_sum`)
                    VALUES (:order_id, :product_purchased_count, :purchased_sum); ";

        $params = [
            'order_id' => $resultCheckStatus['id'],
            'product_purchased_count' => $product_purchased_count,
            'purchased_sum' => $purchased_sum
        ];

        $result = $this->db->query($sql, $params);

        $changeStatus = "UPDATE orders SET status = 1 WHERE TRUE; ";
        $this->db->query($changeStatus);

        return $result;
    }

    /**
     * Получение общей стоимости по заказу
     * @param int|null $product_purchased_count Если не передать параметр то функция вернет количество товара в заказе
     * умнженное на актуальную цену. Иначе указанное количество умнженное на актуальную цену.
     * @return mixed
     */
    public function costPayment(int $product_purchased_count = null): mixed
    {
        try {
            if (!empty($product_purchased_count)) {
                $sql = "SELECT price * $product_purchased_count as sum FROM price_history ORDER BY id DESC LIMIT 1;";
            } else {
                $sql = "
                    with product_count as (
                        SELECT product_count FROM orders WHERE status = 0 ORDER BY id DESC LIMIT 1
                    ), price as (
                        SELECT price FROM price_history ORDER BY id DESC LIMIT 1
                    )
                    SELECT pc.product_count * p.price as sum FROM product_count as pc, price as p; ";
            }

            $result = $this->db->query($sql)[0]['sum'];
        } catch (Exception $exception) {
            print_r($exception->getMessage());
            die();
        }

        return $result;
    }

    /**
     * Стоимость товаров от которых отказался покупатель
     * @return mixed
     */
    public function buyerRefused(): mixed
    {
        $sql = "
            with product_count as (
                SELECT product_count FROM orders WHERE status = 1 ORDER BY id DESC LIMIT 1
            ), product_purchased_count as (
                SELECT product_purchased_count FROM $this->tableName ORDER BY id DESC LIMIT 1
            )
            SELECT pc.product_count - p.product_purchased_count as refused_count FROM product_count as pc, product_purchased_count as p;";

        $refused_count = $this->db->query($sql)[0]['refused_count'];

        $productPrice = "SELECT price * $refused_count as refused_price FROM price_history ORDER BY id DESC LIMIT 1; ";

        return $this->db->query($productPrice)[0]['refused_price'];
    }
}
