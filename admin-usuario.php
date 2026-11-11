<?php
session_start();
require "conexion.php";
require "escapar.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION["usuario_rol"] !== "admin") {
    header("Location: panel.php");
    exit;
}

$buscar = trim($_GET['buscar'] ?? '');
$sql = 'SELECT id, nombre,  dni, correo, rol, fecha_creacion, fecha_archivado FROM usuarios WHERE fecha_archivado IS NULL';
$parametros = [];

if ($buscar !== '') {
    $sql .= ' AND (nombre LIKE :nombre  OR dni LIKE :dni OR correo LIKE :correo)';
    $termino = '%' . $buscar . '%';
    $parametros = [
        ':nombre' => $termino,
        ':dni' => $termino,
        ':correo' => $termino,
    ];
}

$stmt = $conexionbd->prepare($sql);
$stmt->execute($parametros);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administración de Usuarios</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand mb-0 h1">Administrar Usuarios</span>
    <div class="container">
        <a href="panel.php" class="btn btn-light btn-sm">Volver al panel</a>
        <a href="logout.php" class="btn btn-light btn-sm">Salir</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Usuarios </h5>

            <form method="GET" action="admin_usuario.php" class="row g-2 mb-3">
                
                <div class="col-md-2">
                    <a href="usuarios_archivados.php" class="btn btn-outline-info w-100"> Ver archivados</a>
                </div>
                <div class="col-md-2">
                    <a href="crear-usuario.php" class="btn btn-success w-100">Nuevo</a>
                </div>
            </form>

            <?php if (empty($usuarios)): ?>
                <div class="alert alert-info">No se encontraron usuarios activos.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Creado en</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo escapar((string)$usuario['id']); ?></td>
                                <td><?php echo escapar($usuario['nombre']); ?></td>
                                <td><?php echo escapar($usuario['dni']); ?></td>
                                <td><?php echo escapar($usuario['correo']); ?></td>
                                <td><?php echo escapar($usuario['rol']); ?></td>
                                <td><?php echo escapar($usuario['fecha_creacion']); ?></td>
                                <td>
                                    <?php if ($usuario['nombre'] !== $_SESSION['usuario']): ?>
                                    <a href="archivar_usuario.php?id=<?php echo (int)$usuario['id']; ?>" class="btn btn-sm btn-danger" >Archivar</a>
                                <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
