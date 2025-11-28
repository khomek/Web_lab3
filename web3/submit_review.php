<?php
require_once 'db_connect.php';
require_once 'user_manager.php';

header('Content-Type: application/json');

// Проверяем авторизацию
$currentUser = UserManager::getCurrentUser();
if (!$currentUser) {
    echo json_encode(['success' => false, 'message' => 'Для отправки отзыва необходимо авторизоваться']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        error_log("=== REVIEW FORM SUBMISSION ===");
        error_log("Full POST data: " . print_r($_POST, true));

        // Детальная проверка каждого поля
        $product_alias = $_POST['productSelect'] ?? '';
        $user_name = trim($_POST['userName'] ?? '');
        $user_email = filter_var($_POST['userEmail'] ?? '', FILTER_VALIDATE_EMAIL);
        $rating = filter_var($_POST['rating'] ?? 0, FILTER_VALIDATE_INT);
        $review_text = trim($_POST['detailedReview'] ?? '');
        $suggestions = trim($_POST['suggestions'] ?? '');
        $newsletter = isset($_POST['newsletter']) ? true : false;
        $publish_agreement = isset($_POST['publishAgreement']) ? true : false;

        error_log("Field validation:");
        error_log("  product_alias: '$product_alias' (empty: " . (empty($product_alias) ? 'YES' : 'NO') . ")");
        error_log("  user_name: '$user_name' (empty: " . (empty($user_name) ? 'YES' : 'NO') . ")");
        error_log("  user_email: '$user_email' (valid: " . ($user_email ? 'YES' : 'NO') . ")");
        error_log("  rating: '$rating' (valid: " . ($rating ? 'YES' : 'NO') . ", range: " . ($rating >= 1 && $rating <= 5 ? 'OK' : 'INVALID') . ")");
        error_log("  review_text: '$review_text' (empty: " . (empty($review_text) ? 'YES' : 'NO') . ")");
        error_log("  newsletter: " . ($newsletter ? 'YES' : 'NO'));
        error_log("  publish_agreement: " . ($publish_agreement ? 'YES' : 'NO'));

        // Проверка обязательных полей с детальной информацией
        $errors = [];
        if (empty($product_alias)) $errors[] = "Продукт не выбран";
        if (empty($user_name)) $errors[] = "Имя не заполнено";
        if (!$user_email) $errors[] = "Email не заполнен или неверный";
        if (!$rating) $errors[] = "Оценка не выбрана";
        if ($rating < 1 || $rating > 5) $errors[] = "Оценка должна быть от 1 до 5";
        if (empty($review_text)) $errors[] = "Текст отзыва не заполнен";

        if (!empty($errors)) {
            error_log("Validation errors: " . implode(', ', $errors));
            throw new Exception("Пожалуйста, исправьте следующие ошибки: " . implode(', ', $errors));
        }

        // Получаем ID продукта по alias
        $product_sql = "SELECT id FROM products WHERE alias = :alias";
        $product_stmt = $conn->prepare($product_sql);
        $product_stmt->bindParam(':alias', $product_alias);
        $product_stmt->execute();
        $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception("Продукт не найден");
        }

        $product_id = $product['id'];
        error_log("Product found: ID $product_id");

        // Сохраняем отзыв
        $sql = "INSERT INTO reviews (product_id, user_name, user_email, rating, review_text, is_approved, is_published, newsletter_subscription) 
                VALUES (:product_id, :user_name, :user_email, :rating, :review_text, false, :is_published, :newsletter)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':review_text', $review_text);
        $stmt->bindParam(':is_published', $publish_agreement, PDO::PARAM_BOOL);
        $stmt->bindParam(':newsletter', $newsletter, PDO::PARAM_BOOL);
        
        if ($stmt->execute()) {
            $review_id = $conn->lastInsertId();
            error_log("Review saved successfully with ID: $review_id");
            
            // Сохраняем выбранные характеристики (если есть)
            if (isset($_POST['likedFeatures']) && is_array($_POST['likedFeatures'])) {
                $features_sql = "INSERT INTO review_features (review_id, feature_name) VALUES (:review_id, :feature_name)";
                $features_stmt = $conn->prepare($features_sql);
                
                $features_count = 0;
                foreach ($_POST['likedFeatures'] as $feature) {
                    $features_stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
                    $features_stmt->bindParam(':feature_name', $feature);
                    $features_stmt->execute();
                    $features_count++;
                }
                error_log("Saved $features_count features for review ID: $review_id");
            }
            
            echo json_encode(['success' => true, 'message' => 'Отзыв успешно отправлен! Он будет опубликован после модерации.']);
        } else {
            $error_info = $stmt->errorInfo();
            error_log("Failed to execute SQL: " . print_r($error_info, true));
            throw new Exception("Ошибка при сохранении отзыва: " . $error_info[2]);
        }
        
    } catch(PDOException $e) {
        error_log("Database error in submit_review.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
    } catch(Exception $e) {
        error_log("Error in submit_review.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
}
?>