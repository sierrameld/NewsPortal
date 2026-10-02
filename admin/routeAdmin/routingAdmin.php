<?php
// Последняя часть адреса после "/", как в route/routing.php главного сайта
// /NewsPortal/admin/newsEdit?id=2  ->  "newsEdit"
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = substr($uri, strrpos($uri, '/') + 1);

if ($path === '' || $path === 'index' || $path === 'index.php') {
    controllerAdmin::formLoginSite();                    // форма входа или главная админки
}
// ------------------------------------------------ вход и выход (MVC3)
elseif ($path === 'login') {
    controllerAdmin::loginAction();
}
elseif ($path === 'logout') {
    controllerAdmin::logoutAction();
}
// ------------------------------------------------ список новостей (MVC5)
elseif ($path === 'newsAdmin') {
    controllerAdminNews::NewsList();
}
// ------------------------------------------------ добавление (MVC6)
elseif ($path === 'newsAdd') {
    controllerAdminNews::newsAddForm();
}
elseif ($path === 'newsAddResult') {
    controllerAdminNews::newsAddResult();
}
// ------------------------------------------------ изменение (MVC7)
elseif ($path === 'newsEdit' && isset($_GET['id'])) {
    controllerAdminNews::newsEditForm((int)$_GET['id']);
}
elseif ($path === 'newsEditResult' && isset($_GET['id'])) {
    controllerAdminNews::newsEditResult((int)$_GET['id']);
}
// ------------------------------------------------ удаление (MVC8)
elseif ($path === 'newsDel' && isset($_GET['id'])) {
    controllerAdminNews::newsDeleteForm((int)$_GET['id']);
}
elseif ($path === 'newsDelResult' && isset($_GET['id'])) {
    controllerAdminNews::newsDeleteResult((int)$_GET['id']);
}
else {
    controllerAdmin::error404();
}
