<?php
session_start();
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
            
            if(empty($name) || empty($email) || empty($password) || empty($birthDate)) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: index.php?action=register");
                exit();
            }
               
            $userRepo = new UserRepository();
             
            $existingUser = $userRepo->findByEmail($email);

            if ($existingUser) {
                $_SESSION['error'] = "A user with that email already exists.";
                header("Location: index.php?action=register");
                exit();
            }

            $userId = $userRepo->register($name, $email, $password, $birthDate);

            if ($userId) {
                header("Location: index.php?action=login");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed.";
                header("Location: index.php?action=register");
                exit();
            }
        }
    }

    
  


}
