<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/include/conexion.php';
require_once __DIR__ . '/Clases/productos.php';
require_once __DIR__ . '/Clases/marcasVehiculares.php';

$conexionBD = new ConexionBD();
$pdo = $conexionBD->conectar();
$productos = [];
$marcasVehiculares = [];

if ($pdo === null) {
    die("No se pudo establecer la conexión con la base de datos.");
}

if ($pdo !== null) {
    $repo = new Productos($pdo);
    $productos = $repo->listarDestacados();
    $car = new MarcasVehiculares($pdo);
    $marcasVehiculares = $car->listarMarcas();

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

<body class="fondo2">
    <?php require_once __DIR__ . '/include/navbar.php'; ?>

    <header class="container-fluid py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-12 col-lg-7">

                    <span class="badge rounded-pill px-3 py-2 mb-3 bg-danger text-light">
                        <i class="bi bi-geo-alt-fill"></i> Honduras
                    </span>

                    <h1 class="display-4 fw-bold mb-3">
                        AutoPartes y Repuestos Don Pancho
                    </h1>

                    <h2 class="h3 text-danger fw-semibold mb-3">
                        Expertos en Repuestos Genuinos y Compatibles
                    </h2>

                    <p class="lead text-secondary mb-4">
                        Encuentra repuestos y accesorios para tu vehículo
                        con calidad, variedad y precios competitivos.
                        Estamos comprometidos con ofrecer soluciones
                        confiables para el mantenimiento de tu automóvil.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="catalogo.php" class="btn btn-danger btn-lg">
                            Explorar catálogo
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <a href="sucursales.php" class="btn btn-outline-dark btn-lg">
                            Nuestras sucursales
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <img src="uploads/logo1.jpg" class="img-fluid rounded-4 shadow"
                        alt="Repuestos automotrices Don Pancho">
                </div>
            </div>
        </div>
    </header>

    <section id="destacados" class="container-fliud rounded-4 py-5 px-3 mt-3 bg-light">
        <div>
            <div class="text-center mb-5">
                <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold text-dark">Repuestos Destacados</span>
                <h2 class="display-6 fw-bold mt-2 text-black">Nuestros Repuestos Insignia</h2>
                <p class="text-danger">Expertos en Repuestos Genuinos y Compatibles</p>
            </div>

            <div class="row g-3 rounded-4 py-4 px-4 justify-content-center bg-dark">
                <?php foreach ($productos as $producto): ?>
                    <div class=" col-12 col-md-6 col-lg-4  ">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white ">
                            <img class="card-img-top" style="height: 220px; object-fit: contain"
                                src="uploads/<?= htmlspecialchars($producto['foto']) ?>"
                                alt="<?= htmlspecialchars($producto['descripcion']) ?>">
                            <div class="card-body d-flex flex-column p-4 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill px-2.5 py-1.5"></span>
                                    <span></span>
                                </div>
                                <h4 class="card-title text-danger fw-bold mb-2"><?= htmlspecialchars($producto['nombre']) ?>
                                </h4>
                                <p class="card-text text-secondary small flex-grow-1">
                                    <?= htmlspecialchars($producto['descripcion']) ?>
                                </p>
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-danger">Precio</span>
                                        <span
                                            class="fs-5 fw-bold text-black">L.<?= htmlspecialchars($producto['precio']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="marcas-vehiculares" class="container  rounded-4 py-5 px-3 bg-dark">
        <div class="bg-light rounded-4 mb-3 mx-3 pb-3">
            <div class="text-center roundend-4 mb-3">
                <span class="badge rounded-pill text-uppercase fw-bold text-dark">Marcas Afiliadas</span>
                <h2 class="display-6 fw-bold mt-2 text-black">Marcas Vehiculares Aliadas</h2>
                <p class="text-danger">Expertos en Repuestos Genuinos y Compatibles</p>
            </div>
        </div>

        <div class="row mt-3 mb-3 px-3 mx-3 rounded-4  bg-light">
            <?php foreach ($marcasVehiculares as $marca): ?>
                <div class=" mt-3 col-6 col-md-4 col-lg-2 text-center">
                    <img src="uploads/logo-marcas/<?= htmlspecialchars($marca['logo']) ?>"
                        alt="<?= htmlspecialchars($marca['nombre']) ?>" class="img-fluid"
                        style="height: 80px; object-fit: contain;">
                    <p class="fw-semibold mt-2">
                        <?= htmlspecialchars(ucfirst($marca['nombre'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
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
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047-.1-.166-.276-.276a2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-2.388-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
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