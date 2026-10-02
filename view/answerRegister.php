<?php // Ответ после регистрации. $result приходит из Controller::registerUser ?>
<?php if ($result[0] === true): ?>
    <div class="alert alert-info">
        <strong>Пользователь добавлен.</strong> <a href="admin/">Dashboard</a>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <strong>Ошибка!</strong><br>
        <?= $result[1] /* текст ошибок составлен в модели, пользовательских данных в нём нет */ ?>
        <a href="registerForm">Форма регистрации</a>
    </div>
<?php endif; ?>
