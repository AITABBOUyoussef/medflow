<?php

include_once 'src/controller/UserController.php';
include_once 'src/controller/MedecinController.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'login':
           UserController::loginAction();
            break;
        case 'register':
            UserController::registerAction();
            break;

        case 'store_register':
            UserController::registerSubmitAction();
            break;

        case 'login_submit':
            UserController::loginSubmitAction();
            break;
        
        case 'medecin_dashboard':
            MedecinController::dashboardAction();
            break;   
            
        case 'confirm_rdv':
            MedecinController::confirmRdvAction();
            break;

        case 'cancel_rdv':
            MedecinController::cancelRdvAction();
            break;

        case 'show_complete_rdv':
            MedecinController::completeRdvAction();
            break;

        case 'list_rdv':
            MedecinController::listAction();
            break;

        case 'planning':
            MedecinController::planningAction();
            break;
        
    }
}else{
    UserController::loginAction();
}