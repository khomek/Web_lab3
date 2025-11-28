<?php
require_once 'user_manager.php';

header('Content-Type: application/json');

// Всегда стартуем сессию
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = UserManager::getCurrentUser();
if ($user) {
    echo json_encode([
        'success' => true, 
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'company' => $user['company'],
            'phone' => $user['phone']
        ]
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>