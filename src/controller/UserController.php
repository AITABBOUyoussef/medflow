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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $birthDate = $_POST['birth_date'];


            $userRepo = new UserRepository();
            $userId = $userRepo->register($name, $email, $password, $birthDate);

            if ($userId) {
                header("Location: index.php?action=login");
                exit();
            } else {
                echo "Registration failed.";
            }
        }
    }


}
