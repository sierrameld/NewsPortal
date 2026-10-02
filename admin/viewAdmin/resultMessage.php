<?php
// Сообщение о результате добавления, изменения или удаления.
// $test = [true] или [false, 'текст ошибки'], $okText и $failText задаёт страница
?>
<?php if ($test[0] === true): ?>
    <div class="alert alert-info">
        <strong><?= $okText ?></strong> <a href="newsAdmin">Список новостей</a>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <strong><?= $failText ?></strong> <?= htmlspecialchars($test[1] ?? '') ?>
        <a href="newsAdmin">Список новостей</a>
    </div>
<?php endif; ?>
