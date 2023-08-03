<?php
/**
 * Testing Elevated main class.
 * It handles all the database and testing related operations.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\Singleton;

/**
 * Class TE
 * It is a main class
 * It handles all the database and testing related operations
 */
class TE {
	/**
	 * Use Singleton trait.
	 */
	use Singleton;

	/**
	 * TE constructor.
	 * It is a private constructor to prevent direct object creation.
	 */
	private function __construct() {
		// disable testing environment for self ajax requests.
		if ( TE_AJAX::get_instance()->is_te_ajax_request() ) {
			return;
		}

		$this->init_db();

		if ( ! $this->is_enabled() ) {
			return;
		}

		$this->start();
		$this->fire_old_queries();
		$this->end();
	}

	/**
	 * Initialize the database.
	 * It assigns db instance to global $wpdb.
	 *
	 * @return void
	 */
	public function init_db() : void {
		global $wpdb;

		$db_user     = defined( 'DB_USER' ) ? DB_USER : '';
		$db_password = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : '';
		$db_name     = defined( 'DB_NAME' ) ? DB_NAME : '';
		$db_host     = defined( 'DB_HOST' ) ? DB_HOST : '';

		$wpdb = new TE_DB( $db_user, $db_password, $db_name, $db_host ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	/**
	 * Check if the testing is enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() : bool {
		global $wpdb;

		return '1' === $wpdb->get_var( "SELECT option_value FROM wp_options WHERE option_name = 'TE_Status'" );
	}

	/**
	 * Start testing.
	 * It sets the autocommit to false.
	 *
	 * @return void
	 */
	public function start() : void {
		global $wpdb;

		$wpdb->query( 'SET autocommit = 0' );
	}

	/**
	 * Commit testing.
	 * It commits all the queries.
	 */
	public function commit() : void {
		global $wpdb;

		$wpdb->query( 'COMMIT' );
		$wpdb->query( 'SET autocommit = 1' );
	}

	/**
	 * Rollback testing.
	 * It rolls back all the queries.
	 *
	 * @return void
	 */
	public function rollback() : void {
		// delete all the queries so next time they don't execute.
		TE_Query::get_instance()->delete();
	}

	/**
	 * End testing.
	 * It commits all the queries.
	 *
	 * @return void
	 */
	public function end() : void {
		register_shutdown_function( array( $this, 'record_queries' ) );
	}

	/**
	 * Record all queries.
	 * It records all the queries fired during the test.
	 *
	 * @hook query
	 *
	 * @return void
	 */
	public function record_queries() : void {
		$queries = TE_DB::$te_queries;

		TE_Query::get_instance()->save( $queries );
	}

	/**
	 * Fire old queries.
	 * It fires all the queries recorded during the test.
	 *
	 * @return void
	 */
	public function fire_old_queries() : void {
		global $wpdb;

		$queries = TE_Query::get_instance()->get();

		foreach ( $queries as $query ) {
			$result = $wpdb->query( $query['query'] ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

			if ( 'insert' === $query['type'] ) {
				// get the table name from the query.
				$wpdb->update( $query['table'], array( 'id' => $query['id'] ), array( 'id' => $wpdb->insert_id ) );
			}
		}
	}

	/**
	 * Clean up after committing the changes.
	 *
	 * @return void
	 */
	public function cleanup() : void {
		global $wpdb;

		// delete all the queries.
		TE_Query::get_instance()->delete();

		// delete all the options.
		$wpdb->query( "DELETE FROM wp_options WHERE option_name LIKE 'TE_Status'" );
	}
}

