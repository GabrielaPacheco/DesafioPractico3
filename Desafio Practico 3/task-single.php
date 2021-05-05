<?php
include('conexion.php');

if(isset($_POST['id'])) {
  $id = mysqli_real_escape_string($link, $_POST['id']);

  $query = "SELECT * from recetas WHERE id = {$id}";

  $result = mysqli_query($link, $query);
  
  if(!$result) {
    die('Query Failed'. mysqli_error($connection));
  }

  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'nombre' => $row['nombre'],
      'tipo' => $row['tipo'],
      'ingredientes' => $row['ingredientes'],
      'preparacion' => $row['preparacion'],
      'imagen' => $row['imagen'],
      'id' => $row['id']
    );
  }
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

?>
