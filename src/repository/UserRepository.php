<?php
include_once __DIR__ . "/../../config/DB.php";
include_once __DIR__ . "/BaseRepository.php";
class UserRepository extends BaseRepository
{
   
    public static function register($name, $email, $password, $birthDate)
    {
        $stmt = self::getConnection()->prepare("SELECT id FROM roles WHERE label = 'PATIENT'");
        $stmt->execute();

        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        $roleId = $role['id'];

        $stmt = self::getConnection()->prepare("
        INSERT INTO users(name, email, password, role_id)
        VALUES(?, ?, ?, ?)
    ");

        $stmt->execute([
            $name,
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            $roleId
        ]);

        $userId = self::getConnection()->lastInsertId();

        $stmt = self::getConnection()->prepare("
        INSERT INTO patients(user_id, birth_date)
        VALUES(?, ?)
    ");

        $stmt->execute([
            $userId,
            $birthDate
        ]);

        return $userId;
    }

    public static function findByEmail($email)
    {
        $stmt = self::getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function login($email, $password)
    {
        $stmt = self::getConnection()->prepare("
        SELECT
            users.*,
            roles.label AS role
        FROM users
        INNER JOIN roles
            ON users.role_id = roles.id
        WHERE users.email = ?
    ");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        return $user;
    }
}
