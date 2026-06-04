<?php

class Middleware
{
    public static function auth()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public static function medecin()
    {
        self::auth();

        if ($_SESSION['user']['role'] !== 'MEDECIN') {
           header('Location: index.php?action=login');
            exit;
        }
    }

    public static function patient()
    {
        self::auth();

        if ($_SESSION['user']['role'] !== 'PATIENT') {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public static function admin()
    {
        self::auth();

        if ($_SESSION['user']['role'] !== 'ADMIN') {
              header('Location: index.php?action=login');
                exit;
        }
    }
}