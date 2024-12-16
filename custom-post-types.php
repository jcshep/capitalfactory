<?php  



// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =-
//	Video - Post Type
// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =-

add_action( 'init', 'create_post_type_video' );
function create_post_type_video() {
	register_post_type( 'video',
		array(
			'labels' => array(
				'name' => __( 'Videos' ),
				'singular_name' => __( 'Video' ),
			),
			'public' => true,
			'rewrite' => array(
				'slug' => 'video',
				'with_front' => true
			),
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array( 'title', 'editor','custom-fields', ),
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'menu_icon' => 'dashicons-video-alt'
		)
	);
}








// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =-
//	Video - Post Type
// =- =- =- =- =- =- =- =- =- =- =- =- =- =- =-

// add_action( 'init', 'create_post_type_video' );
// function create_post_type_video() {
// 	register_post_type( 'video',
// 		array(
// 			'labels' => array(
// 				'name' => __( 'Videos' ),
// 				'singular_name' => __( 'Video' ),
// 			),
// 			'public' => true,
// 			'rewrite' => array(
// 				'slug' => 'video',
// 				'with_front' => true
// 			),
// 			'has_archive' => true,
// 			'hierarchical' => false,
// 			'supports' => array( 'title', 'editor','custom-fields' ),
// 			'capability_type' => 'post',
// 			'map_meta_cap' => true,
// 			'menu_icon' => 'dashicons-video-alt'
// 		)
// 	);
// }











?>