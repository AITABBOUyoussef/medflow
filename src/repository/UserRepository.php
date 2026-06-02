<?php
include_once __DIR__ . "/../../config/DB.php";
class UserRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

public  function register($name, $email, $password, $birthDate)
{
    $stmt = $this->pdo->prepare("SELECT id FROM roles WHERE label = 'PATIENT'");
    $stmt->execute();

    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    $roleId = $role['id'];

    $stmt = $this->pdo->prepare("
        INSERT INTO users(name, email, password, role_id)
        VALUES(?, ?, ?, ?)
    ");

    $stmt->execute([
        $name,
        $email,
        password_hash($password, PASSWORD_BCRYPT),
        $roleId
    ]);

    $userId = $this->pdo->lastInsertId();

    $stmt = $this->pdo->prepare("
        INSERT INTO patients(user_id, birth_date)
        VALUES(?, ?)
    ");

    $stmt->execute([
        $userId,
        $birthDate
    ]);

    return $userId;
}

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
