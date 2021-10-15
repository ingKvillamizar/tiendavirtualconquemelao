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
	<!-- /header -->
	
	<main class="bg_gray">
	
		
	<div class="container margin_30">
		
		<h1>Preguntas Frecuentes</h1>
		
		<div class="row margin_30">
			<?php   $p=mysqli_query($link,"select * from faq where estatus='si'");
while($row=mysqli_fetch_array($p)){?>
				<div class="col-lg-4 col-md-6">
					<a class="box_topic" href="#0">
						<i class="ti-wallet"></i>
						<h3><?=$row["titulo"]?></h3>
						<p><?=$row["texto"]?></p>
					</a>
				</div>
			<?php }  ?>	
			</div>
	</div>
	<!-- /page_header -->

		<!-- /search-input -->
		
			
			<!--/row-->
		</div>
		<!-- /container -->
		
		<!-- /bg_white -->
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