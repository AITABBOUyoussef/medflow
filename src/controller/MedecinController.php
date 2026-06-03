<?php

require_once __DIR__ . "/../repository/MedecinRepository.php";
require_once __DIR__ . "/../repository/RendezVousRepository.php";

class MedecinController
{
    public static function dashboardAction()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $medecinRepository = new MedecinRepository();
        $rendezVousRepository = new RendezVousRepository();

        $medecin = $medecinRepository->findByUserId(
            $_SESSION['user']['id']
        );

        $rendezVous = $rendezVousRepository->findByMedecin(
            $medecin->id
        );

        require_once __DIR__ . '/../../views/medecin/dashboard.php';
    }


 

 

  
}