<?php session_start(); include "conex.php";
$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));

$dolar=$informativos["dolar"];
$buscar=mysqli_query($link,"select * from _carrito where  aux=".$_SESSION["aux"]." ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include "partials_Meta.php" ?>
    <title><?=$informativos["nombre_pagina"]?></title>

    <?php  include "partials_FONTS.php" ?>

	<?php  include "partials_STYLES.php" ?>

	<!-- SPECIFIC CSS -->
    <link href="<?=URL?>/css/checkout.css" rel="stylesheet">

</head>

<body>
	
	<div id="page">
		
	<?php  include "partials_Header.php" ?>
	<!-- /header -->
	
	<main class="bg_gray">
	
		
	<div class="container margin_30">
		<div class="page_header">
			
		<h1>Crear Pedido V&iacute;a WhatsApp</h1>
			
	</div>
	<form action="<?=URL?>/pedido-enviado" method="post">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="step first">
						<h3>1. Direcci&oacute;n</h3>
					
					<div class="tab-content checkout">
						<div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="tab_1">
							<div class="form-group">
								<input required type="email" name="email" class="form-control" placeholder="Email">
							</div>
							
							<hr>
							<div class="row no-gutters">
								<div class="col-6 form-group pr-1">
									<input required type="text" name="name" class="form-control" placeholder="Nombre">
								</div>
								<div class="col-6 form-group pl-1">
									<input required type="text" name="lastname"  class="form-control" placeholder="Apellido">
								</div>
							</div>
							<!-- /row -->
							<div class="form-group">
								<input required type="text" name="address"  class="form-control" placeholder="Direcci&oacute;n completa">
							</div>
							<div class="form-group">
								<input required type="text" name="referencia"  class="form-control" placeholder="Punto de referencia">
							</div>
							<div class="form-group">
								
									<input required type="text" name="city" class="form-control" placeholder="Ciudad">
								
								
							</div>
							<!-- /row -->
							
							
							<div class="form-group">
								<input required type="text" name="phone" class="form-control" placeholder="Tel&eacute;fono">
							</div>
							<hr>
							
							
						</div>
						<!-- /tab_1 -->
					  
					</div>
					</div>
					<!-- /step -->
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="step middle payments">
						<h3>2. Pago y env&iacute;o</h3>
							<ul>
								<?php
						
						$envios = mysqli_query($link,"select * from datosbancarios where estatus='si' order by orden ASC");
						while($row = mysqli_fetch_assoc($envios)){?>
							
							<li>
									<label class="container_radio"><?=ucfirst($row["banco"])?>
										<input checked type="radio" name="payment" value="<?=ucfirst($row["banco"])?>">
										<span class="checkmark"></span>
									</label>
								</li>
							
						<?php }
						
						?>
								
							</ul>
							<div class="payment_info d-none d-sm-block"><figure><img src="img/cards_all.svg" alt=""></figure>	</div>
							
							<h6 class="pb-2">M&eacute;todos de env&iacute;o</h6>
							
						
						<ul>
						
						<?php
						
						$envios = mysqli_query($link,"select * from envio where estatus='si' order by orden ASC");
						while($row = mysqli_fetch_assoc($envios)){?>
							
							<li>
									<label class="container_radio"><?=ucfirst($row["nombre_es"])?>
										<input type="radio" name="shipping" checked value="<?=ucfirst($row["nombre_es"])?>">
										<span class="checkmark"></span>
									</label>
								</li>
							
						<?php }
						
						?>
						
						
								
								
								
							</ul>
						
					</div>
					<!-- /step -->
					
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="step last">
						<h3>3. Orden resumen</h3>
					<div class="box_general summary">
					
					
						<ul>
						<?php
							
							
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
	
	"nombre_es" => $producto['nombre_es'],
	"precio" => fpreciosD($precioF),
	"precioNew" => fpreciosD($precioNew),
	"moneda" => $informativos["moneda"],
	"descuento" => $producto['descuento'],
	"descuentoF" => number_format($producto['descuento'], 0),
	"descuento_caduca" => $fecha_caduca,
	"precioFWithDescount" => fpreciosD($precioFWithDescount),
	"foto" => $pic["foto"],
	
	"link" => URL.'/'.url($producto['nombre_es']).'-'.$producto['id'].'.html',
	"cantidad" => $row["cantidad"],
	"costo" => fpreciosD($row["precio"])
	);
	
?>
						
							<li class="clearfix"><em><?=$row["cantidad"]?>x <?=$producto['nombre_es']?></em>  <span><?=fpreciosD($row["precio"]*$row["cantidad"]);?></span></li>
							
<?php	
	
} ?>
							
						</ul>
						<ul>
							<li class="clearfix"><em><strong>Subtotal</strong></em>  <span><?=fpreciosD($total)?> <?=$informativos["moneda"]?></span></li>
							<li class="clearfix"><em><strong>Env&iacute;o</strong></em> <span>0.00 <?=$informativos["moneda"]?></span></li>
							
						</ul>
						<div class="total clearfix">TOTAL <span><?=fpreciosD($total)?> <?=$informativos["moneda"]?></span></div>
						
						
						<button name="btn_pedido" type="submit" class="btn_1 full-width">Confirmar y enviar a WhatsApp</button>
					</div>
					<!-- /box_general -->
					</div>
					<!-- /step -->
				</div>
			</div>
			</form>
		</div>
		<!-- /container -->
	</main>
	<!--/main-->
	
	<?php  include "partials_FOOTER.php" ?>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->
	<!-- Modal Payments Method-->
	<div class="modal fade" id="payments_method" tabindex="-1" role="dialog" aria-labelledby="payments_method_title" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="payments_method_title">Payments Methods</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Lorem ipsum dolor sit amet, oratio possim ius cu. Labore prompta nominavi sea ei. Sea no animal saperet gloriatur, ius iusto ullamcorper ad. Qui ignota reformidans ei, vix in elit conceptam adipiscing, quaestio repudiandae delicatissimi vis ei. Fabulas accusamus no has.</p>
			 <p>Et nam vidit zril, pri elaboraret suscipiantur ut. Duo mucius gloriatur at, in vis integre labitur dolores, mei omnis utinam labitur id. An eum prodesset appellantur. Ut alia nemore mei, at velit veniam vix, nonumy propriae conclusionemque ea cum.</p>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- COMMON SCRIPTS -->
    <?php  include "partials_JS.php" ?>

    <script>
    	// Other address Panel
		$('#other_addr input').on("change", function (){
	        if(this.checked)
	            $('#other_addr_c').fadeIn('fast');
	        else
	            $('#other_addr_c').fadeOut('fast');
	    });
	</script>
		
</body>
</html>