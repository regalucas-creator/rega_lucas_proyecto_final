<?php
require_once __DIR__ . '/conexion.php';
try {
$sql = 'SELECT id, nombre,
pass, email, 
FROM usuarios
ORDER BY id DESC';
$consulta = $conexionbd->query($sql);
$usuarios = $consulta->fetchAll(
PDO::FETCH_ASSOC
);
} catch (PDOException $e) {
error_log($e->getMessage());
http_response_code(500);
exit('No se pudieron encontrar cuentas en la base de datos .');
}
function escaparListado(string $v): string {
return htmlspecialchars(
$v, ENT_QUOTES, 'UTF-8'
);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de cuentas</title>
</head>
<body><main>
<h1>Listado de cuentas</h1>
<p><strong>Cuentas:</strong>
<?= count($usuarios) ?></p>
<?php if (empty($usuarios)): ?>
<p>No se encontraron cuentas registradas.</p>
<?php else: ?>
<table>
<thead><tr>
<th>ID</th><th>Nombre</th>
<th>Apellido</th><th>Pass</th>
<th>Correo</th>
</tr></thead>
<tbody>
<?php foreach ($usuarios
as $usuarios): ?>
<tr>
<td><?= escaparListado(
(string)$usuarios['id']
) ?></td>
<td><?= escaparListado(
$usuarios['nombre']
) ?></td>
<td><?= escaparListado(
$usuarios['pass']
) ?></td>
<td><?= escaparListado(
$usuarios['correo']
) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</main></body></html>