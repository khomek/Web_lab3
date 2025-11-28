<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        error_log("=== CONTACT FORM SUBMISSION ===");
        error_log("Full POST data: " . print_r($_POST, true));

        // Детальная проверка каждого поля
        $user_name = trim($_POST['name'] ?? '');
        $user_email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $privacy_agreement = isset($_POST['privacyAgreement']) ? true : false;

        error_log("Field validation:");
        error_log("  name: '$user_name' (empty: " . (empty($user_name) ? 'YES' : 'NO') . ")");
        error_log("  email: '$user_email' (valid: " . ($user_email ? 'YES' : 'NO') . ")");
        error_log("  subject: '$subject' (empty: " . (empty($subject) ? 'YES' : 'NO') . ")");
        error_log("  message: '$message' (empty: " . (empty($message) ? 'YES' : 'NO') . ")");
        error_log("  privacy: " . ($privacy_agreement ? 'YES' : 'NO'));

        // Проверка обязательных полей с детальной информацией
        $errors = [];
        if (empty($user_name)) $errors[] = "Имя не заполнено";
        if (!$user_email) $errors[] = "Email не заполнен или неверный";
        if (empty($subject)) $errors[] = "Тема не заполнена";
        if (empty($message)) $errors[] = "Сообщение не заполнено";
        if (!$privacy_agreement) $errors[] = "Согласие не подтверждено";

        if (!empty($errors)) {
            error_log("Validation errors: " . implode(', ', $errors));
            throw new Exception("Пожалуйста, заполните все обязательные поля и подтвердите согласие на обработку данных. Ошибки: " . implode(', ', $errors));
        }

        error_log("All fields validated successfully, saving to database...");

        // Сохраняем сообщение
        $sql = "INSERT INTO contact_messages (user_name, user_email, subject, message) 
                VALUES (:user_name, :user_email, :subject, :message)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        
        if ($stmt->execute()) {
            $last_id = $conn->lastInsertId();
            error_log("Contact message saved successfully with ID: $last_id");
            echo json_encode(['success' => true, 'message' => 'Сообщение успешно отправлено! Мы ответим вам в ближайшее время.']);
        } else {
            $error_info = $stmt->errorInfo();
            error_log("Failed to execute SQL: " . print_r($error_info, true));
            throw new Exception("Ошибка при отправке сообщения: " . $error_info[2]);
        }
        
    } catch(PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
    } catch(Exception $e) {
        error_log("General error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
}
?>