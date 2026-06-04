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

        require_once "../views/search.php";
    }
}