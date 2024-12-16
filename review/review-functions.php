<?php  

add_filter( 'acf/load_field/name=review_initiation_form', 'acf_populate_gf_forms_ids' );
function acf_populate_gf_forms_ids( $field ) {
    if ( class_exists( 'GFFormsModel' ) ) {
        $choices = [];

        foreach ( \GFFormsModel::get_forms() as $form ) {
            $choices[ $form->id ] = $form->title;
        }

        $field['choices'] = $choices;
    }

    return $field;
}


add_filter( 'acf/load_field/name=menu', 'acf_populate_menus' );
function acf_populate_menus( $field ) {
    
    foreach (wp_get_nav_menus() as $key => $menu) {
    
        $choices[$menu->name] = $menu->name;
        $field['choices'] = $choices;
    }

    return $field;
}



add_filter( 'gform_notification', 'custom_notification', 10, 3 );
function custom_notification($notification, $form, $entry) {
        
    if($form['title'] == 'Review Our Practice') :

        include 'review/confirmation-email.php';

        $notification['from'] = $entry[11];
        $notification['subject'] = $entry[6];
        $notification['message'] = $entry[8];
        
        return $notification;

        die();

    endif;

    return true;
}


?>