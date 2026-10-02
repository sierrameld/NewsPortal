<?php
// Модель отвечает только за данные: делает запрос и возвращает массив
class News {

    // Подзапрос, который считает комментарии каждой новости (колонка comments_count)
    private const COUNT_SQL = '(SELECT COUNT(*) FROM comments c WHERE c.news_id = n.id) AS comments_count';

    // Три самые свежие новости (в PDF метод назывался getLast10News, но брал 3)
    public static function getLast3News(): array {
        $db = new Database();
        return $db->getAll(
            'SELECT n.id, n.title, n.picture, ' . self::COUNT_SQL . ' FROM news n ORDER BY n.created_at DESC, n.id DESC LIMIT 3'
        );
    }

    // Все новости, свежие сверху
    public static function getAllNews(): array {
        $db = new Database();
        return $db->getAll('SELECT n.id, n.title, n.picture, ' . self::COUNT_SQL . ' FROM news n ORDER BY n.created_at DESC, n.id DESC');
    }

    // Новости одной категории
    public static function getNewsByCategoryID(int $id): array {
        $db = new Database();
        return $db->getAll(
            'SELECT n.id, n.title, n.picture, ' . self::COUNT_SQL . ' FROM news n WHERE n.category_id = ? ORDER BY n.created_at DESC, n.id DESC',
            [$id]
        );
    }

    // Одна новость целиком. Если такой нет, вернётся false
    public static function getNewsByID(int $id) {
        $db = new Database();
        return $db->getOne('SELECT * FROM news WHERE id = ?', [$id]);
    }
}
