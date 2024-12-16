

<div class="container">
	<div id="accordion">

		<?php if ($module['section_title']): ?>
			<h2 class="text-center mb-4"><?= $module['section_title'] ?></h2>
		<?php endif ?>

		<?php foreach ($module['accordion_items'] as $key => $accordion): ?>
			
			<div class="card">
				<div class="card-header" id="heading<?= $key ?>">
					<h2 class="mb-0">
						<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
							<?= $accordion['title'] ?>
							<i class="fa fa-chevron-right"></i>
						</button>
					</h2>

				</div>
				<div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>" data-parent="#accordionExample">
					<div class="card-body">
						<?= $accordion['content'] ?>
					</div>
				</div>
			</div>

		<?php endforeach ?>
		


	</div>
</div>



