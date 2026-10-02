<?php
class Comments {

    // Добавить комментарий к новости
    public static function insertComment(int $newsId, string $text): int {
        $db = new Database();
        return $db->executeRun(
            'INSERT INTO comments (news_id, text, date) VALUES (?, ?, ?)',
            [$newsId, $text, date('Y-m-d H:i:s')]
        );
    }

    // Все комментарии к новости, новые сверху
    public static function getCommentsByNewsID(int $newsId): array {
        $db = new Database();
        return $db->getAll(
            'SELECT id, text, date FROM comments WHERE news_id = ? ORDER BY id DESC',
            [$newsId]
        );
    }
}
