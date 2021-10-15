<?php session_start(); include "conex.php";
$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));
$dolar=$informativos["dolar"];

 
if(isset($_POST["btn_pedido"])){
	
if(!isset($_SESSION["aux"])){?>

<script>window.location=URL."/";</script>

<?php }else{
	
$codigo=generarCodigo(8);	


$shipping = mysqli_fetch_assoc(mysqli_query($link,"select * from envio where nombre_es='".$_POST["shipping"]."' " ));


mysqli_query($link,"insert into orden values(NULL,NULL,'por_pagar',".$shipping["id"].",NOW(),NULL,0,NULL,NULL,'".$_POST["payment"]."','".$codigo."','".$_POST["address"]."','".$_POST["name"]."','".$_POST["lastname"]."','".$_POST["phone"]."') ") or die("error");

$id=mysqli_insert_id($link);	
	
$consulta=mysqli_query($link,"select * from _carrito where aux=".$_SESSION["aux"]."");

while($row=mysqli_fetch_assoc($consulta)){

   mysqli_query($link,"insert into orden_carrito values(NULL,".$row["id_producto"].",".$row["cantidad"].",".$row["precio"].",NOW(),".$id.",".$row["id_talla"].")");
   
   $cdes=$row["cantidad"];
   //descuento del inventario -> productos ->
   mysqli_query($link,"update productos_tallas set stock_actual=stock_actual-".$cdes." where id=".$row["id_producto"]." and id_talla=".$row["id_talla"]."");
  
}


	



// PEDIDO AL WhatsApp
$buscar=mysqli_query($link,"select * from _carrito where  aux=".$_SESSION["aux"]." ");

$total = 0;
$info = "";
while($row = mysqli_fetch_assoc($buscar)){
	
	$producto = mysqli_fetch_assoc(mysqli_query($link,"select * from productos where id=".$row["id_producto"]." "));

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
	
	$info .= "*".$row["cantidad"]."*  x ".$producto['nombre_es']." *|* ( ".fpreciosD($row["precio"])." ".$informativos["moneda"]." )%0D%0A";

}	

$text = "
*Nuevo pedido* 🛵 *(".$_SERVER["HTTP_HOST"].")* %0D%0A%0D%0A

".$info."


*Total en ".$informativos["moneda"].":* ".fpreciosD($total)."%0D%0A


*Forma de entrega:* ".$_POST["shipping"]."%0D%0A
*Metodo de Pago:* ".$_POST["payment"]."%0D%0A%0D%0A

=====*Datos del Cliente*=====%0D%0A%0D%0A

👤 ".$_POST["name"]." ".$_POST["lastname"]." %0D%0A
📱 ".$_POST["phone"]."%0D%0A
📍 *Direccion:* ".$_POST["address"]."%0D%0A
📍 *Punto de referencia:* ".$_POST["referencia"]."%0D%0A
📍 *Ciudad:* ".$_POST["city"]."%0D%0A
📝****%0D%0A%0D%0A

Por favor confirme mediante respuesta.%0D%0A%0D%0A

-----------------------------%0D%0A
(Mensaje para el Cliente)%0D%0A%0D%0A

*Recuerde cancelar con el método de pago seleccionado!* %0D%0A%0D%0A

*".$_POST["payment"].":* %0D%0A

*Tasa del dia💰*%0D%0A%0D%0A

1 USD  - ".fpreciosD($dolar)." ".$informativos["moneda"]."

";


// DELETE DATA

mysqli_query($link,"delete from _carrito where aux=".$_SESSION["aux"]."");

unset($_SESSION['aux']);

	 
	
 }	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include "partials_Meta.php"; ?>
    <title><?=$informativos["nombre_pagina"]?></title>

    <?php  include "partials_FONTS.php"; ?>

	<?php  include "partials_STYLES.php"; ?>

	<!-- SPECIFIC CSS -->
    <link href="css/checkout.css" rel="stylesheet">

</head>

<body>
	
	<div id="page">
		
	<?php  include "partials_Header.php"; ?>
	<!-- /header -->
	
	<main class="bg_gray">
		<div class="container">
            <div class="row justify-content-center">
				<div class="col-md-5">
					<div id="confirm">
					
					<h2>Pedido Creado!</h2>
						<div class="icon icon--order-success svg add_bottom_15">
							<svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
								<g fill="none" stroke="#8EC343" stroke-width="2">
									<circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
									<path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
								</g>
							</svg>
						</div>
					
					<a class="btn_1" style="background-color:#ffc107;color:#222" target="_blank" href="https://api.whatsapp.com/send?phone=+584128256644&amp;text=<?=$text?>">Enviar pedido al WhatsApp</a>
					
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
		
	</main>
	<!--/main-->
	
	<?php  include "partials_FOOTER.php" ?>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->
	
	<!-- COMMON SCRIPTS -->
    	<?php  include "partials_JS.php" ?>

		
</body>
</html>