<?php

include_once __DIR__ . "/../../config/DB.php";
include_once __DIR__ . "/BaseRepository.php";

class MedecinRepository extends BaseRepository
{
  
    public static function findById($id)
    {
        $stmt = self::getConnection()->prepare("
            SELECT m.*,
                   u.name,
                   u.email,
                   s.nom AS specialite
            FROM medecins m
            INNER JOIN users u
                ON m.user_id = u.id
            INNER JOIN specialites s
                ON m.specialite_id = s.id
            WHERE m.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function findByUserId($userId)
    {
        $stmt = self::getConnection()->prepare("
            SELECT *
            FROM medecins
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function getDisponibilites($medecinId)
{
    $sql = "
        SELECT *
        FROM disponibilites
        WHERE medecin_id = ?
        ORDER BY date, heure_debut
    ";

    $stmt = self::getConnection()->prepare($sql);
    $stmt->execute([$medecinId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


public static function createDisponibilite(
    $medecinId,
    $date,
    $heureDebut,
    $heureFin
) {
    $sql = "
        INSERT INTO disponibilites
        (
            medecin_id,
            date,
            heure_debut,
            heure_fin,
            disponible
        )
        VALUES (?, ?, ?, ?, 1)
    ";

    $stmt = self::getConnection()->prepare($sql);

    return $stmt->execute([
        $medecinId,
        $date,
        $heureDebut,
        $heureFin
    ]);
}

   

}