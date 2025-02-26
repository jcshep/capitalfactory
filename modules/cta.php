<div class="container cta">

	<div id="cta" class="p-60 rounded-corners-1 text-white" style="background-color: <?= strtolower($args['bg_color']) ?>">
		<div class="row align-items-start py-1">
			<div class="col-12 spacer-md"></div>
			<div class="col-md-6 <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">
				<h2 class="display-lg pb-4 text-uppercase <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>"><?= $args['title']; ?></h2>
				<?= $args['content']; ?>
			</div>
			<div class="col-md-6 d-flex justify-content-md-end flex-wrap gap-xs">

				<?php if ($args['button_1']): ?>
					<?php if ($args['button_opens_form_modal']) : ?>


						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModal">
							<?= $args['button_1']['title'] ?>
						</button>

						<!-- Modal -->
						<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content ">
									<div class="modal-header">
										<h5 class="modal-title display-lg text-uppercase" id="formModalLabel"><?= $args['button_1']['title'] ?></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?php
										$form_id = $args['gravity_form'];
										if ($form_id && $form_id !== 'none') {
											$escaped_form_id = acf_esc_html($form_id);
											echo do_shortcode("[gravityform id=\"$escaped_form_id\" title=\"false\" description=\"false\" ajax=\"true\" tabindex=\"4\"]");
										}
										?>
									</div>
								</div>
							</div>
						</div>



					<?php else : ?>
						<a class="btn btn-primary" target="<?= $args['button_1']['target'] ?>" href="<?= $args['button_1']['url'] ?>">
							<?= $args['button_1']['title'] ?>
						</a>
					<?php endif ?>

				<?php endif ?>

				<?php if ($args['button_2']): ?>
					<a class="btn btn-primary" target="<?= $args['button_2']['target'] ?>" href="<?= $args['button_2']['url'] ?>">
						<?= $args['button_2']['title'] ?>
					</a>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/cta.css">

