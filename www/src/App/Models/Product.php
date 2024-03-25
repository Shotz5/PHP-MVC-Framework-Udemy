<?php

namespace App\Models;

use PDO;
use App\Database;

class Product
{
    public function getData(): array
    {
        $db = new Database;

        $pdo = $db->getConnection();
        $stmt = $pdo->query("SELECT * FROM product");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
