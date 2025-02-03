<?php

class WP_Miusage_Block_Renderer {

    public function __construct() {
        add_action('init', [ $this, 'register_block' ]);
    }

    public function register_block() {
        register_block_type('wp-miusage-api-block/block', [
            'render_callback' => [ $this, 'render_block' ]
        ]);
    }

    public function render_block($attributes) {
        $api_handler = new WP_Miusage_API_Handler();
        $data = $api_handler->get_data();

        if ( empty($data) ) {
            return 'Failed to fetch data';
        }

        ob_start();
        ?>
        <div class="miusage-api-block">
            <h2><?php echo esc_html($data['title']); ?></h2>
            <table>
                <thead>
                    <tr>
                        <?php foreach ($data['data']['headers'] as $header) : ?>
                            <th><?php echo esc_html($header); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['data']['rows'] as $row) : ?>
                        <tr>
                            <td><?php echo esc_html($row['id']); ?></td>
                            <td><?php echo esc_html($row['fname']); ?></td>
                            <td><?php echo esc_html($row['lname']); ?></td>
                            <td><?php echo esc_html($row['email']); ?></td>
                            <td><?php echo esc_html(date('Y-m-d H:i:s', $row['date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }
}
