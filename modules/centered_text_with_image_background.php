

<div class="container">

	<div id="centered-text-image-bg" class="rounded-corners-1 d-flex align-items-center justify-content-center text-center size-<?= strtolower($args['size']) ?>">
		
		<img src="<?= $args['background_image']['url'] ?>" alt="">

		<div class="inside p-75 position-relative rounded-corners-2 <?php if($args['add_white_container_around_text']) {echo 'bg-white';} else {echo "bg-dark";} ?>">
			
			<?php if ($args['tag']): ?>
				<div class="tag <?php if(!$args['add_white_container_around_text']) echo 'bd-white' ?>"><?= $args['tag'] ?></div>
				<div class="spacer-xxl"></div>
				<div class="spacer-xl"></div>
			<?php endif ?>

			<?php if ($args['add_white_container_around_text']): ?>
				<p class="text-xl"><?= $args['title'] ?></p>	
			<?php else: ?>
				<h3 class="display-sm mb-3"><?= $args['title'] ?></h3>		
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
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/centered_text_with_image_background.css">