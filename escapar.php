<?php
function escapar(string $valor): string {
    return htmlspecialchars(
        $valor,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>
