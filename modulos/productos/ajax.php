<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../conexion.php';

if (isset($_POST['fnc'])) {
    $op = $_POST['fnc'];


    switch ($op) {
        case "":
        	break;
        default:
            echo '0|Función no reconocida.';
            break;
    }
}

?>
 
