<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/include/conexion.php';
require_once __DIR__ . '/Clases/usuarios.php';

$conexionBD = new ConexionBD();
$pdo = $conexionBD->conectar();

if ($pdo === null) {
    die("No se pudo establecer la conexión con la base de datos.");
}

$usuarioModel = new Usuarios($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'login') {

    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($correo) || empty($password)) {
        $mensajeError = "Por favor complete todos los campos obligatorios con valores positivos válidos.";
    } else {
        $usuario = $usuarioModel->obtenerUsuariosPorCorreo($correo);


        if ($usuario && $password === $usuario['password']) {

            session_regenerate_id(true);
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['rol'] = (int) $usuario['id_rol'];
            $_SESSION['nombre_rol'] = $usuario['rol'];


            header('Location: index.php');
            exit;

        } else {
            $mensajeError = "Correo o contraseña incorrectos.";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AutoPartes y Repuestos Don Pancho | Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css?v=2">
</head>

<body>
    <?php require_once __DIR__ . '/include/navbar.php'; ?>

    <?php if (!empty($mensajeError)): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 shadow-sm" role="alert">

            <i class="bi bi-exclamation-circle-fill"></i>

            <div>
                <?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?>
            </div>

        </div>
    <?php endif; ?>


    <section class="login-page">

        <div class="login-card">

            <h2>Inicio de Sesión</h2>
            <p>Autopartes y Repuestos Don Pancho</p>

            <form action="login.php" method="POST">

                <input type="hidden" name="accion" value="login">

                <div class="mb-3">
                    <label for="correo" class="form-label">
                        Correo electrónico
                    </label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Contraseña
                    </label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Iniciar sesión
                </button>
            </form>

        </div>

    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>