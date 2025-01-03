<div id="hero">

	<div class="container">

		<?php if ($args['background_media'] == 'Video') : ?>
			<video id="background-video" playsinline autoplay muted loop data-speed="0.9" width="100%" height="auto"></video>
		<?php endif; ?>

		<?php if ($args['background_media'] == 'Image') : ?>
			<img src="<?= $args['image']['sizes']['large'] ?>" class="bg-img" alt="">
		<?php endif; ?>


		<?php if ($args['style'] == 'Two Columns'): ?>
			<div class="p-45 d-flex align-items-end position-relative h-100">
				<div class="row">
					<div class="col-md-7">
						<h1 class="display-xxl"><?= $args['title'] ?></h1>
					</div> <!--col-->
					<div class="col-md-4 pl-0">

						<?php if ($args['subtitle']): ?>
							<h2 class="display-md"><?= $args['subtitle'] ?></h2>
						<?php endif ?>

						<?php if ($args['content']): ?>
							<p><?= $args['content'] ?></p>
						<?php endif ?>

						<?php if ($args['button']): ?>
							<a class="btn btn-primary" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
								<?= $args['button']['title'] ?>
							</a>
						<?php endif ?>
					</div> <!--col-->
				</div> <!--row-->
			</div>

			<div class="spacer-xl"></div>
		<?php endif ?>


		<?php if ($args['style'] == 'Centered'): ?>

			<div class="p-45 d-flex justify-content-center flex-column align-items-center position-relative h-100">

				<?php if ($args['tag']): ?>
					<div class="tag bd-black bg-white"><?= $args['tag'] ?></div>
					<div class="spacer-md"></div>
				<?php endif ?>

				<?php if ($args['content']): ?>
					<div class="row">
						<div class="col-md-8 offset-md-2">
							<h1 class="display-lg text-uppercase text-center"><?= $args['content'] ?></h1>
						</div>
					</div>
				<?php endif ?>

				<?php if ($args['subtitle']): ?>
					<p class="text-xl"><?= $args['subtitle'] ?></p>
				<?php endif ?>
			</div>

		<?php endif; ?>






	</div>

</div>



<!-- Style -->
<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'hero-style', // Handle
		get_template_directory_uri() . '/modules/hero.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/hero.css') // Cache-busting
	);
}
?>



<!-- Scripts -->
<script src="<?php bloginfo('template_directory'); ?>/js/dash.all.min.js"></script>
<script>
	(function() {
		var url = "https://player.vimeo.com/external/1037527479.mpd?s=45f5ec256dd406bfe5a05bb065cc99daf43c83b6&logging=false"; // replace this with your .mpd URL
		var video = document.getElementById("background-video");
		var player = dashjs.MediaPlayer().create();

		// Initialize the player with autoplay and loop functionality
		player.initialize(video, url, true);

		// Ensure video is muted and looped
		video.muted = true;
		video.loop = true;
	})();
</script>