<?php 


// Airtable credentials
$apiKey = "patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce";
$baseId = "app3c8mUha4KsZAQV";
$tableName = "tbljHA2exehxeQG11";




function import_airtable_startups($apiKey, $baseId, $tableName)
{
	// Step 1: Delete all existing 'startup' posts
	$existing_startups = get_posts([
		'post_type'      => 'startup',
		'posts_per_page' => -1,
		'post_status'    => 'any'
	]);

	foreach ($existing_startups as $startup) {
		wp_delete_post($startup->ID, true); // Force delete without sending to trash
	}

	// Step 2: Delete all existing taxonomy terms
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

	// Step 3: Import fresh data from Airtable with pagination
	$all_records = [];
	$offset = null;

	do {
		$url = "https://api.airtable.com/v0/{$baseId}/{$tableName}?pageSize=100";
		if ($offset) {
			$url .= "&offset=" . urlencode($offset);
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
			break;
		}

		$data = json_decode($response, true);

		if (!isset($data['records'])) {
			error_log("No records found in Airtable response");
			break;
		}

		// Process records from this page
		foreach ($data['records'] as $record) {
			$fields = $record['fields'];

			// Create a new startup post
			$post_id = wp_insert_post([
				'post_title'   => $fields['Company'],
				'post_content' => $fields['Description'] ?? '',
				'post_type'    => 'startup',
				'post_status'  => 'publish'
			]);

			if ($post_id && !is_wp_error($post_id)) {
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

		// Get offset for next page
		$offset = $data['offset'] ?? null;

	} while ($offset);
}













// Add a submenu page under the 'startup' custom post type menu
function register_import_startups_submenu() {
    add_submenu_page(
        'edit.php?post_type=startup',        // Parent slug (the startups admin page)
        'Import Startups',                    // Page title
        'Import',                             // Menu title (what appears in the menu)
        'manage_options',                     // Capability required to access
        'import_startups',                    // Menu slug
        'import_startups_page_callback'       // Callback function that renders the page
    );
}
add_action('admin_menu', 'register_import_startups_submenu');



// Callback function for the Import page
function import_startups_page_callback() {
    // Make sure to have your Airtable credentials available here
    global $apiKey, $baseId, $tableName;
    
    // Check if the button was clicked and verify the nonce
    if ( isset($_GET['action']) && $_GET['action'] === 'import' && check_admin_referer('import_startups_action', 'import_nonce') ) {
        import_airtable_startups($apiKey, $baseId, $tableName);
        echo '<div class="notice notice-success is-dismissible"><p>Startups imported successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Import Startups from Airtable</h1>
        <p>Click the button below to import startups from Airtable.</p>
        <form method="get">
            <input type="hidden" name="post_type" value="startup">
            <input type="hidden" name="page" value="import_startups">
            <?php wp_nonce_field('import_startups_action', 'import_nonce'); ?>
            <p>
                <input type="submit" name="action" value="import" class="button button-primary" />
            </p>
        </form>
    </div>
    <?php
}
