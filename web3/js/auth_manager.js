// auth_manager.js - Максимально упрощенная версия
class AuthManager {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    async init() {
        await this.loadUserInfo();
        this.setupEventListeners();
    }

    // Загрузка информации о пользователе
    async loadUserInfo() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'auth_check.php');
            
            if (!response.ok) return;
            
            const result = await response.json();
            
            if (result.success && result.user) {
                this.currentUser = result.user;
                this.updateAuthButton();
            } else {
                this.currentUser = null;
                this.updateAuthButton();
            }
        } catch (error) {
            console.log('Auth check failed, user not logged in');
            this.currentUser = null;
            this.updateAuthButton();
        }
    }

    // Обновление только кнопки в шапке
    updateAuthButton() {
        const authButtons = document.querySelectorAll('.login-modal-btn');
        
        authButtons.forEach(button => {
            if (this.currentUser) {
                let displayName = this.currentUser.username;
                if (this.currentUser.first_name) {
                    displayName = this.currentUser.first_name;
                }
                button.textContent = displayName;
                button.classList.remove('btn-outline-light');
                button.classList.add('btn-success');
                
                // Для авторизованных - показываем dropdown при клике
                button.setAttribute('data-bs-toggle', ''); // Убираем Bootstrap toggle
                button.onclick = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showUserDropdown(button);
                };
            } else {
                button.textContent = 'Вход / Регистрация';
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-light');
                // Для неавторизованных - возвращаем Bootstrap функциональность
                button.setAttribute('data-bs-toggle', 'modal');
                button.onclick = null;
            }
        });
    }

    // Простой dropdown
    showUserDropdown(button) {
        // Удаляем старый dropdown если есть
        const oldDropdown = document.querySelector('.user-dropdown');
        if (oldDropdown) oldDropdown.remove();
        
        const dropdown = document.createElement('div');
        dropdown.className = 'user-dropdown';
        dropdown.style.cssText = `
            position: fixed;
            z-index: 1060;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-width: 180px;
        `;
        
        const rect = button.getBoundingClientRect();
        dropdown.style.top = (rect.bottom + 5) + 'px';
        dropdown.style.left = (rect.left) + 'px';
        
        dropdown.innerHTML = `
            <div style="padding: 8px 12px; border-bottom: 1px solid #eee;">
                <div style="font-weight: bold;">${this.currentUser.username}</div>
                <div style="font-size: 12px; color: #666;">${this.currentUser.email || 'No email'}</div>
            </div>
            <button onclick="authManager.logout()" style="width: 100%; border: none; background: none; padding: 8px 12px; text-align: left; color: #dc3545; cursor: pointer;">
                Выйти
            </button>
        `;
        
        document.body.appendChild(dropdown);
        
        // Закрытие при клике вне
        setTimeout(() => {
            const closeHandler = (e) => {
                if (!dropdown.contains(e.target) && e.target !== button) {
                    dropdown.remove();
                    document.removeEventListener('click', closeHandler);
                }
            };
            document.addEventListener('click', closeHandler);
        }, 0);
    }

    // Скрыть dropdown
    hideUserDropdown() {
        const dropdowns = document.querySelectorAll('.user-dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.remove();
        });
    }

    // Вход
async login(login, password) {
    console.log('Login method called'); // Отладка
    try {
        const basePath = this.getBasePath();
        const response = await fetch(basePath + 'auth_login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ login, password })
        });
        
        console.log('Login response status:', response.status); // Отладка
        
        const result = await response.json();
        console.log('Login result:', result); // Отладка
        
        if (result.success) {
            this.currentUser = result.user;
            this.updateAuthButton();
            this.showMessage('Вход выполнен успешно!', 'success');
            
            // Закрываем модальное окно
            const modal = document.getElementById('loginModal');
            if (modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
            }
            
            return true;
        } else {
            this.showMessage('Ошибка: ' + result.message, 'error');
            return false;
        }
    } catch (error) {
        console.error('Login error:', error);
        this.showMessage('Произошла ошибка при входе', 'error');
        return false;
    }
}
    // Выход
    async logout() {
        try {
            // Сразу скрываем dropdown
            this.hideUserDropdown();
            
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'auth_logout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.currentUser = null;
                this.updateAuthButton();
                this.showMessage('Выход выполнен успешно!', 'info'); // ЗАМЕНЕНО
                
                setTimeout(() => {
                    window.location.reload();
                }, 100);
            }
        } catch (error) {
            console.error('Logout error:', error);
            
            // Даже если ошибка, очищаем локальное состояние
            this.currentUser = null;
            this.updateAuthButton();
            this.showMessage('Произошла ошибка при выходе', 'error'); // ЗАМЕНЕНО
            
            // Принудительно удаляем куки на клиенте
            document.cookie = 'auth_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            
            setTimeout(() => {
                window.location.reload();
            }, 100);
        }
    }

    // Регистрация
async register(userData) {
    try {
        const basePath = this.getBasePath();
        const response = await fetch(basePath + 'auth_register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData)
        });
        
        // Проверяем статус ответа
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            this.currentUser = result.user;
            this.updateAuthButton();
            this.showMessage('Регистрация выполнена успешно!', 'success');
            
            // Закрываем модальное окно
            const modal = document.getElementById('loginModal');
            if (modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
            }
            
            return true;
        } else {
            this.showMessage('Ошибка: ' + result.message, 'error');
            return false;
        }
    } catch (error) {
        console.error('Register error:', error);
        this.showMessage('Произошла ошибка при регистрации', 'error');
        return false;
    }
}

    // Вспомогательные методы
    getBasePath() {
        const currentPath = window.location.pathname;
        if (currentPath.includes('/pages/')) {
            return '../';
        }
        return './';
    }

   // Показать сообщение (автоматически закрывается)
showMessage(message, type = 'success') {
    console.log('showMessage called:', message, type); // Отладка
    
    try {
        // Удаляем существующие уведомления
        const existingAlerts = document.querySelectorAll('.custom-alert');
        existingAlerts.forEach(alert => {
            if (alert.parentElement) {
                alert.remove();
            }
        });
        
        // Создаем новое уведомление
        const alert = document.createElement('div');
        alert.className = `custom-alert ${type}`;
        
        // Принудительно задаем стили
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 300px;
            max-width: 500px;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.3s ease-out;
        `;
        
        // Добавляем цветовые стили в зависимости от типа
        if (type === 'success') {
            alert.style.backgroundColor = '#d4edda';
            alert.style.color = '#155724';
            alert.style.border = '1px solid #c3e6cb';
        } else if (type === 'error') {
            alert.style.backgroundColor = '#f8d7da';
            alert.style.color = '#721c24';
            alert.style.border = '1px solid #f5c6cb';
        } else if (type === 'info') {
            alert.style.backgroundColor = '#d1ecf1';
            alert.style.color = '#0c5460';
            alert.style.border = '1px solid #bee5eb';
        }
        
        alert.innerHTML = `
            <div class="message-content" style="flex: 1;">${message}</div>
            <button class="close-btn" style="background: none; border: none; font-size: 18px; cursor: pointer; margin-left: 15px; color: inherit; opacity: 0.7;">&times;</button>
        `;
        
        document.body.appendChild(alert);
        console.log('Alert added to DOM'); // Отладка
        
        // Добавляем обработчик для ручного закрытия
        const closeBtn = alert.querySelector('.close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 300);
            });
        }
        
        // Автоматически закрываем через 3 секунды
        setTimeout(() => {
            if (alert.parentElement) {
                alert.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 300);
            }
        }, 3000);
        
    } catch (error) {
        console.error('Error showing message:', error);
        // Fallback на стандартный alert
        alert(`[${type}] ${message}`);
    }
}

    setupEventListeners() {
        // Ждем полной загрузки DOM
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.setupFormHandlers();
            });
        } else {
            this.setupFormHandlers();
        }
    }

    setupFormHandlers() {
    // Форма входа
    const loginForm = document.getElementById('loginFormElement');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            this.login(
                formData.get('login'),
                formData.get('password')
            ).then(success => {
                if (success) {
                    loginForm.reset();
                } else {
                    // Ошибка уже обработана в методе login
                }
            }).catch(error => {
                this.showMessage('Произошла ошибка при входе', 'error');
            });
        });
    }
    
    // Форма регистрации
    const registerForm = document.getElementById('registerFormElement');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            const userData = Object.fromEntries(formData.entries());
            this.register(userData).then(success => {
                if (success) {
                    registerForm.reset();
                } else {
                    // Ошибка уже обработана в методе register
                }
            }).catch(error => {
                this.showMessage('Произошла ошибка при регистрации', 'error');
            });
        });
    }

     // Обработчик формы отзывов
    const feedbackForm = document.getElementById('feedbackForm');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopImmediatePropagation(); // Важно: останавливаем все обработчики
            await this.submitFeedbackForm(feedbackForm);
            return false; // Дополнительная защита
        });
    }

    // Обработчик формы обратной связи (контакты)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            await this.submitContactForm(contactForm);
            return false;
        });
    }

    // Обработчики форм демонстрации
    const demoForms = document.querySelectorAll('.demo-request-form');
    demoForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            await this.submitDemoForm(form);
            return false;
        });
    });
}

// Метод для отправки формы отзывов
async submitFeedbackForm(form) {
    console.log('=== SUBMIT FEEDBACK FORM DEBUG ===');
    
    // Проверяем авторизацию
    if (!this.currentUser) {
        this.showMessage('Для отправки отзыва необходимо авторизоваться', 'error');
        return;
    }

    try {
        const formData = new FormData(form);
        
        // Детальная отладка всех полей
        console.log('All feedback form fields:');
        for (let [key, value] of formData.entries()) {
            console.log(`  ${key}: '${value}'`);
        }
        
        // Проверяем конкретно важные поля
        const emailField = form.querySelector('#userEmail');
        const ratingField = form.querySelector('input[name="rating"]:checked');
        console.log('Email field value:', emailField ? emailField.value : 'NOT FOUND');
        console.log('Rating selected:', ratingField ? ratingField.value : 'NOT FOUND');
        
        const data = Object.fromEntries(formData);
        console.log('Feedback form data as object:', data);
        
        const basePath = this.getBasePath();
        console.log('Base path:', basePath);
        
        const response = await fetch(basePath + 'submit_review.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        });
        
        console.log('Response status:', response.status);
        
        const text = await response.text();
        console.log('Raw response:', text);
        
        try {
            const result = JSON.parse(text);
            console.log('Parsed result:', result);
            
            if (result.success) {
                this.showMessage(result.message, 'success');
                form.reset();
            } else {
                this.showMessage(result.message, 'error');
            }
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            this.showMessage('Ошибка при обработке ответа сервера', 'error');
        }
        
    } catch (error) {
        console.error('Fetch error:', error);
        this.showMessage('Произошла ошибка при отправке отзыва', 'error');
    }
}
// Метод для отправки формы обратной связи
async submitContactForm(form) {
    console.log('=== SUBMIT CONTACT FORM DEBUG ===');
    
    try {
        const formData = new FormData(form);
        
        // Детальная отладка всех полей
        console.log('All form fields:');
        for (let [key, value] of formData.entries()) {
            console.log(`  ${key}: '${value}'`);
        }
        
        // Проверяем конкретно чекбокс
        const privacyCheckbox = form.querySelector('#feedbackPrivacyAgreement');
        console.log('Privacy checkbox element:', privacyCheckbox);
        console.log('Privacy checkbox checked:', privacyCheckbox ? privacyCheckbox.checked : 'NOT FOUND');
        console.log('Privacy checkbox name:', privacyCheckbox ? privacyCheckbox.name : 'NOT FOUND');
        console.log('Privacy checkbox value:', privacyCheckbox ? privacyCheckbox.value : 'NOT FOUND');
        
        const data = Object.fromEntries(formData);
        console.log('Form data as object:', data);
        
        const basePath = this.getBasePath();
        console.log('Base path:', basePath);
        
        const response = await fetch(basePath + 'submit_contact.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        });
        
        console.log('Response status:', response.status);
        
        const text = await response.text();
        console.log('Raw response:', text);
        
        try {
            const result = JSON.parse(text);
            console.log('Parsed result:', result);
            
            if (result.success) {
                this.showMessage(result.message, 'success');
                form.reset();
            } else {
                this.showMessage(result.message, 'error');
            }
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            this.showMessage('Ошибка при обработке ответа сервера', 'error');
        }
        
    } catch (error) {
        console.error('Fetch error:', error);
        this.showMessage('Произошла ошибка при отправке сообщения', 'error');
    }
}

// Метод для отправки формы демонстрации
async submitDemoForm(form) {
    try {
        const formData = new FormData(form);
        const basePath = this.getBasePath();
        
        const response = await fetch(basePath + 'demo_form.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            this.showMessage(result.message, 'success');
            form.reset();
        } else {
            this.showMessage(result.message, 'error');
        }
    } catch (error) {
        console.error('Error submitting demo form:', error);
        this.showMessage('Произошла ошибка при отправке заявки', 'error');
    }
}
}


// Создаем глобальный экземпляр
const authManager = new AuthManager();

// Глобальные функции для переключения форм
function showRegistrationForm() {
    const loginForm = document.getElementById('loginForm');
    const registrationForm = document.getElementById('registrationForm');
    const userInfo = document.getElementById('userInfo');
    
    if (loginForm) loginForm.style.display = 'none';
    if (registrationForm) registrationForm.style.display = 'block';
    if (userInfo) userInfo.style.display = 'none';
}

function showLoginForm() {
    const loginForm = document.getElementById('loginForm');
    const registrationForm = document.getElementById('registrationForm');
    const userInfo = document.getElementById('userInfo');
    
    if (loginForm) loginForm.style.display = 'block';
    if (registrationForm) registrationForm.style.display = 'none';
    if (userInfo) userInfo.style.display = 'none';
}

