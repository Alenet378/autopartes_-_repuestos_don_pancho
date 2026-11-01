<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/include/conexion.php';
require_once __DIR__ . '/Clases/factura.php';


$conexionBD = new ConexionBD();
$pdo = $conexionBD->conectar();

if ($pdo === null) {
    die("No se pudo establecer la conexión con la base de datos.");
}

$factura = new Factura($pdo);
$facturas = $factura->listar();


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AutoPartes y Repuestos Don Pancho | Sucursales </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/estilos.css?v=2">
</head>

<body>
    <?php require_once __DIR__ . '/include/navbar.php'; ?>

    <section id="sucursales" class="py-5 bg-light">
        <div class="container py-lg-4">
            <div class="text-center mb-5">
                <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold text-dark bg-light"></span>
                <h2 class="display-6 fw-bold mt-2">Sucursales</h2>
                <p class="text-muted text-dark">Nuestras sucursales están ubicadas en las principales ciudades de
                    Honduras para brindarte el mejor servicio</p>
            </div>
            <div class="row g-4">
                <div class="col">
                    <div class="card h-100 border-dark bg-dark">
                        <img src="https://d3fphkxyf5o5bm.cloudfront.net/image-resize/format=webp,w=1200/QwRY54Li1HMwD7oNfogFJiQdGKsVfRcivsk8Ngn6Af"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-light">Tegucigalpa</h4>
                            <p class="card-text text-light">Ubicados en el Boulevard Suyapa, Calle
                                Principal</p>
                            <p class="card-text text-light">Tel. 2223-0000</p>
                            <p class="card-text text-light">Horario de Atención: 10.00 a.m. 8:00 p.m.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-dark bg-dark">
                        <img src="https://d9zuehkdkxba0.cloudfront.net/wp-content/uploads/2019/05/semaforo-aeropuerto-toncontin-2.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-light">Tegucigalpa</h4>
                            <p class="card-text text-light">Ubicados en el Barrio Toncontin, Calle
                                Principal, Enfrente del Aeropuerto</p>
                            <p class="card-text text-light">Tel. 2221-0000</p>
                            <p class="card-text text-light">Horario de Atención: 10.00 a.m. 8:00 p.m.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-dark bg-dark">
                        <img src="https://www.laprensa.hn/binrepository/960x640/1c138/960d503/none/11004/DSMX/imagen-mv-guamilito-08092022-6_2430664_20220912180606.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-light">San Pedro Sula</h4>
                            <p class="card-text text-light">Ubicados en Barrio Medina, Calle Principal</p>
                            <p class="card-text text-light">Tel. 2224-0000</p>
                            <p class="card-text text-light">Horario de Atención: 10.00 a.m. 8:00 p.m.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-dark bg-dark">
                        <img src="https://www.honduras.com/wp-content/uploads/2020/07/la-ceiba-la-tribuna.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-light">La Ceiba</h4>
                            <p class="card-text text-light">Ubicados en la CA-13</p>
                            <p class="card-text text-light">Tel. 2225-0000</p>
                            <p class="card-text text-light">Horario de Atención: 10.00 a.m. 8:00 p.m.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <br>

    <section id="reportes" class="py-5 bg-light">
        <div class="container pb-5">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow-sm border-0 bg-light">

                        <div
                            class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 bg-light">
                            <h5 class="mb-0 text-secondary">
                                Historial de Facturas Registradas
                                <span class="badge bg-primary ms-2">
                                    <?= count($facturas) ?>
                                </span>
                            </h5>
                        </div>

                        <div class="card-body p-0">
                            <?php if (!empty($facturas)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0 table-light">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center"># Factura</th>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">RTN</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Modalidad de envío</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($facturas as $item): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-danger">
                                                            <?= htmlspecialchars($item['numero_factura']) ?>
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        <strong>
                                                            <?= htmlspecialchars($item['nombre_cliente']) ?>
                                                        </strong>
                                                    </td>

                                                    <td class="text-center">
                                                        <code><?= htmlspecialchars($item['rtn']) ?></code>
                                                    </td>

                                                    <td class="text-center">
                                                        <?= htmlspecialchars($item['fecha']) ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <?= htmlspecialchars($item['modalidad_envio']) ?>
                                                    </td>

                                                    <td class="text-end fw-bold text-danger">
                                                        L. <?= number_format((float) $item['total'], 2) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            <?php else: ?>
                                <div class="p-4 text-center text-muted">
                                    <p class="mb-0">Aún no se han registrado facturas.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>



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