
<?php
session_start();
require "conexion.php";


$usuario = $_POST["nombre"] ?? "";
$pass    = $_POST["pass"] ?? "";


$consulta = $conexionbd->prepare("SELECT * FROM usuarios WHERE nombre = ?");
$consulta->execute([$usuario]);
$fila = $consulta->fetch(); 




if (password_verify($pass, $fila["pass"])) {
    
    $_SESSION["usuario"] = $fila["nombre"];
    $_SESSION["rol"] = $fila["rol"];
    header("Location: panel.php");
    exit;
} 
?>