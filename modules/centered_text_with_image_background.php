

<div class="container">

	<div id="centered-text-image-bg" class="rounded-corners-1 d-flex align-items-center justify-content-center text-center size-<?= strtolower($args['size']) ?>">
		
		<img src="<?= $args['background_image']['url'] ?>" alt="">

		<div class="inside p-75 position-relative rounded-corners-2 <?php if($args['add_white_container_around_text']) {echo 'bg-white';} else {echo "bg-dark";} ?>">
			
			<?php if ($args['tag']): ?>
				<div class="tag <?php if(!$args['add_white_container_around_text']) echo 'bd-white' ?>"><?= $args['tag'] ?></div>
				<div class="spacer-xxl"></div>
				<div class="spacer-xl"></div>
			<?php endif ?>

			<?php if($args['title_1']) : ?>
				<p class="text-xl title-2 mb-2"><strong><?= $args['title_1'] ?></strong></h2>
			<?php endif; ?>

			<?php if($args['title_2']) : ?>
				<h2 class="display-lg title-1 text-uppercase"><?= $args['title_2'] ?></h2>
			<?php endif; ?>

			<?php if ($args['add_white_container_around_text']): ?>
				<p class="text-xl title-2 mb-3"><strong><?= $args['title'] ?></strong></p>	
			<?php else: ?>
				<h3 class="display-sm title-2 mb-3"><?= $args['title'] ?></h3>		
			<?php endif ?>
			
			
			<p class="text-lg"><?= $args['content'] ?></p>

			<?php if ($args['button']): ?>
				<a class="btn btn-primary" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
					<?= $args['button']['title'] ?>									
				</a>
			<?php endif ?>
		</div>
		


		
	</div>

</div>




<!-- Style -->

<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'centered_text_with_image_background-style', // Handle
		get_template_directory_uri() . '/modules/centered_text_with_image_background.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/centered_text_with_image_background.css') // Cache-busting
	);
}
?>