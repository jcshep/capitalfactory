<?php 


// Manage scripts 
function page_builder_scripts() {
	
	// Theme CSS
	wp_register_style('page-builder', get_template_directory_uri() . '/fortris-page-builder/page-builder.css');
	wp_enqueue_style('page-builder');

	// Before After JS
	wp_register_script('beforeafter', get_template_directory_uri() . '/js/beforeafter.jquery-1.0.0.min.js', array('jquery'));
	wp_enqueue_script('beforeafter');

} 

add_action( 'wp_enqueue_scripts', 'page_builder_scripts', 1000); 







?>