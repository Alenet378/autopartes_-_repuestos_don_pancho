<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/include/conexion.php';
require_once __DIR__ . '/Clases/productos.php';
require_once __DIR__ . '/Clases/factura.php';

$conexionBD = new ConexionBD();
$pdo = $conexionBD->conectar();

if ($pdo === null) {
    die("No se pudo establecer la conexión con la base de datos.");
}

$factura = new Factura($pdo);
$producto = new Productos($pdo);
$productos = $producto->listar();
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['facturar'])) {

    $nombre = trim($_POST['nombre_cliente'] ?? '');
    $rtn = trim($_POST['rtn'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion_envio'] ?? '');
    $modalidad = $_POST['modalidad_envio'] ?? '';
    $seleccion = $_POST['productos'] ?? [];

    if ($nombre === '') {
        $errores[] = "El nombre del cliente es obligatorio.";
    }


    if (!preg_match('/^[0-9]{14}$/', $rtn)) {
        $errores[] = "El RTN debe contener exactamente 14 dígitos.";
    }


    if (!preg_match('/^[0-9]{8}$/', $telefono)) {
        $errores[] = "El teléfono debe contener exactamente 8 dígitos.";
    }

    if ($direccion === '') {
        $errores[] = "La dirección es obligatoria.";
    }

    $modalidadesValidas = [
        'Mostrador',
        'Moto express',
        'Flete en camioncito'
    ];

    if (!in_array($modalidad, $modalidadesValidas, true)) {
        $errores[] = "Seleccione una modalidad de envío válida.";
    }

    if (!is_array($seleccion) || empty($seleccion)) {
        $errores[] = "Debe seleccionar al menos un producto.";
    } else {

        $hayProductos = false;

        foreach ($seleccion as $id => $cantidad) {

            if (
                !ctype_digit((string) $id) ||
                !ctype_digit((string) $cantidad)
            ) {
                $errores[] = "Se recibió una cantidad o producto inválido.";
                break;
            }

            $cantidad = (int) $cantidad;

            if ($cantidad < 0) {
                $errores[] = "Las cantidades no pueden ser negativas.";
                break;
            }

            if ($cantidad > 0) {
                $hayProductos = true;
            }
        }
        if (!$hayProductos) {
            $errores[] = "Debe seleccionar al menos un producto.";
        }
    }

    $productosFactura = [];

    if (empty($errores)) {

        $sql = "SELECT id, nombre, precio, existencias
            FROM productos
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        foreach ($seleccion as $id => $cantidad) {

            $cantidad = (int) $cantidad;

            if ($cantidad === 0) {
                continue;
            }

            $stmt->execute(['id' => (int) $id]);

            $productoBD = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$productoBD) {
                $errores[] = "Uno de los productos seleccionados no existe.";
                break;
            }

            if ($cantidad > (int) $productoBD['existencias']) {
                $errores[] = "No hay suficientes existencias de "
                    . $productoBD['nombre'] . ".";
                break;
            }
            $productosFactura[] = [
                'id' => (int) $productoBD['id'],
                'nombre' => $productoBD['nombre'],
                'precio' => (float) $productoBD['precio'],
                'cantidad' => $cantidad,
                'subtotal' => (float) $productoBD['precio'] * $cantidad
            ];
        }
    }

    $subtotal = 0;
    $cantidadTotal = 0;

    foreach ($productosFactura as $item) {
        $subtotal += $item['subtotal'];
        $cantidadTotal += $item['cantidad'];
    }
    $descuento = 0;

    if ($cantidadTotal >= 10) {
        $descuento = $subtotal * 0.10;
    }

    $baseImponible = $subtotal - $descuento;

    $isv = $baseImponible * 0.15;

    switch ($modalidad) {
        case 'Mostrador':
            $costoEnvio = 0;
            break;

        case 'Moto express':
            $costoEnvio = 50;
            break;

        case 'Flete en camioncito':
            $costoEnvio = 180;
            break;

        default:
            $costoEnvio = 0;
    }

    $total = $baseImponible + $isv + $costoEnvio;

    $datosFactura = [
        'numero_factura' => $numeroFactura,
        'fecha' => date('Y-m-d H:i:s'),
        'nombre_cliente' => $nombre,
        'rtn' => $rtn,
        'telefono' => $telefono,
        'direccion_envio' => $direccion,
        'modalidad_envio' => $modalidad,
        'sub_total' => round($subtotal, 2),
        'descuento' => round($descuento, 2),
        'isv' => round($isv, 2),
        'costo_envio' => round($costoEnvio, 2),
        'total' => round($total, 2)
    ];

    try {
        if (empty($errores)) {

            $idFactura = $factura->crear(
                $datosFactura,
                $productosFactura
            );

            $numeroFactura = 'FAC-DP-' . str_pad(
                (string) $idFactura,
                6,
                '0',
                STR_PAD_LEFT
            );
        }

    } catch (PDOException $e) {
        $errores[] = "Ocurrió un error al registrar la factura.";
    }


}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AutoPartes y Repuestos Don Pancho | Pagina de Inicio </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/estilos.css?v=2">
</head>

<body>
    <?php require_once __DIR__ . '/include/navbar.php'; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <strong>Se encontraron los siguientes errores:</strong>

            <ul class="mb-0 mt-2">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div>
        <form action="" method="POST">

            <div class="card shadow-sm mb-4 mt-3">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Datos del cliente</h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre_cliente" class="form-label text-white">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                                maxlength="255" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rtn" class="form-label text-white">RTN</label>
                            <input type="text" class="form-control" id="rtn" name="rtn" maxlength="14" minlength="14"
                                pattern="[0-9]{14}" placeholder="00000000000000" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label text-white">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="8"
                                minlength="8" pattern="[0-9]{8}" placeholder="00000000" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion_envio" class="form-label text-white">Dirección</label>
                            <input type="text" class="form-control" id="direccion_envio" name="direccion_envio"
                                maxlength="255" placeholder="Ingrese su dirección" required>
                        </div>

                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th style="width: 150px;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombre']) ?></td>
                                <td>L. <?= number_format((float) $item['precio'], 2) ?></td>
                                <td><?= (int) $item['existencias'] ?></td>
                                <td><input type="number" class="form-control" name="productos[<?= (int) $item['id'] ?>]"
                                        min="0" max="<?= (int) $item['existencias'] ?>" value="0"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Modalidad de envío</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="modalidad_envio" id="mostrador"
                            value="Mostrador" required>
                        <label class="form-check-label text-white" for="mostrador">
                            Retiro en mostrador
                            <span class="text-white">— L. 0.00</span>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="modalidad_envio" id="moto"
                            value="Moto express">
                        <label class="form-check-label text-white" for="moto">Moto express
                            <span class="text-white">— L. 50.00</span>
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="modalidad_envio" id="camioncito"
                            value="Flete en camioncito">

                        <label class="form-check-label text-white" for="camioncito">
                            Flete en camioncito
                            <span class="text-white">— L. 180.00</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-center mb-4">
                <button type="submit" name="facturar" class="btn btn-danger btn-lg px-5">Generar factura</button>
            </div>


        </form>
    </div>

    <footer class="py-5 mt-3 border-top bg-dark text-white">
        <div class="container">
            <div class="row g-4">

                <div class="col-12 col-md-4">
                    <h5><i class="bi bi-water"></i> AutoPartes y Repuestos Don Pancho</h5>
                    <p>
                        Encuentra repuestos y accesorios para tu vehículo
                        con calidad, variedad y precios competitivos.
                        Estamos comprometidos con ofrecer soluciones
                        confiables para el mantenimiento de tu automóvil.
                    </p>
                </div>

                <div class="col-12 col-md-4">
                    <h6 text-uppercase>Horarios de Atencion</h6>
                    <ul>
                        <li><i></i> Lunes a Viernes: 08:00 a.m. - 5:00 p.m.</li>
                        <li><i></i> Sábados: 09:00 a.m. - 03:00 p.m.</li>
                    </ul>
                </div>


                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase">Nos puedes encontrar</h6>

                    <div class="d-flex flex-column align-items-start gap-2">

                        <a class="d-flex align-items-center gap-2 text-decoration-none"
                            href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047-.1-.166-.276-.276a2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-2.388-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                            Instagram
                        </a>

                        <a class="d-flex align-items-center gap-2 text-decoration-none" href="https://x.com/"
                            target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-twitter-x" viewBox="0 0 16 16">
                                <path
                                    d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                            </svg>
                            X (Twitter)
                        </a>

                        <a class="d-flex align-items-center gap-2 text-decoration-none" href="https://www.facebook.com/"
                            target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-facebook" viewBox="0 0 16 16">
                                <path
                                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                            </svg>
                            Facebook
                        </a>

                    </div>
                </div>

            </div>

            <div>
                &copy; 2026 AutoPartes y Repuestos Don Pancho
            </div>
        </div>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>