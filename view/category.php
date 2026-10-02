<?php // Пункты выпадающего меню "Kategooriad". Переменная $categories приходит из Controller::render ?>
<li class="submenuunit"><a href="all">ALL</a></li>
<?php foreach ($categories as $c): ?>
<li class="submenuunit"><a href="category?id=<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['name']) ?></a></li>
<?php endforeach; ?>
