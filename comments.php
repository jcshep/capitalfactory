



<?php if ( post_password_required() ) : ?>
				<p>This post is password protected. Enter the password to view any comments.</p>
<?php endif; ?>


<?php if ( have_comments() ) : ?>
			<h3 id="comments-title"> <?php echo get_comments_number(); ?> response to <?php echo get_the_title() ?></h3>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<?php previous_comments_link('Older Comments'); ?>
				<?php next_comments_link('Newer Comments'); ?>
			<?php endif; ?>

			<ol>
				<?php wp_list_comments(); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<?php previous_comments_link('Older Comments'); ?>
				<?php next_comments_link('Newer Comments'); ?>
			<?php endif; ?>

<?php else : ?>

	<?php if ( ! comments_open() ) : ?>
		<p>Comments are closed.</p>
	<?php endif; ?>

<?php endif;?>

<?php comment_form(); ?>