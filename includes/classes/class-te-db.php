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
 * Custom database class extends wpdb.
 */
class TE_DB extends \wpdb {
	/**
	 * Store all the queries.
	 *
	 * @var array $te_queries
	 */
	public static $te_queries = array();

	/**
	 * Store current query.
	 *
	 * @var array $current_te_query
	 */
	public $current_te_query = array();

	/**
	 * Override the wpdb query function.
	 *
	 * @param string $query SQL query string.
	 *
	 * @return bool|int|\mysqli_result|resource|null
	 */
	public function query( $query ) {
		$result = parent::query( $query );

		// If the query is to fix the previous INSERT query, then return the result and don't record.
		if ( is_array( $this->current_te_query ) && isset( $this->current_te_query->insert_correct_query ) && $this->current_te_query->insert_correct_query ) {
			return $result;
		}

		self::$te_queries[] = $this->get_te_query( $query );

		return $result;
	}

	/**
	 * Create the TE query with extra parameters.
	 *
	 * @param string $query SQL query string.
	 *
	 * @return array
	 */
	private function get_te_query( string $query ): array {
		if ( str_starts_with( $query, 'INSERT' ) ) {

			$table_name = explode( ' ', $query )[2];
			$table_name = str_replace( '`', '', $table_name );
			$table_name = str_replace( '\'', '', $table_name );
			$table_name = str_replace( '"', '', $table_name );

			return array(
				'query' => $query,
				'type'  => 'insert',
				'id'    => $this->insert_id,
				'table' => $table_name,
			);
		}

		if ( str_starts_with( $query, 'UPDATE' ) ) {
			return array(
				'query' => $query,
				'type'  => 'update',
			);
		}

		if ( str_starts_with( $query, 'DELETE' ) ) {
			return array(
				'query' => $query,
				'type'  => 'delete',
			);
		}

		if ( str_starts_with( $query, 'SELECT' ) ) {
			return array(
				'query' => $query,
				'type'  => 'select',
			);
		}

		return array(
			'query' => $query,
			'type'  => 'unknown',
		);
	}
}

