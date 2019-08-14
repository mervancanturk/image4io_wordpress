<?php 
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die;
    }

    delete_option('image4io_apiKey');

    delete_option('image4io_apiSecret');

    delete_option('image4io_path');

?>