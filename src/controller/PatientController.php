<?php

class PatientController
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function search()
    {
        $keyword = $_GET['search'] ?? '';

        $medecins = $this->repository->searchDoctors($keyword);

        require_once __DIR__ . "/../../views/patient/search.php";
    }

    public  function ActionDashbaordPatient()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('Location: index.php?action=login');
            exit;
        }

        $patient = $this->repository->getByUserId((int) $userId);
        $patientId = (int) ($patient['id'] ?? 0);

        $appointments = $patientId > 0
            ? $this->repository->getAppointments($patientId)
            : [];

        require_once __DIR__ . "/../../views/patient/dashboard.php";
    }

    
}