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
	private function includes() {   }

	/**
	 * Registers hooks
	 */
	private function register_hooks() {
		 add_action( 'gust_register_components', [ $this, 'register_components' ] );
		add_filter( 'gust_tag_pre_output', [ $this, 'tag_pre_output' ], 10, 5 );
	}

	/**
	 * Determines wether an array has a key or not
	 *
	 * @param string $key The key to check for.
	 * @param mixed  $array The array to check.
	 */
	private static function array_has_key( $key, $array ) {
		return array_key_exists( $key, $array ) && ! empty( $array[ $key ] );
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
				'collapse',
				'kbd',
				'loading',
				'progress',
				'stats',
				'tooltip',
			),
			'data-input'   => array(
				'checkbox',
				'radio',
				'range',
				'select',
			),
			'layout'       => array(
				'artboard',
				'divider',
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

	/**
	 * Filters the output of various components.
	 *
	 * @param string $output The HTML to putout.
	 * @param mixed  $context Any context that is applied.
	 * @param object $tag Details of the tag.
	 * @param mixed  $component_details The component details, if any, otherwise null.
	 * @param mixed  $parent_component_details The parent component details, if any, otherwise null.
	 */
	public function tag_pre_output( $output, $context, $tag, $component_details, $parent_component_details ) {
		if ( ! self::array_has_key( 'id', $tag ) ) {
			return $output;
		}
		switch ( $tag['id'] ) {
			case 'daisyui-select-input': 
				return $this->select_input_output( $parent_component_details );

			default: 
				return $output;

		}
	}

	/**
	 * Outputs HTML options for the select component.
	 *
	 * @param mixed $parent_component_details The parent component details, if any, otherwise null.
	 */
	private function select_input_output( $parent_component_details ) {
		$options = '<option selected disabled>Pick one</option>';
		if ( ! $parent_component_details && ! self::array_has_key( 'options', $parent_component_details ) && ! self::array_has_key( 'selectOptions', $parent_component_details['options'] ) ) {
			return $options;
		}

		$option_lines = explode( "\n", $parent_component_details['options']['selectOptions'] );
		foreach ( $option_lines as $option_line ) {
			$trimmed_line = trim( $option_line );
			if ( empty( $trimmed_line ) ) {
				continue;
			}
			$value_labels = explode( '=', $trimmed_line );
			$value        = $value_labels[0];
			$label        = self::array_has_key( 1, $value_labels ) ? $value_labels[1] : $value_labels[0];
			$options     .= '<option value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
		}
		return $options;
	}
}
Gust_Daisyui::instance();
