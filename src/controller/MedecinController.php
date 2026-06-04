<?php

require_once __DIR__ . "/../repository/MedecinRepository.php";
require_once __DIR__ . "/../repository/RendezVousRepository.php";
require_once __DIR__ . "/../repository/OrdonnanceRepository.php";

class MedecinController
{


    public static function dashboardAction()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $medecin = MedecinRepository::findByUserId(
            $_SESSION['user']['id']
        );

        $rendezVous = RendezVousRepository::findByMedecin(
            $medecin->id
        );

        $EN_ATTENTE_rdv = RendezVousRepository::countByStatus('EN_ATTENTE');
        $TERMINE_rdv = RendezVousRepository::countByStatus('TERMINE');
        $CONFIRME_rdv = RendezVousRepository::countByStatus('CONFIRME');
        $ANNULE_rdv = RendezVousRepository::countByStatus('ANNULE');

        require_once __DIR__ . '/../../views/medecin/dashboard.php';
    }

   
     public static function confirmRdvAction()
    {
        RendezVousRepository::confirm($_GET['id']);

        header('Location: index.php?action=medecin_dashboard&msg=Rendez-vous confirmé');
        exit;
    }


    public static function cancelRdvAction()
    {
        RendezVousRepository::cancel($_GET['id']);

        header('Location: index.php?action=medecin_dashboard&msg=Rendez-vous annulé');
        exit;
    }
    
    public static function completeRdvAction()
    {

      $id = $_POST['rdv_id'];
        $ordonnance = $_POST['ordonnance'] ;

        RendezVousRepository::finish($_POST['rdv_id']);
        OrdonnanceRepository::create($id, $ordonnance);

        header('Location: index.php?action=medecin_dashboard&msg=Ordonnance enregistrée');
        exit;

     }   


     public static function listAction()
     {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $medecin = MedecinRepository::findByUserId(
            $_SESSION['user']['id']
        );

        $rendezVous = RendezVousRepository::findByMedecin(
            $medecin->id
        );

        require_once __DIR__ . '/../../views/medecin/list.php';
     }
    

     public static function planningAction()
     {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $medecin = MedecinRepository::findByUserId(
            $_SESSION['user']['id']
        );

        $rendezVous = RendezVousRepository::findByMedecin(
            $medecin->id
        );

        require_once __DIR__ . '/../../views/medecin/planning.php';
     }
 

  
}