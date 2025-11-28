<?php
require_once 'user_manager.php';

header('Content-Type: application/json');

// Всегда стартуем сессию
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $login = $data['login'] ?? '';
    $password = $data['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
        exit;
    }
    
    $result = UserManager::login($login, $password);
    
    if ($result['success'] && isset($result['token'])) {
        // Устанавливаем cookie с токеном
        setcookie('auth_token', $result['token'], time() + 86400, '/', '', false, true);
        
        // Сохраняем пользователя в сессию
        $_SESSION['current_user'] = $result['user'];
    }
    
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
}
?>