<div class="people" id="people-anchor">
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

                <div class="spacer-lg"></div>

                <div id="filter">
                    <div class="d-flex flex-md-nowrap flex-wrap justify-content-center">
                        <?php
                        $industries = get_terms(array('taxonomy' => 'mentor-industry', 'hide_empty' => false));
                        $technologies = get_terms(array('taxonomy' => 'mentor-technology', 'hide_empty' => false));
                        $mentor_specialty = get_terms(array('taxonomy' => 'mentor-specialty', 'hide_empty' => false));
                        $product_type = get_terms(array('taxonomy' => 'mentor-product-type', 'hide_empty' => false));
                        ?>
                        <!-- <div class="mb-3 mr-3">
                            <div class="select-wrapper">
                                <select name="industry" id="industry-select" class="form-control btn-primary">
                                    <option value="">Select Industry</option>
                                    <?php foreach ($industries as $industry) : ?>
                                        <option value="<?php echo esc_attr($industry->slug); ?>"><?php echo esc_html($industry->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="mb-3 mr-3">
                            <div class="select-wrapper">
                                <select name="technology" id="technology-select" class="form-control btn-primary">
                                    <option value="">Select Technology</option>
                                    <?php foreach ($technologies as $technology) : ?>
                                        <option value="<?php echo esc_attr($technology->slug); ?>"><?php echo esc_html($technology->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 mr-3">
                            <div class="select-wrapper">
                                <select name="product_type" id="product-type-select" class="form-control btn-primary">
                                    <option value="">Select Product Type</option>
                                    <?php foreach ($product_type as $type) : ?>
                                        <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 mr-3">
                            <div class="select-wrapper">
                                <select name="specialty" id="specialty-select" class="form-control btn-primary">
                                    <option value="">Select Specialty</option>
                                    <?php foreach ($mentor_specialty as $mentor_specialty) : ?>
                                        <option value="<?php echo esc_attr($mentor_specialty->slug); ?>"><?php echo esc_html($mentor_specialty->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a href="" class="btn btn-primary reset">Reset</a>
                        </div>
                    </div>
                </div>

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

                    ?>
                            <div class="col-md-15">
                                <?php
                                // Get taxonomy terms for this mentor
                                $mentor_industries = get_the_terms(get_the_ID(), 'industry');
                                $mentor_technologies = get_the_terms(get_the_ID(), 'mentor-technology');
                                $mentor_specialties = get_the_terms(get_the_ID(), 'mentor-specialty');
                                $mentor_product_types = get_the_terms(get_the_ID(), 'mentor-product-type');
                                
                                // Create arrays of slugs for data attributes
                                $industry_slugs = !empty($mentor_industries) && !is_wp_error($mentor_industries) ? 
                                    wp_list_pluck($mentor_industries, 'slug') : [];
                                    
                                $technology_slugs = !empty($mentor_technologies) && !is_wp_error($mentor_technologies) ? 
                                    wp_list_pluck($mentor_technologies, 'slug') : [];
                                    
                                $specialty_slugs = !empty($mentor_specialties) && !is_wp_error($mentor_specialties) ? 
                                    wp_list_pluck($mentor_specialties, 'slug') : [];
                                    
                                $product_type_slugs = !empty($mentor_product_types) && !is_wp_error($mentor_product_types) ? 
                                    wp_list_pluck($mentor_product_types, 'slug') : [];
                                ?>
                                <a href="<?php the_permalink(); ?>" 
                                   class="mentor-card text-center mb-4"
                                   data-industry="<?php echo esc_attr(implode(' ', $industry_slugs)); ?>"
                                   data-technology="<?php echo esc_attr(implode(' ', $technology_slugs)); ?>"
                                   data-specialty="<?php echo esc_attr(implode(' ', $specialty_slugs)); ?>"
                                   data-product-type="<?php echo esc_attr(implode(' ', $product_type_slugs)); ?>">
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
                                </a>
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

wp_enqueue_script(
    'people-script', // Handle
    get_template_directory_uri() . '/modules/people.js', // Path to JS
    array('jquery'), // Dependencies
    filemtime(get_template_directory() . '/modules/people.js') // Cache-busting
);
?>
