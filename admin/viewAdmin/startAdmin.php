<article>
    <div id="main" class="container">
        <h3>Админ панель</h3>
        <div class="row">
            <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['name'] ?? '') ?>.</p>
            <?php if (($_SESSION['status'] ?? '') !== 'admin'): ?>
                <p>Управлять новостями может только администратор.</p>
            <?php endif; ?>
        </div>
    </div>
</article>
