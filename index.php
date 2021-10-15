<?php session_start(); include "conex.php";
$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include "partials_Meta.php" ?>
    <title><?=$informativos["nombre_pagina"]?></title>

    <?php  include "partials_FONTS.php" ?>

	<?php  include "partials_STYLES.php" ?>

	<!-- SPECIFIC CSS -->
    <link href="<?=URL?>/css/home_1.css" rel="stylesheet">

</head>

<body>
	
	<div id="page">
		
	<?php  include "partials_Header.php" ?>
		
	<main>
		<?php  include "partials_Slider.php" ?>

		<ul id="banners_grid" class="clearfix">
		<?php   $cat = mysqli_query($link,"select * from  categorias order by orden ASC");
					while($rows = mysqli_fetch_assoc($cat)){
		?>			
												
<li>
				<a href="<?=URL?>/listados/<?=url($rows["nombre_es"])?>-<?=$rows["id"]?>.html" class="img_container">
					<img src="<?=URL?>/images/<?=$rows["foto"]?>" data-src="<?=URL?>/images/<?=$rows["foto"]?>" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3><?=$rows["nombre_es"]?></h3>
						<div><span class="btn_1">IR</span></div>
					</div>
				</a>
			</li>												
				<?php 	 }		 ?>
			
			
		</ul>
		<!--/banners_grid -->
		
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Nuevos</h2>
				<span>Productos</span>
				<p></p>
			</div>
			<div class="row small-gutters">
				<?php  $p = mysqli_query($link, "SELECT * FROM `productos` where estatus='si' order by id DESC");
						while($rows= mysqli_fetch_assoc($p)) {
							
							$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$rows["id"]." order by orden ASC limit 0,1"));
							
							$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$rows["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
							$id_talla = $talla["id"];
							
				?>			
					<div class="col-6 col-md-2 col-xl-2" >
					<div class="grid_item" >
						<figure  >
						<?php  if($rows["descuento"] > 0){
						?>
							<span class="ribbon off">-<?=number_format($rows["descuento"], 0)?>%</span>
						<?php 						
						}  ?>
						
							<a href="<?=URL?>/<?=url($rows["nombre_es"])?>-<?=ucfirst($rows["id"])?>.html">
								<img class="img-fluid lazy" src="<?=URL?>/items/<?=$pic["foto"]?>" data-src="<?=URL?>/items/<?=$pic["foto"]?>" alt=""  style="object:fit">
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
							<li><a href="#0" onClick="addItemToCart(<?=$rows["id"]?>,<?=$id_talla?>)" rel="<?=$rows["id"]?>-<?=$id_talla?>"   class="tooltip-1 addToCart"  data-toggle="tooltip" data-placement="left" title="Agregar al carrito"><i class="ti-shopping-cart"></i><span>Agregar al carrito</span></a></li>
						</ul>
					</div>
					<!-- /grid_item -->
				</div>		
							
				<?php		}
				?>
				
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

<?php  $p = mysqli_query($link, "SELECT * FROM `productos` where  estatus='si' and especial='si'   order by id DESC limit 0,1");
						while($rows= mysqli_fetch_assoc($p)) {
							
							$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$rows["id"]." order by orden ASC limit 0,1"));
							
							$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$rows["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
							$id_talla = $talla["id"];
							
?>
		<div class="featured lazy" data-bg="url(<?=URL?>/items/<?=$pic["foto"]?>)">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				<div class="container margin_60">
					<div class="row justify-content-center justify-content-md-start">
						<div class="col-lg-6 wow" data-wow-offset="150">
							<h3><?php echo $rows["nombre_es"]; ?></h3>
							<p><?php echo $rows["descripcion_es"]; ?></p>
							<div class="feat_text_block">
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
									
								</div>
								<a class="btn_1" href="<?=URL?>/<?=url($rows["nombre_es"])?>-<?=ucfirst($rows["id"])?>.html" role="button">Comprar</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->
<?php  }  ?>
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Destacados</h2>
				<span>Productos</span>
				<p></p>
			</div>
			<div class="owl-carousel owl-theme products_carousel">
			
			<?php  $p = mysqli_query($link, "SELECT * FROM `productos` where  estatus='si' and destacado='si'   order by id DESC");
						while($rows= mysqli_fetch_assoc($p)) {
							
							$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$rows["id"]." order by orden ASC limit 0,1"));
							
							$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$rows["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
							$id_talla = $talla["id"];
							
			?>	
				<div class="item">
	                <div class="grid_item">
						<figure  >
						<?php  if($rows["descuento"] > 0){
						?>
							<span class="ribbon off">-<?=number_format($rows["descuento"], 0)?>%</span>
						<?php 						
						}  ?>
						
							<a href="<?=URL?>/<?=url($rows["nombre_es"])?>-<?=ucfirst($rows["id"])?>.html">
								<img class="img-fluid lazy" src="<?=URL?>/items/<?=$pic["foto"]?>" data-src="<?=URL?>/items/<?=$pic["foto"]?>" alt="" style="object:fit">
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
						}else{
							
							
							?>
							
							<span class="new_price"><?php echo fpreciosD($precioF); echo " "; echo $informativos["moneda"];  ?> </span>
						
						<?php }  ?>
							
							<div>Tasa: 1.USD: <?php echo fpreciosD($informativos["dolar"]); echo " "; echo $informativos["moneda"];  ?></div>
							
						</div>
						<ul>
							<li><a rel="<?=$rows["id"]?>-<?=$id_talla?>" onClick="addItemToCart(<?=$rows["id"]?>,<?=$id_talla?>)"  class="tooltip-1 addToCart" data-toggle="tooltip" data-placement="left" title="Agregar al carrito"><i class="ti-shopping-cart"></i><span>Agregar al carrito</span></a></li>
						</ul>
					</div>
	                <!-- /grid_item -->
	            </div>
				<?php }  ?>
				
			</div>
			<!-- /products_carousel -->
		</div>
		<!-- /container -->
		
		<?php include "partials_BRANDS.php"; ?>
		<!-- /bg_gray -->

		<!-- /container -->
	</main>
	<!-- /main -->
		
	<?php  include "partials_FOOTER.php" ?>
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->
	
	<?php  include "partials_JS.php" ?>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="js/carousel-home.min.js"></script>

</body>
</html>