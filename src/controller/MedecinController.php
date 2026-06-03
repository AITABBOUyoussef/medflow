<?php

require_once __DIR__ . "/../repository/MedecinRepository.php";

class MedecinController
{
    public static function dashboardAction()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        require_once __DIR__ . '/../../views/medecin/dashboard.php';
    }

 

 

  
}