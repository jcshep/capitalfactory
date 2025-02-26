<div class="startups">
    <div class="container text-center ">
        <div class="bg-cream rounded-corners-1 p-60">


            <div class="tag bd-gray">Portfolio</div>

            <div class="spacer-lg"></div>

            <div id="filter">
                <div class="row">
                    <?php
                    $industries = get_terms(array('taxonomy' => 'industry', 'hide_empty' => false));
                    $technologies = get_terms(array('taxonomy' => 'startup-technology', 'hide_empty' => false));
                    $funds = get_terms(array('taxonomy' => 'fund', 'hide_empty' => false));
                    ?>
                    <div class="col-md-3 mb-3">
                        <div class="select-wrapper">
                            <select name="industry" id="industry-select" class="form-control btn-primary">
                                <option value="">Select Industry</option>
                                <?php foreach ($industries as $industry) : ?>
                                    <option value="<?php echo esc_attr($industry->slug); ?>"><?php echo esc_html($industry->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="select-wrapper">
                            <select name="technology" id="technology-select" class="form-control btn-primary">
                                <option value="">Select Technology</option>
                                <?php foreach ($technologies as $technology) : ?>
                                    <option value="<?php echo esc_attr($technology->slug); ?>"><?php echo esc_html($technology->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="select-wrapper">
                            <select name="fund" id="fund-select" class="form-control btn-primary">
                                <option value="">Select Fund</option>
                                <?php foreach ($funds as $fund) : ?>
                                    <option value="<?php echo esc_attr($fund->slug); ?>"><?php echo esc_html($fund->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 text-left">
                        <a href="" class="btn btn-primary reset">Reset</a>
                    </div>
                </div>
            </div>

            <div class="spacer-xl"></div>

            <div id="startups-container" class="row">
                <?php
                $query_args = array(
                    'post_type' => 'startup',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'
                );

                $startups_query = new WP_Query($query_args);

                if ($startups_query->have_posts()) :
                    $counter = 0;
                    while ($startups_query->have_posts()) : $startups_query->the_post();
                        // Get taxonomy terms for this startup
                        $startup_industries = get_the_terms(get_the_ID(), 'industry');
                        $startup_technologies = get_the_terms(get_the_ID(), 'startup-technology');
                        $startup_funds = get_the_terms(get_the_ID(), 'fund');
                        
                        // Create arrays of slugs for data attributes
                        $industry_slugs = !empty($startup_industries) && !is_wp_error($startup_industries) ? 
                            wp_list_pluck($startup_industries, 'slug') : [];
                        $technology_slugs = !empty($startup_technologies) && !is_wp_error($startup_technologies) ? 
                            wp_list_pluck($startup_technologies, 'slug') : [];
                        $fund_slugs = !empty($startup_funds) && !is_wp_error($startup_funds) ? 
                            wp_list_pluck($startup_funds, 'slug') : [];
                        

                ?>
                        <div class="col-md-15 startup-item" 
                             data-industries="<?php echo esc_attr(implode(' ', $industry_slugs)); ?>"
                             data-technologies="<?php echo esc_attr(implode(' ', $technology_slugs)); ?>"
                             data-funds="<?php echo esc_attr(implode(' ', $fund_slugs)); ?>">
                            <a class="startup-card text-left mb-4" href="<?php the_permalink(); ?>">
                                <div class="img-placeholder">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', array('class' => 'startup-thumbnail')); ?>
                                    <?php else : ?>
                                        <!-- Placeholder if no image -->
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

    wp_enqueue_script(
        'startups-script', // Handle
        get_template_directory_uri() . '/modules/startups.js', // Path to JS
        array('jquery'), // Dependencies
        filemtime(get_template_directory() . '/modules/startups.js') // Cache-busting
    );
?>



