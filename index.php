<?php

include_once 'src/controller/UserController.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'login':
            echo "login";
            break;
        case 'register':
            echo 'register';

    }
}