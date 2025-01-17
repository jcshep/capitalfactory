<div class="container basic-text text-center <?= $args['text_color'] == 'Light' ? 'text-white' : 'text-dark' ?>">

    <?php if ( $args['tag'] ) : ?>
        <div class="tag"><?php echo $args['tag']; ?></div>
    <?php endif; ?>

    <div class="spacer-xl"></div>

    <?php if ( $args['title'] ) : ?>
        <h3 class="display-xl mb-0"><?php echo $args['title']; ?></h3>
    <?php endif; ?>
        
    <?php if ( $args['content'] ) : ?>
        <div class="spacer-xl"></div>
        <?php echo $args['content']; ?>
    <?php endif; ?>

    <?php if ( $args['button'] ) : ?>
        <div class="spacer-xl"></div>
        <a href="<?php echo $args['button']['url']; ?>" class="btn btn-primary"><?php echo $args['button']['title']; ?></a>        
    <?php endif; ?>
    
	
</div>


<!-- Style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/modules/basic-text.css">