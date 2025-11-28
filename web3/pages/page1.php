<?php include_once '../auth_init.php'; ?>
<?php
require_once '../db_connect.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>О нас</title>
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
                    <h1 class="display-4 fw-bold">О КОМПАНИИ</h1>
                    <p class="lead">Более 37 лет опыта в автоматизации управления предприятиями</p>
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
                        <a href="../index.php" class="context-menu-item">Главная</a>
                        <a href="page1.php" class="context-menu-item active">О нас</a>
                        <a href="page2.php" class="context-menu-item">Каталог</a>
                        <a href="page3.php" class="context-menu-item">Контакты</a>
                        <a href="reviews.php" class="context-menu-item">Отзывы</a>
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-lg-9 mb-4">
                <div class="content-section">
                    <h2 class="mb-4">Наша история</h2>
                    
                    <p class="fs-5 mb-4">
                        «Галактика» — российский разработчик программного обеспечения. Мы более 37 лет занимаемся разработкой и внедрением ПО для автоматизации управления и учета крупных предприятий.
                    </p>
                    
                    <p class="fs-5 mb-5">
                        «Галактика» основана в 1987 году. Сегодня в ней работают более 500 сотрудников, 90% из них – это разработчики, ИТ-архитекторы, специалисты в области систем автоматизации и управления производством. Офисы компании находятся в Москве, Минске и Екатеринбурге.
                    </p>

                    <!-- Статистика компании -->
                    <div class="company-stats mb-5">
                        <h3 class="text-center mb-4">Галактика в цифрах</h3>
                        <div class="row text-center">
                            <div class="col-md-4 stat-item mb-3">
                                <div class="stat-number">37+</div>
                                <div class="stat-label">лет на рынке</div>
                            </div>
                            <div class="col-md-4 stat-item mb-3">
                                <div class="stat-number">6500+</div>
                                <div class="stat-label">реализованных проектов</div>
                            </div>
                            <div class="col-md-4 stat-item mb-3">
                                <div class="stat-number">1200+</div>
                                <div class="stat-label">клиентов</div>
                            </div>
                        </div>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="mt-5">
                        <h3 class="mb-4">Наши ценности</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Качество</h5>
                                        <p class="card-text">Мы гарантируем высочайшее качество наших продуктов и услуг</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Надежность</h5>
                                        <p class="card-text">Наши решения проверены временем и тысячами клиентов</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Инновации</h5>
                                        <p class="card-text">Постоянное развитие и внедрение новых технологий</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Поддержка</h5>
                                        <p class="card-text">Комплексная техническая поддержка и сопровождение</p>
                                    </div>
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