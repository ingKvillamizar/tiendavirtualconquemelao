<footer class="revealed">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_1">Acceso directo</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
							<li><a href="<?=URL?>/nosotros">Acerca de nosotros</a></li>
							<li><a href="<?=URL?>/preguntas-frecuentes">Preguntas frecuentes</a></li>
							<li><a href="<?=URL?>/contacto">Contactos</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_2">Categor&iacute;as</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
						<?php   $cat = mysqli_query($link,"select * from  categorias order by orden ASC");
									while($rows = mysqli_fetch_assoc($cat)){
						?>	
							<li><a href="<?=URL?>/listados/<?=url($rows["nombre_es"])?>-<?=$rows["id"]?>.html"><?=$rows["nombre_es"]?></a></li>
							
							<?php } ?>
							
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-target="#collapse_3">Contactos</h3>
					<div class="collapse dont-collapse-sm contacts" id="collapse_3">
						<ul>
							<li><i class="ti-home"></i><?=$informativos["direccion"]?><br>Venezuela</li>
							<li><i class="ti-headphone-alt"></i><?=$informativos["telefono1"]?></li>
							<li><i class="ti-email"></i><a href="#0"><?=$informativos["correo1"]?></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						
					<div class="collapse dont-collapse-sm" id="collapse_4">
						
						
							<h3>S&iacute;guenos</h3>
							<ul>
							
							<?php  $con2=mysqli_query($link,"select * from redes_sociales where estatus='si'");

								 while($row2=mysqli_fetch_assoc($con2)){?>
							
								 <li> <a target="_blank" href="<?=$row2["link"]?>"><i class="ti-<?=strtolower($row2["nombre"])?>"></i></a></li>
								  
								 <?php }	 ?>
							
								
							</ul>
						
					</div>
				</div>
			</div>
			<!-- /row-->
			<hr>
			<div class="row add_bottom_25">
				<div class="col-lg-6">
					<ul class="footer-selector clearfix">
						
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?=URL?>/img/cards_all.svg" alt="" width="198" height="30" class="lazy"></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul class="additional_links">
						<li><a href="<?=URL?>/terminos-condiciones">T&eacute;rminos y condiciones</a></li>
						<li><a href="<?=URL?>/politica-privacidad">Pol&iacute;tica de privacidad</a></li>
						<li><span>© 2021 </span></li>
						 
					</ul>
				</div>
			</div>
			
			<div class="row add_bottom_25">
				<div class="col-lg-12" style="text-align:center">
					<span>website elaborada por <a href="https://tupaginaonline.net.ve">tupaginaonline.net</a> </span>
				</div>
				 
			</div>
			
			
		</div>
	</footer>
	<!--/footer-->