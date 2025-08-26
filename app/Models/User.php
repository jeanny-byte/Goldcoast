<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Config;
use PDO;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password_hash;
    public string $role;

    public static function findByEmail(string $email): ?array
    {
        $pdo = Config::db();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function countAll(): int
    {
        $pdo = Config::db();
        $cnt = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        return $cnt;
    }

    public static function createAdmin(string $name, string $email, string $password): int
    {
        $pdo = Config::db();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, "admin")');
        $stmt->execute([$name, $email, $hash]);
        return (int)$pdo->lastInsertId();
    }
}
