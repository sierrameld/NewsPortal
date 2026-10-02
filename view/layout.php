<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NEWSPORTAL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css?v=<?= filemtime(__DIR__ . '/../style.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
</head>
<body>
    <nav class="one">
        <ul class="topmenu">
            <li><a href="#">Kategooriad</a>
                <ul class="submenu">
                    <?php include __DIR__ . '/category.php'; ?>
                </ul>
            </li>
            <li><a href="testError">Info</a></li>
            <li><a href="./">Stardileht</a></li>
        </ul>
    </nav>

    <section>
        <div class="divBox">
            <?= $content ?? '<h1>Content is gone!</h1>' ?>
        </div>
    </section>

    <hr>
    <p style="display:block; text-align:center;">NEWSPORTAL &copy; <?= date('Y') ?></p>
</body>
</html>
