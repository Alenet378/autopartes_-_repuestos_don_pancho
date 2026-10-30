<?php
require_once "conexion.php";

$conexion = new ConexionBD();
$pdo = $conexion->conectar();

if ($pdo !== null) {
    echo "¡Conexión exitosa!";
} else {
    echo "No se pudo establecer la conexión.";
}
?>