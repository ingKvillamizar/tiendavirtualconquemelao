<?php session_start(); include "conex.php" ;

$datos=file_get_contents('php://input');

$item = json_decode($datos);

$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));
$dolar=$informativos["dolar"];

if(!isset($_SESSION["aux"])){ $_SESSION["aux"]=rand(0,999999999);}

$buscar=mysqli_query($link,"select * from _carrito where id_producto=".$item->id." and aux=".$_SESSION["aux"]." and id_talla=".$item->idTalla."");

$producto = mysqli_fetch_assoc(mysqli_query($link,"select * from productos where id=".$item->id." "));

$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$producto["id"]." order by id ASC limit 0,1"));
	
$fecha_caduca = str_replace("-","/",$producto["descuento_caduca"]);

$precioF = $producto["precio"] * $dolar; 

if($producto["descuento"] > 0){
	
		$precioNew = ($producto["precio"] - ($producto["precio"] * $producto["descuento"]) / 100);
		$precioFWithDescount = 	$precioNew	* $dolar; 
		
	}else{
			
		$precioFWithDescount = 0;
		$precioNew = 0;
}


$precioSave = $producto["descuento"] > 0 ? $precioFWithDescount : $precioF;


$filas=mysqli_num_rows($buscar);


if($filas>0){
	//act.
	
mysqli_query($link,"update _carrito set cantidad=cantidad+".$item->cantidad."  where id_producto=".$item->id." and aux=".$_SESSION["aux"]." and id_talla=".$item->idTalla."");


}else{
	//add.
	
		mysqli_query($link,"insert into _carrito values (NULL,".$item->id.",".$item->cantidad.",".$precioSave.",NOW(),".$_SESSION["aux"].",".$item->idTalla.")");

}

	
	$json = array(
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
		"link" => URL.'/'.url($producto['nombre_es']).'-'.$producto['id'].'.html'
	);
	


echo json_encode($json);
?>