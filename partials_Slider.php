<div id="carousel-home">
			<div class="owl-carousel owl-theme">
			
				<?php   $cat = mysqli_query($link,"select * from  slider order by orden ASC");
												while($rows = mysqli_fetch_assoc($cat)){
										?>	
			
			
				<div class="owl-slide cover" style="background-image: url(<?=URL?>/images_carousel/<?=$rows["foto"]?>);">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<div class="container">
							<div class="row justify-content-center justify-content-md-end">
								<div class="col-lg-6 static">
									
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<?php } ?>
				<!--/owl-slide-->
				
				
			</div>
			<div id="icon_drag_mobile"></div>
		</div>
		<!--/carousel-->