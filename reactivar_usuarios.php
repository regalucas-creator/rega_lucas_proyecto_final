UPDATE usuarios
SET archivado_en = NULL
WHERE id = :id
AND archivado_en IS NOT NULL;