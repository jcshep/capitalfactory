<?php 

// Add these functions to handle batch processing
add_action('wp_ajax_import_startups_batch', 'import_startups_batch');
add_action('wp_ajax_get_import_status', 'get_import_status');

// Add the submenu page
add_action('admin_menu', function() {
    add_submenu_page(
        'edit.php?post_type=startup',    // Parent slug
        'Import Startups',               // Page title
        'Import',                        // Menu title
        'manage_options',                // Capability
        'import-startups',               // Menu slug
        'render_import_page'             // Callback function
    );
});

function render_import_page() {
    wp_enqueue_script('jquery');
    ?>
    <div class="wrap">
        <h1>Import Startups</h1>
        <div id="import-progress" style="display:none;">
            <p>Progress: <span id="progress-text">0%</span></p>
            <div class="progress-bar" style="width:100%; height:20px; background:#f0f0f0;">
                <div id="progress-bar-fill" style="width:0%; height:100%; background:#0073aa;"></div>
            </div>
        </div>
        <button id="start-import" class="button button-primary">Start Import</button>
        <div id="import-log"></div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        let offset = null;
        let isImporting = false;
        let totalProcessed = 0;

        function logMessage(message) {
            $('#import-log').prepend('<p>' + message + '</p>');
        }

        function updateProgress(processed, total) {
            totalProcessed += processed;
            const percentage = Math.round((totalProcessed / total) * 100);
            $('#progress-bar-fill').css('width', percentage + '%');
            $('#progress-text').text(percentage + '%');
        }

        function importBatch() {
            if (!isImporting) return;

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'import_startups_batch',
                    offset: offset,
                    nonce: '<?php echo wp_create_nonce("import_startups_nonce"); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        logMessage('Processed ' + response.data.processed + ' records');
                        updateProgress(response.data.processed, response.data.total);

                        if (response.data.offset) {
                            offset = response.data.offset;
                            setTimeout(importBatch, 1000);
                        } else {
                            logMessage('Import completed successfully!');
                            isImporting = false;
                            $('#start-import').prop('disabled', false);
                        }
                    } else {
                        logMessage('Error: ' + (response.data ? response.data.message : 'Unknown error'));
                        isImporting = false;
                        $('#start-import').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    logMessage('Error: ' + error);
                    isImporting = false;
                    $('#start-import').prop('disabled', false);
                }
            });
        }

        $('#start-import').click(function() {
            $(this).prop('disabled', true);
            $('#import-progress').show();
            $('#import-log').empty();
            totalProcessed = 0;
            isImporting = true;
            offset = null;
            importBatch();
        });
    });
    </script>
    <?php
}

function import_startups_batch() {
    // Verify nonce
    if (!check_ajax_referer('import_startups_nonce', 'nonce', false)) {
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
    $tableName = "tbljHA2exehxeQG11";
    $batch_size = 100; // Process 5 records at a time
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
            $existing_startups = get_posts([
                'post_type'      => 'startup',
                'posts_per_page' => -1,
                'post_status'    => 'any'
            ]);

            foreach ($existing_startups as $startup) {
                wp_delete_post($startup->ID, true);
            }

            // Delete existing taxonomy terms
            $taxonomies = ['industry', 'startup-technology'];
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
            
            // Create startup post
            $post_data = [
                'post_title'   => $fields['Company'] ?? 'Untitled Startup',
                'post_content' => $fields['Description'] ?? '',
                'post_type'    => 'startup',
                'post_status'  => 'publish'
            ];

            $post_id = wp_insert_post($post_data);

            if (!is_wp_error($post_id)) {
                // Handle logo upload
                if (!empty($fields['Logo']) && is_array($fields['Logo']) && !empty($fields['Logo'][0]['url'])) {
                    $logo_url = $fields['Logo'][0]['url'];
                    $logo_filename = $fields['Logo'][0]['filename'];
                    
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    
                    $tmp = download_url($logo_url);
                    
                    if (!is_wp_error($tmp)) {
                        $file_array = array(
                            'name'     => $logo_filename,
                            'tmp_name' => $tmp,
                            'error'    => 0,
                            'size'     => filesize($tmp)
                        );
                        
                        $logo_id = media_handle_sideload($file_array, $post_id);
                        
                        if (!is_wp_error($logo_id)) {
                            set_post_thumbnail($post_id, $logo_id);
                            update_field('logo', $logo_id, $post_id);
                        }
                        
                        @unlink($tmp);
                    }
                }

                // Map Airtable fields to ACF fields
                update_field('cohort', $fields['Cohort'] ?? '', $post_id);
                update_field('website', $fields['Website'] ?? '', $post_id);
                update_field('portfolio_onboard', $fields['Portfolio Onboard'] ?? '', $post_id);
                update_field('tagline', $fields['Tagline'] ?? '', $post_id);
                update_field('description', $fields['Description'] ?? '', $post_id);
                update_field('pitch_vc_link', $fields['Pitch.vc link'] ?? '', $post_id);
                update_field('uei', $fields['UEI'] ?? '', $post_id);

                // Handle custom taxonomy "industry"
                if (!empty($fields['Industry'])) {
                    $industry_names = explode(',', $fields['Industry']);
                    $industry_names = array_map('trim', $industry_names);
                    $industry_names = array_filter($industry_names, function ($industry) {
                        return !is_numeric($industry) && !empty($industry);
                    });

                    foreach ($industry_names as $industry) {
                        if (!term_exists($industry, 'industry')) {
                            wp_insert_term($industry, 'industry');
                        }
                    }
                    wp_set_object_terms($post_id, $industry_names, 'industry', false);
                }

                // Handle custom taxonomy "startup-technology"
                if (!empty($fields['Technologies'])) {
                    $technologies = $fields['Technologies'];
                    foreach ($technologies as $tech) {
                        if (!term_exists($tech, 'startup-technology')) {
                            wp_insert_term($tech, 'startup-technology');
                        }
                    }
                    wp_set_object_terms($post_id, $technologies, 'startup-technology', false);
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


