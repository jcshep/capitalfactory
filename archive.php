<?php get_header(); ?>


<div id="page-upper">
	<div class="container">
	</div>
</div>



<div id="content">
	<div class="container">
		<div class="row">

			<div class="col-md-3  order-md-1">
				<?php get_sidebar(); ?>
			</div>

			<div class="col-md-9 order-md-2" id="page-content">

			<?php
				if ( have_posts() )
					the_post();
			?>

						<h1>
							<?php if ( is_day() ) : ?>
								<?php echo( 'Daily Archives: ' . get_the_date()); ?>
							<?php elseif ( is_month() ) : ?>
								<?php echo( 'Archives: ' . get_the_date('F Y')); ?>
							<?php elseif ( is_year() ) : ?>
								<?php echo( 'Archives: ' . get_the_date('Y')); ?>
							<?php else : ?>
								Blog Archives
							<?php endif; ?>
						</h1>

						<hr>			

			<?php 
				rewind_posts();
				 get_template_part( 'loop', 'archive' );
			?>


			</div>

			
		</div>
	</div>
</div>


<?php get_footer(); ?>