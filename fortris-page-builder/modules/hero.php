


<div id="hero">
	<img src="<?= $module['hero_image'] ?>" class="bg <?= strtolower($module['hero_size']) ?>" alt="">

	<?php if ($module['include_hero_text_overlay']): ?>
		
		<div class="title text-center">
			<h1 style="color:<?= $module['title_color'] ?>"><?= $module['title'] ?></h1>
		</div>

	<?php endif ?>

</div>