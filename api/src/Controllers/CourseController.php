<?php

namespace Controllers;

use Models\Course;


require_once __DIR__ . '/../Models/Course.php';

class CourseController
{

    private Course $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    public function getAllCourses(): void
    {
        $courses = $this->courseModel->getAll();
        echo json_encode($courses);
    }

    public function getCoursesByCategory(int $categoryId): void
    {
        header('Content-Type: application/json');

        $courseModel = new Course();
        $courses = $courseModel->getByCategory($categoryId);

        echo json_encode($courses, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function getCourse($id)
    {
        $course = $this->courseModel->getById($id);
        header('Content-Type: application/json');
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }



}