<?php
session_start();
require "conexion.php";
require "escapar.php";

// Verificar que haya sesión iniciada
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}


// Buscar los datos del usuario actual utilizando la sesión
$stmt = $conexionbd->prepare('SELECT id, nombre, dni, correo, rol FROM usuarios WHERE nombre = :nombre AND fecha_archivado IS NULL LIMIT 1');
$stmt->execute([':nombre' => $_SESSION["usuario"]]);
$usuario = $stmt->fetch();

if (!$usuario) {
    http_response_code(404);
    exit('Usuario no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi Cuenta</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Cuenta</span>
        <a href="panel.php" class="btn btn-light btn-sm">Volver al panel</a>
        <a href="logout.php" class="btn btn-light btn-sm">Salir</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <h5 class="card-title mb-3">Datos</h5>

            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td><?php echo escapar((string)$usuario['id']); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nombre</th>
                        <td><?php echo escapar($usuario['nombre']); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">DNI</th>
                        <td><?php echo escapar($usuario['dni']); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Correo electrónico</th>
                        <td><?php echo escapar($usuario['correo']); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Rol</th>
                        <td><?php echo escapar($usuario['rol']); ?></td>
                    </tr>
                </tbody>
            </table>

            <a href="editar-usuario.php?id=<?php echo (int)$usuario['id']; ?>" class="btn btn-primary">Editar datos</a>
        </div>
    </div>
</div>

</body>
</html>