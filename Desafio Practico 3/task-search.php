<?php

include('conexion.php');

$search = $_POST['search'];
if(!empty($search)) {
  $query = "SELECT * FROM recetas WHERE nombre OR tipo LIKE '$search%'";
  $result = mysqli_query($link, $query);
  
  if(!$result) {
    die('Query Error' . mysqli_error($link));
  }
  
  $json = array();
  while($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'nombre' => $row['nombre'],
      'tipo' => $row['tipo'],
      'id' => $row['id']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}

?>
