<div class="container basic-text text-center <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">

    <?php if ($args['tag']) : ?>
        <div class="tag"><?php echo $args['tag']; ?></div>
    <?php endif; ?>

    <div class="spacer-xl"></div>

    <?php if ($args['title']) : ?>
        <h3 class="display-xl mb-0"><?php echo $args['title']; ?></h3>
    <?php endif; ?>

    <?php
    $form_id = $args['gravity_form'];
    if ($form_id && $form_id !== 'none') {
        $escaped_form_id = acf_esc_html($form_id);
        echo do_shortcode("[gravityform id=\"$escaped_form_id\" title=\"false\" description=\"false\" ajax=\"true\" tabindex=\"4\"]");
    }
    ?>


</div>


<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/basic-text.css">