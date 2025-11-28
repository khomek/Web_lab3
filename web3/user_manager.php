<?php
require_once 'db_connect.php';
require_once 'jwt_helper.php';

class UserManager {
    
    public static function register($username, $email, $password, $firstName = '', $lastName = '', $company = '', $phone = '') {
        try {
            // Проверяем, существует ли пользователь
            if (self::userExists($username, $email)) {
                return ['success' => false, 'message' => 'Пользователь с таким логином или email уже существует'];
            }
            
            // Хешируем пароль
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            // Создаем пользователя
            $sql = "INSERT INTO users (username, email, password_hash, first_name, last_name, company, phone) 
                    VALUES (:username, :email, :password_hash, :first_name, :last_name, :company, :phone)";
            
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $passwordHash);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':phone', $phone);
            
            if ($stmt->execute()) {
                $userId = $GLOBALS['conn']->lastInsertId();
                
                // Создаем JWT токен
                $token = JWTHelper::encode([
                    'user_id' => $userId,
                    'username' => $username,
                    'email' => $email
                ]);
                
                return [
                    'success' => true, 
                    'message' => 'Регистрация успешна',
                    'token' => $token,
                    'user' => [
                        'id' => $userId,
                        'username' => $username,
                        'email' => $email,
                        'first_name' => $firstName,
                        'last_name' => $lastName
                    ]
                ];
            } else {
                return ['success' => false, 'message' => 'Ошибка при создании пользователя'];
            }
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()];
        }
    }
    
    public static function login($login, $password) {
        try {
            // Ищем пользователя по username или email
            $sql = "SELECT * FROM users WHERE (username = :login OR email = :login) AND is_active = true";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Создаем JWT токен
                $token = JWTHelper::encode([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Вход выполнен успешно',
                    'token' => $token,
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'company' => $user['company'],
                        'phone' => $user['phone']
                    ]
                ];
            } else {
                return ['success' => false, 'message' => 'Неверный логин или пароль'];
            }
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()];
        }
    }
    
    public static function userExists($username, $email) {
        $sql = "SELECT COUNT(*) as count FROM users WHERE username = :username OR email = :email";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    public static function validateToken($token) {
    $payload = JWTHelper::decode($token);
    if (!$payload) {
        return false;
    }
    
    // Проверяем, существует ли пользователь в БД
    $sql = "SELECT id, username, email, first_name, last_name, company, phone, is_active 
            FROM users WHERE id = :id AND is_active = true";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bindParam(':id', $payload['user_id']);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user : false;
}
    

public static function getCurrentUser() {
    // Всегда стартуем сессию если нужно
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Сначала проверяем сессию (для быстрого доступа)
    if (isset($_SESSION['current_user']) && $_SESSION['current_user']) {
        return $_SESSION['current_user'];
    }
    
    // Если нет в сессии, проверяем JWT токен
    if (isset($_COOKIE['auth_token'])) {
        $user = self::validateToken($_COOKIE['auth_token']);
        if ($user) {
            // Сохраняем в сессию для быстрого доступа
            $_SESSION['current_user'] = $user;
            return $user;
        }
    }
    
    return false;
}

public static function logout() {
    // Очищаем сессию
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['current_user'])) {
        unset($_SESSION['current_user']);
    }
    
    // Удаляем куки
    if (isset($_COOKIE['auth_token'])) {
        setcookie('auth_token', '', time() - 3600, '/', '', false, true);
    }
    
    // Уничтожаем сессию
    session_destroy();
    
    return ['success' => true, 'message' => 'Выход выполнен успешно'];
}
}
?>