<?php
// Parámetros de conexión a la base de datos
$host = 'localhost';
$db_name = 'inventario_fshama_v2';
$username = 'root';
$password = '';

// Establecer conexión con la base de datos usando mysqli
$conexion = new mysqli($host, $username, $password, $db_name);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

/**
 * Función para ejecutar consultas SQL
 * 
 * @param string $query Consulta SQL a ejecutar
 * @return mixed Resultado de la consulta
 */
function dbQuery($query) {
    global $conexion; // Usamos la conexión previamente establecida
    return mysqli_query($conexion, $query);
}

/**
 * Función para obtener una fila de resultados como un array asociativo
 * 
 * @param mysqli_result $result Resultado de una consulta SQL
 * @return array Fila de resultados
 */
function dbFetchAssoc($result) {
    return mysqli_fetch_assoc($result);
}
