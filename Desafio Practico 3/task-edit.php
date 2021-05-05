<?php

  include('conexion.php');

if(isset($_POST['id'])) {
  $recipe_nombre = $_POST['nombre'];
  $recipe_tipo = $_POST['tipo'];
  $recipe_ingredientes = $_POST['ingredientes'];
  $recipe_preparacion = $_POST['preparacion'];
  $id = $_POST['id'];

  $query = "UPDATE recetas SET nombre = '$recipe_nombre', tipo = '$recipe_tipo', ingredientes = '$recipe_ingredientes', preparacion = '$recipe_preparacion' WHERE id = '$id'";
  $result = mysqli_query($link, $query);

  if (!$result) {
    die('Query Failed.');
  }
  echo "Receta Actualizada Exitosamente";  

}

?>
