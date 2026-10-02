<?php
// Запросы админки к таблице news. Методы изменения возвращают [true] или [false, 'текст ошибки']
class modelAdminNews {

    // Список новостей с категорией и автором, без картинок
    public static function getNewsList(): array {
        $db = new Database();
        return $db->getAll(
            'SELECT n.id, n.title, c.name, u.username
             FROM news n
             JOIN category c ON n.category_id = c.id
             JOIN users u    ON n.user_id = u.id
             ORDER BY n.created_at DESC, n.id DESC'
        );
    }

    // Одна новость со всеми полями, или false
    public static function getNewsDetail(int $id) {
        $db = new Database();
        return $db->getOne(
            'SELECT n.*, c.name, u.username
             FROM news n
             JOIN category c ON n.category_id = c.id
             JOIN users u    ON n.user_id = u.id
             WHERE n.id = ?',
            [$id]
        );
    }

    // ------------------------------------------------ добавление
    public static function getNewsAdd(int $userId): array {
        [$fields, $error] = self::readForm();
        if ($error !== '') return [false, $error];

        [$image, $error] = self::readImage(true);
        if ($error !== '') return [false, $error];

        $db = new Database();
        $rows = $db->executeRun(
            'INSERT INTO news (title, text, picture, category_id, user_id) VALUES (?, ?, ?, ?, ?)',
            [$fields['title'], $fields['text'], $image, $fields['categoryId'], $userId]
        );
        return $rows ? [true] : [false, 'Ошибка записи в базу'];
    }

    // ------------------------------------------------ изменение
    public static function getNewsEdit(int $id): array {
        if (!self::getNewsDetail($id)) return [false, 'Новость не найдена'];

        [$fields, $error] = self::readForm();
        if ($error !== '') return [false, $error];

        [$image, $error] = self::readImage(false);   // новую картинку выбирать не обязательно
        if ($error !== '') return [false, $error];

        $db = new Database();
        if ($image === null) {
            $db->executeRun(
                'UPDATE news SET title = ?, text = ?, category_id = ? WHERE id = ?',
                [$fields['title'], $fields['text'], $fields['categoryId'], $id]
            );
        } else {
            $db->executeRun(
                'UPDATE news SET title = ?, text = ?, picture = ?, category_id = ? WHERE id = ?',
                [$fields['title'], $fields['text'], $image, $fields['categoryId'], $id]
            );
        }
        // rowCount равен 0, если сохранили без изменений, это тоже успех
        return [true];
    }

    // ------------------------------------------------ удаление (комментарии удалит каскад в базе)
    public static function getNewsDelete(int $id): array {
        $db = new Database();
        $rows = $db->executeRun('DELETE FROM news WHERE id = ?', [$id]);
        return $rows ? [true] : [false, 'Новость не найдена'];
    }

    // ------------------------------------------------ проверки формы

    // Заголовок, текст и категория из POST
    private static function readForm(): array {
        $title      = trim((string)($_POST['title'] ?? ''));
        $text       = trim((string)($_POST['text'] ?? ''));
        $categoryId = (int)($_POST['idCategory'] ?? 0);

        if ($title === '' || mb_strlen($title) > 255) return [null, 'Заголовок пустой или длиннее 255 символов'];
        if ($text === '')                              return [null, 'Текст новости пустой'];

        $db = new Database();
        if (!$db->getOne('SELECT id FROM category WHERE id = ?', [$categoryId])) return [null, 'Нет такой категории'];

        return [['title' => $title, 'text' => $text, 'categoryId' => $categoryId], ''];
    }

    // Байты загруженной картинки. [null, ''] если файл не выбран и он не обязателен
    private static function readImage(bool $required): array {
        $file = $_FILES['picture'] ?? null;

        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return $required ? [null, 'Выберите картинку'] : [null, ''];
        }
        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            return [null, 'Файл слишком большой'];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [null, 'Ошибка загрузки файла'];
        }
        if (@getimagesize($file['tmp_name']) === false) {   // проверяем, что это действительно картинка
            return [null, 'Файл не является картинкой'];
        }
        if ($file['size'] > 16 * 1024 * 1024) {             // предел колонки MEDIUMBLOB
            return [null, 'Файл больше 16 МБ'];
        }
        return [file_get_contents($file['tmp_name']), ''];
    }
}
