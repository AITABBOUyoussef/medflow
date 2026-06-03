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

     public static function loginSubmitAction()
     {
         session_start();

         $email = $_POST['email'];
         $password = $_POST['password'];

         $userRepository = new UserRepository();

         $user = $userRepository->login($email, $password);

         if (!$user) {
            $_SESSION['error'] = "Invalid email or password.";

             header('Location: index.php?action=login');
             exit;
         }

         $_SESSION['user'] = [
             'id'      => $user->id,
             'name'    => $user->name,
             'email'   => $user->email,
             'role'    => $user->role
         ];

         if ($user->role === 'MEDECIN') {
             header('Location: index.php?action=medecin_dashboard');
             exit;
         }

         if ($user->role === 'PATIENT') {
             header('Location: index.php?action=patient_dashboard');
             exit;
         }

         if ($user->role === 'ADMIN') {
             header('Location: index.php?action=admin_dashboard');
             exit;
         }
     }


    public static function logoutAction()
    {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
        exit;
 }
 
}
