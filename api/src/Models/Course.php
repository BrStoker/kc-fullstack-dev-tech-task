<?php

namespace Models;

use Core\Database;
use PDO;

class Course
{

    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getAll(): string|false
    {
        $query = "SELECT course_id, title, description, image_preview, category_id FROM courses";
        $params = [];

        if (!empty($_GET['category'])) {
            $query .= " WHERE category_id = :category_id";
            $params['category_id'] = $_GET['category'];
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByCategory(int $categoryId): array
    {

        $categoryIds = $this->getAllChildCategoryIds($categoryId);
        $categoryIds[] = $categoryId;

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $stmt = $this->conn->prepare("SELECT id, name, category_id FROM courses WHERE category_id IN ($placeholders)");
        $stmt->execute($categoryIds);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAllChildCategoryIds(int $parentId): array
    {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE parent_id = ?");
        $stmt->execute([$parentId]);

        $childIds = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $childIds[] = $row['id'];
            $childIds = array_merge($childIds, $this->getAllChildCategoryIds($row['id']));
        }

        return $childIds;
    }



}