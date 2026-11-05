<form method="GET" action="admin_usuarios.php">
<input type="search" name="buscar" maxlength="100"
placeholder="Nombre, apellido, DNI o correo">
<button type="submit">Buscar</button>
</form>


<?php
$buscar = trim($_GET['buscar'] ?? '');
$sql = 'SELECT id, nombre, dni, correo,
rol, creado_en, archivado_en FROM usuarios
WHERE archivado_en IS NULL';
if ($buscar !== '') {
$sql .= ' AND (nombre LIKE :nombre OR 
OR dni LIKE :dni OR correo LIKE :correo)';
$termino = '%' . $buscar . '%';
}
$stmt = $conexionbd->prepare($sql);
$stmt->execute($parametros);
?>


