<?php
/**
 * Testing Elevated Database class.
 * It handles all the database related operations.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\Singleton;

/**
 * Class TE_DB
 * It handles all the database related operations.
 */
class TE_DB {
	/**
	 * Use Singleton trait.
	 */
	use Singleton;

	/**
	 * TE_DB constructor.
	 * It is a private constructor to prevent direct object creation.
	 */
	private function __construct() {
		// Use SAVEQUERIES to store all the queries.
		define( 'SAVEQUERIES', true );

		$this->init_db();
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

		$wpdb = new \wpdb( $db_user, $db_password, $db_name, $db_host ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
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
	}

	/**
	 * Rollback testing.
	 * It rolls back all the queries.
	 *
	 * @return void
	 */
	public function rollback() : void {
		global $wpdb;

		$wpdb->query( 'ROLLBACK' );
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
		global $wpdb;

		$queries = $wpdb->queries ?? array();

		$queries = array_map(
			function( $query ) {
				return $query[0];
			},
			$queries
		);

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

		$query = TE_Query::get_instance()->get();

		foreach ( $query as $sql ) {
			$wpdb->query( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		}
	}
}

