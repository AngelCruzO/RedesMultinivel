<div class="card card-default color-palette-box card-info card-outline">
	
	<div class="card-header">
		
		<section class="jd-slider slide-plan-compensacion">
			
			<div class="slide-inner">
				
				<ul class="slide-area">
					
					<?php 

					for($i=1;$i<=34;$i++){

						echo '<li>
								<img src="vistas/img/plan-compensacion/diapositivas/'.$i.'.jpg" class="img-fluid">
							  </li><!--./li-->';

					} 

					?>
					

				</ul><!--./ul-->

			</div><!--./slide-inner-->

			<a class="prev" href="#">
              <i class="fas fa-angle-left fa-2x ml-3"></i>
            </a>
            <a class="next" href="#">
              <i class="fas fa-angle-right fa-2x ml-3"></i>
            </a>

            <div class="controller">
            	<a href="#" class="auto">
            		<i class="fas fa-play fa-xs"></i>
            		<i class="fas fa-pause fa-xs"></i>
            	</a>

	            <div class="indicate-area"></div>
	        </div><!--./controller-->

		</section><!--./section-->

	</div><!--./card-header-->

</div><!--./card-->