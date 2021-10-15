<?php include "conex.php" ;

$sub = mysqli_query($link,"select * from categorias where estatus='si' ");

$json = array();
while($row = mysqli_fetch_assoc($sub)){
	
	$json[] = array("id" => $row["id"], "nombre" => $row['nombre_es']);
	$i++;
}

echo json_encode($json);
?>