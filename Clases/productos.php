<?php
declare(strict_types=1);
require_once __DIR__ . '/include/conexion.php';

class Productos
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = "SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    c.nombre AS categoria,
                    p.precio,
                    p.existencias,
                    p.foto,
                    p.destacado
                FROM productos p
                INNER JOIN categorias c ON p.id_categoria = c.id";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM productos WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function crear(string $nombre,string $descripcion,int $id_categoria, float $precio, int $existencias, string $foto, bool $destacado): int {
        $sql='INSERT INTO productos(nombre,descripcion,id_categoria,precio,existencias,foto,destacado) 
                VALUES (:nombre,:descripcion,:id_categoria,:precio,:existencias,:foto,:destacado)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre'=> $nombre,
            ':descripcion'=> $descripcion,
            ':id_categoria'=> $id_categoria,
            ':precio'=> $precio,
            ':existencias'=> $existencias,
            ':foto'=> $foto,
            ':destacado'=> $destacado
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function actualizar(int $id, float $nuevoPrecio, int $nuevoStock,string $nuevonombre): bool {
        $sql = "UPDATE productos 
                SET precio = :precio, existencias = :stk , nombre= :nombre
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':precio' => $nuevoPrecio,
            ':stk'  => $nuevoStock,
            ':id'   => $id,
            ':nombre' => $nuevonombre

        ]);
    }


}


?>