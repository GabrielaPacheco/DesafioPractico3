<?php

include('conexion.php');

  $query = "SELECT * from recetas";
  $result = mysqli_query($link, $query);
  if(!$result) {
    die('Query Failed'. mysqli_error($link));
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
  $jsonstring = json_encode($json);
  echo $jsonstring;
?>
