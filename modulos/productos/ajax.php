<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../conexion.php';

if (isset($_POST['fnc'])) {
    $op = $_POST['fnc'];

    switch ($op) {
        case "agregar_producto":
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['id_categoria'];
            $precio_compra = $_POST['precio_compra'];
            $precio_venta = $_POST['precio_venta'];
            $stock_actual = $_POST['stock_actual'];
            $unidad_medida = $_POST['unidad_medida'];
            $active = $_POST['active'];

            $query = "INSERT INTO productos (nombre_producto, descripcion, id_categoria, precio_compra, precio_venta, stock_actual, unidad_medida, active) VALUES ('$nombre', '$descripcion', $id_categoria, $precio_compra, $precio_venta, $stock_actual, '$unidad_medida', $active)";

            if (dbQuery($query)) {
                echo '1|Producto agregado correctamente';
            } else {
                echo '0|Error al agregar producto';
            }
            break;

        case "editar_producto":
            $id = $_POST['id_producto'];
            $nombre = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['id_categoria'];
            $precio_compra = $_POST['precio_compra'];
            $precio_venta = $_POST['precio_venta'];
            $stock_actual = $_POST['stock_actual'];
            $unidad_medida = $_POST['unidad_medida'];
            $active = $_POST['active'];

            $query = "UPDATE productos SET nombre_producto='$nombre', descripcion='$descripcion', id_categoria=$id_categoria, precio_compra=$precio_compra, precio_venta=$precio_venta, stock_actual=$stock_actual, unidad_medida='$unidad_medida', active=$active WHERE id_producto=$id";

            if (dbQuery($query)) {
                echo '1|Producto actualizado correctamente';
            } else {
                echo '0|Error al actualizar producto';
            }
            break;

        case "eliminar_producto":
            $id = $_POST['id_producto'];

            $query = "DELETE FROM productos WHERE id_producto=$id";

            if (dbQuery($query)) {
                echo '1|Producto eliminado correctamente';
            } else {
                echo '0|Error al eliminar producto';
            }
            break;

        case "mostrar_productos":
            $query = "SELECT p.*, c.nombre_categoria AS nombre_categoria FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            ORDER BY p.id_producto";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $productos = array();
                while ($row = dbFetchAssoc($result)) {
                    array_push($productos, $row);
                }
                echo '1|' . json_encode($productos);
            } else {
                echo '0|No hay productos registrados.';
            }
            break;

        case "mostrar_producto":
            $id = $_POST['id_producto'];
            $query = "SELECT * FROM productos WHERE id_producto=$id";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $producto = dbFetchAssoc($result);
                echo '1|' . json_encode($producto);
            } else {
                echo '0|Producto no encontrado.';
            }
            break;

        case "mostrar_categorias":
            $query = "SELECT * FROM categorias ORDER BY id_categoria";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $categorias = array();
                while ($row = dbFetchAssoc($result)) {
                    array_push($categorias, $row);
                }
                echo '1|' . json_encode($categorias);
            } else {
                echo '0|No hay categorías registradas.';
            }

            break;

        case "mostrar_unidades_medida":
            $query = "SHOW COLUMNS FROM productos WHERE Field = 'unidad_medida'";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $row = dbFetchAssoc($result);
                $type = $row['Type'];
                preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
                $enum = explode("','", $matches[1]);
                echo '1|' . json_encode($enum);
            } else {
                echo '0|No se encontraron unidades de medida.';
            }
            break;

        case "buscar_producto":
            $consulta = $_POST['consulta'];
            $query = "SELECT * FROM productos WHERE nombre_producto LIKE '%$consulta%'";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $productos = array();
                while ($row = dbFetchAssoc($result)) {
                    array_push($productos, $row);
                }
                echo '1|' . json_encode($productos);
            } else {
                echo '0|No se encontraron productos con esa consulta.';
            }
            break;

            // ... otros casos ...

        default:
            echo '0|Función no reconocida.';
            break;
    }
}
