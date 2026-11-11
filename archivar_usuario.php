<?php
session_start();
require "conexion.php";

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
    header("Location: admin-usuario.php");
    exit;
}

$stmtYo = $conexionbd->prepare('SELECT id FROM usuarios WHERE nombre = :nombre LIMIT 1');
$stmtYo->execute([':nombre' => $_SESSION["usuario"]]);
$yo = $stmtYo->fetch();
if ($yo && (int)$yo['id'] === $id) {
    header("Location: admin-usuario.php");
    exit;
}

$stmt = $conexionbd->prepare('UPDATE usuarios SET archivado_en = CURRENT_TIMESTAMP WHERE id = :id AND archivado_en IS NULL');
$stmt->execute([':id' => $id]);

header("Location: admin-usuario.php");
exit;
?>