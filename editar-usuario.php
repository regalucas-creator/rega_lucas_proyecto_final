<?php
session_start();
require "conexion.php";
require "escapar.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

$esAdmin = (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "usuario");
$esAdmin = (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "admin");

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Identificador inválido.');
}


if (!$esAdmin) {
    $stmtMe = $conexionbd->prepare('SELECT id FROM usuarios WHERE nombre = :nombre AND fecha_archivado IS NULL LIMIT 1');
    $stmtMe->execute([':nombre' => $_SESSION["usuario"]]);
    $yo = $stmtMe->fetch();
    if ((int)$yo['id'] !== $id) {
        header("Location: panel.php");
        exit;
    }
}

$stmt = $conexionbd->prepare('SELECT id, nombre, dni, correo, rol FROM usuarios WHERE id = :id AND fecha_archivado IS NULL LIMIT 1');
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
    $dni = trim($_POST['dni'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $rol = $_POST['rol'] ?? 'usuario';

    if ($nombre === '' || $dni === '' || $correo === '') {
        $error = "Completá todos los campos.";
        
    } else
    $eraMiCuenta = ($usuario['nombre'] === $_SESSION["usuario"]); {
        if ($esAdmin) {
            $update = $conexionbd->prepare('UPDATE usuarios SET nombre = :nombre, dni = :dni, correo = :correo, rol = :rol WHERE id = :id');
            $update->execute([
                ':nombre' => $nombre,
                ':dni' => $dni,
                ':correo' => $correo,
                ':rol' => $rol,
                ':id' => $id,
            ]);
        } else {
            $update = $conexionbd->prepare('UPDATE usuarios SET nombre = :nombre, dni = :dni, correo = :correo WHERE id = :id');
            $update->execute([
                ':nombre' => $nombre,
                ':dni' => $dni,
                ':correo' => $correo,
                ':id' => $id,
            ]);
        }
        $exito = "Usuario actualizado correctamente.";
        $stmt = $conexionbd->prepare('SELECT id, nombre, dni, correo, rol FROM usuarios WHERE id = :id AND fecha_archivado IS NULL LIMIT 1');
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch();
        if ($eraMiCuenta && $usuario) {
            $_SESSION["usuario"] = $usuario['nombre'];
            $_SESSION["usuario_rol"] = $usuario['rol'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
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
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="<?php echo escapar($usuario['correo']); ?>" required>
                </div>
                <?php if ($esAdmin): ?>
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="usuario" <?php echo $usuario['rol'] === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo $usuario['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="listado.php" class="btn btn-secondary">Volver a mi cuenta</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>