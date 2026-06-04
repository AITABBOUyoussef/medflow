<?php

include_once __DIR__ . "/../../config/DB.php";

class BaseRepository
{
    protected static ?PDO $pdo = null;

    protected static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = DB::connect();
        }

        return self::$pdo;
    }
}