<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../conexion.php';

if (isset($_POST['fnc'])) {
    $op = $_POST['fnc'];

    switch ($op) {
        case 'obtenerProductos':
            $query = "SELECT * FROM inventario";
            $result = dbQuery($query);
            if ($result) {
                $productos = array();
                while ($row = dbFetchAssoc($result)) {
                    $productos[] = $row;
                }
                echo json_encode($productos);
            } else {
                echo '0|Error al obtener productos.';
            }
            break;

        case 'buscarProducto':
            $busqueda = $_POST['producto'];

            // Suponiendo que quieras buscar por el nombre del producto
            $query = "SELECT * FROM productos WHERE nombre_producto LIKE '%$busqueda%'";

            $result = dbQuery($query);
            if ($result) {
                $productos = array();
                while ($row = dbFetchAssoc($result)) {
                    $productos[] = $row;
                }

                // Se verifica si se encontraron productos
                if (count($productos) > 0) {
                    echo json_encode($productos);
                } else {
                    echo '0|Producto no encontrado.';
                }
            } else {
                echo '0|Error en la consulta.';
            }
            break;


        case 'agregarEntrada':
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];
            $query = "INSERT INTO inventario (id_producto, fecha, tipo_movimiento, cantidad, motivo) VALUES ('$id_producto', NOW(), 'Entrada', '$cantidad', '$motivo')";
            if (dbQuery($query)) {
                echo '1|Entrada agregada correctamente.';
            } else {
                echo '0|Error al agregar entrada.';
            }
            break;

        case 'agregarSalida':
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];
            $query = "INSERT INTO inventario (id_producto, fecha, tipo_movimiento, cantidad, motivo) VALUES ('$id_producto', NOW(), 'Salida', '$cantidad', '$motivo')";
            if (dbQuery($query)) {
                echo '1|Salida agregada correctamente.';
            } else {
                echo '0|Error al agregar salida.';
            }
            break;

        case 'obtenerProductosConMovimientos':
            $productos = obtenerProductosConMovimientos();
            echo json_encode($productos);
            break;


        case "obtenerEstadisticas":
            echo json_encode(obtenerEstadisticas());
            break;

            // Aquí podrías agregar más casos de uso según las necesidades de tu aplicación.

        default:
            echo '0|Función no reconocida.';
            break;
    }
}

function obtenerProductosConMovimientos()
{
    // Consulta todos los productos y su stock inicial
    $query = "SELECT id_producto, nombre_producto AS nombre, stock_actual FROM productos";
    $result = dbQuery($query);

    $productos = [];
    while ($row = dbFetchAssoc($result)) {
        $productos[$row['id_producto']] = [
            'id_producto' => $row['id_producto'],
            'nombre' => $row['nombre'],
            'stock_inicial' => $row['stock_actual'],  // Asumimos que el stock_actual es el stock inicial
            'stock_actual' => $row['stock_actual'],
            'movimientos' => []
        ];
    }

    // Consulta todos los movimientos
    $queryMovimientos = "SELECT id_producto, tipo_movimiento, cantidad FROM inventario";
    $resultMovimientos = dbQuery($queryMovimientos);

    while ($rowMovimiento = dbFetchAssoc($resultMovimientos)) {
        $idProducto = $rowMovimiento['id_producto'];
        if (isset($productos[$idProducto])) {
            if ($rowMovimiento['tipo_movimiento'] == 'Entrada') {
                $productos[$idProducto]['stock_actual'] += $rowMovimiento['cantidad'];
            } else {
                $productos[$idProducto]['stock_actual'] -= $rowMovimiento['cantidad'];
            }

            $productos[$idProducto]['movimientos'][] = [
                'tipo_movimiento' => $rowMovimiento['tipo_movimiento'],
                'cantidad' => $rowMovimiento['cantidad']
            ];
        }
    }

    return array_values($productos);
}

function obtenerEstadisticas()
{
    // Total de productos
    $query = "SELECT COUNT(*) as totalProductos FROM productos";
    $result = dbQuery($query);
    $stats['totalProductos'] = dbFetchAssoc($result)['totalProductos'];

    // Productos bajo stock (ejemplo: menos de 5)
    $query = "SELECT COUNT(*) as productosBajoStock FROM productos WHERE stock_actual < 5";
    $result = dbQuery($query);
    $stats['productosBajoStock'] = dbFetchAssoc($result)['productosBajoStock'];

    // Último movimiento
    $query = "SELECT tipo_movimiento FROM inventario ORDER BY fecha DESC LIMIT 1";
    $result = dbQuery($query);
    $ultimoMov = dbFetchAssoc($result);
    $stats['ultimoMovimiento'] = $ultimoMov ? $ultimoMov['tipo_movimiento'] : 'Ninguno';

    // Movimientos en los últimos 7 días
    $query = "SELECT COUNT(*) as movimientosRecientes FROM inventario WHERE fecha >= CURDATE() - INTERVAL 7 DAY";
    $result = dbQuery($query);
    $stats['movimientosRecientes'] = dbFetchAssoc($result)['movimientosRecientes'];

    return $stats;
}
