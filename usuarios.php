<?php
    declare(strict_types=1);
    require_once __DIR__ . '/include/conexion.php';

    class Usuarios {

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function listarUsuarios() : array {
        $sql = "SELECT
                    u.id,
                    u.username,
                    r.rol as rol,
                    u.correo
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarUsuarios(int $id): bool{
        $sql = "DELETE FROM usuarios WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function crearUsuario(string $username, int $id_rol, string $correo, string $password): int {
        $sql = 'INSERT INTO usuarios(username,id_rol,correo,password)
                    VALUES (:username,:id_rol,:correo,:password)';
        $stmt = $this->pdo->prepare($sql); 
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); 
        $stmt-> execute([
            ':username'=> $username,
            ':id_rol'=> $id_rol,
            ':correo' => $correo,
            ':password'=> $password
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    




    }
?>