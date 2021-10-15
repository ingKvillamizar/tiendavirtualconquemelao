<?php include "conex.php" ;
$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));
$datos=file_get_contents('php://input');

$item = json_decode($datos);

if($item->idSubCategoria == "" && $item->idInside == ""){
	
	$query = "select * from productos where estatus='si' and  id_categoria=".$item->idCategoria." ";
	
}elseif($item->idSubCategoria != "" && $item->idInside == 0){
	
	$query = "select * from productos where estatus='si' and  id_subcategoria=".$item->idSubCategoria." ";
}else{
	$query = "select * from productos where estatus='si' and  id_subcategoria=".$item->idSubCategoria." and idInside=".$item->idInside." ";
	
}

$sub = mysqli_query($link,$query);

$json = array();
while($row = mysqli_fetch_assoc($sub)){
	
	$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$row["id"]." order by orden ASC limit 0,1"));
	
	$fecha_caduca = str_replace("-","/",$row["descuento_caduca"]);
	
	
	$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$row["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
	$id_talla = $talla["id"];
	
	$precio = $row["precio"]; $dolar=$informativos["dolar"]; $precioF = $precio * $dolar; 
	
	
						
	if($row["descuento"] > 0){
							
		$precioNew = ($row["precio"] - ($row["precio"] * $row["descuento"]) / 100);
		$dolar=$informativos["dolar"];
		$precioFWithDescount = 	$precioNew	* $dolar; 				
	}else{
		
		$precioFWithDescount = 0;
		$precioNew = 0;
	}

	
	
	$json[] = array(
	"id" => $row['id'],
	"idTalla" => $id_talla,
	"nombre_es" => $row['nombre_es'],
	"precio" => fpreciosD($precioF),
	"precioNew" => fpreciosD($precioNew),
	"moneda" => $informativos["moneda"],
	"descuento" => $row['descuento'],
	"descuentoF" => number_format($row['descuento'], 0),
	"descuento_caduca" => $fecha_caduca,
	"precioFWithDescount" => fpreciosD($precioFWithDescount),
	"foto" => $pic["foto"],
	"dolar" => fpreciosD($informativos['dolar']),
	"link" => URL.'/'.url($row['nombre_es']).'-'.$row['id'].'.html'
	);
	
}

echo json_encode($json);
?>