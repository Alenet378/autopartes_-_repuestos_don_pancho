<?php
declare(strict_types=1);
require_once __DIR__ . '/../include/conexion.php';

class KitBase{


private PDO $pdo;
public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function listar(): array
{
    $sql = "SELECT
                k.id,
                v.tipo AS tipo_vehiculo,
                a.nombre AS marca_aceite,
                m.nombre AS marca_vehiculo,
                k.viscosidad_aceite,
                k.precio
            FROM kit_base k
            INNER JOIN tipos_vehiculos v
                ON k.id_tipo_vehiculo = v.id
            INNER JOIN marcas_aceite a
                ON k.id_marca_aceite = a.id
            INNER JOIN marcas_vehiculos m
                ON k.id_marca_vehiculo = m.id";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}






?>