<?php session_start(); include "conex.php";

$informativos=mysqli_fetch_assoc(mysqli_query($link,"select * from _informativos where id=1"));

$detalle=mysqli_fetch_array(mysqli_query($link,"select * from productos where id=".limpiar($link,$_GET["id"]).""));

mysqli_query($link,"update productos set contador=contador+1 where id=".limpiar($link,$_GET["id"])."");


$foto=mysqli_fetch_array(mysqli_query($link,"select * from   productos_imagenes where id_producto=".limpiar($link,$_GET["id"])."  order by orden ASC limit 0,1 "));


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <?php  include "partials_Meta.php" ?>
    <title><?=$informativos["nombre_pagina"]?></title>

    <?php  include "partials_FONTS.php" ?>

	<?php  include "partials_STYLES.php" ?>

	<!-- SPECIFIC CSS -->
    <link href="<?=URL?>/css/product_page.css" rel="stylesheet">

</head>

<body>
	
	<div id="page">
		
	<?php  include "partials_Header.php" ?>
	<!-- /header -->

	<main>
	    <div class="container margin_30">
		
	       
			
<?php  if($detalle["descuento"] > 0){
				
				$fecha_caduca = str_replace("-","/",$detalle["descuento_caduca"]);
				
?>
							
<div class="countdown_inner">-<?=number_format($detalle["descuento"], 0)?>% Descuento. Oferta caduca en <div data-countdown="<?=$fecha_caduca?>" class="countdown"></div>
	        </div>
						<?php 						
						}  ?>
	        <div class="row">
	            <div class="col-md-6">
	                <div class="all">
	                    <div class="slider">
	                        <div class="owl-carousel owl-theme main">
							
							<?php  $images = mysqli_query($link, "SELECT * FROM `productos_imagenes` where id_producto=".$detalle["id"]." order by orden ASC");
									while($rows = mysqli_fetch_assoc($images)){ ?>
									
									<div style="background-image: url(<?=URL?>/items/<?=$rows["foto"]?>);" class="item-box"></div>
										
							<?php		}
							?>
	                            
	                           
	                        </div>
	                        <div class="left nonl"><i class="ti-angle-left"></i></div>
	                        <div class="right"><i class="ti-angle-right"></i></div>
	                    </div>
	                    <div class="slider-two">
	                        <div class="owl-carousel owl-theme thumbs">
							<?php  $images = mysqli_query($link, "SELECT * FROM `productos_imagenes` where id_producto=".$detalle["id"]." order by orden ASC");
							$i = 0;
									while($rows = mysqli_fetch_assoc($images)){ ?>
									
									
									 <div style="background-image: url(<?=URL?>/items/<?=$rows["foto"]?>);" class="item <?php  if($i ==0){echo 'active';} ?>"></div>
										
							<?php		$i++;}
							?>
	                           
	                        </div>
	                        <div class="left-t nonl-t"></div>
	                        <div class="right-t"></div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6">
	                <div class="breadcrumbs">
	                    
	                </div>
	                <!-- /page_header -->
	                <div class="prod_info">
	                    <h1><?=$detalle["nombre_es"]?></h1>
	                   
	                    <p><small>SKU: MTKRY-00<?=$_GET["id"]?></small><br><?=$detalle["descripcion_es"]?></p>
	                    <div class="prod_options">
	                       
	                        <div class="row mt-1">
	                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Presentaci&oacute;n</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
	                                <div class="custom-select-form">
	                                    <select class="wide" id="idTalla">
										
										<?php  $query = mysqli_query($link, "SELECT * FROM `productos_tallas` where id_producto = ".$detalle["id"]." and estatus= 'si' ");

												while($rows = mysqli_fetch_assoc($query)){

													$tallas = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM `tallas` where id=".$rows["id_talla"]." "));
													?>
												
												<option value="<?=$rows["id"]?>"><?=$tallas["nombre_es"]?></option>
													
										<?php 		}
										?>
	                                       
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row ">
	                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Cantidad</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
	                                <div class="numbers-row">
	                                    <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-5 col-md-6">
							<?php 

								$precio = $detalle["precio"]; $dolar=$informativos["dolar"]; $precioF = $precio * $dolar; 
								
								if($detalle["descuento"] > 0){
									
									$precioNew = ($detalle["precio"] - ($detalle["precio"] * $detalle["descuento"]) / 100); $dolar=$informativos["dolar"];
									$precioFWithDescount = 	$precioNew	* $dolar; 	
								}								
								if($detalle["descuento"] > 0){	
							?>
							
							
							
	                            <div class="price_main"><span class="new_price"><?php echo fpreciosD($precioFWithDescount); echo " "; echo $informativos["moneda"];  ?></span><span class="percentage">-<?=number_format($detalle["descuento"], 0)?>%</span> <span class="old_price"><?php echo fpreciosD($precioF); echo " "; echo $informativos["moneda"];  ?></span></div>
								
								<?php  }else{ ?>
									
									<div class="price_main"><span class="new_price"><?php echo fpreciosD($precioF); echo " "; echo $informativos["moneda"];  ?></span></div>
									
								<?php } ?>
								
								
	                        </div>
	                        <div class="col-lg-4 col-md-6">
	                            <div class=""><a href="#0" class="btn_1" 
								
								onClick="addItemToCart(
								<?=$detalle["id"]?>,
								document.getElementById('idTalla').value,
								document.getElementById('quantity_1').value
								)" 
								>A&ntilde;adir al carrito</a></div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /prod_info -->
	               
	               
	            </div>
	        </div>
	        <!-- /row -->
	    </div>
	    <!-- /container -->
	    
	   
	    <!-- /tabs_product -->
	    
	    <!-- /tab_content_wrapper -->

	    <div class="container margin_60_35">
	        <div class="main_title">
	            <h2>Relacionados</h2>
	            <span>Productos</span>
	            <p></p>
	        </div>
	        <div class="owl-carousel owl-theme products_carousel">
			
			
			
			<?php  $p = mysqli_query($link, "SELECT * FROM `productos` where  estatus='si' and id_categoria=".$detalle["id_categoria"]." and id not in(".$detalle["id"].") order by id DESC");
						while($rows= mysqli_fetch_assoc($p)) {
							
							$pic = mysqli_fetch_assoc(mysqli_query($link, "select * from productos_imagenes where id_producto=".$rows["id"]." order by orden ASC limit 0,1"));
							
							$talla = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `productos_tallas` where estatus='si' and id_producto=".$rows["id"]." and stock_actual > stock_inicial order by id ASC limit 0,1"));
							
							$id_talla = $talla["id"];
							
			?>	
			
			
	            <div class="item">
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
							<li><a href="#0" rel="<?=$rows["id"]?>-<?=$id_talla?>" 
							
							onClick="addItemToCart(<?=$rows["id"]?>,<?=$id_talla?>)" 
							
							class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Agregar al carrito</span></a></li>
						</ul>
					</div>
	                <!-- /grid_item -->
	            </div>
				
				 <!-- /item -->
				<?php  } ?>	
	           
	         
	            </div>
	            
	        </div>
	        <!-- /products_carousel -->
	    </div>
	    <!-- /container -->

	    <div class="feat">
			<div class="container">
				<ul>
		<?php   $cat = mysqli_query($link,"select * from  servicios where estatus='si' order by orden ASC");
					while($rows = mysqli_fetch_assoc($cat)){
		?>	
					<li>
						<div class="box">
							<i class="ti-dot"></i>
							<div class="justify-content-center">
								<h3><?=$rows["nombre_es"]?></h3>
							</div>
						</div>
					</li>
		<?php  } ?>			
				</ul>
			</div>
		</div>
		<!--/feat-->

	</main>
	<!-- /main -->
	<?php  include "partials_FOOTER.php" ?>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->

	
	
	
	
	
 	<?php  include "partials_JS.php" ?>
  
    <!-- SPECIFIC SCRIPTS -->
    <script  src="js/carousel_with_thumbs.js"></script>

</body>

</html>
