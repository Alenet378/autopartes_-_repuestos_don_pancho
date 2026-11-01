<?php
declare(strict_types=1);
require_once __DIR__ . '/../include/conexion.php';
class Filtros
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = "SELECT
                    id,
                    nombre,
                    descripcion,
                    precio,
                    existencias
                FROM filtros";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}