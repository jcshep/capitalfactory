<?php get_header(); ?>



<div class="blog" id="upper">
	<div id="page-upper">
		<div class="container">
			<?php //if(function_exists(simple_breadcrumb)) {simple_breadcrumb();} ?>
			<div class="row">
				<div class="col-12">
					<?php get_template_part('blog/part-blog-search'); ?>		
				</div>
			</div>
		  
		</div>
	</div>
	
	<div class="spacer-md"></div>
</div>


<div id="content">
	<div class="container">
		<div id="page-content">
			<?php if ( have_posts() ) : ?>

				<h1>Search Results for: <?php echo get_search_query(); ?></h1>
				<?php get_template_part( 'blog/loop', 'search' ); ?>

			<?php else : ?>

				<h2>Nothing Found</h2>
				<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
				
				<?php get_search_form(); ?>

			<?php endif; ?>
		</div>
		</div>
	</div>
</div>



<?php get_footer(); ?>