<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario FSHAMA</title>
    <!-- Librería CSS de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Librería CSS de Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Librería JS de jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Librería JS de Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Librería JS de Popper (necesaria para ciertas funcionalidades de Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Librería JS de dom2pdf para convertir DOM a PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <a class="navbar-brand" href="index.php"><img style="max-width: 100px;padding:5px;" src="https://fshama.netlify.app/media/logo%202.svg" alt="ferreteria shama"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            // Listar las carpetas dentro del directorio 'modulos'
            $modulos = array_filter(glob('modulos/*'), 'is_dir');

            foreach ($modulos as $modulo) {
                // Extraer el nombre del módulo de la ruta
                $nombreModulo = basename($modulo);
                echo '<li class="nav-item">';
                echo '<a class="nav-link font-weight-bold text-uppercase" style="color:black;" href="index.php?modulo=' . $nombreModulo . '">' . ucfirst($nombreModulo) . '</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</nav>
<!-- Fin Navbar -->