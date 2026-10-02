<?php
class ViewComments {

    // Форма отправки комментария. Данные идут методом POST на адрес insertcomment
    public static function CommentsForm(int $newsId): void {
        echo '<form action="insertcomment" method="post">';
        echo '<input type="hidden" name="id" value="' . $newsId . '">';
        echo 'Teie kommentaar: <input type="text" name="comment" maxlength="500" required> ';
        echo '<input type="submit" value="Saada">';
        echo '</form>';
    }

    // Таблица с комментариями
    public static function CommentsByNews(array $comments): void {
        if (!$comments) {
            return;
        }
        echo '<table id="ctable">';
        echo '<thead><tr><th>Kommentaar</th><th>Kuupäev</th></tr></thead><tbody>';
        foreach ($comments as $value) {
            echo '<tr><td>' . htmlspecialchars($value['text']) . '</td>';
            echo '<td>' . htmlspecialchars((string)$value['date']) . '</td></tr>';
        }
        echo '</tbody></table>';
    }

    // Количество комментариев красным, для списков новостей. Если комментариев нет, ничего не выводится
    public static function CommentsCount(int $count): void {
        if ($count > 0) {
            echo '<b><font color="red">(' . $count . ')</font></b>';
        }
    }

    // То же количество, но ссылкой на таблицу комментариев (для страницы новости)
    public static function CommentsCountWithAncor(int $count): void {
        if ($count > 0) {
            echo '<b><a href="#ctable">(' . $count . ')</a></b>';
        }
    }
}
