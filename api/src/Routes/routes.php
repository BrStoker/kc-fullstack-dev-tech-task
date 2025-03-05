<?php

use Controllers\CategoryController;
use Controllers\CourseController;

require_once __DIR__ . '/../Controllers/CategoryController.php';
require_once __DIR__ . '/../Controllers/CourseController.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
header('Content-Type: application/json');


if ($uri === 'categories') {
    $controller = new CategoryController();
    $controller->getAllCategories();
} elseif (preg_match('/^categories\/([\w-]+)$/', $uri, $matches)) {
    $controller = new CategoryController();
    $controller->getCategory($matches[1]);
} elseif ($uri === 'courses') {
    $controller = new CourseController();
    $controller->getAllCourses();
} elseif (preg_match('/^courses\/([\w-]+)$/', $uri, $matches)) {
    $controller = new CourseController();
    $controller->getCourse($matches[1]);
} elseif (preg_match('/^courses\/category\/(\d+)$/', $uri, $matches)) {
    $controller = new CourseController();
    $controller->getCoursesByCategory((int) $matches[1]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}