<?php if(get_field('page_creator')): foreach (get_field('page_creator') as $key => $module): ?>
	
	<div id="fortris-page-builder">
	<?php  
		switch ($module['acf_fc_layout']) {
	
			case 'content_block':
				include 'modules/content.php';
				break;

			case 'form_module':
				include 'modules/form.php';
				break;

			case 'callout_box':
				include 'modules/callout.php';
				break;

			case 'accordion':
				include 'modules/accordion.php';
				break;

			case 'hero':
				include 'modules/hero.php';
				break;

			case 'before_after':
				include 'modules/before-after.php';
				break;

		}
	?>

	</div>

<?php  endforeach; endif; ?>