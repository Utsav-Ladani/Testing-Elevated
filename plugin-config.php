<?php
/**
 * Testing Elevated plugin config
 * Declare all constants here.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated;

/**
 * Define constants below.
 */

/**
 * Plugin namespace.
 *
 * @const string PLUGIN_NAMESPACE Plugin namespace.
 */
if ( ! defined( 'PLUGIN_NAMESPACE' ) ) {
	define( 'PLUGIN_NAMESPACE', 'Testing_Elevated' );
}

/**
 * Plugin directory path.
 *
 * @const string PLUGIN_DIR Plugin directory path.
 */
if ( ! defined( 'PLUGIN_DIR' ) ) {
	define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Plugin directory URL.
 *
 * @const string PLUGIN_URL Plugin directory URL.
 */
if ( ! defined( 'PLUGIN_URL' ) ) {
	define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
