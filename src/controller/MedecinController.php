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

        $medecinRepository = new MedecinRepository();
        $rendezVousRepository = new RendezVousRepository();

        $medecin = $medecinRepository->findByUserId(
            $_SESSION['user']['id']
        );

        $rendezVous = $rendezVousRepository->findByMedecin(
            $medecin->id
        );

        $EN_ATTENTE_rdv = $rendezVousRepository->countByStatus('EN_ATTENTE');
        $TERMINE_rdv = $rendezVousRepository->countByStatus('TERMINE');
        $CONFIRME_rdv = $rendezVousRepository->countByStatus('CONFIRME');
        $ANNULE_rdv = $rendezVousRepository->countByStatus('ANNULE');


        require_once __DIR__ . '/../../views/medecin/dashboard.php';
    }

   
     public static function confirmRdvAction()
    {
        $repository = new RendezVousRepository();

        $repository->confirm($_GET['id']);

            header('Location: index.php?action=medecin_dashboard&msg=Rendez-vous confirmé');

        exit;
    }


    public static function cancelRdvAction()
    {
        $repository = new RendezVousRepository();

        $repository->cancel($_GET['id']);

        header('Location: index.php?action=medecin_dashboard&msg=Rendez-vous annulé');
        exit;
    }
    
    public static function completeRdvAction()
    {

      $id = $_POST['rdv_id'];
        $ordonnance = $_POST['ordonnance'] ;
      $reporendtory = new RendezVousRepository();
      $reporendtory->finish($_POST['rdv_id']);
      

        $ordonnanceRepository = new OrdonnanceRepository();
        $ordonnanceRepository->create($id, $ordonnance);

        header('Location: index.php?action=medecin_dashboard&msg=Ordonnance enregistrée');
        exit;

     }   


     public static function listAction()
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

        require_once __DIR__ . '/../../views/medecin/list.php';
     }
    

     public static function planningAction()
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

        require_once __DIR__ . '/../../views/medecin/planning.php';
     }
 

  
}