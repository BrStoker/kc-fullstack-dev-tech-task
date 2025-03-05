<?php

namespace Controllers;

use Models\Category;

require_once __DIR__ . '/../Models/Category.php';
class CategoryController
{
    private Category $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function getAllCategories()
    {
        $categories = $this->categoryModel->getAll();
        echo json_encode($categories, JSON_UNESCAPED_SLASHES);
    }

    public function getCategory($id)
    {
        $category = $this->categoryModel->getById($id);
        header('Content-Type: application/json');
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
        }
    }

}