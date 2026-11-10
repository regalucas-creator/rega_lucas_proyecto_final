<?php
session_start();
require "conexion.php";
require "escapar.php";

// Verificar que haya sesión iniciada
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

// Opcional: Si entra un admin, lo mandamos a su panel de administración
if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "admin") {
    header("Location: panel.php");
    exit;
}

// Buscar los datos del usuario actual utilizando la sesión
$stmt = $conexionbd->prepare('SELECT id, nombre, dni, correo, rol FROM usuarios WHERE nombre = :nombre AND archivado_en IS NULL LIMIT 1');
$stmt->execute([':nombre' => $_SESSION["usuario"]]);
$usuario = $stmt->fetch();

if (!$usuario) {
    http_response_code(404);
    exit('Usuario no encontrado.');
}

$error = "";
$exito = "";

// Lógica para modificar sus propios datos (basado en editar-usuario.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    if ($nombre === '' || $dni === '' || $correo === '') {
        $error = "Completá todos los campos.";
    } else {
        // Actualizamos los datos del usuario en la base de datos
        $update = $conexionbd->prepare('UPDATE usuarios SET nombre = :nombre, dni = :dni, correo = :correo WHERE id = :id');
        $update->execute([
            ':nombre' => $nombre,
            ':dni' => $dni,
            ':correo' => $correo,
            ':id' => $usuario['id'],
        ]);
        $exito = "Tus datos han sido actualizados correctamente.";
        
        // Actualizamos la sesión por si cambió el nombre de usuario
        $_SESSION["usuario"] = $nombre;

        // Recargar los datos actualizados
        $stmt = $conexionbd->prepare('SELECT id, nombre, dni, correo, rol FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1');
        $stmt->execute([':id' => $usuario['id']]);
        $usuario = $stmt->fetch();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi Perfil y Listado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand mb-0 h1">👤 Mi Cuenta</span>
        <a href="panel.php" class="btn btn-light btn-sm">Volver al panel</a>
        <a href="logout.php" class="btn btn-light btn-sm">Salir</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <h5 class="card-title mb-3">Modificar mis datos</h5>

            <?php if ($error !== ""): ?>
                <div class="alert alert-danger"><?php echo escapar($error); ?></div>
            <?php endif; ?>
            <?php if ($exito !== ""): ?>
                <div class="alert alert-success"><?php echo escapar($exito); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre de usuario</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo escapar($usuario['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" value="<?php echo escapar($usuario['dni']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" value="<?php echo escapar($usuario['correo']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <input type="text" class="form-control" value="<?php echo escapar($usuario['rol']); ?>" disabled>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="panel.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>