<?php

global $pdo;
require 'config/database.php';

try {
    $stmt = $pdo->query("SELECT 'Подключение успешно!' AS message");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => "Ошибка запроса: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}