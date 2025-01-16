<?php $j = $args['j']; ?>
<div class="container media<?php if ($args['text_color'] == 'light'): ?> text-white<?php endif; ?> <?= $args['variant']; ?>" id="section<?= $j; ?>">


	<div class="<?= ($args['variant'] == 'v1') ? 'p-45' : 'p-60'; ?> rounded-corners-1 w-100" style="background-color: <?= $args['bg_color']; ?>">

		<?php if (($args['variant'] == 'v1') || ($args['variant'] == 'v2')): ?>
			<div class="spacer-lg mb-1"></div>
		<?php else: ?>
			<div class="spacer-md"></div>
		<?php endif; ?>

		<div class="row">
			<?php if ($args['variant'] == 'v3'): ?>
				<div class="col-12">
					<div class="tag bd-gray"><?= $args['tag']; ?></div>
					<div class="spacer-xl"></div>
				</div>
				<div class="col-md-6">
					<h2 class="display-xl"><?= $args['title']; ?></h2>
				</div>
				<div class="col-md-6 pl-md-5">
					<?php if ($args['content']): ?>
						<div class="text-xl lh-1-4<?php if ($args['text_color'] == 'dark'): ?> text-gray<?php endif; ?>">
							<?= $args['content']; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="spacer-lg mb-1 col-12"></div>

				<?php if ($args['subtitle']): ?>
				  <div class="text-center col-12">
				  	<h3 class="subtitle"><?= $args['subtitle']; ?></h3>
				  </div>
				  <div class="col-12 spacer-md mb-1"></div>
			  <?php endif; ?>

			<?php else: ?>
				<div class="col-md-9 mx-auto text-center">
					<div class="tag<?php if ($args['text_color'] == 'light'): ?> bd-light<?php endif; ?>"><?= $args['tag']; ?></div>
					<div class="spacer-xl"></div>
					<h2 class="display-xl"><?= $args['title']; ?></h2>
					<?php if ($args['content']): ?>
						<div class="spacer-md"></div>
						<div class="px-0 col-md-6 mx-auto text-xl lh-1-4">
							<?= $args['content']; ?>
						</div>
					<?php endif; ?>
					<div class="spacer-xl"></div>
				</div>
			<?php endif; ?>

			<?php if ($args['media']): ?>
				<?php $i = 0; foreach ($args['media'] as $m): ?>
					<?php if ($m['featured']): ?>
						<div class="col-12 media-item featured">
							<?php get_template_part('modules/media-item', null, array('featured' => true, 'm' => $m, 'i' => $i, 'j' => $j, 'variant'=> $args['variant'])); ?>	
						</div>
						<div class="spacer-xl d-none d-md-block col-12"></div>
						<div class="modal pr-0 fade" id="modal-<?= $j; ?>-<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title-<?= $j; ?>-<?= $i; ?>" aria-hidden="true">
						  <div class="modal-dialog modal-dialog-centered" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="modal-title-<?= $j; ?>-<?= $i ?>"><?= $m['title']; ?></h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	<div class="ratio" style="--aspect-ratio: 56.25%">
						      		<?= $m['video']; ?>
						      	</div>
						      </div>
						    </div>
						  </div>
						</div>
					<?php endif; ?>
				<?php $i++; endforeach; ?>

				<div class="col-12">
					<div class="<?php if ($args['variant'] !== 'v3'): ?>masonry d-flex flex-wrap <?php else: ?>grid <?php endif; ?>position-relative">
						<?php $i = 0; $k = 0; foreach ($args['media'] as $m): ?>
							<?php if (!$m['featured']): ?>

								<?php if ($i == 0 && ($args['variant'] !== 'v3')): ?><div class="media-item-sizer col-md-6 col-lg-4"></div><?php endif; ?>

								<div class="media-item<?php if ($args['variant'] !== 'v3'): ?> col-md-6 col-lg-4<?php else: ?> mb-0 px-0<?php endif; ?>">
									<?php get_template_part('modules/media-item', null, array('featured' => false, 'm' => $m, 'i' => $i, 'j' => $j, 'variant'=> $args['variant'], 'k' => $k )); ?>	
									<?php if ($m['video'] && ($m['type'] == 'video')): ?>
									<div class="modal pr-0 fade" id="modal-<?= $j; ?>-<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title-<?= $j; ?>-<?= $i; ?>" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="modal-title-<?= $j; ?>-<?= $i ?>"><?= $m['title']; ?></h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									      	<div class="ratio" style="--aspect-ratio: 56.25%">
									      		<?= $m['video']; ?>
									      	</div>
									      </div>
									    </div>
									  </div>
									</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php $i++; $k++; if ($k >= 6) { $k = 0;} endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($args['variant'] == 'v3'): ?>
				<div class="spacer-sm col-12"></div>
			<?php endif; ?>

			<div class="col-12 mt-5 gap-sm d-flex flex-column flex-sm-row justify-content-center align-items-center">
				<?php if ($args['btn_primary']): ?>
					<a href="<?= $args['btn_primary']['url']; ?>" target="<?= $args['btn_primary']['target']; ?>" class="btn btn-primary"><?= $args['btn_primary']['title']; ?></a>
				<?php endif; ?>
				<?php if ($args['btn_secondary']): ?>
					<a href="<?= $args['btn_secondary']['url']; ?>" target="<?= $args['btn_secondary']['target']; ?>" class="btn btn-secondary"><?= $args['btn_secondary']['title']; ?></a>
				<?php endif; ?>
			</div>
			<div class="col-12 spacer-md"></div>

		</div>
	</div>
</div>


	<!-- Style -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/media.css">
	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
	<script>
		(function() {
			var grid = document.querySelector('#section<?= $j; ?> .masonry');
			if (grid) {
				var msnry = new Masonry( grid, {
				  itemSelector: '.media-item',
				  // columnWidth: '.media-item-sizer',
				 // gutter: 34
				});
			}
		})();
	</script>