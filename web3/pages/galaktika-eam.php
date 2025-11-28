<?php
require_once '../db_connect.php';

// Получаем alias продукта из URL
$product_alias = basename($_SERVER['PHP_SELF'], '.php');

try {
    // Получаем информацию о продукте
    $sql = "SELECT * FROM product_catalog WHERE alias = :alias AND available = true";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':alias', $product_alias);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header("HTTP/1.0 404 Not Found");
        die("Продукт не найден");
    }
    
    // Получаем характеристики продукта
    $features_sql = "SELECT * FROM product_features WHERE product_id = :product_id ORDER BY sort_order";
    $features_stmt = $conn->prepare($features_sql);
    $features_stmt->bindParam(':product_id', $product['id']);
    $features_stmt->execute();
    $features = $features_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Получаем отзывы для продукта
    $reviews_sql = "SELECT * FROM product_reviews WHERE product_alias = :alias AND is_approved = true AND is_published = true ORDER BY created_at DESC";
    $reviews_stmt = $conn->prepare($reviews_sql);
    $reviews_stmt->bindParam(':alias', $product_alias);
    $reviews_stmt->execute();
    $reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Ошибка загрузки данных: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($product['name']); ?> - Подробное описание</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> 
</head>
<body>
    <main class="container mt-4">
        <div class="back-button">
            <button onclick="history.back()" class="btn btn-outline-primary">← Назад в каталог</button>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-section">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold text-primary"><?php echo htmlspecialchars($product['name']); ?></h1>
                            <p class="lead"><?php echo htmlspecialchars($product['short_description']); ?></p>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="../<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-image img-fluid">
                        </div>
                    </div>

                    <h2 class="product-header">Краткое описание товара</h2>
                    <p class="short-description">
                        <?php echo htmlspecialchars($product['short_description']); ?>
                    </p>

                    <?php if (!empty($features)): ?>
                    <h2 class="product-header">Характеристики</h2>
                    <ul class="features-list">
                        <?php foreach($features as $feature): ?>
                        <li><strong><?php echo htmlspecialchars($feature['feature_name']); ?>:</strong> 
                            <?php echo htmlspecialchars($feature['feature_value']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <h2 class="product-header">Подробное описание</h2>
                    <div class="detailed-description">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>

                    <?php if (!empty($reviews)): ?>
                    <h2 class="product-header">Отзывы</h2>
                    <div class="reviews-section">
                        <?php foreach($reviews as $review): ?>
                        <div class="review-card mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
                                <div class="rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?php echo $i <= $review['rating'] ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="mb-2"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                            <small class="text-muted"><?php echo date('d.m.Y', strtotime($review['created_at'])); ?></small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Форма заявки на демонстрацию -->
                    <div class="demo-request mt-5">
                        <h4>Заказать демонстрацию</h4>
                        <form class="demo-request-form">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_name" class="form-label">Ваше имя *</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company" class="form-label">Компания</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Телефон *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Сообщение</label>
                                <textarea class="form-control" id="message" name="message" rows="3" 
                                          placeholder="Укажите удобное время для демонстрации или интересующие вас вопросы"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить заявку</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/auth_manager.js"></script>
</body>
</html>