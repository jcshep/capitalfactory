<?php
	$featured = $args['featured'];
	$variant = $args['variant'];
	$m = $args['m'];
	$i = $args['i'];
	$j = $args['j'];
	$k = $args['k'];

	$isVideo = $m['video'] && ($m['type'] == 'video');
	$hasIcon = $m['icon'] && ($variant == 'v3');
	$icon = 'icon-camera.svg';

	switch ($m['type']) {
		case 'img':
			$icon = 'icon-img.svg';
			break;
		case 'podcast':
			$icon = 'icon-podcast.svg';
			break;
		case 'document':
			$icon = 'icon-document.svg';
			break;
	}

	$ratio = $featured ? '56.25%' : '70%'; //v1

	if ($featured == false && ($variant == 'v2')) {
		if ($k == 1 || $k == 3 || $k == 4) {
			$ratio = '100%';
		} else {
			$ratio = '56.25%';
		}
	}
?>

<div class="rounded-corners-4 bg-cream<?= $isVideo ? ' has-video' : ''; ?><?= $hasIcon ? ' has-icon' : ''; ?>">
	<?php if ($hasIcon): ?>
		<div class="position-relative">
		  <img src="<?= $m['icon']['url']; ?>" alt="<?= $m['icon']['alt']; ?>" class="d-block media-item-icon">
		</div>
	<?php elseif ($isVideo): ?>
		<button type="button" class="w-100 img position-relative ratio rounded-corners-4" style="--aspect-ratio: <?= $ratio; ?>" data-toggle="modal" data-target="#modal-<?= $j; ?>-<?= $i; ?>">
			<img src="<?= $m['image']['sizes']['large']; ?>" alt="<?= $m['image']['alt']; ?>" class="d-block media-item-img">
		</button>
	<?php elseif ($m['link'] && ($m['type'] == 'document') || $m['type'] == 'podcast'): ?>
		<a href="<?= $m['link']; ?>" target="_blank" class="img position-relative ratio rounded-corners-4" style="--aspect-ratio: <?= $ratio; ?>">
		  <img src="<?= $m['image']['sizes']['large']; ?>" alt="<?= $m['image']['alt']; ?>" class="d-block media-item-img">
		</a>
	<?php else: ?>
		<div class="img position-relative ratio rounded-corners-4" style="--aspect-ratio: <?= $ratio; ?>">
		  <img src="<?= $m['image']['sizes']['large']; ?>" alt="<?= $m['image']['alt']; ?>" class="d-block media-item-img">
		</div>
	<?php endif; ?>
	<div class="d-flex flex-column flex-sm-row media-item-text">
		<?php if ($variant !== 'v3'): ?>
		  <img src="<?php bloginfo('template_directory');?>/img/<?= $icon; ?>" alt="" width="22" height="22" class="mb-3 mb-md-0">
	  <?php endif; ?>
		<div>
			<h3 class="display-xxl"><?= $m['title']; ?></h3>
			<?php if ($m['content'] && $variant !== 'v3'): ?><div class="text-md"><?= $m['content']; ?></div><?php endif; ?>
		</div>
	</div>
</div>