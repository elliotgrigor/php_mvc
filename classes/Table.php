<?php

class Table extends Database
{
    private $tableName;
    private $db;

    public function __construct($table_name) {
        $this->tableName = $table_name;
        parent::connect();
    }

    public function getAll() {
        return parent::$pdo
            ->query("SELECT * FROM `{$this->tableName}`")
            ->fetchAll();
    }

    public function get($id) {
        return parent::$pdo
            ->query("SELECT * FROM `{$this->tableName}` WHERE `id` = {$id}")
            ->fetch();
    }
}