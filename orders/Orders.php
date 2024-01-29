<?php

class Orders extends BaseClass
{
    private string $tableName = 'orders';

    /**
     * Создание заказа
     * @param $product_count
     * @return array
     */
    public function addOrder($product_count): array
    {
        $sql = "INSERT INTO `$this->tableName` (`product_count`) VALUES (:product_count); ";

        return $this->db->query($sql, ['product_count' => $product_count]);
    }

    /**
     * Получаем заказы
     * @return array
     */
    public function getOrders(): array
    {
        $sql = "SELECT * FROM $this->tableName ORDER BY id DESC; ";

        return $this->db->query($sql);
    }
}
