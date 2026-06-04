<?php

include_once __DIR__ . "/../../config/DB.php";
include_once __DIR__ . "/BaseRepository.php";

class OrdonnanceRepository extends BaseRepository
{
  

    public static function create($rendezVousId, $contenu)
    {
        $stmt = self::getConnection()->prepare("
            INSERT INTO ordonnances
            (rendez_vous_id, contenu)
            VALUES (?, ?)
        ");

        return $stmt->execute([
            $rendezVousId,
            $contenu
        ]);
    }
}