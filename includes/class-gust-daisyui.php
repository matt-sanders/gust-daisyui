<?php
/**
 * Gust Daisy UI
 * 
 * @package GustDaisyui
 */

defined('ABSPATH') || exit;

/**
 * Main Gust Daisy UI class.
 */
class Gust_Daisyui
{
    /**
     * The single instance of the class
     * 
     * @var Gust Daisyui
     */
    protected static $_instance = null; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore


    /**
     * Main Gust Daisyui Instance.
     * Ensures only one instance of Gust Daisyui is loaded or can be loaded.
     * 
     * @return Gust Daisyui - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Gust Daisyui constructor
     */
    public function __construct()
    {
        $this->define_constants();  
        $this->includes();
    }

    /**
     * Defines constants
     */
    private function define_constants()
    {
        define('GUST_DAISYUI_PLUGIN_ABSPATH', dirname(GUST_DAISYUI_PLUGIN_FILE) . '/');
        define('GUST_DAISYUI_PLUGIN_URL', plugins_url('/', GUST_DAISYUI_PLUGIN_FILE));
        define('GUST_DAISYUI_PLUGIN_NONCE', 'GUST_DAISYUI_PLUGIN_NONCE');
    }

    /**
     * Includes files
     */
    private function includes()
    {
    }

}
Gust_Daisyui::instance();
