<?php
$menu = get_nav_menu_items_hierarchical('overlay');
?>
<div class="nav">
	<div class="nav-scroller">
		<div class="container pb-4">
			<div class="nav-row">
				<?php foreach ($menu as $item): ?>
					<ul>
						<li>
							<a
								href="<?= $item['url']; ?>"
								target="<?= $item['target'] ? $item['target'] : '_self'; ?>"
								<?php if ($item['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
								<?= $item['title']; ?>
							</a>

							<?php if ($item['children']): ?>
								<ul class="sub-menu">
									<?php foreach ($item['children'] as $child): ?>
										<li>
											<a target="<?= $child['target'] ? $child['target'] : '_self'; ?>" href="<?= $child['url']; ?>" <?php if ($child['object_id'] == get_the_ID()): ?> aria-current="page" <?php endif; ?>>
												<?php if (get_field('icon', $child['ID'])): ?>
													<img src="<?= get_field('icon', $child['ID'])['url']; ?>">
												<?php endif; ?>
												<span class="sub-menu-title"><?= get_field('title', $child['ID']) ? get_field('title', $child['ID']) : $child['title']; ?></span>
											</a>
										</li>
									<?php endforeach; ?>

								</ul>
							<?php endif; ?>

						</li>
					</ul>
				<?php endforeach; ?>

				<?php
				$menu_id = get_nav_menu_locations()['overlay'];
				if ($menu_id):
				?>
					<a href="<?= get_field('box_link', 'menu_' . $menu_id)['url']; ?>" target="<?= get_field('box_link', 'menu_' . $menu_id)['target']; ?>" class="nav-box d-flex align-items-end">
						<?php if (get_field('box_img', 'menu_' . $menu_id)): ?>
							<img src="<?= get_field('box_img', 'menu_' . $menu_id)['sizes']['large']; ?>" alt="<?= get_field('box_img', 'menu_' . $menu_id)['alt']; ?>">
						<?php endif; ?>
						<span>
							<span class="nav-box-date"><?= get_field('box_date', 'menu_' . $menu_id); ?></span>
							<span class="nav-box-title"><?= get_field('box_title', 'menu_' . $menu_id); ?></span>
						</span>
						<span class="nav-box-cat"><?= get_field('box_cat', 'menu_' . $menu_id); ?></span>
					</a>
				<?php endif; ?>

			</div>
		</div>
		<div class="container d-flex flex-wrap flex-column flex-md-row gap-sm align-items-md-center justify-content-between pb-4">
			<?php //if( have_rows('socials', 'option') ): 
			?>
			<ul class="socials d-flex list-unstyled mb-0">
				<?php while (have_rows('socials', 'option')) : the_row();
					$link = get_sub_field('link'); ?>
					<?php
					$img = get_sub_field('icon');
					if ($link):
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
					?>
						<li>
							<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" aria-label="<?php echo esc_html($link_title); ?>">
								<?php echo file_get_contents($img['url']); ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endwhile; ?>

				<?php //while( have_rows('socials', 'option') ) : the_row(); $link = get_sub_field('link'); 
				?>
				<?php
				// $img = get_sub_field('icon');
				// if( $link ): 
				//   $link_url = $link['url'];
				//   $link_title = $link['title'];
				//   $link_target = $link['target'] ? $link['target'] : '_self';
				?>
				<!-- <li><a href="<?php // echo esc_url( $link_url ); 
									?>" target="<?php // echo esc_attr( $link_target ); 
																					?>" aria-label="<?php // echo esc_html( $link_title ); 
																																			?>"><?php // echo file_get_contents($img['url']); 
																																														?></a></li> -->
				<?php //endwhile; 
				?>
			</ul>
			<?php //endif; 
			?>
			<div class="nav-copy copy">
				<?= get_field('copyrights', 'option'); ?>
			</div>
		</div>
	</div>
</div>