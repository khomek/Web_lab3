<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

// Отладка
error_log("=== DEMO FORM SUBMISSION ===");
error_log("POST data: " . print_r($_POST, true));
error_log("REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Валидация данных
        $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        $user_name = trim($_POST['user_name']);
        $company = trim($_POST['company'] ?? '');
        $phone = trim($_POST['phone']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $message = trim($_POST['message'] ?? '');
        
        if (!$product_id || empty($user_name) || empty($phone) || !$email) {
            throw new Exception("Пожалуйста, заполните все обязательные поля");
        }
        
        $sql = "INSERT INTO demo_requests (product_id, user_name, company, phone, email, message) 
                VALUES (:product_id, :user_name, :company, :phone, :email, :message)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.']);
        } else {
            throw new Exception("Ошибка при сохранении заявки");
        }
        
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
}
?>