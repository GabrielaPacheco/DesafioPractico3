<?php

  include('conexion.php');

if(isset($_POST['nombre'])) {
  $recipe_nombre = $_POST['nombre'];
  $recipe_tipo = $_POST['tipo'];
  $recipe_ingredientes = $_POST['ingredientes'];
  $recipe_preparacion = $_POST['preparacion'];
  $destino = "imagenes/comida.jpg";
  if(isset($_FILES["imagen"]["tmp_name"])){
   if($_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png" || $_FILES["imagen"]["type"] == "image/jpg"){
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], "imagenes/".$_FILES['imagen']['name'])) {
      $destino = "imagenes/".$_FILES['imagen']['name'];
    } 
  }
}
  $query = "INSERT into recetas(nombre, tipo, ingredientes, preparacion, imagen) VALUES ('$recipe_nombre', '$recipe_tipo', '$recipe_ingredientes', '$recipe_preparacion', '$destino')";
  $result = mysqli_query($link, $query);
  if (!$result) {
  die('Query Failed.');
  echo "Error";
}
echo "Receta Añadida Exitosamente"; 

  

}

?>