<?php
/**
 * Plugin autoloader config
 * Declare all constants here.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated;

/**
 * Define constants below for specific plugin.
 * Edit this file as per the plugin.
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
	define( 'PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/testing-elevated/' );
}

