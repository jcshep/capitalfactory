<div class="container basic-text 
    <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>
    <?= !$args['content'] ? 'text-center' : 'text-left' ?>
    ">
    <div class="p-60 rounded-corners-1 <?= $args['white_background'] ? 'bg-cream' : NULL ?>">
        <div class="inside">

            <?php if ($args['tag']) : ?>
                <div class="tag"><?php echo $args['tag']; ?></div>
                <div class="spacer-xl"></div>
            <?php endif; ?>


            <?php if ($args['title']) : ?>
                <h2 class="display-xl mb-0"><?php echo $args['title']; ?></h2>
                <div class="spacer-md"></div>
            <?php endif; ?>

            <?php if ($args['subtitle']) : ?>
                <p class="text-xl mb-0"><?php echo $args['subtitle']; ?></p>
            <?php endif; ?>

            <?php if ($args['content']) : ?>
                
                <?php echo $args['content']; ?>
            <?php endif; ?>

            <?php if ($args['button']) : ?>
                <div class="spacer-xl"></div>
                <a href="<?php echo $args['button']['url']; ?>" class="btn btn-primary"><?php echo $args['button']['title']; ?></a>
            <?php endif; ?>
        </div>

    </div>
</div>


<?php
// Check if function exists to ensure the file is included in a WordPress environment
if (function_exists('wp_enqueue_style')) {
    wp_enqueue_style(
        'basic-text-style', // Handle
        get_template_directory_uri() . '/modules/basic-text.css', // Path to CSS
        array(), // Dependencies (if any)
        filemtime(get_template_directory() . '/modules/basic-text.css') // Cache-busting
    );
}
?>