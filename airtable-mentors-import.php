<?php 
function import_mentors_batch() {
    // Verify nonce
    if (!check_ajax_referer('import_mentors_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'Invalid security token']);
        return;
    }

    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Unauthorized']);
        return;
    }

    $apiKey = "patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce";
    $baseId = "app3c8mUha4KsZAQV";
    $tableName = "tblGQOY7TwxADCvFW";
    $batch_size = 100;
    $offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : null;

    try {
        $url = "https://api.airtable.com/v0/{$baseId}/{$tableName}?pageSize={$batch_size}";
        if ($offset) {
            $url .= "&offset=" . urlencode($offset);
        }

        $response = wp_remote_get($url, [
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json'
            ],
            'timeout' => 30
        ]);

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => $response->get_error_message()]);
            return;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        
        if (!isset($data['records'])) {
            wp_send_json_error(['message' => 'No records found in response']);
            return;
        }

        // Delete existing posts only on first batch
        if (!$offset) {
            $existing_mentors = get_posts([
                'post_type'      => 'mentor',
                'posts_per_page' => -1,
                'post_status'    => 'any'
            ]);

            foreach ($existing_mentors as $mentor) {
                wp_delete_post($mentor->ID, true);
            }

            // Delete existing taxonomy terms
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
        }

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
                // Handle avatar upload
                if (!empty($fields['Avatar']) && is_array($fields['Avatar']) && !empty($fields['Avatar'][0]['url'])) {
                    $avatar_url = $fields['Avatar'][0]['url'];
                    $avatar_filename = $fields['Avatar'][0]['filename'];
                    
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    
                    $tmp = download_url($avatar_url);
                    
                    if (!is_wp_error($tmp)) {
                        $file_array = array(
                            'name'     => $avatar_filename,
                            'tmp_name' => $tmp,
                            'error'    => 0,
                            'size'     => filesize($tmp)
                        );
                        
                        $avatar_id = media_handle_sideload($file_array, $post_id);
                        
                        if (!is_wp_error($avatar_id)) {
                            set_post_thumbnail($post_id, $avatar_id);
                            update_field('avatar', $avatar_id, $post_id);
                        }
                        
                        @unlink($tmp);
                    }
                }

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

                // Handle mentor-industry taxonomy
                if (!empty($fields['Industry'])) {
                    $industry_names = explode(',', $fields['Industry']);
                    $industry_names = array_map('trim', $industry_names);
                    $industry_names = array_filter($industry_names, function ($industry) {
                        return !is_numeric($industry) && !empty($industry);
                    });

                    foreach ($industry_names as $industry) {
                        if (!term_exists($industry, 'mentor-industry')) {
                            wp_insert_term($industry, 'mentor-industry');
                        }
                    }
                    wp_set_object_terms($post_id, $industry_names, 'mentor-industry', false);
                }

                // Handle mentor-technology taxonomy
                if (!empty($fields['Technologies'])) {
                    $technologies = $fields['Technologies'];
                    foreach ($technologies as $tech) {
                        if (!term_exists($tech, 'mentor-technology')) {
                            wp_insert_term($tech, 'mentor-technology');
                        }
                    }
                    wp_set_object_terms($post_id, $technologies, 'mentor-technology', false);
                }

                // Handle mentor-product-type taxonomy
                if (!empty($fields['Product Type'])) {
                    $product_types = $fields['Product Type'];
                    foreach ($product_types as $type) {
                        if (!term_exists($type, 'mentor-product-type')) {
                            wp_insert_term($type, 'mentor-product-type');
                        }
                    }
                    wp_set_object_terms($post_id, $product_types, 'mentor-product-type', false);
                }

                // Handle mentor-specialty taxonomy
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

        // Get total count from Airtable on first batch
        $total_count = 100; // Default value
        if (!$offset) {
            $count_url = "https://api.airtable.com/v0/{$baseId}/{$tableName}?maxRecords=0";
            $count_response = wp_remote_get($count_url, [
                'headers' => [
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json'
                ]
            ]);
            if (!is_wp_error($count_response)) {
                $count_data = json_decode(wp_remote_retrieve_body($count_response), true);
                if (isset($count_data['total'])) {
                    $total_count = $count_data['total'];
                }
            }
        }

        wp_send_json_success([
            'processed' => count($data['records']),
            'offset' => isset($data['offset']) ? $data['offset'] : null,
            'total' => $total_count
        ]);

    } catch (Exception $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}

// Register AJAX action for logged-in users
add_action('wp_ajax_import_mentors_batch', 'import_mentors_batch');

// Add the submenu page
add_action('admin_menu', function() {
    add_submenu_page(
        'edit.php?post_type=mentor',    // Parent slug
        'Import Mentors',               // Page title
        'Import',                       // Menu title
        'manage_options',               // Capability
        'import-mentors',               // Menu slug
        'render_mentors_import_page'    // Callback function
    );
});

function render_mentors_import_page() {
    wp_enqueue_script('jquery');
    ?>
    <div class="wrap">
        <h1>Import Mentors</h1>
        <div id="import-progress" style="display:none;">
            <p>Progress: <span id="progress-text">0%</span></p>
            <div class="progress-bar" style="width:100%; height:20px; background:#f0f0f0;">
                <div id="progress-bar-fill" style="width:0%; height:100%; background:#0073aa; transition:width 0.3s ease-in-out;"></div>
            </div>
            <p id="status-text">Importing...</p>
        </div>
        <div id="import-controls">
            <?php wp_nonce_field('import_mentors_nonce', 'import_nonce'); ?>
            <button id="start-import" class="button button-primary">Start Import</button>
        </div>
        <div id="import-results" style="margin-top:20px;"></div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var importing = false;
        var processed = 0;
        var total = 0;

        function updateProgress(current, total) {
            var percentage = Math.round((current / total) * 100);
            $('#progress-text').text(percentage + '%');
            $('#progress-bar-fill').css('width', percentage + '%');
            $('#status-text').text('Imported ' + current + ' of ' + total + ' mentors...');
        }

        function importBatch(offset = null) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'import_mentors_batch',
                    nonce: $('#import_nonce').val(),
                    offset: offset
                },
                success: function(response) {
                    if (response.success) {
                        processed += response.data.processed;
                        
                        if (total === 0) {
                            total = response.data.total;
                        }
                        
                        updateProgress(processed, total);

                        if (response.data.offset) {
                            importBatch(response.data.offset);
                        } else {
                            $('#status-text').text('Import completed successfully!');
                            $('#import-controls button').prop('disabled', false);
                            importing = false;
                        }
                    } else {
                        $('#status-text').text('Error: ' + (response.data.message || 'Unknown error'));
                        $('#import-controls button').prop('disabled', false);
                        importing = false;
                    }
                },
                error: function(xhr, status, error) {
                    $('#status-text').text('Error: ' + error);
                    $('#import-controls button').prop('disabled', false);
                    importing = false;
                }
            });
        }

        $('#start-import').click(function(e) {
            e.preventDefault();
            if (importing) return;

            importing = true;
            processed = 0;
            total = 0;
            
            $(this).prop('disabled', true);
            $('#import-progress').show();
            $('#import-results').empty();
            
            importBatch();
        });
    });
    </script>

    <style>
    .progress-bar {border-radius:3px; overflow:hidden;}
    #status-text {margin-top:10px; font-style:italic;}
    #import-controls {margin-top:20px;}
    </style>
    <?php
}
