<?php

// Airtable credentials for Industries
$industriesApiKey = "patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce";
$industriesBaseId = "app3c8mUha4KsZAQV";
$industriesTableName = "tblu4acZqXuqwcrTk";

/**
 * Import industries from Airtable into the 'industry' taxonomy
 * 
 * @param string $apiKey Airtable API key
 * @param string $baseId Airtable base ID
 * @param string $tableName Airtable table name
 * @param bool $limit_to_100 Whether to limit the import to 100 records
 * @return int|bool Number of imported records or false on error
 */
function import_airtable_industries($apiKey, $baseId, $tableName, $limit_to_100 = false) {
    // Step 1: Delete all existing 'industry' taxonomy terms
    $existing_terms = get_terms([
        'taxonomy' => 'industry',
        'hide_empty' => false
    ]);

    foreach ($existing_terms as $term) {
        wp_delete_term($term->term_id, 'industry');
    }

    // Step 2: Import fresh data from Airtable with pagination
    $all_records = [];
    $offset = null;
    $imported_count = 0;

    do {
        $url = "https://api.airtable.com/v0/{$baseId}/{$tableName}?pageSize=100";
        if ($offset) {
            $url .= "&offset=" . urlencode($offset);
        }

        // If limiting to 100 records, only do one iteration
        if ($limit_to_100 && $imported_count > 0) {
            break;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$apiKey}"
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            error_log("Airtable API Error: " . $response);
            return false;
        }

        $data = json_decode($response, true);

        if (!isset($data['records'])) {
            error_log("No records found in Airtable response");
            return false;
        }

        foreach ($data['records'] as $record) {
            $fields = $record['fields'];
            $record_id = $record['id']; // Get the Airtable record ID
            
            // Skip if no name is provided
            if (empty($fields['Name'])) {
                continue;
            }

            $industry_name = $fields['Name'];
            
            // Check if term already exists
            $term = term_exists($industry_name, 'industry');
            
            if (!$term) {
                // Create new term
                $result = wp_insert_term($industry_name, 'industry');
                
                if (!is_wp_error($result)) {
                    $term_id = $result['term_id'];
                    
                    // Add the Airtable record ID to the custom field "id"
                    update_field('id', $record_id, 'industry_' . $term_id);
                    
                    $imported_count++;
                }
            } else {
                // Term exists, update the ID field
                $term_id = $term['term_id'];
                update_field('id', $record_id, 'industry_' . $term_id);
                $imported_count++;
            }
        }
        
        // Check if there are more records to fetch
        $offset = $data['offset'] ?? null;

    } while ($offset && (!$limit_to_100 || $imported_count < 100));
    
    return $imported_count;
}

// Add a submenu page under the 'startup' custom post type menu
function register_import_industries_submenu() {
    add_submenu_page(
        'edit.php?post_type=startup',        // Parent slug (the startups admin page)
        'Import Industries',                  // Page title
        'Import Industries',                  // Menu title (what appears in the menu)
        'manage_options',                     // Capability required to access
        'import_industries',                  // Menu slug
        'import_industries_page_callback'     // Callback function that renders the page
    );
}
add_action('admin_menu', 'register_import_industries_submenu');

// Callback function for the Import Industries page
function import_industries_page_callback() {
    // Make sure to have your Airtable credentials available here
    global $industriesApiKey, $industriesBaseId, $industriesTableName;
    
    // Check if the button was clicked and verify the nonce
    if (isset($_GET['action']) && $_GET['action'] === 'import' && check_admin_referer('import_industries_action', 'import_nonce')) {
        // Check if limit option is selected
        $limit_to_100 = isset($_GET['limit_to_100']) && $_GET['limit_to_100'] === 'yes';
        
        $imported_count = import_airtable_industries($industriesApiKey, $industriesBaseId, $industriesTableName, $limit_to_100);
        
        if ($imported_count !== false) {
            $message = $imported_count . ' industries imported successfully.';
            if ($limit_to_100) {
                $message .= ' (Limited to 100 records)';
            }
            echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Error importing industries. Please check the error log.</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1>Import Industries from Airtable</h1>
        <p>Click the button below to import industries from Airtable into the "industry" taxonomy.</p>
        <form method="get">
            <input type="hidden" name="post_type" value="startup">
            <input type="hidden" name="page" value="import_industries">
            <?php wp_nonce_field('import_industries_action', 'import_nonce'); ?>
            
            <!-- <p>
                <label>
                    <input type="checkbox" name="limit_to_100" value="yes">
                    Limit import to 100 records (for testing)
                </label>
            </p> -->
            
            <p>
                <input type="submit" name="action" value="import" class="button button-primary" />
            </p>
        </form>
    </div>
    <?php
}
