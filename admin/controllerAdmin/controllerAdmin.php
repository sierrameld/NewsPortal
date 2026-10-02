<?php
class controllerAdmin {

    // Главная админки: вошёл, значит стартовая страница, нет, значит форма входа
    public static function formLoginSite(): void {
        if (self::isLogged()) {
            self::render('startAdmin');
            return;
        }
        include __DIR__ . '/../viewAdmin/formLogin.php';
    }

    // Обработка формы входа. После POST всегда перенаправляем, чтобы F5 не слал пароль повторно
    public static function loginAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && !modelAdmin::userAuthentication((string)($_POST['email'] ?? ''), (string)($_POST['password'] ?? ''))) {
            $_SESSION['errorString'] = 'Неправильное имя пользователя или пароль';
        }
        self::redirect('./');
    }

    // Выход из админ-панели
    public static function logoutAction(): void {
        modelAdmin::userLogout();
        self::redirect('./');
    }

    public static function error404(): void {
        http_response_code(404);
        self::render('error404');
    }

    // ---------------------------------------------------------------- общие помощники

    public static function isLogged(): bool {
        return isset($_SESSION['userId']);
    }

    public static function isAdmin(): bool {
        return ($_SESSION['status'] ?? '') === 'admin';
    }

    // Пускает дальше только админа. Гостя отправляет на форму входа,
    // обычному пользователю показывает "У вас нет прав"
    public static function requireAdmin(): bool {
        if (!self::isLogged()) {
            self::redirect('./');
        }
        if (!self::isAdmin()) {
            http_response_code(403);
            self::render('startAdmin');
            return false;
        }
        return true;
    }

    public static function redirect(string $url): void {
        header('Location: ' . $url);
        exit;
    }

    // Как render главного сайта: view в буфер, потом в общий шаблон админки
    public static function render(string $view, array $data = []): void {
        extract($data);
        ob_start();
        include __DIR__ . '/../viewAdmin/' . $view . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
    }
}
