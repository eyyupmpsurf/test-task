<?php

class PriceHistory extends BaseClass
{
    private string $tableName = 'price_history';

    /**
     * Изменение цены товара
     * @param $price
     * @return array
     */
    public function addHistory($price): array
    {
        try {
            $sql = "INSERT INTO `$this->tableName` (`price`, `created_at`) VALUES (:price, :created_at); ";
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }

        $params = [
            'price' => $price,
            'created_at' => date("Y-m-d")
        ];

        return $this->db->query($sql, $params);
    }

    /**
     * Акуальная цена товара
     * @return float
     */
    public function getCurrentPrice(): float
    {
        $sql = "SELECT price FROM $this->tableName ORDER BY id DESC LIMIT 1; ";

        $result = $this->db->query($sql)[0];

        return $result['price'];
    }
}