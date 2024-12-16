<?php  
	
    $disregard_cookie = false;
    if (get_field('only_show_once')) {
    
    	$cookie_name = 'notification-'.$post->ID;
    	
    	setcookie('notification-'.$post->ID, 'true', time()+86400);

    } else {
        $disregard_cookie = true;
    }




?>




	
<?php if (get_field('add_a_popup_notification_to_this_page') && ($disregard_cookie || !isset($_COOKIE['notification-'.$post->ID]))): ?>
	


<script type="text/javascript">
    $(window).on('load', function() {
        
    	const notification = document.querySelector(".notification");
    	const closeButton = document.querySelector(".close-button");

    	function toggleNotification() {
    		notification.classList.toggle("show-notification");
    	}

    	function windowOnClick(event) {
    		if (event.target === notification) {
    			toggleNotification();
    		}
    	}

        setTimeout(function() {
    	   toggleNotification();
        }, 1000);


    	closeButton.addEventListener("click", toggleNotification);
    	window.addEventListener("click", windowOnClick);

    	<?php if(get_field('display_time')) : ?>
    	setTimeout(function() {
    		notification.classList.remove("show-notification");
    	}, <?= get_field('display_time') * 1000 ?>);
    	<?php endif; ?>

    });
</script>



<div class="notification">
    <div class="notification-content">
        <span class="close-button">×</span>
        <?php if (get_field('popup_image')): ?>
        	<img src="<?= get_field('popup_image')['url'] ?>">
        <?php endif ?>
        <?php if (get_field('popup_title')): ?>
            <h2><?= get_field('popup_title') ?></h2>
        <?php endif ?>

        <?php if (get_field('popup_content')): ?>
        	<p><?= get_field('popup_content') ?></p>
        <?php endif ?>

        <?php if (get_field('popup_link')): ?>
        	<a href="<?= get_field('popup_link')['url'] ?>" class="btn btn-primary"><?= get_field('popup_link')['title'] ?></a>
        <?php endif ?>

         <?php if (get_field('popup_title_2') || get_field('popup_content_2') || get_field('popup_link_2')): ?>

         <hr>

            <?php if (get_field('popup_title_2')): ?>
                <h2><?= get_field('popup_title_2') ?></h2>
            <?php endif ?>

            <?php if (get_field('popup_content_2')): ?>
                <p><?= get_field('popup_content_2') ?></p>
            <?php endif ?>

            <?php if (get_field('popup_link_2')): ?>
                <a href="<?= get_field('popup_link_2')['url'] ?>" class="btn btn-primary"><?= get_field('popup_link_2')['title'] ?></a>
            <?php endif ?>

        <?php endif ?>

    </div>
</div>


<!-- <link rel="stylesheet" id="dashicons-css"  href="<?php bloginfo('template_directory'); ?>/css/modules/modal.css" type="text/css" media="all" /> -->



<style type="text/css">

    .notification {
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 9999;
    /*background-color: rgba(0, 0, 0, 0.5);*/
    opacity: 0;
    visibility: hidden;
    transform: translateX(-100vw);
    transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 1s;
}

.notification-content {
    text-align: center;
    position: fixed;
    top: 120px;
    left: 60px;
    /*transform: translate(-50%, -50%);*/
    background-color: white;
    padding: 0 24px 24px;
    width: 400px;
    box-shadow: 2px 2px 10px 0 rgba(0, 0, 0, 0.3);
}

.notification-content h2 {
/*    color: #259fea; */
    text-transform: uppercase;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 10px;
}

.notification-content img {width: calc(100% + 48px); margin: 0 0 0 -24px; max-width: none}

.notification-content .btn {text-transform: uppercase; display: inline-block; padding: 7px 19px; height: auto;}
.notification-content p {font-size: 13px; margin-bottom: 15px;}

.close-button {
    position: absolute;
    right: -10px;
    top: -10px;
    color: #FFF;
    width: 1.5rem;
    font-size: 24px;
    line-height: 1.5rem;
    text-align: center;
    cursor: pointer;
    border-radius: 100px;
    background-color: #000;
    cursor: pointer;
}

.close-button:hover {
    background-color: darkgray;
}

.show-notification {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
    transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 1s;
}



@media only screen and (max-width:991px) {

    .notification-content {right: 15px;}
    .notification-content {width: 280px;}

}

</style>



<?php endif ?>