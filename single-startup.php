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



                <?php if (has_post_thumbnail()) : ?>
                    <div class="img-placeholder">
                        <?php the_post_thumbnail('large', array('class' => 'startup-thumbnail')); ?>                        
                    </div>
                    <div class="spacer-md"></div>
                <?php else : ?>
                    <div class="spacer-xxl"></div>
                <?php endif; ?>


                <div class="tag bd-white">ALL ACCESS FUND</div>
                <div class="spacer-md"></div>

                <div class="row w-100">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-xl text-uppercase text-center display-xl">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

                <div class="spacer-sm"></div>

                <p class="text-uppercase"><?php the_field('tagline'); ?></p>


                <div class="spacer-lg"></div>



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

<div class="container company">

    <div id="company" class="p-60 rounded-corners-1 bg-cream">
        <div class="row align-items-start">
            <!-- <div class="col-md-6 col-left">
                <img src="<?php bloginfo('template_directory'); ?>/img/company-1.jpg" alt="" class="rounded-corners-3">
                <div class="spacer-xl"></div>
            </div> -->
            <div class="col-md-12 col-right">
                <h2 class="display-lg pb-4 mb-3">About <?php the_title(); ?></h2>
                <div class="text-gray">
                    <p><?php the_field('description'); ?></p>
                </div>
                <a href="mailto:<?php the_field('email'); ?>" class="btn btn-primary">Connect With Us</a>
                <div class="spacer-xl"></div>
            </div>
            <div class="col-12">
                <hr class="my-0">
                <div class="spacer-md"></div>
            </div>
            <div class="col-lg-8 mb-5 mb-lg-0">
                <ul class="tags">
                    <?php
                    $technologies = get_the_terms(get_the_ID(), 'startup-technology');
                    if ($technologies && !is_wp_error($technologies)) {
                        foreach ($technologies as $tech) {
                            echo '<li class="tag bd-gray">' . esc_html($tech->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-lg-4 d-flex justify-content-lg-end">
                <div class="d-flex gap-md text-gray text-xl">
                    <!-- <div class="d-flex align-items-center gap-xxs"><img src="<?php bloginfo('template_directory'); ?>/img/icon-marker.svg" alt="">Springfield</div> -->
                    <?php
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



