<div class="startups">
    <div class="container text-center ">
        <div class="bg-cream rounded-corners-1 p-60">


            <div class="tag bd-gray">Portfolio</div>


            <div class="spacer-xl"></div>

            <div class="row">
                <?php
                $query_args = array(
                    'post_type' => 'startup',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'
                );

                $mentors_query = new WP_Query($query_args);

                if ($mentors_query->have_posts()) :
                    $counter = 0;
                    while ($mentors_query->have_posts()) : $mentors_query->the_post();
                        // Start new row after every 5 mentors
                        if ($counter % 5 == 0 && $counter != 0) {
                            echo '</div><div class="row">';
                        }
                ?>
                        <div class="col-md-15">
                            <a class="startup-card text-left mb-4" href="<?php the_permalink(); ?>">


                                <div class="img-placeholder">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', array('class' => 'startup-thumbnail')); ?>
                                    <?php else : ?>

                                    <?php endif; ?>
                                </div>

                                <h5 class="display-md">PORTFOLIO</h5>
                                <h4 class="startup-name mb-2 display-sm"><?php the_title(); ?></h4>

                                <?php if (get_field('title')) : ?>
                                    <div class="mentor-title text-muted"><?php echo esc_html(get_field('title')); ?></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php
                        $counter++;
                    endwhile;
                    wp_reset_postdata();
                    ?>



                <?php else : ?>
                    <div class="col-12">
                        <p>No startups found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="spacer-xl"></div>

        </div>
    </div>
</div>

<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'startups-style', // Handle
		get_template_directory_uri() . '/modules/startups.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/startups.css') // Cache-busting
	);
}
?>


