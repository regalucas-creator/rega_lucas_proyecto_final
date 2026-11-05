<?php

session_start();


if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Mi Panel</span>

            <a href="logout.php" class="btn btn-light btn-sm">Salir</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h1 class="h4">Bienvenido, <?php echo $_SESSION["usuario"]; ?> 👋</h1>
                <p class="mb-0 text-secondary">Entraste correctamente. Esta página solo es visible cuando estás logueado.</p>

                <hr>


                <a href="pagina1.html" class="btn btn-primary"> 👇 Toca aqui para ir a la pagina principal</a>
            </div>
        </div>
    </div>

</body>
</html>