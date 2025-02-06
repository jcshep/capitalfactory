<div class="container pricing">
	<div class="p-60 image-bg bg-cream pb-0 rounded-corners-1">
		<?php if ($args['background_image']): ?><img src="<?= $args['background_image']['url'] ?>" alt="<?= $args['background_image']['alt'] ?>"><?php endif; ?>

		<div class="row">
			<div class="col-12 text-center text-white">
				<div class="tag bd-white text-white"><?= $args['tag']; ?></div>
				<div class="spacer-xl"></div>
				<h2 class="display-xxl text-cream"><?= $args['title']; ?></h2>
				<div class="spacer-xl"></div>
			</div>
			<?php if ($args['repeater']): ?>
				<div class="col-12 grid gap-md">
					<?php foreach($args['repeater'] as $r): ?>
						<div class="rounded-corners-3 w-100 p-30" style="background-color: <?= $r['bg_color']; ?>">
							<?php if ($r['img']): ?><img src="<?= $r['img']['url'] ?>" alt="<?= $r['img']['alt'] ?>"><?php endif; ?>
							<div class="spacer-md"></div>
							<h3 class="display-lg mb-0 text-center"><?= $r['title']; ?></h3>
							<div class="spacer-md"></div>
							<?= $r['content']; ?>
							<?php if ($r['price']): ?>
								<div class="text-center">
								  <small>Starting at</small>
								  <div class="price"><?= $r['price']; ?><span><?= $r['per']; ?></span></div>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="col-12 text-center">	
				<div class="spacer-xl"></div>
					<?php if ($args['button']): ?>
						<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
							<?= $args['button']['title'] ?>									
						</a>
					<?php endif ?>
					<div class="spacer-xxl"></div>
			</div>
		</div>
	</div>
</div>

	<!-- Style -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/pricing.css">