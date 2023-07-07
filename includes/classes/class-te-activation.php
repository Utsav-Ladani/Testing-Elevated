<?php
/**
 * Testing Elevated plugin activation class.
 * It handles all the activation and deactivation related operations.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\Singleton;

/**
 * Class TE_Activation
 * It handles all the activation and deactivation related operations.
 */
class TE_Activation {
	/**
	 * Use Singleton trait.
	 */
	use Singleton;

	/**
	 * Plugin activation function.
	 * It copies the db.php Drop-ins file to the wp-content directory.
	 *
	 * @return void
	 */
	public function activate() : void {
		TE_File::get_instance()->copy( '/plugins/testing-elevated/wp-content/db.php', '/db-2.php' );
	}

	/**
	 * Plugin deactivation function.
	 * It deletes the db.php Drop-ins file from the wp-content directory.
	 *
	 * @return void
	 */
	public function deactivate() : void {
		TE_File::get_instance()->delete( '/db-2.php' );
	}
}
