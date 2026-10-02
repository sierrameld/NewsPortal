<?php
class modelAdmin {

    // Вход по email и паролю. При успехе кладёт данные пользователя в сессию
    public static function userAuthentication(string $email, string $password): bool {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email || $password === '') {
            return false;
        }
        $db   = new Database();
        $user = $db->getOne('SELECT id, username, password, status FROM users WHERE email = ?', [$email]);

        // password_verify сравнивает введённый пароль с хешем из базы
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }
        session_regenerate_id(true);       // новый номер сессии после входа, защита от подмены сессии
        $_SESSION['sessionId'] = session_id();
        $_SESSION['userId']    = (int)$user['id'];
        $_SESSION['name']      = $user['username'];
        $_SESSION['status']    = $user['status'];
        return true;
    }

    // Выход: очищаем сессию и уничтожаем её
    public static function userLogout(): void {
        $_SESSION = [];
        session_destroy();
    }
}
