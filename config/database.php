<?php

require_once DIR . "/Env.php";
Env::load(DIR . "/../.env");
class DB {

    public static function connect() {

        try {
            $pdo = new PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }
}
?>


