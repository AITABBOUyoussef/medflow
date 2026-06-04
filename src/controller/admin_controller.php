<?php

require_once __DIR__ . '/../repository/admin_repository.php';
require_once __DIR__ . '/../../config/database.php';

class AdminController
{
    private $repository;



    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $db = $database->connect();

        $this->repository = new admin_repository($db);
    }

    public function createDoctor()
    {
        $doctor_name     = trim($_POST['doctor_name'] ?? '');
        $doctor_email    = trim($_POST['doctor_email'] ?? '');
        $doctor_password = $_POST['doctor_password'] ?? '';
        $specialite_id   = (int) ($_POST['specialite_id'] ?? 0);

        if (
            empty($doctor_name) ||
            empty($doctor_email) ||
            empty($doctor_password) ||
            $specialite_id <= 0
        ) {
            $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires.";
            self::redirectTo('/views/admin/dashboard_admin.php');
        }

        $result = $this->repository->createDoctor(
            $doctor_name,
            $doctor_email,
            $doctor_password,
            $specialite_id
        );

        if ($result) {
            $_SESSION['success'] =
                "Le médecin $doctor_name a été créé avec succès.";
        } else {
            $_SESSION['error'] =
                "Erreur lors de la création du médecin.";
        }

        self::redirectTo('/views/admin/dashboard_admin.php');
    }

    public function updateDoctor()
    {
        $doctor_id     = (int) ($_POST['doctor_id'] ?? 0);
        $doctor_name   = trim($_POST['doctor_name'] ?? '');
        $specialite_id = (int) ($_POST['specialite_id'] ?? 0);
        $doctor_status = trim($_POST['doctor_status'] ?? 'Actif');

        if (
            $doctor_id <= 0 ||
            empty($doctor_name) ||
            $specialite_id <= 0
        ) {
            $_SESSION['error'] = "Données invalides.";
            self::redirectTo('/views/admin/table_doctors.php');
        }

        $result = $this->repository->updateDoctor(
            $doctor_id,
            $doctor_name,
            $specialite_id,
            $doctor_status
        );

        if ($result) {
            $_SESSION['success'] =
                "Médecin modifié avec succès.";
        } else {
            $_SESSION['error'] =
                "Erreur lors de la modification.";
        }

        self::redirectTo('/views/admin/table_doctors.php');
    }

    public function createSpecialite()
    {
        $name = trim($_POST['specialite_name'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] =
                "Veuillez saisir un nom de spécialité.";
        } else {

            $result = $this->repository->creatSpécialité($name);

            if ($result) {
                $_SESSION['success'] =
                    "Spécialité ajoutée avec succès.";
            } else {
                $_SESSION['error'] =
                    "La spécialité existe déjà.";
            }
        }

        self::redirectTo('/views/admin/dashboard_admin.php');
    }

    public function deleteSpecialite()
    {
        $name = trim($_POST['specialite_name'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] =
                "Nom de spécialité invalide.";
        } else {

            $result = $this->repository->deleteSpécialité($name);

            if ($result) {
                $_SESSION['success'] =
                    "Spécialité supprimée.";
            } else {
                $_SESSION['error'] =
                    "Impossible de supprimer cette spécialité.";
            }
        }

        self::redirectTo('/views/admin/dashboard_admin.php');
    }

    public static function dashboardAction()
    {
        self::redirectTo('/views/admin/dashboard_admin.php');
    }

    public static function tableDoctorsAction()
    {
        self::redirectTo('/views/admin/table_doctors.php');
    }



        private static function basePath()
    {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $suffix = '/src/controller';

        if ($scriptDir === '' || $scriptDir === '/') {
            return '';
        }

        if (str_ends_with($scriptDir, $suffix)) {
            return substr($scriptDir, 0, -strlen($suffix));
        }

        return $scriptDir;
    }

    private static function redirectTo($path)
    {
        $base = rtrim(self::basePath(), '/');
        $target = $base === '' ? $path : $base . $path;

        header('Location: ' . $target);
        exit;
    }
}