<?php
$variant = $args['variation'];
$img_square = $args['img_square'];
$bg_cream = $args['bg_cream'];
$bg_color = $args['bg_color'];

if ($variant !== 'v6'):
?>



	<div class="container side-by-side <?= $variant; ?><?php if ($img_square): ?> side-by-side-square<?php endif; ?><?php if ($args['image2'] && $args['image']): ?> v5<?php endif; ?>" <?php if ($bg_color): ?> style="--bg: <?= $bg_color; ?>" <?php endif; ?>>



		<?php if ($variant == 'v3'): ?>

			<div class="row">

				<div class="col-md-12 pl-60">
					<?php if ($args['tag']): ?><div class="tag border-0 p-0"><?= $args['tag'] ?></div><?php endif; ?>
					<div class="spacer-md"></div>
				</div>

				<div class="col-md-6 pl-60">
					<h2 class="
						<?= $args['title_font_size'] == 'Large' ? 'display-xl' : 'display-lg' ?> 
						<?= $args['title_font_color'] == 'Light' ? 'text-white' : 'text-dark' ?>
						"><?= $args['title']; ?></h2>
				</div>

				<div class="col-md-5">
					<div class="content pr-5 <?= $args['content_font_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">
						<?= $args['content']; ?>
					</div>
				</div>
			</div>

			<div class="spacer-lg"></div>
		<?php else: ?>





			<div class="<?php if ($variant == 'v4'): ?>row <?php else: ?>grid gap-sm<?php if ($bg_cream): ?> bg-cream rounded-corners-3<?php endif; ?><?php endif; ?>">

				<div class="col-text-container<?php if ($variant == 'v4'): ?> col-md-7<?php endif; ?>">

					<?php if ($variant == 'v4'): ?>
						<div class="spacer-xxl d-none d-md-block"></div>
					<?php endif; ?>

					<div class="
					p-60 rounded-corners-1
					<?php if ($variant == 'v4'): ?> pr-0 <?php endif; ?> 
					col-text d-flex flex-column align-items-start 
					<?php if ($variant == 'v1' || $variant == 'v2' || $variant == 'v5'): ?> bg-cream<?php endif; ?>
				">

						<?php if ($args['tag'] && $variant != 'v4'): ?>
							<div class="tag bd-gray"><?= $args['tag'] ?></div>
							<div class="spacer-xl"></div>
						<?php endif ?>

						<div class="<?php if ($variant !== 'v4'): ?>mt-auto<?php endif ?>">
							<?php if ($args['logo']): ?>
								<img src="<?= $args['logo']['url']; ?>" alt="<?= $args['logo']['alt']; ?>" class="side-by-side-logo mb-4 bg-white rounded-corners-4">
							<?php endif; ?>

							<h3 class="
							<?php if ($variant == 'v4' || $variant == 'v5'): ?>
								display-xl
							<?php else: ?>
								<?= $args['title_font_size'] == 'Large' ? 'display-xl' : 'display-sm' ?> 
							<?php endif; ?> 
							mb-0">
								<?= $args['title']; ?>
							</h3>


							<div class="spacer-md"></div>
							<div class="content">
								<?= $args['content']; ?>
							</div>

							<div class="spacer-sm"></div>

							<div class="d-flex gap-sm flex-wrap">
								<?php if ($args['button']): ?>
									<a class="btn btn-primary btn-big mb-5 mb-md-0<?php if ($variant == 'v4'): ?> btn-outline-white<?php endif; ?>" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
										<?= $args['button']['title'] ?>
									</a>
								<?php endif; ?>
								<?php if ($args['button2']): ?>
									<a class="btn btn-outline btn-big mb-5 mb-md-0<?php if ($variant == 'v4'): ?> btn-outline-white<?php else: ?> btn-outline-yellow<?php endif; ?>" target="<?= $args['button2']['target'] ?>" href="<?= $args['button2']['url'] ?>">
										<?= $args['button2']['title'] ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>


				</div>

				<div class="<?php if ($variant == 'v4'): ?>col-md-5<?php endif; ?><?php if ($bg_cream): ?> p-4<?php endif; ?>">

					<?php if ($args['image']): ?>
						<div class="image-bg h-100 <?php if ($variant !== 'v4' && $variant !== 'v5'): ?> bg-cream<?php endif; ?><?php if ($bg_cream): ?> rounded-corners-3<?php else: ?> rounded-corners-1<?php endif; ?>">
							<img src="<?= $args['image']['url'] ?>" alt="<?= $args['image']['alt'] ?>" class="h-100">

							<?php if ($args['image2']): ?><img src="<?= $args['image2']['url'] ?>" alt="<?= $args['image2']['alt'] ?>" class="h-100"><?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

		<?php endif; ?>

	</div>

<?php else: ?>


	<div class="container v6 side-by-side text-white <?php if (!$args['image']) echo 'no-top-img' ?>">
		<?php if ($args['image']): ?>
			<img src="<?= $args['image']['url'] ?>" alt="<?= $args['image']['alt'] ?>" class="top-img">
		<?php endif; ?>

		<div class="p-60 image-bg pb-0 rounded-corners-1" style="background-color: <?= $args['bg_color'] ?>">

			<div class="row">
				<?php if ($args['content']): ?>
					<?php if ($args['tag']) : ?>
						<div class="col-12">
							<div class="tag  <?= $args['title_font_color'] == 'Light' ? 'text-white bd-white' : 'text-dark bd-dark' ?>"><?= $args['tag'] ?></div>
							<div class="spacer-xl"></div>
						</div>
					<?php endif; ?>

					<div class="col-md-5">
						<?php if ($args['title']): ?>
							<h3 class="display-xl mb-0 <?= $args['title_font_color'] == 'Light' ? 'text-white' : 'text-dark' ?>"><?= $args['title'] ?></h3>
							<div class="spacer-md"></div>
						<?php endif ?>
					</div>
					<div class="col-md-6 ml-auto text-white">
						<div class="<?= $args['content_font_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">
							<?= $args['content'] ?>
						</div>
						<div class="d-flex flex-wrap gap-xs">
							<?php if ($args['button']): ?>
								<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button']['target'] ?>" href="<?= $args['button']['url'] ?>">
									<?= $args['button']['title'] ?>
								</a>
							<?php endif ?>
							<?php if ($args['button2']): ?>
								<a class="btn btn-primary mb-5 mb-md-0" target="<?= $args['button2']['target'] ?>" href="<?= $args['button2']['url'] ?>">
									<?= $args['button2']['title'] ?>
								</a>
							<?php endif ?>
						</div>
					</div>
					<div class="col-12 spacer-xxl d-none d-md-block"></div>
					<div class="col-12 spacer-md d-block d-md-none"></div>
				<?php endif; ?>


				<?php if ($args['lower_section_embed']): ?>
					<div class="w-100">
						<?php echo $args['lower_section_embed']; ?>
						<div class="spacer-md"></div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php endif; ?>




<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'side-by-side-style', // Handle
		get_template_directory_uri() . '/modules/side_by_side.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/side_by_side.css') // Cache-busting
	);
}
?>