<?php
class modelAdminCategory {

    // Все категории по алфавиту, для выпадающего списка в формах
    public static function getCategoryList(): array {
        $db = new Database();
        return $db->getAll('SELECT id, name FROM category ORDER BY name ASC');
    }
}
