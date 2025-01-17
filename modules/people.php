<div class="people">
    <div class="container text-center ">
        <div class="bg-cream rounded-corners-1 p-60">
            <?php if ($args['type'] == 'Team') : ?>

                <div class="spacer-md"></div>
                <div class="tag">Our Team</div>
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
                { Airtable Integration}
                <div class="spacer-xl"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/people.css">