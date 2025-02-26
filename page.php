<?php get_header(); ?>

<?php if (post_password_required()) : ?>
    <div class="spacer-xxl"></div>
    <div class="spacer-xxl"></div>
    <div class="spacer-xxl"></div>
    <div class="container">
        <div class="bg-cream rounded-corners-1">
            <div class="spacer-xxl"></div>
            <div class="container  basic-text text-center <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">
                <?php echo get_the_password_form(); ?>
            </div>
            <div class="spacer-xxl"></div>
        </div>
    </div>
    <div class="spacer-xxl"></div>
<?php else : ?>
    <?php get_template_part('builder') ?>
<?php endif; ?>

<?php get_footer(); ?>

