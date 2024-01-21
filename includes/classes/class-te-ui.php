<?php
/**
 * Testing Elevated plugin UI class.
 * It renders the right side menu and notices.
 *
 * @package testing-elevated
 */

namespace Testing_Elevated\Includes\Classes;

use Testing_Elevated\Includes\Traits\TE_Singleton;

require_once WP_CONTENT_DIR . '/plugins/testing-elevated/plugin-config.php';

/**
 * Class TE_UI
 * It renders the right side menu and notices.
 */
class TE_UI {
	/**
	 * Use Singleton trait.
	 */
	use TE_Singleton;

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		$this->add_menu();
	}

	/**
	 * Add menu to UI.
	 *
	 * @return void
	 */
	public function add_menu(): void {
		add_action( 'wp_head', array( $this, 'render_menu' ) );
		add_action( 'admin_head', array( $this, 'render_menu' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_menu_styles_and_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_menu_styles_and_scripts' ) );
	}

	/**
	 * Render the right side menu.
	 *
	 * @return void
	 */
	public function render_menu(): void {
		?>
		<div class="te-menu-wrapper">
			<div class="te-menu__title">
				<img class="te-menu__title__image" src="<?php echo esc_url( TE_PLUGIN_URL . 'assets/images/te_logo.png' ); ?>" alt="Testing Elevated">
			</div>
			<ul id="te-menu" class="te-menu">
				<li id="te-start" class="te-menu__item" data-action="te_start">Start</li>
				<li id="te-commit" class="te-menu__item" data-action="te_commit">Commit</li>
				<li id="te-rollback" class="te-menu__item" data-action="te_rollback">Rollback</li>
			</ul>
		</div>
		<?php
	}

	/**
	 * Enqueue the styles and scripts for the menu.
	 *
	 * @return void
	 */
	public function enqueue_menu_styles_and_scripts(): void {
		wp_enqueue_style(
			'te-menu-style',
			TE_PLUGIN_URL . 'assets/css/menu.css',
			array(),
			filemtime( TE_PLUGIN_DIR . 'assets/css/menu.css' )
		);

		wp_enqueue_script(
			'te-menu-script',
			TE_PLUGIN_URL . 'assets/js/menu.js',
			array(),
			filemtime( TE_PLUGIN_DIR . 'assets/js/menu.js' ),
			true
		);

		wp_localize_script(
			'te-menu-script',
			'te_menu_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'te_nonce' ),
				'enabled'  => TE::get_instance()->is_enabled(),
			)
		);
	}
}
