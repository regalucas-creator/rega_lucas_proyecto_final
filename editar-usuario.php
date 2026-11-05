<?php

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
http_response_code(400);
exit('Identificador inválido.');
}
$stmt = $conexionbd->prepare('SELECT id, nombre,  dni, correo
FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1');


