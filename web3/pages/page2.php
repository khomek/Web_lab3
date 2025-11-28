<?php include_once '../auth_init.php'; ?>
<?php
require_once '../db_connect.php';

try {
    $sql = "SELECT * FROM product_catalog WHERE available = true ORDER BY name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $products = [];
    error_log("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Каталог продуктов</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Шапка сайта -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-brand d-flex align-items-center">
                <img src="../images/label.png" alt="Галактика" class="me-2">
                <a href="../index.php" class="fw-bold text-decoration-none text-white">ГАЛАКТИКА</a>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
           <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="https://galaktika.ru/?ysclid=mhaj4ts298452292586">Официальный сайт</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://galaktika.ru/partners">Партнерам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://galaktika.ru/uslugi">Заказчикам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://sem.galaktika.ru/">Семинары</a>
                    </li>
                </ul>
                
                <!-- Кнопка входа/регистрации -->
                <button class="btn btn-outline-light login-modal-btn" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Вход / Регистрация
                </button>
            </div>
        </div>
    </nav>

    <!-- Заголовок страницы -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">КАТАЛОГ ПРОДУКТОВ</h1>
                    <p class="lead">Комплексные решения для автоматизации управления предприятиями</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Основное содержимое -->
    <main class="container mt-4">
        <div class="row">
            <!-- Колонка с меню -->
            <div class="col-lg-3 mb-4">
                <div class="menu-column">
                    <!-- Кнопка для открытия контекстного меню -->
                    <button class="context-menu-btn" onclick="toggleContextMenu()">
                        <div class="hamburger-icon">
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                        </div>
                    </button>

                    <!-- Контекстное меню -->
                    <div class="context-menu" id="contextMenu">
                        <div class="context-menu-header">Навигация</div>
                        <a href="../index.php" class="context-menu-item">Главная</a>
                        <a href="page1.php" class="context-menu-item">О нас</a>
                        <a href="page2.php" class="context-menu-item active">Каталог</a>
                        <a href="page3.php" class="context-menu-item">Контакты</a>
                        <a href="reviews.php" class="context-menu-item">Отзывы</a>
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-lg-9 mb-4">
                <div class="main-content">
                    <h2 class="mb-4">Наши продукты</h2>
                    
                    <p class="fs-5 mb-4">
                        Портфель программных продуктов «Галактика» включает полнофункциональную ERP-систему корпоративного класса, программные продукты по управлению кадрами и расчету заработной платы, управлению эффективностью производственных активов и управлению производством на промышленных предприятиях.
                    </p>

                    <!-- Сетка продуктов -->
                    <div class="row">
                        <?php if (!empty($products)): ?>
                            <?php foreach($products as $product): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 product-card">
                                    <img src="../<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                         class="card-img-top catalog-product-image"
                                         style="height: 200px; object-fit: contain; padding: 1rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['short_description']); ?></p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="<?php echo htmlspecialchars($product['alias']); ?>.php" 
                                           class="btn btn-primary">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <div class="alert alert-warning">
                                    <h5>Товары временно недоступны</h5>
                                    <p>Проверьте подключение к базе данных или наличие товаров в каталоге.</p>
                                    <?php
                                    // Для отладки - покажем ошибку
                                    if (isset($e)) {
                                        echo "<small class='text-muted'>Ошибка: " . $e->getMessage() . "</small>";
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="mt-5">
                        <h3 class="mb-4">Преимущества наших решений</h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <img src="../images/corp.png" alt="Для крупных предприятий" class="mb-2" style="height: 64px;">
                                    <h5>Для крупных предприятий</h5>
                                    <p class="small">Масштабируемые решения для корпораций</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <img src="../images/lock.png" alt="Безопасность" class="mb-2" style="height: 64px;">
                                    <h5>Безопасность</h5>
                                    <p class="small">Соответствие требованиям ФСТЭК</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <img src="../images/sync.png" alt="Интеграция" class="mb-2" style="height: 64px;">
                                    <h5>Интеграция</h5>
                                    <p class="small">Готовность к интеграции с другими системами</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Футер -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Галактика. Все права защищены.</p>
        </div>
    </footer>

<script>  
            // Функция для переключения контекстного меню
            window.toggleContextMenu = function() {
                const menu = document.getElementById('contextMenu');
                menu.classList.toggle('show');
            }

            // Закрытие меню при клике вне его области
            document.addEventListener('click', function(event) {
                const menu = document.getElementById('contextMenu');
                const button = document.querySelector('.context-menu-btn');
                
                if (!menu.contains(event.target) && !button.contains(event.target)) {
                    menu.classList.remove('show');
                }
            });

            // Закрытие меню при нажатии Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    const menu = document.getElementById('contextMenu');
                    menu.classList.remove('show');
                }
            });

            // Обновление активного пункта меню
            document.querySelectorAll('.context-menu-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Убираем активный класс у всех пунктов
                    document.querySelectorAll('.context-menu-item').forEach(i => {
                        i.classList.remove('active');
                    });
                    // Добавляем активный класс к текущему пункту
                    this.classList.add('active');
                    // Закрываем меню после клика
                    document.getElementById('contextMenu').classList.remove('show');
                });
            });
       
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <?php include_once '../modal_auth.php'; ?>
    <script src="../js/auth_manager.js"></script>
</body>
</html>