<?php
// Точка входа админ-панели. Сюда admin/.htaccess присылает все запросы внутри /admin/
session_start();
date_default_timezone_set('Europe/Tallinn');

require_once __DIR__ . '/../inc/Database.php';

require_once __DIR__ . '/modelAdmin/modelAdmin.php';
require_once __DIR__ . '/modelAdmin/modelAdminNews.php';
require_once __DIR__ . '/modelAdmin/modelAdminCategory.php';

require_once __DIR__ . '/controllerAdmin/controllerAdmin.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminNews.php';

require_once __DIR__ . '/routeAdmin/routingAdmin.php';
