<?php
/**
 * Testing Elevated plugin ajax class.
 * It handles all the ajax requests. These requests are used to start or stop the testing.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\Singleton;

/**
 * Class TE_AJAX
 * It handles all the ajax requests. These requests are used to start or stop the testing.
 */
class TE_AJAX {
	/**
	 * Use Singleton trait.
	 */
	use Singleton;

	/**
	 * TE_AJAX constructor.
	 * It attaches the ajax actions.
	 */
	public function __construct() {
		// Start testing.
		add_action( 'wp_ajax_te_start_testing', array( $this, 'start_testing' ) );
		add_action( 'wp_ajax_nopriv_te_start_testing', array( $this, 'start_testing' ) );

		// Commit changes made during testing.
		add_action( 'wp_ajax_te_commit_changes', array( $this, 'commit_changes' ) );
		add_action( 'wp_ajax_nopriv_te_commit_changes', array( $this, 'commit_changes' ) );

		// Rollback changes made during testing.
		add_action( 'wp_ajax_te_rollback_changes', array( $this, 'rollback_changes' ) );
		add_action( 'wp_ajax_nopriv_te_rollback_changes', array( $this, 'rollback_changes' ) );
	}

	/**
	 * Check if the request is a TE AJAX request.
	 *
	 * @return bool
	 */
	public function is_te_ajax_request() : bool {
		return defined( 'DOING_AJAX' ) &&
			isset( $_REQUEST['action'] ) && // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			str_starts_with( $_REQUEST['action'], 'te_' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	/**
	 * Start the testing.
	 *
	 * @return void
	 */
	public function start_testing() : void {
		update_option( 'TE_Status', true );

		wp_send_json_success( 'You can now start testing.' );
	}

	/**
	 * Commit the changes made during testing.
	 *
	 * @return void
	 */
	public function commit_changes() : void {
		TE_DB::get_instance()->fire_old_queries();
		TE_DB::get_instance()->commit();
		TE_DB::get_instance()->cleanup();

		wp_send_json_success( 'Changes made during testing are committed.' );
	}

	/**
	 * Rollback the changes made during testing.
	 *
	 * @return void
	 */
	public function rollback_changes() : void {
		TE_DB::get_instance()->rollback();

		wp_send_json_success( 'Changes made during testing are rolled back.' );
	}
}


