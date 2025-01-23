<div class="container timeline">
	<?php if ($args['background_image']): ?>
	  <img src="<?= $args['background_image']['url'] ?>" alt="<?= $args['background_image']['alt'] ?>">
  <?php endif; ?>

	<div class="p-60 image-bg bg-gray pb-0 rounded-corners-1">

		<div class="row">
			<?php if ($args['content']): ?>
				<div class="col-12">
					<div class="tag bd-gray"><?= $args['tag'] ?></div>
					<div class="spacer-xl"></div>
				</div>
				<div class="col-md-5">
					<?php if ($args['title']): ?>
						<h3 class="display-xl mb-0"><?= $args['title'] ?></h3>		
						<div class="spacer-md"></div>
					<?php endif ?>
					<?php if ($args['button']): ?>
						<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
							<?= $args['button']['title'] ?>									
						</a>
					<?php endif ?>
				</div>
				<div class="col-md-6 ml-auto text-gray">
					<?= $args['content'] ?>
				</div>
				<div class="col-12 spacer-md"></div>
			<?php endif; ?>



			<?php if ($args['timeline']): ?>
				<div class="col-12 position-relative z-2">
					<div class="slider-timeline">
						<?php foreach($args['timeline'] as $img): ?>
							<div class="slide">
								<div class="slide-year"><span class="bg-gray"><?= $img['year'] ? $img['year'] : '&nbsp;'; ?></span></div>
								<img src="<?= $img['image']['sizes']['large']; ?>" alt="<?= $img['image']['url']; ?>" class="rounded-corners-2 mb-3">
								<div class="slide-text"><?= $img['text']; ?></div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="spacer-xxl"></div>
					<div class="spacer-md"></div>
					<div class="spacer-md"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

	<!-- Style -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/timeline.css">