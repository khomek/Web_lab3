<?php
require_once 'user_manager.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $firstName = $data['first_name'] ?? '';
    $lastName = $data['last_name'] ?? '';
    $company = $data['company'] ?? '';
    $phone = $data['phone'] ?? '';
    
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля']);
        exit;
    }
    
    $result = UserManager::register($username, $email, $password, $firstName, $lastName, $company, $phone);
    
    if ($result['success'] && isset($result['token'])) {
        // Устанавливаем cookie с токеном
        setcookie('auth_token', $result['token'], time() + 86400, '/', '', false, true);
    }
    
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
}
?>