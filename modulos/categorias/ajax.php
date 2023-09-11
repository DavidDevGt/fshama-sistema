<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../conexion.php';

if (isset($_POST['fnc'])) {
    $op = $_POST['fnc'];ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    switch ($op) {
        case "mostrar_categorias":
            $query = "SELECT * FROM categorias ORDER BY id_categoria";

            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $response = array();
                while ($row = dbFetchAssoc($result)) {
                    array_push($response, $row);
                }
                echo '1|' . json_encode($response);
            } else {
                echo '0|No hay categorías registradas.';
            }

            break;

        case "agregar_categoria":
            $nombreCategoria = $_POST['nombreCategoria'];
            $descripcion = $_POST['descripcion'];

            $query = "INSERT INTO categorias (nombre_categoria, descripcion) VALUES ('$nombreCategoria', '$descripcion')";

            if (dbQuery($query)) {
                echo '1|Categoría agregada correctamente.';
            } else {
                echo '0|Error al agregar la categoría.';
            }

            break;

        case "editar_categoria":
            $idCategoria = $_POST['idCategoria'];
            $nombreCategoria = $_POST['nombreCategoria'];
            $descripcion = $_POST['descripcion'];

            $query = "UPDATE categorias SET nombre_categoria='$nombreCategoria', descripcion='$descripcion' WHERE id_categoria='$idCategoria'";

            if (dbQuery($query)) {
                echo '1|Categoría actualizada correctamente.';
            } else {
                echo '0|Error al actualizar la categoría.';
            }

            break;

        case "eliminar_categoria":
            $idCategoria = $_POST['idCategoria'];

            $query = "DELETE FROM categorias WHERE id_categoria='$idCategoria'";

            if (dbQuery($query)) {
                echo '1|Categoría eliminada correctamente.';
            } else {
                echo '0|Error al eliminar la categoría.';
            }

            break;

        default:
            echo '0|Función no reconocida.';
            break;
    }
}

?>
