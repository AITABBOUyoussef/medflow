<?php

include_once 'src/controller/UserController.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'login':
           UserController::loginAction();
            break;
        case 'register':
            UserController::registerAction();
            break;

    }
}