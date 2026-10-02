<?php
class Register {

    // Регистрация нового пользователя.
    // Возвращает [true] при успехе или [false, 'текст ошибки'].
    public static function registerUser(): array {
        $name     = trim((string)($_POST['name'] ?? ''));
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = (string)($_POST['password'] ?? '');
        $confirm  = (string)($_POST['confirm'] ?? '');

        $errorString = '';
        if ($name === '' || mb_strlen($name) > 100) {
            $errorString .= 'Введите имя (не длиннее 100 символов)<br>';
        }
        if (!$email || mb_strlen($email) > 50) {
            $errorString .= 'Неправильный email<br>';
        }
        if (mb_strlen($password) < 6) {
            $errorString .= 'Пароль должен быть не короче 6 символов<br>';
        }
        if ($password !== $confirm) {
            $errorString .= 'Пароли не совпадают<br>';
        }

        $db = new Database();
        if ($errorString === '' && $db->getOne('SELECT id FROM users WHERE email = ?', [$email])) {
            $errorString .= 'Пользователь с таким email уже зарегистрирован<br>';
        }
        if ($errorString !== '') {
            return [false, $errorString];
        }

        // В базу кладём только хеш пароля, сам пароль не хранится нигде
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $rows = $db->executeRun(
            'INSERT INTO users (username, email, password, status, registration_date) VALUES (?, ?, ?, ?, ?)',
            [$name, mb_strtolower($email), $passwordHash, 'user', date('Y-m-d')]
        );
        return $rows ? [true] : [false, 'Ошибка записи в базу'];
    }
}
