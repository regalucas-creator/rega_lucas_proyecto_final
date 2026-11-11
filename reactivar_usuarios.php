<?php
session_start();
require "conexion.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION["usuario_rol"] !== "admin") {
    header("Location: panel.php");
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    header("Location: usuarios_archivados.php");
    exit;
}

$stmt = $conexionbd->prepare('UPDATE usuarios SET fecha_archivado = NULL WHERE id = :id AND fecha_archivado IS NOT NULL');
$stmt->execute([':id' => $id]);

header("Location: usuarios_archivados.php");
exit;
?>