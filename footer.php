<footer class="container">
	<div class="p-45 position-relative">
		<div class="row footer-top">
			<img src="<?php bloginfo('template_directory');?>/img/footer.jpg" alt="" class="w-100 h-100">
			<div class="col-12">
				<div class="spacer-lg"></div>
			</div>
			<div class="col-md-2 mb-5 mb-md-0">

				<?php if (get_field('upper_section_content', 'option')): ?>
				  <div class="tag bd-white"><?= get_field('upper_section_content', 'option')['tag']; ?></div>
				<?php endif; ?>

			</div>
			<div class="col-md-8">
				<?php if (get_field('upper_section_content', 'option')): ?>
				  <div class="display-xl"><?= get_field('upper_section_content', 'option')['title']; ?></div>
				<?php endif; ?>

				<div class="spacer-md"></div>
				<?php if (get_field('upper_section_content', 'option')): ?>
				  <p><?= get_field('upper_section_content', 'option')['content']; ?></p>
				<?php endif; ?>
			</div>
			<div class="col-md-2">
				<?php if (get_field('upper_section_content', 'option')): ?>
					<a target="<?= get_field('upper_section_content', 'option')['button']['target']; ?>" href="<?= get_field('upper_section_content', 'option')['button']['url']; ?>" class="btn btn-primary"><?= get_field('upper_section_content', 'option')['button']['title']; ?></a>
				<?php endif; ?>
			</div>
			<div class="col-12">
				<div class="spacer-xxl"></div>
			</div>
		</div>
	</div>
	<div class="p-45 position-relative footer-bottom rounded-corners-1">
		<div class="row">
			<div class="col-12 spacer-xxl d-none d-lg-block"></div>
			<div class="col-lg-2 mb-5 mb-lg-0">			
				<a href="<?php bloginfo('url'); ?>">
					<img src="<?php bloginfo('template_directory');?>/img/logo.png" class="logo" alt="">
				</a>
			</div>
			<div class="col-lg-10">
				<div class="grid">
					
					<?php wp_nav_menu('menu=Footer') ?>

				</div>
			</div>

			<div class="col-12 spacer-xl"></div>

			<div class="col-md-4">

				<?php //if( have_rows('socials', 'option') ): ?>
				<ul class="list-unstyled socials p-0 m-0 d-flex align-items-center mb-4 pb-4 pb-md-1">
<!-- 					
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-x.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-linkedin.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-instagram.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-tiktok.svg'); ?></a></li> -->

    			<?php while( have_rows('socials', 'option') ) : the_row(); $link = get_sub_field('link'); ?>
    			<?php 
    				$img = get_sub_field('icon');
					  if( $link ): 
					    $link_url = $link['url'];
					    $link_title = $link['title'];
					    $link_target = $link['target'] ? $link['target'] : '_self';
					  ?>
						<li>
							<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" aria-label="<?php echo esc_html( $link_title ); ?>">
							<?php echo file_get_contents($img['url']); ?>
						</a>
					</li>
					<?php endif; ?>
				  <?php endwhile; ?>
				</ul>
				
				<div class="d-none d-md-block copy">
					<?= get_field('copyrights', 'option'); ?>
				</div>
			</div>
			<div class="col-md-8">
				<div class="newsletter flex-wrap flex-lg-nowrap rounded-corners-3 text-white d-flex justify-content-between align-items-center">
					<div class="mr-5">
						<?php if (get_field('form_text', 'option')): ?>
						  <h4><?= get_field('form_text', 'option')['title']; ?></h4>
						  <p><?= get_field('form_text', 'option')['content']; ?></p>
					  <?php endif; ?>
					</div>
					<?= do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
				</div>
			</div>
			<div class="col-12 d-block d-md-none mt-5 copy">
				<?= get_field('copyrights', 'option'); ?>
			</div>
		</div>
	</div>
	<div class="spacer-lg"></div>
</footer>



</div> <!-- wrapper -->

<?php get_template_part('notification/notification'); ?> 
<?php wp_footer(); ?>
</body>
</html>