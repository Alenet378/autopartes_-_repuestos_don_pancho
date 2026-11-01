<?php

declare(strict_types=1);
require_once __DIR__ . '/../include/conexion.php';


class Factura
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = 'SELECT 
                    id,
                    numero_factura,
                    fecha,
                    nombre_cliente,
                    rtn,
                    telefono,
                    direccion_envio,
                    modalidad_envio,
                    sub_total,
                    descuento,
                    isv,
                    costo_envio,
                    total
                    FROM facturas';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $factura, array $detalles): int
    {
        try {
            $this->pdo->beginTransaction();

            $sql = 'INSERT INTO facturas (
                    numero_factura,
                    fecha,
                    nombre_cliente,
                    rtn,
                    telefono,
                    direccion_envio,
                    modalidad_envio,
                    sub_total,
                    descuento,
                    isv,
                    costo_envio,
                    total
                )
                VALUES (
                    :numero_factura,
                    :fecha,
                    :nombre_cliente,
                    :rtn,
                    :telefono,
                    :direccion_envio,
                    :modalidad_envio,
                    :sub_total,
                    :descuento,
                    :isv,
                    :costo_envio,
                    :total
                )';

            $stmt = $this->pdo->prepare($sql);

            $factura['numero_factura'] = 'PENDIENTE';

            $stmt->execute($factura);

            $idFactura = (int) $this->pdo->lastInsertId();

            $numeroFactura = 'FAC-DP-' . str_pad(
                (string) $idFactura,
                6,
                '0',
                STR_PAD_LEFT
            );

            $sqlActualizar = 'UPDATE facturas
                          SET numero_factura = :numero
                          WHERE id = :id';

            $stmtActualizar = $this->pdo->prepare($sqlActualizar);

            $stmtActualizar->execute([
                ':numero' => $numeroFactura,
                ':id' => $idFactura
            ]);

            $sqlDetalle = 'INSERT INTO detalle_factura (
                            id_factura,
                            id_producto,
                            descripcion,
                            cantidad,
                            precio_unitario,
                            subtotal
                       )
                       VALUES (
                            :id_factura,
                            :id_producto,
                            :descripcion,
                            :cantidad,
                            :precio_unitario,
                            :subtotal
                       )';

            $stmtDetalle = $this->pdo->prepare($sqlDetalle);

            foreach ($detalles as $item) {
                $stmtDetalle->execute([
                    ':id_factura' => $idFactura,
                    ':id_producto' => $item['id'],
                    ':descripcion' => $item['nombre'],
                    ':cantidad' => $item['cantidad'],
                    ':precio_unitario' => $item['precio'],
                    ':subtotal' => $item['subtotal']
                ]);
            }

            $this->pdo->commit();

            return $idFactura;

        } catch (PDOException $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }
}

?>