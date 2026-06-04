<?php
class rendez_vous {
    private string $status;
    private string $createdAt;

    public function __construct($status , $createdAt)
    {
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    // getters
    public function getStatus() : string{
        return $this->status;
    }
    public function getDate() : string{
        return $this->createdAt;
    }
    // settres
    public function setStaus(string $status): void
    {
        $this->status = $status;
    }

    public function setDate(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}