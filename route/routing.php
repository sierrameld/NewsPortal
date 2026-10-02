<?php
// Берём из адреса только последнюю часть после "/"
// /NewsPortal/news?id=2  ->  "news"
// /NewsPortal/           ->  ""
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = substr($uri, strrpos($uri, '/') + 1);

if ($path === '' || $path === 'index' || $path === 'index.php') {
    Controller::StartSite();
}
elseif ($path === 'all') {
    Controller::AllNews();
}
elseif ($path === 'category' && isset($_GET['id'])) {
    Controller::NewsByCatID((int)$_GET['id']);
}
elseif ($path === 'news' && isset($_GET['id'])) {
    Controller::NewsByID((int)$_GET['id']);
}
elseif ($path === 'insertcomment' && $_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['id'], $_POST['comment'])) {
    Controller::InsertComment((int)$_POST['id'], (string)$_POST['comment']);
}
else {
    Controller::error404();
}
