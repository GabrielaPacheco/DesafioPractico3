<?php

include('conexion.php');

if(isset($_POST['id'])) {
  $id = $_POST['id'];
  $query = "DELETE FROM recetas WHERE id = $id"; 
  $result = mysqli_query($link, $query);

  if (!$result) {
    die('Query Failed.');
  }
  echo "Receta Eliminada Exitosamente";  

}

?>
