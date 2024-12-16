
<?php if ($module['title']|| $module['content']): ?>
	

<div 
	id="content" 
	class="<?= $module['text_color'] ?>" 
	style="
		<?php if ($module['background_image']): ?>background-image:url("<?= $module['background_image']?>")<?php endif; ?>
		<?php if ($module['background_color']): ?>background-color:<?= $module['background_color']?><?php endif; ?>
		">
	<div class="container">

		<?php if ($module['include_side_image']): ?>
			
			<div class="row align-items-center">

				<div class="<?= $module['constrain_media'] ? 'col-md-6' :'col-md-7' ?> order-2 <?php if ($module['image_on_left_or_right'] == 'Left'): echo 'order-md-2'; else: echo 'order-md-1'; endif; ?>">

					<?php if ($module['title']): ?>
						<h2><?= $module['title'] ?></h2>	
					<?php endif ?>
					
					
					<?= $module['content'] ?>

					<?php if ($module['include_cta_button']): ?>
						<div class="spacer-md"></div>
						<div>
							<a href="<?= $module['cta']['url'] ?>" class="btn btn-primary">
								<?= $module['cta']['title'] ?> <i class="fa fa-chevron-right"></i>
							</a>
						</div>
					<?php endif ?>
				</div> <!--col-->


				<div class="col <?= $module['constrain_media'] ? 'constrain' : '' ?> order-1  <?php if ($module['image_on_left_or_right'] == 'Left'): echo 'order-md-1'; else: echo 'order-md-2';  endif; ?>">
					
					<?php if ($module['media_type'] == 'Video'): ?>
						<div class="embed-responsive embed-responsive-16by9">
							<?= $module['video_embed'] ?>
						</div>

					<?php else: ?>
						<img class="side-image <?= strtolower($module['side_image_size']) ?> <?php if ($module['image_on_left_or_right'] == 'Left'): echo 'left'; else: echo 'right'; endif; ?>" src="<?= $module['side_image'] ?>" alt="><?= $module['title'] ?>">	
					<?php endif ?>

					
				</div> <!--col-->


			</div> <!--row-->



		<?php else: ?>

			<?php if ($module['title']): ?>
				<h2><?= $module['title'] ?></h2>	
			<?php endif ?>
			

			<?= $module['content'] ?>

			<?php if ($module['include_cta_button']): ?>
				<div>
					<a href="<?= $module['cta']['url'] ?>" class="btn btn-primary">
						<?= $module['cta']['title'] ?> <i class="fa fa-chevron-right"></i>
					</a>
				</div>
			<?php endif ?>

		<?php endif ?>

	</div>

</div>

<?php endif ?>




<?php if ($module['include_grid_modules'] && $module['module']): ?>

	<?php if ($module['constrain_grid_modules']): ?>
		<div class="container">
	<?php else: ?>
		<div class="container-fluid">
	<?php endif ?>		




	<div id="modules" class="interior">
			<div class="row">

				<?php 
					$column_class = 'col-md-4';
					if(count($module['module']) == '4') 
						$column_class = 'col-md-3';
				?>

				<?php foreach ($module['module'] as $key => $grid_module): ?>

					<div class="<?= $column_class ?>">
						<div class="module">
							<div class="icon mb-3">
								<?php if ($grid_module['icon']): ?>																			
									<img src="<?= $grid_module['icon'] ?>" alt="<?= $grid_module['title'] ?>">
								<?php endif ?>
							</div>
							<h3><?= $grid_module['title'] ?></h3>
							<p><?= $grid_module['content'] ?></p>
							<?php if ($grid_module['url'] ): ?>
								<a href="<?= $grid_module['url'] ?>">Learn More <i class="fa fa-chevron-right"></i></a>	
							<?php endif ?>							
						</div>
					</div> <!--col-->

				<?php endforeach ?>


			</div> <!--row-->
		</div>

	</div>
<?php endif ?>



<?php 
// echo '<pre>';
// var_dump($module);
// echo '</pre>'; 
?>