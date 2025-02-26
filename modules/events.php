<?php
$queried = get_queried_object();
$args0 = array(
	'post_type' => array('event'),
	'posts_per_page' => ($queried->taxonomy == 'event-categories') ? -1 : 12,
	'meta_key' => 'date_time',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'fields' => 'ids'
);
if ($queried->taxonomy == 'event-categories') {
	$args0['tax_query'] = array(
		array(
			'taxonomy' => 'event-categories',
			'field' => 'slug',
			'terms' => $queried->slug,
		)
	);
}

$query = new WP_Query($args0);
$posts = $query->posts;
if ($args['variation'] == 'v1'):
?>

	<div class="container events <?= $args['variation'] ?>">

		<div id="events" class="p-60 rounded-corners-1 bg-cream">
			<div class="row align-items-start py-1">
				<div class="col-12">
					<div class="spacer-md"></div>
					<div class="tag bd-gray"><?= $args['tag']; ?></div>
					<div class="spacer-lg"></div>
				</div>
				<div class="col-md-6 mb-5 pb-md-4">
					<h2 class="display-xl"><?= $args['title']; ?></h2>
				</div>
				<div class="col-md-5 mb-5 pb-md-4 mx-auto">
					<?= $args['content']; ?>
				</div>

				<div class="col-12">
					<div class="e-slider">
						<?php foreach ($posts as $post): ?>
							<?php
							$type = get_field('event_type', $post);

							// if ($type == 'Single Event') {
							// 	$start = get_field('date_time', $post);
							// 	$end = get_field('time_end', $post);
							// } else {
							// 	$first = get_field('event_series_dates', $post)[0];
							// 	if ($first) {
							// 		$start = $first['event_date_time'];
							// 		$end = $first['event_time_end'];
							// 	}
							// }

							$start = get_field('date_time', $post);
							$end = get_field('time_end', $post);

							if ($start) {
								$date = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('M. j / g:i A');
							}

							if ($end) {
								$end_time = DateTime::createFromFormat('H:i:s', $end)->format('g:i A');
							}
							?>
							<div>
								<a href="<?= get_permalink($post); ?>" class="event-item d-block">
									<span class="ratio rounded-corners-4" style="--aspect-ratio: 53%">
										<?php if (get_field('cover_image')): ?>
											<img src="<?= get_field('cover_image')['url']; ?>" alt="">
										<?php else: ?>
											<img src="<?php bloginfo('template_directory'); ?>/img/event-placeholder.jpg" alt="Event placeholder">
										<?php endif; ?>
									</span>
									<span class="d-flex flex-column flex-wrap event-item-details">
										<span class="mb-2 d-block event-item-date">
											<?php if ($start): ?>
												<?= $date; ?>
												<?php if ($end): ?>
													- <?= $end_time; ?>
												<?php endif; ?>
											<?php else: ?>
												&nbsp;
											<?php endif; ?>
										</span>
										<span class="display-lg"><?= get_the_title($post); ?></span>
									</span>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
					<a href="<?php bloginfo("url"); ?>/events" class="btn btn-all btn-primary">View All Events</a>


					<div class="spacer-xl d-none d-md-block"></div>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>


<?php if ($args['variation'] == 'v2'): ?>
	<?php
	$terms = get_terms(array(
		'taxonomy'   => 'event-categories',
		'hide_empty' => true,
		'orderby' => 'name',
	));
	?>
	<div class="container events <?= $args['variation'] ?>">

		<div id="events" class="p-60 rounded-corners-1 bg-cream">
			<div class="row align-items-start py-1">
				<div class="col-12 text-center">
					<div class="spacer-md"></div>
					<div class="tag"><?= $args['tag'] ? $args['tag'] : 'Events'; ?></div>
					<div class="spacer-xl"></div>
					<h2 class="display-xl text-center"><?= $args['title'] ? $args['title'] : 'Upcoming Events'; ?></h2>
					<div class="spacer-xl"></div>
					<?php if ($terms): ?>
						<ul class="grid tags gap-xs tags-light d-flex flex-wrap justify-content-center list-unstyled">
							<li><a href="<?= get_post_type_archive_link('event'); ?>" class="tag<?php if ($queried->taxonomy !== 'event-categories'): ?> is-active<?php endif; ?>">View all</a></li>
							<?php foreach ($terms as $t): ?>
								<li><a href="<?= get_term_link($t, 'event-categories'); ?>" class="tag<?php if ($queried->name == $t->name): ?> is-active<?php endif; ?>"><?= $t->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<!-- <div class="spacer-xl"></div> -->
				</div>
				<?php foreach ($posts as $post):
					$terms = wp_get_post_terms($post, 'event-categories');
					$type = get_field('event_type', $post);

					// if ($type == 'Single Event') {
						$start = get_field('date_time', $post);
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('M j @ g:ia');
					// }
				?>
					<div class="col-md-6">
						<a href="<?= get_permalink($post); ?>" class="event-item event-box-item d-block">
							<span class="row">
								<span class="ratio mb-3 mb-md-0 rounded-corners-4 col-md-6" style="--aspect-ratio: 65%">
									<?php if (get_field('cover_image')): ?>
										<img src="<?= get_field('cover_image')['url']; ?>" alt="">
									<?php else: ?>
										<img src="<?php bloginfo('template_directory'); ?>/img/event-placeholder.jpg" alt="Event placeholder">
									<?php endif; ?>
								</span>
								<span class="col-md-6 px-0 px-md-3 d-flex flex-column">
									<ul class="tags mb-3 tags-light gap-xs d-flex flex-wrap list-unstyled">
										<?php if (get_field('event_series_dates', $post)): ?>
											<li class="tag">Event series</li>
										<?php endif; ?>
										<?php foreach ($terms as $t): ?>
											<li class="tag"><?= $t->name; ?></li>
										<?php endforeach; ?>
									</ul>
									<span class="display-lg mb-3 d-block text-uppercase"><?= get_the_title($post); ?></span>
									<ul class="mt-auto mb-0 hours d-flex gap-xs">
										<?php if ($date): ?><li><?= $date; ?></li><?php endif; ?>
										<li><img src="<?php bloginfo('template_directory'); ?>/img/icon-chevron.svg" class="" alt=""></li>
									</ul>
								</span>
							</span>
						</a>
					</div>
				<?php endforeach; ?>
				<div class="col-12 spacer-md"></div>
				<div class="col-12 d-flex flex-column align-items-center justify-content-center">
					<a href="<?php bloginfo("url"); ?>/events" class="btn btn-all mt-0 btn-primary">View All Events</a>
					<div class="spacer-md"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>





<?php if ($args['variation'] == 'v3'): ?>


	<div class="container events <?= $args['variation'] ?>">

		<div id="events" class="p-60 rounded-corners-1 bg-cream">
			<div class="row align-items-start py-1">
				<div class="col-12 text-center">
					<div class="spacer-md"></div>
					<div class="tag"><?= $args['tag'] ? $args['tag'] : 'Events'; ?></div>
					<div class="spacer-xl"></div>
					<h2 class="display-xl text-center"><?= $args['title'] ? $args['title'] : 'Upcoming Events'; ?></h2>
					<div class="spacer-xl"></div>
				</div>


				<?php
				$args = array(
					'post_type' => 'event',
					'posts_per_page' => 6,
					'meta_key' => 'date_time',
					'orderby' => 'meta_value',
					'order' => 'ASC',
				);
				$the_query = new WP_Query($args);
				$posts = $the_query->posts;
				wp_reset_postdata(); // End loop.

				foreach ($posts as $post):


					$type = get_field('event_type', $post);

					if ($type == 'Single Event') {
						$start = get_field('date_time', $post);
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('M j @ g:ia');
					}
				?>


					<div class="col-md-4">
						<a href="<?= get_permalink($post); ?>" class="event-item d-block">

							<div class="ratio mb-3 mb-md-0 rounded-corners-4" style="--aspect-ratio: 55%">
								<?php if (get_field('cover_image')): ?>
									<img src="<?= get_field('cover_image')['url']; ?>" alt="">
								<?php endif; ?>
							</div>

							<div class="lower">
								<?php if ($date): ?><?= $date; ?><?php endif; ?>

								<span class="display-lg mb-3 d-block text-uppercase"><?= get_the_title($post); ?></span>
							</div>
						</a>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>

<?php endif; ?>

<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/events.css">


