<?php get_header(); ?>

<div id="page-upper">
	<div class="container">
		<?php if(function_exists('simple_breadcrumb')) {simple_breadcrumb();} ?>
	</div>
</div>



<div id="content">
	<div class="container">
		<div class="spacer-md"></div>
		<?php get_template_part( 'blog/loop', 'index' ); ?>
	</div>
</div>



<?php get_footer(); ?>