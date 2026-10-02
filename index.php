<?php
// Единая точка входа. Сюда .htaccess присылает все запросы.
session_start();
date_default_timezone_set('Europe/Tallinn');

require_once 'inc/Database.php';
require_once 'model/Category.php';
require_once 'model/News.php';
require_once 'model/Comments.php';
require_once 'model/Register.php';
require_once 'view/news.php';
require_once 'view/comments.php';
require_once 'controller/Controller.php';

// routing.php сам разбирает адрес и вызывает нужный метод контроллера
require_once 'route/routing.php';
