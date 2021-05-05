<?php
// Inicializar sesion
session_start();
 
// desarmar todas las variables de sesion
$_SESSION = array();
 
// destruye la sesion
session_destroy();
 
// Redirigir a la pagina de inicio de sesion
header("location: login.php");
exit;
?>