
<?php
session_start();


require "conexion.php";

$usuario = $_POST["usuario"];
$clave   = $_POST["clave"];


$consulta = $conexionbd->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$consulta->execute([$usuario]);
$fila = $consulta->fetch(); 


if ($fila && password_verify($clave, $fila["clave"])) {

    $_SESSION["usuario"] = $fila["usuario"];
    $_SESSION["rol"] = $fila["rol"];
    header("Location: panel.php");
    exit;
}

header("Location: index.php?error=1");
?>