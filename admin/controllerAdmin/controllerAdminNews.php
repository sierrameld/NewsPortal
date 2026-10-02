<?php
// Управление новостями. Все методы доступны только админу.
// Результат POST сохраняется в сессии и показывается после перенаправления,
// поэтому F5 на странице результата не повторяет добавление или удаление.
class controllerAdminNews {

    // ------------------------------------------------ список
    public static function NewsList(): void {
        if (!controllerAdmin::requireAdmin()) return;
        controllerAdmin::render('newsList', ['arr' => modelAdminNews::getNewsList()]);
    }

    // ------------------------------------------------ добавление
    public static function newsAddForm(): void {
        if (!controllerAdmin::requireAdmin()) return;
        controllerAdmin::render('newsAddForm', ['arr' => modelAdminCategory::getCategoryList()]);
    }

    public static function newsAddResult(): void {
        if (!controllerAdmin::requireAdmin()) return;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['result'] = modelAdminNews::getNewsAdd((int)$_SESSION['userId']);
            controllerAdmin::redirect('newsAddResult');
        }
        $test = self::takeResult();
        if ($test === null) controllerAdmin::redirect('newsAdd');
        controllerAdmin::render('newsAddForm', ['arr' => [], 'test' => $test]);
    }

    // ------------------------------------------------ изменение
    public static function newsEditForm(int $id): void {
        if (!controllerAdmin::requireAdmin()) return;
        $detail = modelAdminNews::getNewsDetail($id);
        if (!$detail) {
            controllerAdmin::error404();
            return;
        }
        controllerAdmin::render('newsEditForm', [
            'arr' => modelAdminCategory::getCategoryList(), 'detail' => $detail, 'id' => $id,
        ]);
    }

    public static function newsEditResult(int $id): void {
        if (!controllerAdmin::requireAdmin()) return;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['result'] = modelAdminNews::getNewsEdit($id);
            controllerAdmin::redirect('newsEditResult?id=' . $id);
        }
        $test = self::takeResult();
        if ($test === null) controllerAdmin::redirect('newsEdit?id=' . $id);
        controllerAdmin::render('newsEditForm', ['test' => $test, 'id' => $id]);
    }

    // ------------------------------------------------ удаление
    public static function newsDeleteForm(int $id): void {
        if (!controllerAdmin::requireAdmin()) return;
        $detail = modelAdminNews::getNewsDetail($id);
        if (!$detail) {
            controllerAdmin::error404();
            return;
        }
        controllerAdmin::render('newsDeleteForm', [
            'arr' => modelAdminCategory::getCategoryList(), 'detail' => $detail, 'id' => $id,
        ]);
    }

    public static function newsDeleteResult(int $id): void {
        if (!controllerAdmin::requireAdmin()) return;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['result'] = modelAdminNews::getNewsDelete($id);
            controllerAdmin::redirect('newsDelResult?id=' . $id);
        }
        $test = self::takeResult();
        if ($test === null) controllerAdmin::redirect('newsAdmin');
        controllerAdmin::render('newsDeleteForm', ['test' => $test, 'id' => $id]);
    }

    // Забрать результат последней операции из сессии (один раз)
    private static function takeResult(): ?array {
        $result = $_SESSION['result'] ?? null;
        unset($_SESSION['result']);
        return $result;
    }
}
