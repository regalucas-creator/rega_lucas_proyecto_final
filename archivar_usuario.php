
UPDATE usuarios
SET archivado_en = CURRENT_TIMESTAMP
WHERE id = :id
AND archivado_en IS NULL;


SELECT id, nombre, apellido,
dni, email, archivado_en
FROM usuarios
WHERE archivado_en IS NOT NULL
ORDER BY archivado_en DESC;
