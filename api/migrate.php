<?php

require 'src/Core/Database.php';

// Создаем объект Database
$database = new \Core\Database();

// Вызываем метод migrate
$database->migrate('/var/www/html/database/migrations');