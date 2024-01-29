<?php

class BaseDb
{
    private PDO $db;

    public function __construct()
    {
        $dbInfo = require 'config/db.php';
        $this->db = new PDO('mysql:host=' . $dbInfo['host'] . ';dbname=' . $dbInfo['dbname'], $dbInfo['login'], $dbInfo['password']);
    }

    public function getDb(): PDO
    {
        return $this->db;
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);

        if ( !empty($params) ) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
