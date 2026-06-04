<?php

include_once 'src/controller/UserController.php';
include_once 'src/controller/MedecinController.php';
require_once 'src/controller/admin_controller.php';

$controller = new AdminController();

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

        case 'logoutAction':
            UserController::logoutAction();
            break;   
            
         case 'create_doctor':
        $controller->createDoctor();
        break;

    case 'update_doctor':
        $controller->updateDoctor();
        break;

    case 'create_specialite':
        $controller->createSpecialite();
        break;

    case 'delete_specialite':
        $controller->deleteSpecialite();
        break;  

    case 'admin_dashboard':
        AdminController::dashboardAction();
        break; 
        
    case 'tableDoctorsAction':
         AdminController::tableDoctorsAction();
         break;
        
    }
}else{
    UserController::loginAction();
}