<?php /* Template Name: Events */ ?>

<?php get_header(); ?>

<?php $args = get_fields(); ?>

<div id="hero">
	<div class="container">
		<div class="inside">

			<?php if ($args['img']) : ?>
				<img src="<?= $args['img']['sizes']['large'] ?>" class="bg-img" alt="">
			<?php endif; ?>

			<div class="d-flex flex-wrap h-100 align-items-center justify-content-center text-center">
				<div class="col-12 p-45 py-0 d-flex flex-column justify-content-center align-items-center pb-5">
					<?php if ($args['tag']): ?>
						<div class="tag bg-white text-black"><?= $args['tag']; ?></div>
						<div class="spacer-lg"></div>
					<?php endif; ?>

					<h1 class="display-xxl"><?= $args['title']; ?></h1>
					<div class="spacer-md"></div>
					<div class="bg-cream rounded-corners-5 hero-date text-black"><?= $args['date']; ?> <br class="d-bloc d-sm-none">@ <?= $args['time']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="spacer-xl"></div>

<?php
	$left = get_field('left');
	$right = get_field('right');


	$date_start = $right['date_start'];
	$time_start = $right['time_start'];

	$date_end = $right['date_end'];
	$time_end = $right['time_end'];

	$full_start = $date_start . '' . $time_start;
	$full_end = $date_end . '' . $time_end;

	$timestamp_start = strtotime($full_start);
	$timestamp_end = strtotime($full_end);
?>
<div class="container">
	<div class="bg-cream p-60 rounded-corners-1">
		<div class="spacer-md"></div>
		<div class="row">
			<div class="col-md-7 pr-md-5">
				<div class="tag bd-gray"><?= $left['tag']; ?></div>
				<div class="spacer-lg"></div>
				<h3 class="display-sm"><?= $left['title']; ?></h3>
				<div class="spacer-md"></div>
				<?php if ($left['tags']): ?>
					<ul class="tags gap-xs col-md-10">
						<?php foreach ($left['tags'] as $t): ?>
							<li class="tag bg-white"><?= $t['tag']; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="spacer-md"></div>
				<?= $left['content']; ?>
				<div class="spacer-md"></div>
				<?php if ($left['button']): ?>
					<a class="btn btn-primary" target="<?= $left['button']['target'] ?>" href="<?= $left['button']['url'] ?>">
						<?= $left['button']['title'] ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="col-12 spacer-lg d-block d-md-none"></div>

			<div class="col-md-5">
				<div class="tag bd-gray"><?= $right['tag']; ?></div>
				<div class="spacer-lg"></div>

				<?php if ($right['map']): ?>
					<div class="rounded-corners-3 mb-4 b-orange">
						<img src="<?= $right['map']['sizes']['large']; ?>" alt="<?= $right['map']['alt']; ?>">
					</div>
				<?php endif; ?>

				<p><strong><?= $right['title']; ?></strong></p>
				<p class="events-address d-flex flex-column gap-xxs text-gray">

					<?php if ($right['address']): ?>
						<span class="d-flex align-items-center gap-xs">
							<img src="<?php bloginfo('template_directory'); ?>/img/icon-pin.svg" alt="" width="20" height="20">
							<span><?= $right['address']; ?></span>
						</span>
				  <?php endif; ?>

					<?php if ($right['date_start']): ?>
						<span class="d-flex align-items-center gap-xs">
							<img src="<?php bloginfo('template_directory'); ?>/img/icon-cal.svg" alt="" width="20" height="22">
							<span><?= date("l, F jS", $timestamp_start); ?> <?php if ($right['date_end'] && ($right['date_start'] !== $right['date_end'])) { echo ' - ' . date("l, F jS", $timestamp_end); } ?></span>
						</span>
				  <?php endif; ?>

					<?php if ($right['time_start']): ?>
						<span class="d-flex align-items-center gap-xs">
							<img src="<?php bloginfo('template_directory'); ?>/img/icon-time.svg" alt="" width="20" height="20">
							<span><?= date("g:i a", $timestamp_start); ?> <?php if ($right['time_end'] && ($right['time_start'] !== $right['time_end'])) { echo ' - ' . date("g:i a", $timestamp_end); } ?></span>
						</span>
				  <?php endif; ?>
				</p>

				<div class="d-flex flex-wrap gap-md">
					<a href="<?= make_google_calendar_link($left['title'], $timestamp_start, $timestamp_end, $left['content'], $right['address']); ?>" class="btn primary btn-black">+ Google Calendar</a>

					<?php if ($right['ical']): ?>
						<a href="<?= $right['ical']; ?>" class="btn primary btn-black">ical Export</a>
					<?php endif; ?>
				</div>

			</div>

		</div>
	</div>
</div>

<div class="spacer-xl"></div>


<?php 

$args0 = array(
	'post_type' => array('event'),
	'posts_per_page' => 12,
	'meta_key' => 'date_time',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'fields' => 'ids'
);

$query = new WP_Query($args0);
$posts = $query->posts;

if ($posts):
?>

	<div class="container events v1">
		<div id="events" class="p-60 rounded-corners-1 bg-cream">
			<div class="row align-items-start py-1">
				<div class="col-12">
					<div class="spacer-md"></div>
					<div class="tag bd-gray">Explore more events</div>
					<div class="spacer-lg"></div>
				</div>

				<div class="col-12">
					<div class="e-slider">
						<?php foreach ($posts as $post): ?>
							<?php
							$type = get_field('event_type', $post);

							if ($type == 'Single Event') {
								$start = get_field('date_time', $post);
								$end = get_field('time_end', $post);
							} else {
								$first = get_field('event_series_dates', $post)[0];
								if ($first) {
									$start = $first['event_date_time'];
									$end = $first['event_time_end'];
								}
							}

							if ($start) {
								$date = DateTime::createFromFormat('Y-m-d H:i:s', $start)->format('M. j / g:i A');
							}
							?>
							<div>
								<a href="<?= get_permalink($post); ?>" class="event-item d-block">
									<span class="ratio rounded-corners-4" style="--aspect-ratio: 53%">
										<?php if (get_field('cover_image')): ?>
											<img src="<?= get_field('cover_image')['url']; ?>" alt="">
										<?php endif; ?>
									</span>
									<span class="d-flex flex-column flex-wrap event-item-details">
										<span class="mb-2 d-block event-item-date">
											<?= $start ? $date : '&nbsp'; ?>
											<?php if ($end): ?>
												- <?= $end; ?>
											<?php endif; ?>
										</span>
										<span class="display-lg"><?= get_the_title($post); ?></span>
									</span>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
					<a href="<?= get_post_type_archive_link('event'); ?>" class="btn btn-all btn-primary">View All Events</a>
					<div class="spacer-xl d-none d-md-block"></div>
				</div>
			</div>
		</div>
	</div>

<?php endif; wp_reset_query(); ?>


<div class="spacer-xl"></div>
<?php get_footer(); ?>