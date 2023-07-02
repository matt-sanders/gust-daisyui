<?php

/**
 * Gust Daisy UI
 * 
 * @package GustDaisyui
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Gust Daisy UI class.
 */
class Gust_Daisyui {



	/**
	 * The single instance of the class
	 * 
	 * @var Gust Daisyui
	 */
	protected static $_instance = null; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * The path to the plugin file
	 *
	 * @var string
	 */
	private $plugin_path;


	/**
	 * Main Gust Daisyui Instance.
	 * Ensures only one instance of Gust Daisyui is loaded or can be loaded.
	 * 
	 * @return Gust Daisyui - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Gust Daisyui constructor
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->register_hooks();
	}

	/**
	 * Defines constants
	 */
	private function define_constants() {
		define( 'GUST_DAISYUI_PLUGIN_ABSPATH', dirname( GUST_DAISYUI_PLUGIN_FILE ) . '/' );
		define( 'GUST_DAISYUI_PLUGIN_URL', plugins_url( '/', GUST_DAISYUI_PLUGIN_FILE ) );
		define( 'GUST_DAISYUI_PLUGIN_NONCE', 'GUST_DAISYUI_PLUGIN_NONCE' );
	}

	/**
	 * Includes files
	 */
	private function includes() {
	}

	/**
	 * Registers hooks
	 */
	private function register_hooks() {
		add_action( 'gust_register_components', [ $this, 'register_components' ] );
	}

	/** 
	 * Registers components
	 *
	 * @param Gust_Components $gust_components An instance of the gust components class.
	 */
	public function register_components( $gust_components ) {
		$component_dirs = array(
			'actions'      => array(
				'button',
			),
			'data-display' => array(
				'badge',
				// 'collapse',
				'kbd',
				'loading',
				'progress',
				'stats',
			),
		);

		foreach ( $component_dirs as $component_dir => $components ) {
			foreach ( $components as $component ) {
				$content = file_get_contents( GUST_DAISYUI_PLUGIN_ABSPATH . 'components/' . $component_dir . '/' . $component . '.json' );
				if ( ! $content ) {
					continue;
				}
				$layout = json_decode( $content, true );
				if ( $layout ) {
					$gust_components->register_component( $layout['id'], $layout );
				}
			}
		}
	}
}
Gust_Daisyui::instance();
