<?php
require_once __DIR__ . '/conexion.php';
try {
$sql = 'SELECT id, nombre,
pass, email, 
FROM user
ORDER BY id DESC';
$consulta = $conexion->query($sql);
$estudiantes = $consulta->fetchAll(
PDO::FETCH_ASSOC
);
} catch (PDOException $e) {
error_log($e->getMessage());
http_response_code(500);
exit('No se puedieron encontrar cuentas en la base de datos .');
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
<?= count($estudiantes) ?></p>
<?php if (empty($estudiantes)): ?>
<p>No se encontraron cuentas registradas.</p>
<?php else: ?>
<table>
<thead><tr>
<th>ID</th><th>Nombre</th>
<th>Apellido</th><th>Pass</th>
<th>Email</th>
</tr></thead>
<tbody>
<?php foreach ($estudiantes
as $estudiante): ?>
<tr>
<td><?= escaparListado(
(string)$estudiante['id']
) ?></td>
<td><?= escaparListado(
$estudiante['nombre']
) ?></td>
<td><?= escaparListado(
$estudiante['pass']
) ?></td>
<td><?= escaparListado(
$estudiante['email']
) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</main></body></html>