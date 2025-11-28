<?php include_once 'auth_init.php'; ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db_connect.php';

try {
    $sql = "SELECT * FROM product_catalog WHERE featured = true ORDER BY sort_order LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $featured_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $featured_products = [];
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Галактика</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
 
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-brand d-flex align-items-center">
    			<img src="images/label.png" alt="Галактика" class="me-2">
    			<a href="index.php" class="fw-bold text-decoration-none text-white">ГАЛАКТИКА</a>
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
                <button class="btn btn-outline-light login-modal-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Вход / Регистрация
                </button>
            </div>
        </div>
    </nav>
	
	<!-- Главный заголовок и описание -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">ГАЛАКТИКА</h1>
                    <p class="lead">Автоматизация управления и учета крупных предприятий</p>
                    <p class="mb-0">Полноценный отечественный аналог ведущих зарубежных продуктов класса ERP, EAM, MES</p>
                </div>
            </div>
        </div>
    </header>

<!-- Основное содержимое -->
    <main class="container">
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
                        <a href="index.php" class="context-menu-item active">Главная</a>
                        <a href="pages/page1.php" class="context-menu-item">О нас</a>
                        <a href="pages/page2.php" class="context-menu-item">Каталог</a>
                        <a href="pages/page3.php" class="context-menu-item">Контакты</a>
                        <a href="pages/reviews.php" class="context-menu-item">Отзывы</a>
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-lg-9 mb-4">
                <div class="main-content">
                    <section class="mb-5">
                        <p class="fs-5">
                            "Галактика" несет <strong>ответственность</strong> за каждый свой продукт и проект. Мы гарантируем заказчикам внедрение наших программных решений в установленные сроки, с фиксированным бюджетом и минимальными для предприятия рисками.
                        </p>
                    </section>

                    <!-- Мы в цифрах -->
                    <section class="mb-5" id="stats">
                        <h3 class="mb-4">Мы в цифрах</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered stats-table">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="bg-light fw-bold"><em>Галактика</em> в цифрах</td>
                                        <td><b>6500+</b><br>Реализованных проектов</td>
                                        <td><b>1200+</b><br>Заказчиков</td>
                                    </tr>
                                    <tr>
                                        <td><b>1000+</b><br>Ресурсный пул</td>
                                        <td><b>200+</b><br>Партнеров</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light fw-bold">Продукты и решения</td>
                                        <td>Галактика ERP</td>
                                        <td>Галактика EAM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Предстоящие мероприятия -->
                    <section class="mb-5" id="events">
                        <h4 class="mb-3">Предстоящие мероприятия</h4>
                        <ul class="no-bullets">
                            <li>"Галактика ФОРУМ"</li>
                            <li>"Галактика MES"</li>
                            <li>Конференция на ЦИПР</li>
                        </ul>
                    </section>

                    <!-- Участие в ассоциациях -->
                    <section class="mb-5" id="associations">
                        <h4 class="mb-3">Участие в ассоциациях</h4>
                        <ol>
                            <li>АРПП "Отечественный софт"</li>
                            <li>Ассоциация АПКИТ</li>
                            <li>РУССОФТ</li>
                        </ol>
                    </section>

                    <!-- Ключевые события -->
                    <section class="mb-5">
                        <h4 class="mb-3">Ключевые события</h4>
                        <ol>
                            <li>
                                <strong>2025</strong>
                                <ul class="no-bullets mt-2">
                                    <li>Генеральный директор - Алексей Телков</li>
                                    <li>Крупнейшие контракты по цифровизации</li>
                                </ul>
                            </li>
                            <li>В <strong>2024</strong> стали лицензиатом ФСТЭК России</li>
                            <li>В <strong>2023</strong> вошли в состав совета по развитию цифровых технологий</li>
                        </ol>
                    </section>
                </div>
            </div>
        </div>
    </main>

  
		<!-- Футер -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Галактика. Все права защищены.</p>
        </div>
    </footer>

   
<script>
// Функция для переключения контекстного меню
function toggleContextMenu() {
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
    <script src="js/bootstrap.bundle.min.js"></script>
    <?php include_once 'modal_auth.php'; ?>
    <script src="js/auth_manager.js"></script>

</body>
</html>