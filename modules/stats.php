<div class="container stats">
	<div class="p-60 bg-cream pb-0 rounded-corners-1 position-relative">
		<img src="<?php bloginfo('template_directory');?>/img/stats-img.png" alt="">

		<div class="row">
			<div class="col-12 text-center">
				<div class="tag"><?= $args['tag']; ?></div>
				<div class="spacer-xl"></div>
				<h2 class="display-xxl"><?= $args['title']; ?></h2>
				<div class="spacer-xl"></div>
				<?php if ($args['stats']): ?>
					<div class="row stats-grid">
					<?php foreach($args['stats'] as $s): ?>
						<div class="col-md-6 stats-grid-item">
							<div class="rounded-corners-4 p-30 d-flex flex-column align-items-center justify-content-center">
								<div class="gallery-stat-num"><?= $s['number']; ?></div>
								<div class="gallery-stat-desc display-lg"><?= $s['text']; ?></div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="col-md-6 mx-auto text-center">	
				<div class="spacer-md"></div>
				<?= $args['content']; ?>
				<div class="spacer-md"></div>
					<?php if ($args['button']): ?>
						<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
							<?= $args['button']['title'] ?>									
						</a>
					<?php endif ?>
					<div class="spacer-xxl"></div>
					<div class="spacer-xxl d-block d-lg-none"></div>
			</div>
		</div>
	</div>
</div>

	<!-- Style -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/stats.css">