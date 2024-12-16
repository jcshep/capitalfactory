


<?php if (get_field('section')): ?>
	
	<?php foreach (get_field('section') as $section_key => $section): ?>
		
		<section class="spacing-top-<?= strtolower($section['spacing_top']) ?> spacing-bottom-<?= strtolower($section['spacing_bottom']) ?>">

		<?php if ($section['modules']): ?>

			<?php foreach ($section['modules'] as $module_key => $module): ?>
				
			

			<?php  
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

				}

			?>

			<!-- Section between spacing -->
			<?php if ($section['modules'] > 1): ?>
				<div class="spacer-<?= $section['spacing_between_modules_within_section'] ?>"></div>
			<?php endif ?>

			<?php endforeach ?>
		
		<?php endif ?>

		

		</section>

	<?php endforeach ?>

<?php endif ?>