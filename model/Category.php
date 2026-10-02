<?php
class Category {

    // Все категории для меню
    public static function getAllCategory(): array {
        $db = new Database();
        return $db->getAll('SELECT id, name FROM category ORDER BY id');
    }
}
