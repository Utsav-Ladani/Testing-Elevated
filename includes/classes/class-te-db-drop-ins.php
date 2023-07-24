<?php

namespace Testing_Elevated\Includes\Classes;

/**
 * Class TE_DB_Drop_Ins
 * It handles all the database related operations.
 */

class TE_DB_Drop_Ins extends \wpdb {
    public static $te_queries = array();
    
    public function query( $query ) {
        $result = parent::query( $query );

        // If the query is a INSERT query, then get the last inserted id.
        if ( preg_match( '/^INSERT/', $query ) ) {

            $table_name = explode( ' ', $query )[2];
            $table_name = str_replace( '`', '', $table_name );
            $table_name = str_replace( '\'', '', $table_name );
            $table_name = str_replace( '\"', '', $table_name );

            $te_query = array(
                'query' => $query,
                'type'  => 'insert',
                'id'    => $this->insert_id,
                'table' => $table_name,
            );

            self::$te_queries[] = $te_query;

            // error_log( 'te_query: ' . print_r( $te_query, true ) );
        }
        else if ( preg_match( '/^UPDATE/', $query ) ) {
            $te_query = array(
                'query' => $query,
                'type'  => 'non-insert',
            );
            self::$te_queries[] = $te_query;

            // error_log( 'te_query: ' . print_r( $te_query, true ) );
        }

        // else {
        //     $te_query = array(
        //         'query' => $query,
        //         'type'  => 'non-insert',
        //     );
        //     self::$te_queries[] = $te_query;
        // }

        // print_r( var_dump( self::$te_queries ) );
        // print_r( 'asdfghkjhgfds' );

        return $result;
	}
}

