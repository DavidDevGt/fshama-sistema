<?php include 'assets/includes/header.php'; ?>

<style>
    /* Estilos personalizados para el index */
    .contenedor-central {
        max-width: 800px;
        margin: 40px auto;
        text-align: center;
    }

    .acceso-directo {
        display: inline-block;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .acceso-directo:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .acceso-directo img {
        width: 70px;
        height: 70px;
        margin-bottom: 10px;
    }
</style>

<?php
// Enrutamiento con PHP nativo
if(isset($_GET['modulo'])) {
    $modulo = $_GET['modulo'];

    $ruta = 'modulos/' . $modulo . '/index.php';

    if(file_exists($ruta)) {
    // echo "Cargando módulo: $modulo";  Agregado para depuración
    include $ruta;
} else {
    // echo "Módulo $modulo no encontrado";  Agregado para depuración
    include 'modulos/404.php';
}

} 

// Verificar si no se ha especificado un módulo en la URL
if (!isset($_GET['modulo'])) {
    // Mostrar accesos directos a los módulos solo si no hay un módulo especificado

    echo '<div class="contenedor-central">';

    $modulos = ['productos', 'ventas', 'compras', 'proveedores', 'categorias', 'inventario'];
    foreach ($modulos as $modulo) {
        echo '<a href="?modulo=' . $modulo . '" class="acceso-directo">';
        echo '<img src="assets/img/' . $modulo . '.png" alt="' . ucfirst($modulo) . '">'; // Asumiendo que hay imágenes correspondientes en la carpeta img
        echo '<div>' . ucfirst($modulo) . '</div>';
        echo '</a>';
    }

    echo '</div>';
}

?>

<?php include 'assets/includes/footer.php'; ?>
