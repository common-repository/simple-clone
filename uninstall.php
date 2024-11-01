<?php
// if uninstall not called from wordpress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// perform cleanup operations (e.g., delete options, custom tables, etc.)
delete_option( 'simple_clone_option' );
