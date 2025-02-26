<?php

function import_airtable_mentors($apiKey, $baseId, $tableName) {
    // Step 1: Delete all existing 'mentor' posts
    $existing_mentors = get_posts([
        'post_type'      => 'mentor',
        'posts_per_page' => -1,
        'post_status'    => 'any'
    ]);

    foreach ($existing_mentors as $mentor) {
        wp_delete_post($mentor->ID, true); // Force delete without sending to trash
    }

    // Step 2: Delete all existing taxonomy terms
    $taxonomies = ['mentor-product-type', 'mentor-industry', 'mentor-technology', 'mentor-specialty'];
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false
        ]);

        foreach ($terms as $term) {
            wp_delete_term($term->term_id, $taxonomy);
        }
    }

    // Step 3: Import fresh data from Airtable
    $url = "https://api.airtable.com/v0/{$baseId}/{$tableName}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$apiKey}"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

	// echo '<pre>';
	// print_r($data); // Print the data for debugging purposes
    // echo '</pre>';
    // die();

    if (!isset($data['records'])) return;

    foreach ($data['records'] as $record) {
        $fields = $record['fields'];

        // Create a new mentor post
        $post_id = wp_insert_post([
            'post_title'   => $fields['Name'] ?? '',
            'post_content' => $fields['Mentor Bio'] ?? '',
            'post_type'    => 'mentor',
            'post_status'  => 'publish'
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Map Airtable fields to ACF fields
            update_field('first_name', $fields['First Name'] ?? '', $post_id);
            update_field('email', $fields['Email'] ?? '', $post_id);
            update_field('phone', $fields['Phone'] ?? '', $post_id);
            update_field('linkedin', $fields['LinkedIn'] ?? '', $post_id);
            update_field('website', $fields['Website'] ?? '', $post_id);
            update_field('company', $fields['Current Company'] ?? '', $post_id);
            update_field('title', $fields['Title'] ?? '', $post_id);
            update_field('city', $fields['City'] ?? '', $post_id);
            update_field('bio', $fields['Mentor Bio'] ?? '', $post_id);
            update_field('work_experience', $fields['Describe your work experience'] ?? '', $post_id);
            update_field('virtual_meeting_link', $fields['If online, please add your preferred virtual contact method for startups (video conference link is preferred)'] ?? '', $post_id);
            update_field('preferred_customer_segments', implode(', ', $fields['Preferred Customer Segment(s)'] ?? []), $post_id);
            update_field('sales_models', implode(', ', $fields['What sales model(s) are you most experienced with?'] ?? []), $post_id);
            update_field('stage', implode(', ', $fields['Stage'] ?? []), $post_id);
            update_field('gender', $fields['Gender'][0] ?? '', $post_id);
            update_field('ethnicity', $fields['What is your ethnicity?'][0] ?? '', $post_id);
            update_field('is_founder', $fields['Founder?'] === 'Yes', $post_id);
            update_field('is_investor', $fields['Investor?'] === 'Yes', $post_id);
            update_field('status', $fields['Status'] === 'Active', $post_id);

            // Handle mentor-industry taxonomy (comma-separated string)
            if (!empty($fields['Industry'])) {
                // Split the industries string into an array of names
                $industry_names = explode(',', $fields['Industry']);
                // Trim any extra whitespace from each industry name
                $industry_names = array_map('trim', $industry_names);

                // Filter out numeric-only values and any empty strings
                $industry_names = array_filter($industry_names, function ($industry) {
                    return !is_numeric($industry) && !empty($industry);
                });

                // Ensure each term exists and assign them
                foreach ($industry_names as $industry) {
                    if (!term_exists($industry, 'mentor-industry')) {
                        wp_insert_term($industry, 'mentor-industry');
                    }
                }
                wp_set_object_terms($post_id, $industry_names, 'mentor-industry', false);
            }

            // Handle mentor-technology taxonomy (array)
            if (!empty($fields['Technologies'])) {
                $technologies = $fields['Technologies'];
                foreach ($technologies as $tech) {
                    if (!term_exists($tech, 'mentor-technology')) {
                        wp_insert_term($tech, 'mentor-technology');
                    }
                }
                wp_set_object_terms($post_id, $technologies, 'mentor-technology', false);
            }

            // Handle mentor-product-type taxonomy (array)
            if (!empty($fields['Product Type'])) {
                $product_types = $fields['Product Type'];
                foreach ($product_types as $type) {
                    if (!term_exists($type, 'mentor-product-type')) {
                        wp_insert_term($type, 'mentor-product-type');
                    }
                }
                wp_set_object_terms($post_id, $product_types, 'mentor-product-type', false);
            }

            // Handle mentor-specialty taxonomy (array)
            if (!empty($fields['Specialties'])) {
                $specialties = $fields['Specialties'];
                foreach ($specialties as $specialty) {
                    if (!term_exists($specialty, 'mentor-specialty')) {
                        wp_insert_term($specialty, 'mentor-specialty');
                    }
                }
                wp_set_object_terms($post_id, $specialties, 'mentor-specialty', false);
            }
        }
    }
}

// Airtable credentials for Mentors
$mentorsApiKey = "patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce";
$mentorsBaseId = "app3c8mUha4KsZAQV";
$mentorsTableName = "tblGQOY7TwxADCvFW";

// Add a submenu page under the 'mentor' custom post type menu
function register_import_mentors_submenu() {
    add_submenu_page(
        'edit.php?post_type=mentor',        // Parent slug (the mentors admin page)
        'Import Mentors',                    // Page title
        'Import',                            // Menu title (what appears in the menu)
        'manage_options',                    // Capability required to access
        'import_mentors',                    // Menu slug
        'import_mentors_page_callback'       // Callback function that renders the page
    );
}
add_action('admin_menu', 'register_import_mentors_submenu');




// Callback function for the Import page
function import_mentors_page_callback() {
    // Make sure to have your Airtable credentials available here
    global $mentorsApiKey, $mentorsBaseId, $mentorsTableName;
    
    // Check if the button was clicked and verify the nonce
    if (isset($_GET['action']) && $_GET['action'] === 'import' && check_admin_referer('import_mentors_action', 'import_nonce')) {
        import_airtable_mentors($mentorsApiKey, $mentorsBaseId, $mentorsTableName);
        echo '<div class="notice notice-success is-dismissible"><p>Mentors imported successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Import Mentors from Airtable</h1>
        <p>Click the button below to import mentors from Airtable.</p>
        <form method="get">
            <input type="hidden" name="post_type" value="mentor">
            <input type="hidden" name="page" value="import_mentors">
            <?php wp_nonce_field('import_mentors_action', 'import_nonce'); ?>
            <p>
                <input type="submit" name="action" value="import" class="button button-primary" />
            </p>
        </form>
    </div>
    <?php
}

function make_google_calendar_link($name, $begin, $end, $details, $location) {
	$params = array('&dates=', '/', '&details=', '&location=', '&sf=true&output=xml');
	$url = 'https://www.google.com/calendar/render?action=TEMPLATE&text=';
	$arg_list = func_get_args();
    for ($i = 0; $i < count($arg_list); $i++) {
    	$current = $arg_list[$i];
    	if(is_int($current)) {
    		$t = new DateTime('@' . $current, new DateTimeZone('UTC'));
    		$current = $t->format('Ymd\THis\Z');
    		unset($t);
    	}
    	else {
    		$current = urlencode($current);
    	}
    	$url .= (string) $current . $params[$i];
    }
    return $url;
}
