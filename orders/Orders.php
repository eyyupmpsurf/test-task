<?php

class Orders extends BaseClass
{
    private string $tableName = 'orders';

    /**
     * Создание заказа
     * @param $order_id
     * @param $product_id
     * @param $product_count
     * @return bool
     */
    public function addOrder($order_id, $product_id, $product_count): bool
    {
        $sql = "INSERT INTO `$this->tableName` (`order_id`, `product_id`,`product_count`) VALUES (:order_id, :product_id, :product_count); ";

        $this->db->query($sql, [
            'order_id' => $order_id,
            'product_id' => $product_id,
            'product_count' => $product_count,
        ]);

        return true;
    }

    /**
     * Получаем следующий индентификатор заказов
     * @return int
     */
    function getNextOrderId(): int
    {
        $sql = "
            SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1;
        ";

        return $this->db->query($sql)[0]['order_id'] + 1;
    }
}
