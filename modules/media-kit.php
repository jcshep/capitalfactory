<?php if ($args['files']): ?>
<div class="container">
	<div class="p-60 bg-cream rounded-corners-1">
		<div class="row">
			<div class="col-12 text-center">
				<div class="spacer-md"></div>
				<div class="tag"><?= $args['tag']; ?></div>
				<div class="spacer-xl"></div>
			</div>

			<?php foreach ($args['files'] as $f): ?>
				<div class="mb-4 mb-md-0 col-md-4">
					<div class="p-45 bg-white media-kit-item d-flex flex-column justify-content-center align-items-center rounded-corners-4">
						<h3 class="mb-0"><?= $f['title']; ?></h3>
						<div class="spacer-md"></div>
						<?php if ($f['file'] || $f['link']): ?>
							<a 
							 class="btn btn-primary d-flex align-items-center gap-xs"
							 <?php if ($f['blank']): ?> target="_blank"<?php endif; ?>
							 <?php if ($f['download']): ?> download<?php endif; ?>
							 href="<?= ($f['type'] == 'link') ? $f['link'] : $f['file']; ?>"
							> 
							  <img src="<?php bloginfo('template_directory');?>/img/icon-download.svg" alt="">
								<?= $f['button'] ?>									
							</a>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach; ?>

			<div class="col-12 text-center">	
				<div class="spacer-xl"></div>
				<?php if ($args['button']): ?>
					<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
						<?= $args['button']['title'] ?>									
					</a>
				<?php endif ?>
				<div class="spacer-md"></div>
			</div>
		</div>
	</div>
</div>

<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/media-kit.css">
<?php endif; ?>