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
		<div class="w-100 img position-relative ratio rounded-corners-4 video-container" style="--aspect-ratio: <?= $ratio; ?>">
			<div class="video-placeholder" onclick="playVideo(this, '<?= esc_attr(htmlspecialchars($m['video'], ENT_QUOTES, 'UTF-8')); ?>')">
				<img src="<?= $m['image']['sizes']['large']; ?>" alt="<?= $m['image']['alt']; ?>" class="d-block media-item-img">
				<div class="play-button">
					<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="50" height="50" rx="25" fill="white" />
						<path d="M35 25L20 33.6603L20 16.3397L35 25Z" fill="#000000" />
					</svg>
				</div>
			</div>
			<div class="video-embed" style="display: none;"></div>
		</div>

		<script>
			function playVideo(button, videoHTML) {
				const container = button.closest('.video-container');
				const placeholder = container.querySelector('.video-placeholder');
				const videoEmbed = container.querySelector('.video-embed');

				// Set the video HTML
				videoEmbed.innerHTML = decodeURIComponent(videoHTML);

				// Hide placeholder, show video
				placeholder.style.display = 'none';
				videoEmbed.style.display = 'block';

				// If it's a YouTube or Vimeo iframe, try to autoplay
				const iframe = videoEmbed.querySelector('iframe');
				if (iframe) {
					let src = iframe.getAttribute('src');
					if (src.indexOf('?') > -1) {
						src += '&autoplay=1';
					} else {
						src += '?autoplay=1';
					}
					iframe.setAttribute('src', src);
				}
			}
		</script>

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
			<img src="<?php bloginfo('template_directory'); ?>/img/<?= $icon; ?>" alt="" width="22" height="22" class="mb-3 mb-md-0">
		<?php endif; ?>
		<div>
			<h3 class="display-xl"><?= $m['title']; ?></h3>
			<?php if ($m['content']): ?><div class="text-md"><?= $m['content']; ?></div><?php endif; ?>
		</div>
	</div>
</div>





