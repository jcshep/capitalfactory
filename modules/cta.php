<div class="container cta">

	<div id="cta" class="p-60 rounded-corners-1 text-white" style="background-color: <?= strtolower($args['bg_color']) ?>">
		<div class="row align-items-start py-1">
			<div class="col-12 spacer-md"></div>
			<div class="col-md-6">
				<h2 class="display-lg pb-4"><?= $args['title']; ?></h2>
				<?= $args['content']; ?>
			</div>
			<div class="col-md-6 d-flex justify-content-md-end flex-wrap gap-xs">
				<?php if ($args['button_1']): ?>
					<a class="btn btn-primary" target="<?= $args['button_1']['target'] ?>" href="<?= $args['button_1']['url'] ?>">
						<?= $args['button_1']['title'] ?>									
					</a>
				<?php endif ?>
				<?php if ($args['button_2']): ?>
					<a class="btn btn-primary" target="<?= $args['button_2']['target'] ?>" href="<?= $args['button_2']['url'] ?>">
						<?= $args['button_2']['title'] ?>									
					</a>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/cta.css">