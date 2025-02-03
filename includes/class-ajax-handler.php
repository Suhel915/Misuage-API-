<?php

class WP_Miusage_AJAX_Handler {

    public function __construct() {
        add_action('wp_ajax_get_miusage_data', [ $this, 'get_miusage_data' ]);
        add_action('wp_ajax_nopriv_get_miusage_data', [ $this, 'get_miusage_data' ]);
    }

    public function get_miusage_data() {
        $api_handler = new WP_Miusage_API_Handler();
        $data = $api_handler->get_data();

        if ( empty($data) ) {
            wp_send_json_error([ 'message' => 'Failed to fetch data' ]);
        }

        wp_send_json_success($data);
    }
}
