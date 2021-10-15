<?php session_start(); include "conex.php";
$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));


$categoria = mysqli_fetch_assoc(mysqli_query($link,"select * from categorias where id=".$_GET["c"].""));

$listado = mysqli_query($link,"select * from productos where id_categoria =".$_GET["c"]." ");

$count = mysqli_num_rows($listado);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include "partials_Meta.php" ?>
    <title><?=$informativos["nombre_pagina"]?></title>

    <?php  include "partials_FONTS.php" ?>
	
	<?php  include "partials_STYLES.php" ?>


	<!-- SPECIFIC CSS -->
    <link href="<?=URL?>/css/listing.css" rel="stylesheet">

</head>

<body>
	
	<div id="page" class="theia-exception">
		
	<?php  include "partials_Header.php" ?>
	<!-- /header -->
		
	<main>
		<div class="top_banner">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.3)">
				<div class="container">
					<div class="breadcrumbs">
						<ul>
							<li><a href="/">Inicio</a></li>
							<li><a href="/">Categor&iacute;a</a></li>
							<li>P&aacute;gina activa</li>
						</ul>
					</div>
					<h1><?=$categoria["nombre_es"]?></h1>
				</div>
			</div>
			<img src="<?=URL?>/images/<?=$categoria["foto"]?>" class="img-fluid" alt="">
		</div>
		<!-- /top_banner -->
			
			
			<div class="container margin_30">
			
			<div class="row">
				
				
				<div class="col-lg-12">
					<div class="row small-gutters">
					
					<?php  if($count > 0) {?>
					
					<?php   while($rows = mysqli_fetch_assoc($listado)){
			
							$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$rows["id"]." order by orden ASC limit 0,1"));
							
							$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$rows["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
							$id_talla = $talla["id"];

						?>
					
							<div class="col-6 col-md-2">
							<div class="grid_item">
						<figure>
						<?php  if($rows["descuento"] > 0){
						?>
							<span class="ribbon off">-<?=number_format($rows["descuento"], 0)?>%</span>
						<?php 						
						}  ?>
						
							<a href="<?=URL?>/<?=url($rows["nombre_es"])?>-<?=ucfirst($rows["id"])?>.html">
								<img class="img-fluid lazy" src="<?=URL?>/items/<?=$pic["foto"]?>" data-src="<?=URL?>/items/<?=$pic["foto"]?>" alt="" width="400" height="400">
							</a>
							
						
						<?php  if($rows["descuento"] > 0){
							$fecha_caduca = str_replace("-","/",$rows["descuento_caduca"]);
						?>
							<div data-countdown="<?=$fecha_caduca?>" class="countdown"></div>
						<?php 						
						}  ?>
							
							
						</figure>
						<a href="<?=URL?>/<?=url($rows["nombre_es"])?>-<?=ucfirst($rows["id"])?>.html">
							<h3><?=$rows["nombre_es"]?></h3>
						</a>
						<div class="price_box">
						
						<?php 

						$precio = $rows["precio"]; $dolar=$informativos["dolar"]; $precioF = $precio * $dolar; 
						
						if($rows["descuento"] > 0){
							
						$precioNew = ($rows["precio"] - ($rows["precio"] * $rows["descuento"]) / 100); $dolar=$informativos["dolar"];
						$precioFWithDescount = 	$precioNew	* $dolar; 				
							
						?>
							
							<span class="new_price"><?php echo fpreciosD($precioFWithDescount); echo " "; echo $informativos["moneda"];  ?></span>
							<span class="old_price"><?php echo fpreciosD($precioF); echo " "; echo $informativos["moneda"];  ?></span>
						<?php 						
						}else{?>
							
							<span class="new_price"><?php echo fpreciosD($precioF); echo " "; echo $informativos["moneda"];  ?> </span>
						
						<?php }  ?>
							
							<div>Tasa: 1.USD: <?php echo fpreciosD($informativos["dolar"]); echo " "; echo $informativos["moneda"];  ?></div>
							
						</div>
						<ul>
							<li><a href="#0" rel="<?=$rows["id"]?>-<?=$id_talla?>" onClick="addItemToCart(<?=$rows["id"]?>,<?=$id_talla?>)"  class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Agregar al carrito</span></a></li>
						</ul>
					</div>
							<!-- /grid_item -->
						</div>
						<!-- /col -->				
					<?php }	?>
					<?php }else{
						
						echo '<h2>No hay productos por ahora.</h2>';
					}	?>
						
						
					</div>
					<!-- /row -->
					<div class="pagination__wrapper">
						<ul class="pagination">
							<li><a href="#0" class="prev" title="previous page">&#10094;</a></li>
							<li>
								<a href="#0" class="active">1</a>
							</li>
							
							<li><a href="#0" class="next" title="next page">&#10095;</a></li>
						</ul>
					</div>
				</div>
				<!-- /col -->
			</div>
			<!-- /row -->			
				
		</div>
		<!-- /container -->
	</main>
	<!-- /main -->
	
	<?php  include "partials_FOOTER.php" ?>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->
	
	<?php  include "partials_JS.php" ?>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="js/sticky_sidebar.min.js"></script>
	<script src="js/specific_listing.js"></script>
		
</body>
</html>