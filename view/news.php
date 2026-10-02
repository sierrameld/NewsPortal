<?php
// View отвечает только за HTML: получает готовые данные и показывает их
class ViewNews {

    // Список новостей с картинками (главная, категория, все новости)
    public static function NewsList(array $arr): void {
        if (!$arr) {
            echo '<p>Uudiseid pole.</p>';
            return;
        }
        foreach ($arr as $value) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($value['picture']) . '" width="150"><br>';
            echo '<h2>' . htmlspecialchars($value['title']) . '</h2>';
            ViewComments::CommentsCount((int)$value['comments_count']);
            echo '<a href="news?id=' . (int)$value['id'] . '">Edasi</a><br>';
        }
    }

    // Одна новость целиком
    public static function ReadNews(array $n, int $commentsCount): void {
        echo '<h2>' . htmlspecialchars($n['title']) . '</h2>';
        ViewComments::CommentsCountWithAncor($commentsCount);
        echo '<br><img src="data:image/jpeg;base64,' . base64_encode($n['picture']) . '" width="150"><br>';
        echo '<p>' . nl2br(htmlspecialchars($n['text'])) . '</p>';
    }
}
