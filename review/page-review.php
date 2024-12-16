<?php  
// Template Name: Review Page
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php
	global $page, $paged;
	$page_title = get_post_meta( $post->ID, 'page-title', true);
	if ($page_title == '') {$page_title = single_post_title('',false);}
	if(is_home()) {$page_title = 'Blog';}
	echo $page_title;
?>
</title>
    
<meta name="description" content="<?php 
	$meta_description = get_post_meta($post->ID, 'meta-description', true); 
	if ($meta_description == '') {
		global $post;
		   if (is_single()) {
			  echo strip_tags(get_the_excerpt($post->ID));
		   }
	}
	if(is_home()) {$meta_description = 'Blog';}
	echo $meta_description;
?>"> 

<link rel="icon" type="image/ico" href="<?php echo bloginfo('url');?>/favicon.ico">
<link rel="icon" href="<?php echo bloginfo('url');?>/favicon.ico">

<meta name ="viewport" content ="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0">

<?php wp_head(); ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" type="text/css">


<style>
	h1 {color: <?= get_field('accent_color') ?>!important}
	h3 {color: <?= get_field('accent_color') ?>!important; font-size: 18px; padding-bottom: 15px; padding-top: 15px;}
	.btn {background: <?= get_field('accent_color') ?>!important;}
</style>


<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/review/review.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/review/star-rating/css/star-rating-svg.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/review/star-rating/jquery.star-rating-svg.js"></script>
	

</head>


<body <?php body_class(); ?>>



<div class="container">
	
	<div class="text-center">
		<img class="review-logo" src="<?= get_field('logo') ?>" alt="">	

		<?php if(isset($_GET['submitted'])) : ?>
			<div class="alert alert-success">
				Thank you. You will receive a message with instructions on how to submit your review.
			</div>
		<?php endif; ?>

		

		<?php if(isset($_GET['redirect'])) : ?>
			<div class="alert alert-success">
				Thank you for your review
			</div>
		<?php endif; ?>

		

		<div class="review-intro">
			<?= get_field('intro_text') ?>	
		</div>



		<?php if(have_rows('review_forms') ): ?>
			<div class="review-links">
			<?php $i=0; while ( have_rows('review_forms') ) : the_row(); ?>
				<a href="?reviewerid=<?= $i ?>#step-2" class="btn btn-primary <?php if(isset($_GET['reviewerid']) && $_GET['reviewerid']==$i) echo 'active' ?>"><?= get_sub_field('practitioner_name') ?></a> 
			<?php $i++; endwhile; ?>
			</div>			
		<?php endif; ?>


		<?php  
			if(isset($_GET['reviewerid'])) :
				$form = get_field('review_forms')[$_GET['reviewerid']];

				// echo '<pre>';
				// var_dump($form);
				// echo '</pre>';
		?>

			<div class="" id="step-2">
				
				<h3>Did you have a positive experience?</h3>

				<div class="row">
					<div class="col-6">
						<a href="?reviewerid=<?= $_GET['reviewerid'] ?>&rating=yes#step-3" class="btn btn-block btn-primary <?php if(isset($_GET['rating']) && $_GET['rating']=='yes') echo 'active' ?>">Yes</a>
					</div> <!--col-->
					<div class="col-6">
						<a href="?reviewerid=<?= $_GET['reviewerid'] ?>&rating=no#step-3" class="btn btn-block btn-primary <?php if(isset($_GET['rating']) && $_GET['rating']=='no') echo 'active' ?>">No</a>
					</div> <!--col-->
				</div> <!--row-->
			</div>
		<?php endif; ?>


		<!--=====================================
		=            Positive Review            =
		======================================-->
		<?php if(isset($_GET['rating']) && $_GET['rating'] == 'yes') : ?>
		
		<div id="step-3" class="review-form">
			<p>Please enter your information below.</p>
				<div class="form">
					<?php 
					$field_values = [
						'practitioner' => $form['practitioner_name'],
						'subject_line' => $form['review_email_subject_line'],
						'email_message' => $form['review_email_body_copy'],
						'text_message' => $form['review_text_message_copy'],
						'review_links' => serialize($form['review_links']),
						'from_email' => get_field('from_email'),
						'logo_file' => get_field('logo'),
						'accent_color' => get_field('accent_color'),
						'contact_link' => get_field('contact_form_link'),
					];
					gravity_form(get_field('review_initiation_form'), $display_title=false, $display_description=false, $display_inactive=false, $field_values, $ajax=false, 1); 
					?> 
				</div>
		</div>
		<?php endif; ?>
		<!--====  End of Positive Review  ====-->
		



		<!--=====================================
		=            Negative Review            =
		======================================-->
		
		<?php if(isset($_GET['rating']) && $_GET['rating'] == 'no') : ?>
			<div id="step-3" class="review-form">
				<div class="form">
					<div class="feedback">
						<p>We would like to discuss your visit further. To have one of our team members contact you please enter your name and phone number below.</h3></p>
						<?php gravity_form(10, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true, $tabindex); ?> 					
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<!--====  End of Negative Review  ====-->
		


		
	</div>
	

</div>



<script>
	// Hide flash notifications
	$(document).ready(function() {
		window.setTimeout(function() {
			$('.alert').not('.static').fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);

		$('.review-form input[type="submit"').addClass('btn btn-primary');
		
		$(".my-rating").starRating({
		    starSize: 45,
		    ratedColor: 'gold',
		    useFullStars: true,
		    useGradient: false,
		    // disableAfterRate: false,

		    callback: function(currentRating, $el){
		        if(currentRating >= 4) {
		        	$('.form').slideDown();
		        	$('.feedback').slideUp();

		        } else {
		        	$('.form').slideUp();
		        	$('.feedback').slideDown();
		        	// window.location.replace("?redirect=true");
		        }
		    }
		});
	});
</script>





<?php wp_footer(); ?>
</body>
</html>















