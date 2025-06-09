<?php

namespace App\Model;

use App\Database\Database;
use PDO;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    protected function prepare($sql)
    {
        return $this->db->prepare($sql);
    }

    protected function execute($stmt, $params = [])
    {
        return $stmt->execute($params);
    }

    protected function query($sql, $params = [])
    {
        $stmt = $this->prepare($sql);
        $this->execute($stmt, $params);
        return $stmt;
    }

    protected function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 