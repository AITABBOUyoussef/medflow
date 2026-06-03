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

        $doctors = [];

        if (!empty($keyword)) {
            $doctors = $this->repository->searchDoctor($keyword);
        }

        require_once "../views/search.php";
    }
}