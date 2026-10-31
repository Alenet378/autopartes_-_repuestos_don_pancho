<?php





?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AutoPartes y Repuestos Don Pancho | Pagina de Inicio </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
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
                <img src="uploads/logo1.jpg" class="img-fluid rounded-4 shadow" alt="Repuestos automotrices Don Pancho">
            </div>
        </div>
    </div>
</header>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>