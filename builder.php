<?php if (get_field('section')): ?>

	<?php foreach (get_field('section') as $section_key => $section): ?>

		<section class="
			<?php if ($section['group_padding']) : ?>
				group-padding
				background-color-<?= strtolower(str_replace(' ','-', $section['background_color'])) ?> 
			<?php endif; ?>			
			spacing-top-<?= strtolower($section['spacing_top']) ?> 
			spacing-bottom-<?= strtolower($section['spacing_bottom']) ?>
			<?= $section['spacing_between_modules_within_section'] == 'overlap' ? 'overlap' : NULL ?>
		">

			<div class="section-inside">
				<?php $j = 0;
				if ($section['modules']): ?>

					<?php foreach ($section['modules'] as $module_key => $module): ?>

						<div class="module-wrap">
							<?php
							$module['j'] = $j;
							switch ($module['acf_fc_layout']) {
								case 'hero':
									get_template_part('modules/hero', 'hero', $module);
									break;


								case 'centered_text_with_image_background':
									get_template_part('modules/centered_text_with_image_background', 'hero', $module);
									break;

								case 'gallery':
									get_template_part('modules/gallery', 'gallery', $module);
									break;

								case 'side_by_side':
									get_template_part('modules/side_by_side', 'side_by_side', $module);
									break;

								case 'testimonials':
									get_template_part('modules/testimonials', 'testimonials', $module);
									break;

								case 'media':
									get_template_part('modules/media', 'media', $module);
									break;

								case 'cta':
									get_template_part('modules/cta', 'cta', $module);
									break;

								case 'company':
									get_template_part('modules/company', 'company', $module);
									break;

								case 'events':
									get_template_part('modules/events', 'events', $module);
									break;

								case 'pricing':
									get_template_part('modules/pricing', 'pricing', $module);
									break;

								case 'stats':
									get_template_part('modules/stats', 'stats', $module);
									break;

								case 'timeline':
									get_template_part('modules/timeline', 'timeline', $module);
									break;

								case 'basic_text':
									get_template_part('modules/basic_text', 'basic_text', $module);
									break;

								case 'people':
									get_template_part('modules/people', 'people', $module);
									break;

								case 'media_kit':
									get_template_part('modules/media-kit', 'media-kit', $module);
									break;
							}

							?>
						</div>


						<?php if (count($section['modules']) != ($j + 1)): ?>
							<div class="spacer-<?= $section['spacing_between_modules_within_section'] ?>"></div>
						<?php endif; ?>

					<?php $j++;
					endforeach ?>

				<?php endif ?>

			</div>

		</section>

	<?php endforeach ?>

<?php endif ?>