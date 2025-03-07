<div class="container gallery">
	<div class="p-60 image-bg bg-cream pb-0 rounded-corners-1">
		<img src="<?= $args['background_image']['url'] ?>" alt="<?= $args['background_image']['alt'] ?>">

		<div class="row">

			<?php if ($args['gallery']): ?>
				<div class="col-12 position-relative z-2">
					<div class="slider">
						<?php foreach ($args['gallery'] as $img): ?>
							<div class="slide rounded-corners-2">
								<img src="<?= $img['sizes']['large']; ?>" alt="<?= $img['url']; ?>">
							</div>
						<?php endforeach; ?>
					</div>
					<div class="spacer-xxl d-none d-lg-none"></div>
					<div class="spacer-xxl"></div>
					<div class="spacer-md"></div>
				</div>
			<?php endif; ?>

			<?php if ($args['content']): ?>
				<div class="col-12">
					<div class="tag bd-gray"><?= $args['tag'] ?></div>
					<div class="spacer-xl"></div>
				</div>
				<div class="col-md-5">
					<?php if ($args['title']): ?>
						<h3 class="display-xl mb-0"><?= $args['title'] ?></h3>
						<div class="spacer-xl"></div>
					<?php endif ?>
					<?php if ($args['button']): ?>
						<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
							<?= $args['button']['title'] ?>
						</a>
					<?php endif ?>
				</div>
				<div class="col-md-6 ml-auto">
					<?= $args['content'] ?>
				</div>
			<?php endif; ?>

			<?php if ($args['show_stats']): ?>
				<div class="col-12 spacer-xl"></div>
				<?php foreach ($args['stats'] as $s): ?>
					<div class="col-md-4 gallery-stat">
						<div class="rounded-corners-4 bg-white p-30">
							<div class="gallery-stat-num display-xl "><?= $s['number']; ?></div>
							<div class="gallery-stat-desc display-lg"><?= $s['text']; ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="col-12">
				<div class="spacer-xxl d-none d-md-block"></div>
				<div class="spacer-md d-block d-md-none"></div>
			</div>
		</div>
	</div>
</div>



<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'gallery-style', // Handle
		get_template_directory_uri() . '/modules/gallery.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/gallery.css') // Cache-busting
	);
}
?>