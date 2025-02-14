<?php if ($args['testimonials']): ?>
<div class="container testimonials">
	<div class="p-45 bg-cream rounded-corners-1">
		<div class="row">
			<div class="col-12 text-center">
				<?php if($args['tag']) : ?>
					<div class="tag bd-gray"><?= $args['tag'] ?></div>	
				<?php else: ?>
					<div class="tag bd-gray">Testimonials</div>
				<?php endif; ?>
				
				<?php if($args['title']) : ?>
					<div class="spacer-xl"></div>
					<h3 class="display-xl mb-0 testimonial-title"><?= $args['title'] ?></h3>
					<div class="spacer-sm"></div>
				<?php endif; ?>

				<div class="spacer-md"></div>
				<img src="<?php bloginfo('template_directory');?>/img/icon-quote.svg" class="d-block mx-auto" alt="">
				<div class="spacer-md"></div>
			</div>

			<div class="col-md-8 px-md-0 mx-auto overflow-hidden">
				<div class="t-slider d-flex">
					<?php foreach ($args['testimonials'] as $t): ?>
						<div class="flex-shrink-0">
							<?= $t['content']; ?>
							<div class="d-flex justify-content-center align-items-center">
								<?php if ($t['author_img']): ?>
								  <img src="<?= $t['author_img']['sizes']['medium']; ?>" class="testimonials-img" alt="<?= $t['author_img']['alt']; ?>">
								<?php endif; ?>
								<div>
									<div class="testimonials-author"><?= $t['author']; ?></div>
									<div class="testimonials-author-title"><?= $t['author_title']; ?></div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/testimonials.css">
<?php endif; ?>