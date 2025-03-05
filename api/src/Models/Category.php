<?php

namespace Models;
use Core\Database;
use PDO;

require_once __DIR__ . '/../Core/Database.php';

class Category
{

    private PDO $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getAll(): string|false
    {
        $query = "
        WITH RECURSIVE category_tree AS (
            SELECT id, parent_id FROM categories
            UNION ALL
            SELECT c.id, c.parent_id 
            FROM categories c
            INNER JOIN category_tree ct ON c.parent_id = ct.id
        )
        SELECT 
            categories.id, 
            categories.name, 
            categories.parent_id, 
            (SELECT COUNT(*) FROM courses WHERE category_id IN (
                SELECT category_id FROM category_tree WHERE category_tree.id = categories.parent_id
            )) AS course_count
        FROM categories;
    ";

        $stmt = $this->conn->query($query);

        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function getById($id)
    {
        $query = "SELECT id, name FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}