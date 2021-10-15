<?php include "conex.php" ;

$datos=file_get_contents('php://input');

$item = json_decode($datos);

//SELECT * FROM categorias as C join subcategorias as S on C.id=S.id_categoria where C.estatus='si' and S.estatus='si' order by C.id ASC

$sub = mysqli_query($link,"select * from subcategorias where id_categoria=".$item->id."");

$json = array();
while($row = mysqli_fetch_assoc($sub)){
	
	
	
	$json[] = array("id" => $row["id"], "subcategorias" => $row['nombre_es']);
	
}

echo json_encode($json);
?>