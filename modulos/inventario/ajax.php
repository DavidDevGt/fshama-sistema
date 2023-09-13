<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../conexion.php';

if (isset($_POST['fnc'])) {
    $op = $_POST['fnc'];

    switch ($op) {
        case "agregar_entrada_inventario":
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];

            $query = "INSERT INTO inventario (id_producto, tipo_movimiento, cantidad, motivo) VALUES ($id_producto, 'Entrada', $cantidad, '$motivo')";

            if (dbQuery($query)) {
                echo '1|Entrada de inventario agregada correctamente';
            } else {
                echo '0|Error al agregar entrada de inventario';
            }
            break;

        case "agregar_salida_inventario":
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];

            $query = "INSERT INTO inventario (id_producto, tipo_movimiento, cantidad, motivo) VALUES ($id_producto, 'Salida', $cantidad, '$motivo')";

            if (dbQuery($query)) {
                echo '1|Salida de inventario agregada correctamente';
            } else {
                echo '0|Error al agregar salida de inventario';
            }
            break;

        case "mostrar_entradas_salidas":
            $query = "SELECT * FROM inventario ORDER BY fecha DESC";
            $result = dbQuery($query);

            if (mysqli_num_rows($result) > 0) {
                $entradas_salidas = array();
                while ($row = dbFetchAssoc($result)) {
                    array_push($entradas_salidas, $row);
                }
                echo '1|' . json_encode($entradas_salidas);
            } else {
                echo '0|No hay movimientos en el inventario registrados.';
            }
            break;

        case "buscar_producto_por_nombre":
            $nombre = $_POST['nombre_producto'];
            $query = "SELECT id_producto, nombre_producto FROM productos WHERE nombre_producto LIKE '%$nombre%' LIMIT 5";
            $result = dbQuery($query);

            $productos = array();
            while ($row = dbFetchAssoc($result)) {
                array_push($productos, $row);
            }

            if (count($productos) > 0) {
                echo '1|' . json_encode($productos);
            } else {
                echo '0|Producto no encontrado.';
            }
            break;

        case "consultar_producto":
            $id_producto = $_POST['id_producto'];
            $query = "SELECT * FROM productos WHERE id_producto = $id_producto";
            $result = dbQuery($query);

            if ($row = dbFetchAssoc($result)) {
                echo '1|' . json_encode($row);
            } else {
                echo '0|Producto no encontrado.';
            }
            break;

        case "eliminar_registro_inventario":
            $id_inventario = $_POST['id_inventario'];
            $query = "DELETE FROM inventario WHERE id_inventario = $id_inventario";

            if (dbQuery($query)) {
                echo '1|Registro de inventario eliminado correctamente';
            } else {
                echo '0|Error al eliminar el registro de inventario';
            }
            break;

        case "actualizar_registro_inventario":
            $id_inventario = $_POST['id_inventario'];
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];
            $tipo_movimiento = $_POST['tipo_movimiento'];

            $query = "UPDATE inventario SET id_producto=$id_producto, tipo_movimiento='$tipo_movimiento', cantidad=$cantidad, motivo='$motivo' WHERE id_inventario=$id_inventario";

            if (dbQuery($query)) {
                echo '1|Registro de inventario actualizado correctamente';
            } else {
                echo '0|Error al actualizar el registro de inventario';
            }
            break;


        default:
            echo '0|Función no reconocida.';
            break;
    }
}
