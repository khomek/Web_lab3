<?php
require_once 'user_manager.php';

header('Content-Type: application/json');

// Всегда стартуем сессию
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Вызываем logout и получаем результат
$result = UserManager::logout();

// Отправляем чистый JSON ответ
echo json_encode($result);
exit;
?>