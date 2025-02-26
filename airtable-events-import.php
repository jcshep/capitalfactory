<?php

// Airtable credentials for Events
$eventsApiKey = "patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce";
$eventsBaseId = "appuPQbhltfdTaodF";
$eventsTableName = "tbl6ZWywSY4XlgwXn";
$eventsViewId = "viwrg70cSUkeWNmQe";

/**
 * Import events from Airtable into the 'event' custom post type
 * 
 * @param string $apiKey Airtable API key
 * @param string $baseId Airtable base ID
 * @param string $tableName Airtable table name
 * @param string $viewId Airtable view ID
 * @return int|bool Number of imported records or false on error
 */
function import_airtable_events($apiKey, $baseId, $tableName, $viewId) {
    // Step 1: Delete all existing 'event' posts
    $existing_events = get_posts([
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'any'
    ]);

    foreach ($existing_events as $event) {
        wp_delete_post($event->ID, true); // Force delete without sending to trash
    }

    // Step 2: Import fresh data from Airtable
    $url = "https://api.airtable.com/v0/{$baseId}/{$tableName}?view={$viewId}";
    $imported_count = 0;
    $offset = null;

    do {
        $request_url = $url;
        if ($offset) {
            $request_url .= "&offset=" . urlencode($offset);
        }

        $response = wp_remote_get($request_url, [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json'
            ],
            'timeout' => 30
        ]);

        if (is_wp_error($response)) {
            error_log('Airtable API Error: ' . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);


        // echo '<pre>';
        // print_r($data); // Print the data for debugging purposes
        // echo '</pre>';
        // die();

        if (!isset($data['records']) || !is_array($data['records'])) {
            error_log('Invalid response from Airtable API');
            return false;
        }

        foreach ($data['records'] as $record) {
            $fields = $record['fields'];
            $record_id = $record['id'];

            // Create a new event post
            $post_data = [
                'post_title'   => $fields['Event name'] ?? 'Untitled Event',
                'post_content' => $fields['Description'] ?? '',
                'post_type'    => 'event',
                'post_status'  => 'publish'
            ];

            $post_id = wp_insert_post($post_data);

            if (!is_wp_error($post_id)) {
                // Save the Airtable record ID as post meta
                update_post_meta($post_id, 'airtable_id', $record_id);

                // Handle event image upload
                if (!empty($fields['Image']) && is_array($fields['Image']) && !empty($fields['Image'][0]['url'])) {
                    $image_url = $fields['Image'][0]['url'];
                    $image_filename = $fields['Image'][0]['filename'];
                    
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    
                    $tmp = download_url($image_url);
                    
                    if (!is_wp_error($tmp)) {
                        $file_array = [
                            'name' => $image_filename,
                            'tmp_name' => $tmp
                        ];
                        
                        $image_id = media_handle_sideload($file_array, $post_id);
                        
                        if (!is_wp_error($image_id)) {
                            set_post_thumbnail($post_id, $image_id);
                            update_field('event_image', $image_id, $post_id);
                        }
                        
                        @unlink($tmp);
                    }
                }

                // Map Airtable fields to ACF fields
                // Date and Time
                if (!empty($fields['Start date/time'])) {
                    // Convert ISO 8601 format to WordPress date format
                    $start_datetime = new DateTime($fields['Start date/time']);
                    $start_datetime->setTimezone(new DateTimeZone(wp_timezone_string()));
                    
                    // Update date field with formatted date
                    update_field('date_time', $start_datetime->format('Y-m-d H:i:s'), $post_id);
                    
                }
                
                if (!empty($fields['End date/time'])) {
                    // Convert ISO 8601 format to WordPress date format
                    $end_datetime = new DateTime($fields['End date/time']);
                    $end_datetime->setTimezone(new DateTimeZone(wp_timezone_string()));
                    
                    // Update end time field with formatted time
                    update_field('time_end', $end_datetime->format('g:i A'), $post_id);
                }

                // Location
                update_field('location', $fields['Location'] ?? '', $post_id);
                update_field('address', $fields['Address'] ?? '', $post_id);
                update_field('city', $fields['City'] ?? '', $post_id);
                update_field('state', $fields['State'] ?? '', $post_id);
                update_field('zip_code', $fields['Zip Code'] ?? '', $post_id);
                
                // Virtual Event
                $is_virtual = !empty($fields['Virtual Event']) && $fields['Virtual Event'] === 'Yes';
                update_field('is_virtual', $is_virtual, $post_id);
                update_field('virtual_event_link', $fields['Virtual Event Link'] ?? '', $post_id);
                
                // Registration
                update_field('registration_link', $fields['Registration Link'] ?? '', $post_id);
                update_field('registration_required', !empty($fields['Registration Required']) && $fields['Registration Required'] === 'Yes', $post_id);
                update_field('registration_deadline', $fields['Registration Deadline'] ?? '', $post_id);
                
                // Event Details
                update_field('event_type', $fields['Event Type'] ?? '', $post_id);
                update_field('event_cost', $fields['Cost'] ?? '', $post_id);
                update_field('event_organizer', $fields['Organizer'] ?? '', $post_id);
                update_field('event_contact_email', $fields['Contact Email'] ?? '', $post_id);
                update_field('event_contact_phone', $fields['Contact Phone'] ?? '', $post_id);
                update_field('event_website', $fields['Website'] ?? '', $post_id);
                
                // Additional Information
                update_field('event_capacity', $fields['Capacity'] ?? '', $post_id);
                update_field('event_sponsors', $fields['Sponsors'] ?? '', $post_id);
                update_field('event_tags', $fields['Tags'] ?? '', $post_id);
                
                $imported_count++;
            }
        }

        // Check if there are more records to fetch
        $offset = $data['offset'] ?? null;

    } while ($offset);

    return $imported_count;
}

// Make sure to register the submenu after the admin_menu hook fires
function register_import_events_submenu() {
    // Check if the 'event' post type exists before adding the submenu
    if (post_type_exists('event')) {
        add_submenu_page(
            'edit.php?post_type=event',          // Parent slug (the events admin page)
            'Import Events',                      // Page title
            'Import',                             // Menu title (what appears in the menu)
            'manage_options',                     // Capability required to access
            'import_events',                      // Menu slug
            'import_events_page_callback'         // Callback function that renders the page
        );
    }
}
// Use priority 11 to ensure it runs after the post type is registered (which typically happens at priority 10)
add_action('admin_menu', 'register_import_events_submenu', 11);

// Callback function for the Import Events page
function import_events_page_callback() {
    // Make sure to have your Airtable credentials available here
    global $eventsApiKey, $eventsBaseId, $eventsTableName, $eventsViewId;
    
    // Check if the button was clicked and verify the nonce
    if (isset($_GET['action']) && $_GET['action'] === 'import' && check_admin_referer('import_events_action', 'import_nonce')) {
        $imported_count = import_airtable_events($eventsApiKey, $eventsBaseId, $eventsTableName, $eventsViewId);
        
        if ($imported_count !== false) {
            echo '<div class="notice notice-success is-dismissible"><p>' . $imported_count . ' events imported successfully.</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Error importing events. Please check the error log.</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1>Import Events from Airtable</h1>
        <p>Click the button below to import events from Airtable into the "event" custom post type.</p>
        <form method="get">
            <input type="hidden" name="post_type" value="event">
            <input type="hidden" name="page" value="import_events">
            <?php wp_nonce_field('import_events_action', 'import_nonce'); ?>
            <p>
                <input type="submit" name="action" value="import" class="button button-primary" />
            </p>
        </form>
    </div>
    <?php
}
