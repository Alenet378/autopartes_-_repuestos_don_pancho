<?php
declare(strict_types=1);
require_once __DIR__ . '/../include/conexion.php';


class MarcasVehiculares
{

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function listarMarcas(): array {
        $sql = "SELECT id, nombre, logo FROM marcas_vehiculos";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>