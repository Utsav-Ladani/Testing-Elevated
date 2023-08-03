<?php
/**
 * Drop-ins db.php
 * This files initializes the database connection.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated;

require_once WP_CONTENT_DIR . '/plugins/testing-elevated/includes/helpers/class-autoloader.php';

use Testing_Elevated\Includes\Classes\TE;

/**
 * Initialize the database and testing environment.
 * It defines the global $wpdb and starts the testing environment.
 */
TE::get_instance();
