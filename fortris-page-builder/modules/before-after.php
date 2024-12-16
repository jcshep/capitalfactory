
<div class="container">
	<div id="before-after">

		<div class="row">
		
		
			<?php foreach ($module['before_afters'] as $key => $group): ?>

				<?php if (count($module['before_afters']) > 1): ?>
					<div class="col-md-6">
					<?php else: ?>
						<div class="col-md-12">
						<?php endif; ?>

				<?php if ($group['title']): ?>
					<h2 class="mb-2"><?= $group['title'] ?></h2>
				<?php endif ?>

				<?php if ($group['description']): ?>
					<p><?= $group['description'] ?></p>
				<?php endif ?>


				<?php if ($group['style'] == 'Side by Side'): ?>
				
				<div id="side-by-side">
					<div class="row">
						<div class="col-6"><img src="<?= $group['before_image']['url'] ?>" /></div> <!--col-->
						<div class="col-6"><img src="<?= $group['after_image']['url'] ?>" /></div> <!--col-->
					</div> <!--row-->
				</div>

				<?php else: ?>

					<div class="beforeAfter" id="beforeAfter<?= $key ?>">
						<img src="<?= $group['before_image']['url'] ?>" />
						<img src="<?= $group['after_image']['url'] ?>" />
					</div>

					<script>

						$(function(){
							$('#beforeAfter<?= $key ?>').beforeAfter();
						});

					</script>

				<?php endif ?>

				

				</div> <!--col-->
			<?php endforeach ?>
			
			

		</div>

				
	</div>
</div>


