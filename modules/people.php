<div class="people">
    <div class="container text-center ">
        <div class="bg-cream rounded-corners-1 p-60">
            <?php if ($args['type'] == 'Team') : ?>

                <div class="spacer-md"></div>
                <div class="tag">Our Leadership Team</div>
                <div class="spacer-xl"></div>

                <div class="row">

                    <?php
                    $query_args = array(
                        'post_type' => 'people',
                        'posts_per_page' => -1,
                    );
                    $the_query = new WP_Query($query_args);
                    while ($the_query->have_posts()) : $the_query->the_post();
                    ?>
                        <div class="col mx-auto">
                            <img src="<?= get_field('image')['url'] ?>" alt="">
                            <div class="name"><?php the_title() ?></div>
                            <div class="text-xl"><?= get_field('title') ?></div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata(); // End loop.
                    ?>

                </div>


            <?php endif; ?>


            <?php if ($args['type'] == 'Mentors') : ?>

                <div class="tag">Mentors Search</div>


                <div class="spacer-xl"></div>

                <div class="row">
                    <?php
                    $query_args = array(
                        'post_type' => 'mentor',
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
                                <div class="mentor-card text-center mb-4">
                                    <?php
                                    $avatar = get_field('avatar');
                                    if ($avatar) : ?>
                                        <img src="<?php echo esc_url($avatar['url']); ?>"
                                            alt="<?php echo esc_attr(get_the_title()); ?>"
                                            class="mentor-avatar rounded-circle mb-3">
                                    <?php else : ?>
                                        <div class="mentor-avatar-placeholder rounded-circle mb-3">
                                            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="75" cy="75" r="75" fill="#d6d2c3" />
                                                <path d="M75 80C89.9117 80 102 67.9117 102 53C102 38.0883 89.9117 26 75 26C60.0883 26 48 38.0883 48 53C48 67.9117 60.0883 80 75 80Z" fill="#f3f0e6" />
                                                <path d="M114 120.5C114 108.074 109.732 96.1635 101.73 87.4797C93.7277 78.7959 82.7558 74 71.5 74C60.2442 74 49.2723 78.7959 41.2698 87.4797C33.2674 96.1635 29 108.074 29 120.5V150H114V120.5Z" fill="#f3f0e6" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    <h4 class="mentor-name mb-2"><?php the_title(); ?></h4>
                                    <?php if (get_field('title')) : ?>
                                        <div class="mentor-title text-muted"><?php echo esc_html(get_field('title')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php
                            $counter++;
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="col-12">
                            <p>No mentors found.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="spacer-xl"></div>

            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Style -->
<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'people-style', // Handle
		get_template_directory_uri() . '/modules/people.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/people.css') // Cache-busting
	);
}
?>
