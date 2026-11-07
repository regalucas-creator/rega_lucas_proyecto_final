<?php
session_start();
require "conexion.php";
require "escapar.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION["rol"] !== "admin") {
    header("Location: panel.php");
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Identificador inválido.');
}

$stmt = $conexionbd->prepare('SELECT id, nombre, apellido, dni, email FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1');
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    http_response_code(404);
    exit('Usuario no encontrado.');
}

$error = "";
$exito = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rol = $_POST['rol'] ?? 'usuario';

    if ($nombre === '' || $apellido === '' || $dni === '' || $email === '') {
        $error = "Completá todos los campos.";
    } else {
        $update = $conexionbd->prepare('UPDATE usuarios SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email, rol = :rol WHERE id = :id');
        $update->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':dni' => $dni,
            ':email' => $email,
            ':rol' => $rol,
            ':id' => $id,
        ]);
        $exito = "Usuario actualizado correctamente.";
        $stmt = $conexionbd->prepare('SELECT id, nombre, apellido, dni, email FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1');
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="card-title">Editar usuario #<?php echo (int)$usuario['id']; ?></h5>
            <?php if ($error !== ""): ?><div class="alert alert-danger"><?php echo escapar($error); ?></div><?php endif; ?>
            <?php if ($exito !== ""): ?><div class="alert alert-success"><?php echo escapar($exito); ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo escapar($usuario['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" value="<?php echo escapar($usuario['dni']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="corre" class="form-control" value="<?php echo escapar($usuario['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="usuario" <?php echo $usuario['rol'] === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo $usuario['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="admin_usuarios.php" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>