<?php
/**
 * Testing Elevated plugin ajax class.
 * It handles all the ajax requests. These requests are used to start or stop the testing.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\TE_Singleton;

/**
 * Class TE_AJAX
 * It handles all the ajax requests. These requests are used to start or stop the testing.
 */
class TE_AJAX {
	/**
	 * Use Singleton trait.
	 */
	use TE_Singleton;

	/**
	 * Valid ajax actions.
	 *
	 * @var string[] Valid ajax actions.
	 */
	private array $valid_actions = array(
		'te_start',
		'te_commit',
		'te_rollback',
	);

	/**
	 * TE_AJAX constructor.
	 * It attaches the ajax actions.
	 */
	public function __construct() {
		// Start testing.
		add_action( 'wp_ajax_te_start', array( $this, 'start_testing' ) );
		add_action( 'wp_ajax_nopriv_te_start', array( $this, 'start_testing' ) );

		// Commit changes made during testing.
		add_action( 'wp_ajax_te_commit', array( $this, 'commit_changes' ) );
		add_action( 'wp_ajax_nopriv_te_commit', array( $this, 'commit_changes' ) );

		// Rollback changes made during testing.
		add_action( 'wp_ajax_te_rollback', array( $this, 'rollback_changes' ) );
		add_action( 'wp_ajax_nopriv_te_rollback', array( $this, 'rollback_changes' ) );
	}

	/**
	 * Check if the request is a TE AJAX request.
	 *
	 * @return bool
	 */
	public function is_te_ajax_request(): bool {
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			return false;
		}

		// custom sanitization and validation.
		return in_array( $_REQUEST['action'], $this->valid_actions, true ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	/**
	 * Start the testing.
	 *
	 * @return void
	 */
	public function start_testing(): void {
		$this->nonce_check();

		update_option( 'TE_Status', true );

		wp_send_json_success( 'You can now start testing.' );
	}

	/**
	 * Commit the changes made during testing.
	 *
	 * @return void
	 */
	public function commit_changes(): void {
		$this->nonce_check();

		TE::get_instance()->fire_old_queries();
		TE::get_instance()->commit();
		TE::get_instance()->cleanup();

		wp_send_json_success( 'Changes made during testing are committed.' );
	}

	/**
	 * Rollback the changes made during testing.
	 *
	 * @return void
	 */
	public function rollback_changes(): void {
		$this->nonce_check();

		TE::get_instance()->rollback();

		wp_send_json_success( 'Changes made during testing are rolled back.' );
	}

	/**
	 * Check if the nonce is valid.
	 *
	 * @return void
	 */
	public function nonce_check(): void {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'te_nonce' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}
	}
}
