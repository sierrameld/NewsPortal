<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link href="public/css/mystyle.css" rel="stylesheet">
    <link href="public/css/font-awesome.min.css" rel="stylesheet">
    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

    <?php if (isset($_SESSION['userId'])): ?>
    <div class="header clearfix">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <ul class="nav nav-pills pull-right">
                    <li role="button"><?= htmlspecialchars($_SESSION['name']) ?>
                        <a href="logout" style="display: inline;">Выйти <i class="fa fa-sign-out"></i></a>
                    </li>
                </ul>
                <?php if (($_SESSION['status'] ?? '') === 'admin'): ?>
                    <h4>
                        <a href="../" target="_blank">WEB SITE</a>
                        &#187; <a href="./">Start admin</a>
                        &#187; <a href="newsAdmin">News List</a>
                    </h4>
                <?php else: ?>
                    <h4>У вас нет прав!</h4>
                <?php endif; ?>
            </div>
        </nav>
    </div>
    <?php endif; ?>

    <div id="content" style="padding-top:20px;">
        <?= $content ?? '' ?>
    </div>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Design Admin dashboard <i class="fa fa-child"></i></p>
    </footer>
</div>
</body>
</html>
