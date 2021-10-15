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
	<link href="<?=URL?>/css/checkout.css" rel="stylesheet">
</head>
<body>
	<div id="page">
		
	<?php  include "partials_Header.php" ?>
	<!-- /header -->
	
	<main class="bg_gray">
		<div class="container">
            <div class="row justify-content-center">
				<div class="col-md-5">
					<h1>T&eacute;rminos y condiciones</h1>
					
					<p><?=$informativos["terminos"]?></p>
					
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