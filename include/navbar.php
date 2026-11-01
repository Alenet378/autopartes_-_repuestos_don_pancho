
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="index.php">
            Don Pancho
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContenido"
                aria-controls="navbarContenido"
                aria-expanded="false"
                aria-label="Mostrar navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContenido">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a class="nav-link text-warning" href="index.php">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-warning" href="catalogo.php">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="kit.php">Arma tu Kit-Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="facturacion.php">Formulario de Pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="sucursales.php">Sucursales</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">

                <?php if (isset($_SESSION['id_usuario'])): ?>

                    <span class="text-white">
                        <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <span class="badge text-bg-danger">
                        <?= $_SESSION['rol'] === 'admin' ? 'Admin' : 'Bodega' ?>
                    </span>

                    <a href="logout.php" class="btn btn-outline-light btn-sm">
                        Cerrar Sesión
                    </a>

                <?php else: ?>

                    <a href="login.php" class="btn btn-danger btn-sm">
                        Iniciar Sesión
                    </a>

                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>
