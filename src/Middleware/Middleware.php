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

   
}