<?php

class WP_Miusage_API_Handler {

    private $api_url = 'https://miusage.com/v1/challenge/1/';

    public function get_data() {
        $data = get_transient('miusage_data');

        if ( false === $data ) {
            $response = wp_remote_get($this->api_url);

            if ( is_wp_error($response) ) {
                return [];
            }

            $data = json_decode(wp_remote_retrieve_body($response), true);

            set_transient('miusage_data', $data, HOUR_IN_SECONDS);
        }

        return $data;
    }
}
