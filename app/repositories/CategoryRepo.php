<?php

namespace app\repositories;
use app\core\Database;

class CategoryRepo
{
    public function __construct(private Database $db) {}

    public function find($id): false|array {
        return $this->db->fetchOne("SELECT * FROM categories WHERE id = :id", ["id" => $id]);
    }
}