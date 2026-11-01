<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/include/conexion.php';
require_once __DIR__ . '/Clases/productos.php';


$rol = $_SESSION['rol'] ?? null;

if ($rol != 1 && $rol != 2) {
    header('Location: index.php');
    exit;
}


$conexionBD = new ConexionBD();
$pdo = $conexionBD->conectar();

if ($pdo === null) {
    die("No se pudo establecer la conexión con la base de datos.");
}

if ($pdo !== null) {
    $repo = new Productos($pdo);
    $productos = $repo->listar();
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['action'] ?? '';
    if ($accion === 'eliminar') {
        $repo->eliminar((int) $_POST['id']);
        header("Location: panel.php");
        exit;
    }
    if ($accion === 'crear') {
    $repo->crear(
        (string) $_POST['nombre'],
        (string) $_POST['descripcion'],
        (int) $_POST['id_categoria'],
        (float) $_POST['precio'],
        (int) $_POST['existencias'],
        (string) ($_POST['foto'] ?? ''),
        isset($_POST['destacado'])
    );

    header('Location: panel.php');
    exit;
}

    if ($accion === 'actualizar') {
        $id = (int) ($_POST['id'] ?? 0);
        $precio = (float) ($_POST['precio'] ?? 0.0);
        $stock = (int) ($_POST['existencias'] ?? 0);
        $nombre = trim((string) ($_POST['nombre'] ?? ''));
        $repo->actualizar($id, $precio, $stock, $nombre);
        header("Location: panel.php");
        exit;
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

<body >
    <?php require_once __DIR__ . '/include/navbar.php'; ?>


    <div class="text-center mt-4">
        <h1 class="fw-bold">Tabla de Inventario</h1>
        <p class="text-muted">
            Tabla con el inventario de productos disponibles en el sistema
        </p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th>Editar Producto</th>
                    <th>Eliminar Producto</th>
                </tr>
            </thead>
            <?php
        if (empty($productos)): ?>
            <tr>
                <td>No hay productos en la tabla </td>
            </tr>
        <?php else: ?>
            <?php foreach ($productos as $pro): ?>
                <tr>
                    <td><?= $pro["nombre"] ?></td>
                    <td><?= $pro["categoria"] ?></td>
                    <td><?= $pro["precio"] ?></td>
                    <td><?= $pro["existencias"] ?></td>
                    <td><button type="button" class="btn-editar" data-id="<?= $pro['id'] ?>" data-nombre="<?= $pro['nombre'] ?>"
                            data-precio="<?= $pro['precio'] ?>" data-stock="<?= $pro['existencias'] ?>">Editar
                        </button>
                    </td>
                   <td>
                        <form method="POST" action="panel.php"
                            onsubmit="return confirm('Desea eliminar el producto');">
                            <input type="hidden" name="action" value="eliminar">
                            <input type="hidden" name="id" value="<?= $pro["id"] ?>">
                            <button type="submit">Borrar una fila de la tabla</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
        </table>
        <button type="button" id="btn-crear">Agregar nuevo producto</button>
    </div>
    
    
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="panel.php" method="POST">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Registrar producto</h5>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="crear">

                    <div class="mb-3">
                        <label for="crearNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control"
                            id="crearNombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="crearDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="crearDescripcion"
                            name="descripcion" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="crearCategoria" class="form-label">ID de categoría</label>
                        <input type="number" class="form-control"
                            id="crearCategoria" name="id_categoria" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="crearPrecio" class="form-label">Precio</label>
                        <input type="number" class="form-control"
                            id="crearPrecio" name="precio" min="0.01"
                            step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="crearExistencias" class="form-label">Existencias</label>
                        <input type="number" class="form-control"
                            id="crearExistencias" name="existencias"
                            min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="crearFoto" class="form-label">Nombre del archivo de foto</label>
                        <input type="text" class="form-control"
                            id="crearFoto" name="foto"
                            placeholder="Ejemplo: bujia.jpg">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="crearDestacado" name="destacado" value="1">
                        <label class="form-check-label" for="crearDestacado">
                            Producto destacado
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        Guardar producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="panel.php" method="POST">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar producto</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="actualizar">
                    <input type="hidden" name="id" id="editarId">

                    <div class="mb-3">
                        <label for="editarNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control"
                            name="nombre" id="editarNombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="editarPrecio" class="form-label">Precio</label>
                        <input type="number" class="form-control"
                            name="precio" id="editarPrecio"
                            min="0.01" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="editarStock" class="form-label">Existencias</label>
                        <input type="number" class="form-control"
                            name="existencias" id="editarStock"
                            min="0" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="panel.php" method="POST">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="eliminar">
                    <input type="hidden" name="id" id="eliminarId">

                    <p class="mb-0">
                        ¿Estás seguro de que deseas eliminar el producto
                        <strong id="eliminarNombre"></strong>?
                    </p>
                    <p class="text-danger small mt-2 mb-0">
                        Esta acción no se puede deshacer.
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        Sí, eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>

<script>

const modalCrear = new bootstrap.Modal(
    document.getElementById('modalCrear')
);

const modalEditar = new bootstrap.Modal(
    document.getElementById('modalEditar')
);

const modalEliminar = new bootstrap.Modal(
    document.getElementById('modalEliminar')
);

document.getElementById('btn-crear').addEventListener('click', () => {
    document.getElementById('crearNombre').value = '';
    document.getElementById('crearDescripcion').value = '';
    document.getElementById('crearCategoria').value = '';
    document.getElementById('crearPrecio').value = '';
    document.getElementById('crearExistencias').value = '';
    document.getElementById('crearFoto').value = '';
    document.getElementById('crearDestacado').checked = false;

    modalCrear.show();
});

document.querySelectorAll('.btn-editar').forEach(boton => {
    boton.addEventListener('click', () => {
        document.getElementById('editarId').value = boton.dataset.id;
        document.getElementById('editarNombre').value = boton.dataset.nombre;
        document.getElementById('editarPrecio').value = boton.dataset.precio;
        document.getElementById('editarStock').value = boton.dataset.stock;

        modalEditar.show();
    });
});

document.querySelectorAll('.btn-eliminar').forEach(boton => {
    boton.addEventListener('click', () => {
        document.getElementById('eliminarId').value = boton.dataset.id;
        document.getElementById('eliminarNombre').textContent =
            boton.dataset.nombre;

        modalEliminar.show();
    });
});

</script>