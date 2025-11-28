<?php include_once '../auth_init.php'; ?>
<?php
require_once '../db_connect.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Отзывы</title>
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
                    <h1 class="display-4 fw-bold">ОТЗЫВЫ</h1>
                    <p class="lead">Поделитесь своим мнением о наших продуктах и услугах</p>
                </div>
                <!-- <div class="col-md-4 text-center">
                    <img src="../images/main1.png" alt="Галактика" class="img-fluid" style="max-height: 150px;">
                </div> -->
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
                        <a href="page1.php" class="context-menu-item">О нас</a>
                        <a href="page2.php" class="context-menu-item">Каталог</a>
                        <a href="page3.php" class="context-menu-item">Контакты</a>
                        <a href="reviews.php" class="context-menu-item">Отзывы</a>
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-lg-9 mb-4">
                <div class="feedback-form">
                    <h2 class="mb-4">Форма обратной связи</h2>
                    <p class="text-muted mb-4">Заполните форму ниже, чтобы оставить свой отзыв о наших продуктах и услугах. Все поля, отмеченные *, обязательны для заполнения.</p>

                    <form id="feedbackForm" onsubmit="return false;">
                        <!-- Секция 1: Основная информация -->
                        <div class="form-section">
                            <h4>Основная информация</h4>
                            
                            <!-- Однострочное текстовое поле -->
                            <div class="mb-3">
                                <label for="userName" class="form-label required-field">Ваше имя</label>
                                <input type="text" class="form-control" id="userName" name="userName" placeholder="Введите ваше имя" required>
                            </div>

                            <!-- Однострочное текстовое поле -->
                            <div class="mb-3">
                                <label for="userEmail" class="form-label required-field">Email адрес</label>
                                <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="example@mail.ru" required>
                                <div class="form-text">Мы никогда не передадим вашу электронную почту кому-либо еще.</div>
                            </div>

                            <!-- Раскрывающийся список -->
                            <div class="mb-3">
                                <label for="productSelect" class="form-label required-field">Продукт/Услуга</label>
                                <select class="form-select" id="productSelect" name="productSelect" required>
                                    <option value="" selected disabled>Выберите продукт...</option>
                                    <option value="galaktika-erp">Галактика ERP</option>
                                    <option value="galaktika-erp-hr">Галактика ERP HR</option>
                                    <option value="galaktika-eam">Галактика EAM</option>
                                    <option value="galaktika-mes">Галактика MES</option>
                                </select>
                            </div>
                        </div>

                        <!-- Секция 2: Оценка продукта -->
                        <div class="form-section">
                            <h4>Оценка продукта</h4>
                            
                            <!-- Радио кнопки -->
                            <div class="mb-3">
                                <label class="form-label required-field">Общая оценка</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="rating5" value="5" required>
                                    <label class="form-check-label" for="rating5">
                                        Отлично
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="rating4" value="4">
                                    <label class="form-check-label" for="rating4">
                                        Хорошо 
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="rating3" value="3">
                                    <label class="form-check-label" for="rating3">
                                        Удовлетворительно 
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="rating2" value="2">
                                    <label class="form-check-label" for="rating2">
                                        Плохо 
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="rating1" value="1">
                                    <label class="form-check-label" for="rating1">
                                        Очень плохо 
                                    </label>
                                </div>
                            </div>

                            <!-- Флажки (чекбоксы) -->
                            <div class="mb-3">
                                <label class="form-label">Что вам понравилось? (можно выбрать несколько вариантов)</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="likedFeatures" id="feature1" value="interface">
                                    <label class="form-check-label" for="feature1">
                                        Удобный интерфейс
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="likedFeatures" id="feature2" value="functionality">
                                    <label class="form-check-label" for="feature2">
                                        Богатый функционал
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="likedFeatures" id="feature3" value="support">
                                    <label class="form-check-label" for="feature3">
                                        Качественная поддержка
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="likedFeatures" id="feature4" value="performance">
                                    <label class="form-check-label" for="feature4">
                                        Высокая производительность
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="likedFeatures" id="feature5" value="documentation">
                                    <label class="form-check-label" for="feature5">
                                        Хорошая документация
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Секция 3: Текстовые отзывы -->
                        <div class="form-section">
                            <h4>Ваш отзыв</h4>
                            
                            <!-- Многострочное текстовое поле -->
                            <div class="mb-3">
                                <label for="detailedReview" class="form-label required-field">Подробный отзыв</label>
                                <textarea class="form-control" id="detailedReview" name="detailedReview" rows="5" placeholder="Расскажите подробно о вашем опыте использования продукта..." required></textarea>
                            </div>

                            <!-- Прокручивающееся текстовое поле -->
                            <div class="mb-3">
                                <label for="suggestions" class="form-label">Предложения по улучшению</label>
                                <textarea class="form-control" id="suggestions" name="suggestions" rows="3" placeholder="Что бы вы хотели улучшить в нашем продукте?"></textarea>
                                <div class="form-text">Это поле не является обязательным, но мы будем благодарны за ваши предложения.</div>
                            </div>
                        </div>

                        <!-- Секция 4: Дополнительные опции -->
                        <div class="form-section">
                            <h4>Дополнительные опции</h4>
                            
                            <!-- Переключатель (toggle switch) -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">
                                        Получать новости о новых продуктах и обновлениях
                                    </label>
                                </div>
                            </div>

                            <!-- Флажок согласия -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="privacyAgreement" name="privacyAgreement" required>
                                <label class="form-check-label required-field" for="privacyAgreement">
                                    Я подтверждаю согласие на обработку персональных данных
                                </label>
                            </div>

                            <!-- Флажок публикации -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="publishAgreement" name="publishAgreement" required>
                                <label class="form-check-label" for="publishAgreement">
                                    Я согласен на публикацию моего отзыва на сайте (без указания личных данных)
                                </label>
                            </div>
                        </div>

                        <!-- Кнопка отправки -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">Очистить форму</button>
                            <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                        </div>
                    </form>
                </div>

                <!-- Информация об обработке отзывов -->
                <div class="alert alert-info mt-4">
                    <h5>Обработка отзывов</h5>
                    <p class="mb-0">Все отзывы проходят модерацию перед публикацией. Мы отвечаем на большинство отзывов в течение 2-3 рабочих дней. Спасибо за ваше время и обратную связь!</p>
                </div>
            </div>
        </div>
    </main>

        <!-- Футер -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Галактика. Все права защищены.</p>
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
            
            if (menu && button && !menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.remove('show');
            }
        });

        // Закрытие меню при нажатии Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const menu = document.getElementById('contextMenu');
                if (menu) {
                    menu.classList.remove('show');
                }
            }
        });

        // Обновление активного пункта меню
        document.querySelectorAll('.context-menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.context-menu-item').forEach(i => {
                    i.classList.remove('active');
                });
                this.classList.add('active');
                const menu = document.getElementById('contextMenu');
                if (menu) {
                    menu.classList.remove('show');
                }
            });
        });
        
        
        
        // Исправляем дублирование ID в форме отзывов
        document.addEventListener('DOMContentLoaded', function() {
            const privacyCheckbox = document.querySelector('#feedbackForm #privacyAgreement');
            if (privacyCheckbox) {
                privacyCheckbox.id = 'reviewPrivacyAgreement';
                const label = document.querySelector('label[for="privacyAgreement"]');
                if (label) {
                    label.setAttribute('for', 'reviewPrivacyAgreement');
                }
            }
        });
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <?php include_once '../modal_auth.php'; ?>
    <script src="../js/auth_manager.js"></script>
</body>
</html>