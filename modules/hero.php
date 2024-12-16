


<div id="hero">

	<div class="container">
		
		<video id="background-video" playsinline autoplay muted loop data-speed="0.9" width="100%" height="auto"></video>


			<div class="p-45 d-flex align-items-end position-relative h-100">
				<?php if ($args['style'] == 'Two Columns'): ?>

					<div class="row">
						<div class="col-md-7">
							<h1 class="display-xl"><?= $args['title'] ?></h1>
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

				<?php endif ?>
				<div class="spacer-xl"></div>
			</div>		

		

	</div>

</div>



<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/hero.css">


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