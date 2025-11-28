<?php
// auth_init.php - Инициализация аутентификации для всех страниц

// Стартуем сессию если еще не начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключаем менеджер пользователей
require_once 'user_manager.php';

// Получаем текущего пользователя
$currentUser = UserManager::getCurrentUser();

// Функция для получения данных пользователя в JSON формате
function getAuthUserData() {
    global $currentUser;
    if ($currentUser) {
        return [
            'id' => $currentUser['id'],
            'username' => $currentUser['username'],
            'email' => $currentUser['email'],
            'first_name' => $currentUser['first_name'],
            'last_name' => $currentUser['last_name']
        ];
    }
    return null;
}
?>