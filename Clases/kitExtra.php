<?php
declare(strict_types=1);
require_once __DIR__ . '/../include/conexion.php';

class KitExtras
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
                    grupo,
                    costo
                FROM kit_extras";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}