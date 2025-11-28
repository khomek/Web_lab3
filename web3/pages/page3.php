<?php include_once '../auth_init.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Контакты</title>
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
                    <h1 class="display-4 fw-bold">КОНТАКТЫ</h1>
                    <p class="lead">Свяжитесь с нами для получения дополнительной информации</p>
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
                <div class="content-section">
                    <h2 class="mb-4">Контактная информация</h2>
                    
                    <!-- Контактные данные -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-card">
                                <h4 class="mb-3">Основные контакты</h4>
                                <ul class="contact-info">
                                    <li class="d-flex align-items-center">
                                        <img src="../images/phone.png">
                                        <!-- <span class="contact-icon">📞</span> -->
                                        <strong>Телефон:</strong> +7 495 252-02-55
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img src="../images/email.png">
                                        <!-- <span class="contact-icon">✉️</span> -->
                                        <strong>Email:</strong> market@galaktika.ru
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img src="../images/address.png">
                                        <!-- <span class="contact-icon">🏢</span> -->
                                        <strong>Адрес:</strong> 125167, Россия, Москва, Театральная аллея, 3с1
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="contact-card">
                                <h4 class="mb-3">Реквизиты компании</h4>
                                <ul class="contact-info">
                                    <li class="d-flex align-items-center">
                                        <img src="../images/doc.png">
                                        <!-- <span class="contact-icon">📋</span> -->
                                        <strong>ОГРН:</strong> 1027739341520
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img src="../images/doc.png">
                                        <!-- <span class="contact-icon">🔢</span> -->
                                        <strong>ИНН:</strong> 7707140573
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img src="../images/value.png">
                                        <!-- <span class="contact-icon">📊</span> -->
                                        <strong>ОКВЭД:</strong> 62.01 (основной)
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <img src="../images/building.png">
                                        <!-- <span class="contact-icon">🏛️</span> -->
                                        <strong>Название:</strong> АО «Корпорация Галактика»
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Карта -->
                    <div class="mt-4">
                        <h4 class="mb-3">Наше местоположение</h4>
                        <div class="map-container">
                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A74b6db37284ac5bbac98e6d217557db666833d98338c977cb800d788a4cb1465&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
                        </div>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="row mt-5">
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <img src="../images/clock.png">
                                <!-- <div class="fs-2 text-primary mb-2">🕒</div> -->
                                <h5>Время работы</h5>
                                <p>Пн-Пт: 9:00 - 18:00<br>Сб-Вс: выходной</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <img src="../images/www.png">
                                <!-- <div class="fs-2 text-primary mb-2">🌐</div> -->
                                <h5>Официальный сайт</h5>
                                <p><a href="https://galaktika.ru" class="text-decoration-none">galaktika.ru</a></p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <img src="../images/bag.png">
                                <!-- <div class="fs-2 text-primary mb-2">💼</div> -->
                                <h5>Для бизнеса</h5>
                                <p>Коммерческие предложения и партнерство</p>
                            </div>
                        </div>
                    </div>

                    <!-- Форма обратной связи -->
                    <div class="mt-5">
                        <h4 class="mb-3">Форма обратной связи</h4>
                        <div class="contact-card">
                            <form id="contactForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Ваше имя</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Введите ваш email"   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"  title="Введите корректный email адрес" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Тема сообщения</label>
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Тема сообщения" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Сообщение</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Введите ваше сообщение" required></textarea>
                                </div>

                                <!-- Чекбокс согласия -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="feedbackPrivacyAgreement" name="privacyAgreement" required>
                                    <label class="form-check-label" for="feedbackPrivacyAgreement">
                                        Я подтверждаю согласие на обработку персональных данных
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                            </form>
                        </div>
                    </div>
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
            
            // Гарантируем, что модальное окно скрыто при загрузке
            var loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.style.display = 'none';
                loginModal.classList.remove('show');
            }
    </script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <?php include_once '../modal_auth.php'; ?>
    <script src="../js/auth_manager.js"></script>
</body>
</html>