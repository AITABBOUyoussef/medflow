<?php

class UserController
{

    public static function loginAction()
    {
        require_once __DIR__ . "/../../views/auth/login.php";
    }

    public static function registerAction()
    {
        require_once __DIR__ . "/../../views/auth/register.php";
    }


}
