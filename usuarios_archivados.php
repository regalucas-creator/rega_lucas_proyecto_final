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

$stmt = $conexionbd->prepare('SELECT id, nombre,  dni, correo, fecha_archivado FROM usuarios WHERE fecha_archivado IS NOT NULL ORDER BY fecha_archivado DESC');
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios archivados</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Archivados</h5>
            <a href="admin-usuario.php" class="btn btn-primary mb-3">Volver </a>

            <?php if (empty($usuarios)): ?>
                <div class="alert alert-info">No hay usuarios archivados.</div>
            <?php else: ?>
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            
                            <th>DNI</th>
                            <th>Correo</th>
                            <th>Archivado en</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo escapar((string)$usuario['id']); ?></td>
                            <td><?php echo escapar($usuario['nombre']); ?></td>
                            <td><?php echo escapar($usuario['dni']); ?></td>
                            <td><?php echo escapar($usuario['correo']); ?></td>
                            <td><?php echo escapar($usuario['fecha_archivado']); ?></td>
                            <td>
                                <a href="reactivar_usuarios.php?id=<?php echo (int)$usuario['id']; ?>" class="btn btn-sm btn-success">Reactivar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>