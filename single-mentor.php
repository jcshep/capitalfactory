<?php


get_header();

// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
    wp_enqueue_style(
        'hero-style', // Handle
        get_template_directory_uri() . '/modules/hero.css', // Path to CSS
        array(), // Dependencies (if any)
        filemtime(get_template_directory() . '/modules/hero.css') // Cache-busting
    );
}
?>


<div id="hero" class="short">

    <div class="container">

        <div class="inside">

            <div class="content-wrap p-45 d-flex justify-content-center flex-column align-items-center position-relative h-100 variation-centered">

                <div class="spacer-xxl"></div>


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
                            <path d="M75 80C89.9117 80 102 67.9117 102 53C102 38.0883 89.9117 26 75 26C60.0883 26 48 38.0883 48 53C48 67.9117 60.0883 80 75 80Z" fill="#0b1e15" />
                            <path d="M114 120.5C114 108.074 109.732 96.1635 101.73 87.4797C93.7277 78.7959 82.7558 74 71.5 74C60.2442 74 49.2723 78.7959 41.2698 87.4797C33.2674 96.1635 29 108.074 29 120.5V150H114V120.5Z" fill="#0b1e15" />
                        </svg>
                    </div>
                <?php endif; ?>
                
                <div class="spacer-lg"></div>


                <?php
                // Display mentor specialties
                $specialties = get_the_terms(get_the_ID(), 'mentor-specialty');
                if ($specialties && !is_wp_error($specialties)) {
                    echo '<div class="d-flex">';
                    foreach ($specialties as $specialty) {
                        echo '<div class="tag bd-white d-inline-block mx-2">' . esc_html($specialty->name) . '</div>';
                    }
                    echo '</div>';
                }
                ?>



                <div class="spacer-md"></div>

                <div class="row w-100">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-xl text-uppercase text-center display-xl">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

                <div class="spacer-sm"></div>

                <?php if (get_field('title')) : ?>
                    <p class="text-uppercase"><?php the_field('title'); ?></p>
                <?php endif; ?>



            </div>
        </div>




    </div>

</div>




<?php if (is_front_page()) : ?>
    <div class="spacer-xl"></div>
    <div class="welcome">
        <div class="container">
            <img src="<?php bloginfo('template_directory'); ?>/img/robot-dude.png" class="robot" alt="">
            <img src="<?php bloginfo('template_directory'); ?>/img/welcome-mask.png" class="mask" alt="">
            <div class="bg">
                <img src="<?php bloginfo('template_directory'); ?>/img/austin.jpg" alt="">
            </div>
        </div>
    </div>
<?php endif; ?>










<div class="spacer-lg"></div>

<div class="container mentor">

    <div id="mentor" class="p-60 rounded-corners-1 bg-cream">
        <div class="row align-items-start">
            <div class="col-md-12">
                <h2 class="display-lg pb-4 mb-3">About <?php the_title(); ?></h2>
                <div class="text-gray">
                    <p><?php the_field('bio'); ?></p>
                </div>
                <?php
                $email = get_field('email');
                if ($email) :
                ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-primary">Connect With <?php echo get_field('is_founder') ? 'Founder' : 'Mentor'; ?></a>
                <?php endif; ?>

                <div class="spacer-xl"></div>
            </div>
            <div class="col-12">
                <hr class="my-0">
                <div class="spacer-md"></div>
            </div>
            <div class="col-lg-8 mb-5 mb-lg-0">
                <ul class="tags">
                    <?php
                    // Display mentor technologies
                    $technologies = get_the_terms(get_the_ID(), 'mentor-technology');
                    if ($technologies && !is_wp_error($technologies)) {
                        foreach ($technologies as $tech) {
                            echo '<li class="tag bd-gray">' . esc_html($tech->name) . '</li>';
                        }
                    }

                    // Display mentor industries
                    $industries = get_the_terms(get_the_ID(), 'mentor-industry');
                    if ($industries && !is_wp_error($industries)) {
                        foreach ($industries as $industry) {
                            echo '<li class="tag bd-gray">' . esc_html($industry->name) . '</li>';
                        }
                    }

                    // Display mentor specialties again in the tags section
                    if ($specialties && !is_wp_error($specialties)) {
                        foreach ($specialties as $specialty) {
                            echo '<li class="tag bd-gray">' . esc_html($specialty->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-lg-4 d-flex justify-content-lg-end">
                <div class="d-flex gap-md text-gray text-xl">
                    <?php
                    // Display company if available
                    $company = get_field('company');
                    if ($company) :
                    ?>
                        <div class="d-flex align-items-center gap-xxs">
                            <img src="<?php bloginfo('template_directory'); ?>/img/icon-building.svg" alt="">
                            <?php echo esc_html($company); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Display website if available
                    $website = get_field('website');
                    if ($website) {
                        // Ensure URL has protocol
                        if (!preg_match("~^(?:f|ht)tps?://~i", $website)) {
                            $website = "https://" . $website;
                        }
                        $display_url = preg_replace("(^https?://)", "", $website); // Remove protocol for display
                    ?>
                        <div class="d-flex align-items-center gap-xxs">
                            <img src="<?php bloginfo('template_directory'); ?>/img/icon-world.svg" alt="">
                            <a href="<?php echo esc_url($website); ?>" target="_blank"><?php echo esc_html($display_url); ?></a>
                        </div>
                    <?php } ?>

                    <?php
                    // Display LinkedIn if available
                    $linkedin = get_field('linkedin');
                    if ($linkedin) {
                        // Ensure URL has protocol
                        if (!preg_match("~^(?:f|ht)tps?://~i", $linkedin)) {
                            $linkedin = "https://" . $linkedin;
                        }
                    ?>
                        <div class="d-flex align-items-center gap-xxs">
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/img/icon-linkedin.svg" alt="LinkedIn logo"></a>
                        </div>
                    <?php } ?>

                    <?php
                    // Display Twitter if available
                    $twitter = get_field('twitter');
                    if ($twitter) {
                        $twitter_url = 'https://twitter.com/' . ltrim($twitter, '@');
                    ?>
                        <div class="d-flex align-items-center gap-xxs">
                            <a href="<?php echo esc_url($twitter_url); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/img/icon-x.svg" alt="X logo"></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-12 d-none d-lg-block mb-1">
                <div class="spacer-lg"></div>
            </div>
        </div>
    </div>
</div>

<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/company.css">

<div class="spacer-lg"></div>

<?php get_footer(); ?>
