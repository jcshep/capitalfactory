<div class="container position-relative z-2 form-container">

    <div class="p-60 rounded-corners-1 form text-center">

    <?php if ($args['tag']) : ?>
        <div class="tag "><?php echo $args['tag']; ?></div>
    <?php endif; ?>

    <div class="spacer-md"></div>

    <?php if ($args['title']) : ?>
        <h3 class="display-xl mb-0"><?php echo $args['title']; ?></h3>
        <div class="spacer-xl"></div>
    <?php endif; ?>

    <div class="form-inside">
        <?php
        $form_id = $args['gravity_form'];
        if ($form_id && $form_id !== 'none') {
            $escaped_form_id = acf_esc_html($form_id);
            echo do_shortcode("[gravityform id=\"$escaped_form_id\" title=\"false\" description=\"false\" ajax=\"true\" tabindex=\"4\"]");
        }
        ?>
    </div>

    </div>

</div>

<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
	wp_enqueue_style(
		'form-style', // Handle
		get_template_directory_uri() . '/modules/form.css', // Path to CSS
		array(), // Dependencies (if any)
		filemtime(get_template_directory() . '/modules/form.css') // Cache-busting
	);
}
?>
