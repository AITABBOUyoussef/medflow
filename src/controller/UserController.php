<?php

require_once __DIR__ . "/../repository/UserRepository.php";

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

    public static function registerSubmitAction()
    {
       var_dump($_POST);
    }


}
