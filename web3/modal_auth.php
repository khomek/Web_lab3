<!-- Модальное окно входа/регистрации -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Вход / Регистрация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Форма входа -->
                <div id="loginForm">
                    <form id="loginFormElement">
                        <div class="mb-3">
                            <label for="login" class="form-label">Логин или Email</label>
                            <input type="text" class="form-control" id="login" name="login" placeholder="Введите ваш логин или email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Введите ваш пароль" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Войти</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="showRegistrationForm()">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>

                <!-- Форма регистрации -->
                <div id="registrationForm" style="display: none;">
                    <form id="registerFormElement">
                        <div class="mb-3">
                            <label for="regUsername" class="form-label">Логин *</label>
                            <input type="text" class="form-control" id="regUsername" name="username" placeholder="Придумайте логин" required>
                        </div>
                        <div class="mb-3">
                            <label for="regEmail" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="regEmail" name="email" placeholder="Введите вашу почту" required>
                        </div>
                        <div class="mb-3">
                            <label for="regPassword" class="form-label">Пароль *</label>
                            <input type="password" class="form-control" id="regPassword" name="password" placeholder="Придумайте пароль" required>
                        </div>
                        <div class="mb-3">
                            <label for="regFirstName" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="regFirstName" name="first_name" placeholder="Ваше имя">
                        </div>
                        <div class="mb-3">
                            <label for="regLastName" class="form-label">Фамилия</label>
                            <input type="text" class="form-control" id="regLastName" name="last_name" placeholder="Ваша фамилия">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="showLoginForm()">Назад ко входу</button>
                        </div>
                    </form>
                </div>
                
                <!-- Блок информации о пользователе -->
                <div id="userInfo" style="display: none;">
                    <div class="text-center">
                        <h5>Добро пожаловать!</h5>
                        <p>Вы авторизованы как <strong id="userName">Пользователь</strong></p>
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-danger me-2" onclick="authManager.logout()">Выйти</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>