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
        if (!$n) {
            self::error404(); // новости с таким id нет
            return;
        }
        $comments = Comments::getCommentsByNewsID($id);
        self::render('readnews', ['n' => $n, 'comments' => $comments]);
    }

    public static function InsertComment(int $newsId, string $text): void {
        if (!News::getNewsByID($newsId)) {
            self::error404(); // комментировать можно только существующую новость
            return;
        }
        $text = trim($text);
        if ($text !== '' && mb_strlen($text) <= 500) {
            Comments::insertComment($newsId, $text);
        }
        header('Location: news?id=' . $newsId . '#ctable');
        exit;
    }

    public static function error404(): void {
        http_response_code(404);
        self::render('error404');
    }

    private static function render(string $view, array $data = []): void {
        $categories = Category::getAllCategory();
        extract($data);
        ob_start();
        include __DIR__ . '/../view/' . $view . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../view/layout.php';
    }
}
