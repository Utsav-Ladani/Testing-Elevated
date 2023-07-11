<?php
/**
 * Plugin Name: Testing Elevated
 * Description: Feel free to test and revert or commit the changes.
 * Author:      Utsav Ladani
 * Author URI:  https://profiles.wordpress.org/utsavladani/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0
 * Text Domain: testing-elevated
 *
 * @package testing-elevated
 */

namespace Testing_Elevated;

require_once __DIR__ . '/includes/helpers/class-autoloader.php';

use Testing_Elevated\Includes\Classes\TE_Activation;
use Testing_Elevated\Includes\Classes\TE_AJAX;
use Testing_Elevated\Includes\Classes\TE_UI;

// Register activation hook.
register_activation_hook( __FILE__, array( TE_Activation::get_instance(), 'activate' ) );

// Register deactivation hook.
register_deactivation_hook( __FILE__, array( TE_Activation::get_instance(), 'deactivate' ) );

// Register AJAX hooks.
TE_AJAX::get_instance();
TE_UI::get_instance();
