<?php

require __DIR__ . "\..\db\BaseDb.php";

class BaseClass
{
    protected BaseDb $db;

    public function __construct()
    {
        $this->db = new BaseDb();
    }
}