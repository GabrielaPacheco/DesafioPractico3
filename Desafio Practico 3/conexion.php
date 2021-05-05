<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'recetas_cocina');
 
/* Conectarse a la base de datos  */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Verifica la conección
if($link === false){
    die("ERROR: No se puede conectar. " . mysqli_connect_error());
}
?>