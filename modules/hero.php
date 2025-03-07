<div id="hero" class="<?= strtolower(str_replace(' ', '-', $args['style'])) ?> <?= strtolower($args["height"]) ?>">

	<div class="container">

		<div class="inside">

			<?php if (isset($args['background_mask'])) : ?>
				<div class="background-mask" style="opacity:<?= $args['background_mask'] ?>%"></div>
			<?php endif; ?>


			<?php if ($args['background_media'] == 'Video') : ?>
				<video id="background-video" playsinline autoplay muted loop data-speed="0.9" width="100%" height="auto"></video>
			<?php endif; ?>

			<?php if ($args['background_media'] == 'Image') : ?>
				<?php if ($args['image']) : ?>
					<img src="<?= $args['image']['sizes']['large'] ?>" class="bg-img" alt="">
				<?php endif; ?>
			<?php endif; ?>





			<?php if ($args['style'] == 'Two Columns'): ?>
				<div class="content-wrap d-flex align-items-end h-100">
					<div class="p-60 position-relative two-columns">
						<div class="row">
							<div class="col-md-7 pr-md-5">

								<?php if ($args['tag']): ?>
									<div class="tag bd-black bg-white mt-5 mt-md-0"><?= $args['tag'] ?></div>
									<div class="spacer-md"></div>
								<?php endif ?>

								<h1 class="<?= $args['title_font_size'] == 'Large' ? 'display-xxl' : 'display-lg' ?> pr-5"><?= $args['title'] ?></h1>
							</div> <!--col-->

							<div class="col-md-4 pl-md-2">

								<?php if ($args['tag']): ?>
									<div class="spacer-md d-none d-md-block"></div>
									<div class="spacer-md"></div>
								<?php endif ?>

								<?php if ($args['subtitle']): ?>
									<h2 class="display-md"><?= $args['subtitle'] ?></h2>
								<?php endif ?>

								<?php if ($args['content']): ?>
									<p><?= $args['content'] ?></p>
								<?php endif ?>

								<?php if ($args['button']): ?>
									<a class="btn btn-primary mr-3" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
										<?= $args['button']['title'] ?>
									</a>
								<?php endif ?>

								<!-- <div class="spacer-sm"></div> -->

								<?php if ($args['button_secondary']): ?>
									<a class="btn btn-secondary" target="<?= $args['button_secondary']['target'] ?>" href="<?= $args['button_secondary']['url'] ?>">
										<?= $args['button_secondary']['title'] ?>
									</a>
								<?php endif ?>
							</div> <!--col-->
						</div> <!--row-->
					</div>
				</div>

				<div class="spacer-lg"></div>
			<?php endif ?>


			<?php if ($args['style'] == 'Centered'): ?>


				<div class="content-wrap p-45 d-flex justify-content-center flex-column align-items-center position-relative h-100 variation-centered">

					<div class="spacer-xxl"></div>
					<div class="spacer-xxl"></div>
					<div class="spacer-xxl"></div>

					<?php if ($args['tag']): ?>
						<div class="tag bd-black bg-white"><?= $args['tag'] ?></div>
						<div class="spacer-lg"></div>
					<?php endif ?>


					<?php if ($args['title']): ?>
						<div class="row w-100">
							<div class="col-md-8 offset-md-2">
								<h1 class="display-xl text-uppercase text-center <?= $args['title_font_size'] == 'Large' ? 'display-xl' : 'display-lg' ?>"><?= $args['title'] ?></h1>
							</div>
						</div>

						<div class="spacer-sm"></div>
					<?php endif ?>

					<?php if ($args['subtitle']): ?>
						<p class="text-xl"><?= $args['subtitle'] ?></p>
					<?php endif ?>


					<?php if ($args['content']): ?>
						<p class="text-xl mb-0"><?= $args['content'] ?></p>
					<?php endif; ?>



					<div class="spacer-lg"></div>

					<div>
						<?php if ($args['button']): ?>
							<a class="btn btn-primary mr-3" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
								<?= $args['button']['title'] ?>
							</a>
						<?php endif ?>

						<!-- <div class="spacer-sm"></div> -->

						<?php if ($args['button_secondary']): ?>
							<a class="btn btn-secondary" target="<?= $args['button_secondary']['target'] ?>" href="<?= $args['button_secondary']['url'] ?>">
								<?= $args['button_secondary']['title'] ?>
							</a>
						<?php endif ?>

					</div>


				</div>
		</div>

	<?php endif; ?>



	</div>

</div>




<?php if (is_front_page()) : ?>
	<div class="spacer-xl"></div>
	<div class="welcome">
		<div class="container">
			<img src="<?php bloginfo('template_directory'); ?>/img/robot-dude.png" class="robot" alt="">
			<img src="<?php bloginfo('template_directory'); ?>/img/welcome-mask.png" class="mask" alt="">
			<div class="bg">
				<img src="<?php bloginfo('template_directory'); ?>/img/austin.jpg" alt="">
			</div>
		</div>
	</div>
<?php endif; ?>



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
		if (video) {

			// Initialize the player with autoplay and loop functionality
			player.initialize(video, url, true);

			// Ensure video is muted and looped
			video.muted = true;
			video.loop = true;
		}
	})();

	$(document).ready(function() {
		$(window).on("scroll", function() {
			var scrollPos = $(window).scrollTop();
			$(".welcome .bg img").css("transform", "translateY(" + scrollPos * 0.3 + "px)");
		});
	});
</script>