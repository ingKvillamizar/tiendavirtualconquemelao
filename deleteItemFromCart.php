<?php session_start(); include "conex.php" ;

$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));

$dolar=$informativos["dolar"];

$datos=file_get_contents('php://input');

$item = json_decode($datos);

$delete=mysqli_query($link,"delete  from _carrito where id=".$item->id." and aux=".$_SESSION["aux"]." ");


$buscar=mysqli_query($link,"select * from _carrito where  aux=".$_SESSION["aux"]." ");

$json = array();

$total = 0;

while($row = mysqli_fetch_assoc($buscar)){
	
	$producto = mysqli_fetch_assoc(mysqli_query($link,"select * from productos where id=".$row["id_producto"]." "));

	$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$producto["id"]." order by orden ASC limit 0,1"));
	
	$fecha_caduca = str_replace("-","/",$producto["descuento_caduca"]);
	
	$precio = $producto["precio"];
	$precioF = $precio * $dolar; 
				
	if($producto["descuento"] > 0){
							
		$precioNew = ($producto["precio"] - ($producto["precio"] * $producto["descuento"]) / 100);
		
		$precioFWithDescount = 	$precioNew	* $dolar; 				
	}else{
		
		$precioFWithDescount = 0;
		$precioNew = 0;
	}

	$total += $producto["descuento"] > 0 ? $precioFWithDescount*$row["cantidad"] : $precioF*$row["cantidad"] ;

	$json[] = array(
	"id" => $row['id'],
	"nombre_es" => $producto['nombre_es'],
	"precio" => fpreciosD($precioF),
	"precioNew" => fpreciosD($precioNew),
	"moneda" => $informativos["moneda"],
	"descuento" => $producto['descuento'],
	"descuentoF" => number_format($producto['descuento'], 0),
	"descuento_caduca" => $fecha_caduca,
	"precioFWithDescount" => fpreciosD($precioFWithDescount),
	"foto" => $pic["foto"],
	"dolar" => fpreciosD($informativos['dolar']),
	"link" => URL.'/'.url($producto['nombre_es']).'-'.$producto['id'].'.html',
	"cantidad" => $row["cantidad"],
	"costo" => fpreciosD($row["precio"]),
	"costoXcantidad" => fpreciosD($row["precio"] * $row["cantidad"])
	);
	
	
	
}


array_push($json,array("total" => fpreciosD($total)));


echo json_encode($json);
?>