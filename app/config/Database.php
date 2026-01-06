<?php
class Database {
    private static $conn;

    public static function connect() {
        if (!self::$conn) {
            self::$conn = new PDO(
                "mysql:host=localhost;dbname=sams",
                "root", "Bikash07",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$conn;
    }
}
