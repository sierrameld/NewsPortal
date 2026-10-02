<?php
class Controller {

    public static function StartSite(): void {
        $arr = News::getLast3News();
        self::render('start', ['arr' => $arr]);
    }

    public static function AllNews(): void {
        $arr = News::getAllNews();
        self::render('allnews', ['arr' => $arr]);
    }

    public static function NewsByCatID(int $id): void {
        $arr = News::getNewsByCategoryID($id);
        self::render('catnews', ['arr' => $arr]);
    }

    public static function NewsByID(int $id): void {
        $n = News::getNewsByID($id);
        if (!$n) {                       // новости с таким id нет
            self::error404();
            return;
        }
        $comments = Comments::getCommentsByNewsID($id);
        self::render('readnews', ['n' => $n, 'comments' => $comments]);
    }

    // Принять комментарий из формы и вернуть человека на страницу новости
    public static function InsertComment(int $newsId, string $text): void {
        if (!News::getNewsByID($newsId)) {   // комментировать можно только существующую новость
            self::error404();
            return;
        }
        $text = trim($text);
        if ($text !== '' && mb_strlen($text) <= 500) {
            Comments::insertComment($newsId, $text);
        }
        header('Location: news?id=' . $newsId . '#ctable');
        exit;
    }

    // Форма регистрации, отдельная страница со своими стилями
    public static function registerForm(): void {
        include __DIR__ . '/../view/formRegister.php';
    }

    // Обработка формы регистрации и ответ внутри общего шаблона
    public static function registerUser(): void {
        $result = Register::registerUser();
        self::render('answerRegister', ['result' => $result]);
    }

    public static function error404(): void {
        http_response_code(404);
        self::render('error404');
    }

    // Собирает страницу: сначала view в буфер, потом кладёт результат в layout.
    // Список категорий нужен меню на каждой странице, поэтому берём его здесь.
    private static function render(string $view, array $data = []): void {
        $categories = Category::getAllCategory();
        extract($data);
        ob_start();
        include __DIR__ . '/../view/' . $view . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../view/layout.php';
    }
}
