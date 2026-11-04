<?php
namespace App\Models;

// Database pertence ao mesmo namespace App\Models.

class User //significa a class que vai ser acessada pala url
{
    public static function all(): array
    {
        return Database::connect() //retorna o registro de busca do BD
            ->query('SELECT * FROM users ORDER BY name') //busca aqui dentro
            ->fetchAll();
    }

    public static function find(int $id): ?array //busca o id 
    {
        $stmt = Database::connect()->prepare(
            'SELECT * FROM users WHERE id = ?' // esperando passar o valor/ entradas de dados
        );
        $stmt->execute([$id]); // aqui o valor é passado
        return $stmt->fetch() ?: null;
    }

    public static function emailExists(string $email): bool
    {
        $stmt = Database::connect()->prepare('SELECT 1 FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return (bool) $stmt->fetchColumn();
    }

    public static function create(string $name, string $email): int // vai receber nome e email
    {
        $stmt = Database::connect()->prepare(
            'INSERT INTO users (name, email) VALUES (?, ?)'
        );
        $stmt->execute([$name, $email]);
        return (int) Database::connect()->lastInsertId();
    }
}
