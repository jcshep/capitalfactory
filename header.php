<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php
			global $page, $paged;
			$page_title = get_post_meta($post->ID, 'page_title', true);
			if ($page_title == '') {
				$page_title = single_post_title('', false);
			}
			echo $page_title;
			?></title>

	<meta name="description" content="<?php
										$meta_description = get_post_meta($post->ID, 'meta_description', true);
										if ($meta_description == '') {
											global $post;
											if (is_single()) {
												echo strip_tags(get_the_excerpt($post->ID));
											}
										}
										echo $meta_description;
										?>">

	<link rel="icon" type="image/ico" href="<?php echo bloginfo('url'); ?>/favicon.ico">
	<link rel="icon" href="<?php echo bloginfo('url'); ?>/favicon.ico">

	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0">

	<?php wp_head(); ?>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-40289497-2"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-40289497-2');
		gtag('config', 'G-QK4SDMKK06');
	</script>

	<!-- Facebook Pixel Code -->
	<script>
		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window,
			document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1272155096210234'); // Insert your pixel ID here.
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=1272155096210234&ev=PageView&noscript=1" />
	</noscript>

</head>


<body <?php body_class(); ?>>

	<!-- Back to top button -->
	<a id="button"></a>

	<div class="wrapper">
		<!--Header Section Start -->
		<header>


			<div class="container d-flex align-items-start justify-content-between">

				<a href="<?php bloginfo('url'); ?>" class="logo-container">
					<img src="<?php bloginfo('template_directory'); ?>/img/logo.png" class="logo" alt="">
				</a>

				<?php
				$menu = get_nav_menu_items_hierarchical('primary');
				?>
				<div class="main-menu d-none d-lg-block">
					<ul id="menu-main" class="menu position-relative">
						<?php foreach ($menu as $item): ?>
							<li <?php if ($item['children']): ?> class="has-children" <?php endif; ?>>
								<?php if (!$item['children']): ?>
									<a
										href="<?= $item['url']; ?>"
										target="<?= $item['target'] ? $item['target'] : '_self'; ?>"
										<?php if ($item['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
										<?= $item['title']; ?>
									</a>
								<?php else: ?>
									<a href="<?= $item['url']; ?>"
										<?php if ($item['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
										<?= $item['title']; ?>
										<span class="has-hover-icon"><img src="<?php bloginfo('template_directory'); ?>/img/icon-chevron-down.svg" alt=""></span>
									</a>

									<ul class="sub-menu">
										<li class="sub-menu-left">
											<a href="<?= $item['url']; ?>" <?php if ($item['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
												<?php if (get_field('icon', $item['ID'])): ?>
													<img src="<?= get_field('icon', $item['ID'])['url']; ?>">
												<?php endif; ?>
												<span class="sub-menu-title"><?= get_field('title', $item['ID']) ? get_field('title', $item['ID']) : $item['title']; ?></span>
												<span class="sub-menu-text"><?= $item['text']; ?></span>
											</a>

											<ul class="sub-menu-right">
												<?php foreach ($item['children'] as $child): ?>
													<li>
														<a target="<?= $child['target'] ? $child['target'] : '_self'; ?>" href="<?= $child['url']; ?>" <?php if ($child['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
															<?php if (get_field('icon', $child['ID'])): ?>
																<img src="<?= get_field('icon', $child['ID'])['url']; ?>">
															<?php endif; ?>
															<span class="sub-menu-title"><?= get_field('title', $child['ID']) ? get_field('title', $child['ID']) : $child['title']; ?></span>
															<span class="sub-menu-text"><?= $child['text']; ?></span>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</li>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php //wp_nav_menu( 'menu=Main' ) 
					?>
				</div>

				<div class="menu-right">
					<a href="" class="hamburger btn btn-white btn-md">Menu</a>
					<!-- <a href="" class="btn btn-white search-btn">
						<span class="d-flex align-items-center justify-content-center h-100">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.5236 15.1303L13.5582 11.165C14.2486 10.047 14.666 8.74293 14.666 7.33278C14.666 3.28283 11.3831 0 7.33301 0C3.28293 0 0 3.28283 0 7.33278C0 11.3827 3.28293 14.6656 7.33301 14.6656C8.74321 14.6656 10.0474 14.2482 11.1642 13.5589L15.1308 17.5242C15.4501 17.8329 15.8778 18.0037 16.3218 17.9999C16.7659 17.9962 17.1906 17.818 17.5045 17.504C17.8184 17.1899 17.9964 16.7651 17.9999 16.3211C18.0035 15.8771 17.8325 15.4494 17.5236 15.1303ZM7.33301 12.4093C4.52955 12.4093 2.25631 10.1362 2.25631 7.33278C2.25631 4.5294 4.52955 2.25624 7.33301 2.25624C10.1365 2.25624 12.4097 4.5294 12.4097 7.33278C12.4097 10.1362 10.1365 12.4093 7.33301 12.4093Z" fill="#0B1E15" />
							</svg>
						</span>
					</a> -->
				</div>
			</div>
		</header>

		<?php get_template_part('header-menu-right'); ?>
		<!--Header Section End -->