<?php
/**
 * The My_WP_Plugin plugin for WordPress.
 *
 * WordPress plugin header information:
 *
 * * Plugin Name: My_WP_Plugin
 * * Plugin URI: https://github.com/meitar/My_WP_Plugin
 * * Description: My Plugin Description
 * * Version: 0.1
 * * Author: My Name <my_email_address@example.com>
 * * Author URI: https://example.com/
 * * License: GPL-3
 * * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * * Text Domain: My_WP_Plugin
 * * Domain Path: /languages
 *
 * @link https://developer.wordpress.org/plugins/the-basics/header-requirements/
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2016 by My Name
 *
 * @package WordPress\Plugin\My_WP_Plugin
 */

if (!defined('ABSPATH')) { exit; } // Disallow direct HTTP access.

/**
 * Base class that WordPress uses to register and initialize plugin.
 */
class My_WP_Plugin {

    /**
     * String to prefix option names, settings, etc. in shared spaces.
     *
     * Some WordPress data storage areas are basically one globally
     * shared namespace. For example, names of options saved in WP's
     * options table must be globally unique. When saving data in any
     * such shared space, we need to prefix the name we use.
     *
     * @var string
     */
    public static $prefix = 'My_WP_Plugin';

    /**
     * Entry point for the WordPress framework into plugin code.
     *
     * This is the method called when WordPress loads the plugin file.
     * It is responsible for "registering" the plugin's main functions
     * with the {@see https://codex.wordpress.org/Plugin_API WordPress Plugin API}.
     *
     * @uses add_action()
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     *
     * @return void
     */
    public static function register () {
        add_action('plugins_loaded', array(__CLASS__, 'registerL10n'));
        add_action('init', array(__CLASS__, 'initialize'));
        add_action('admin_head', array(__CLASS__, 'addHelpTab'));
        add_action('admin_head', array(__CLASS__, 'addHelpSidebar'));

        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
    }

    /**
     * Loads localization files from plugin's languages directory.
     *
     * @uses load_plugin_textdomain()
     *
     * @return void
     */
    public static function registerL10n () {
        load_plugin_textdomain('My_WP_Plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Loads plugin componentry and calls that component's register()
     * method. Called at the WordPress `init` hook.
     *
     * @return void
     */
    public static function initialize () {
        if (!class_exists('WP_Screen_Help_Loader')) {
            require_once 'includes/vendor/wp-screen-help-loader/class-wp-screen-help-loader.php';
        }

        // TODO
    }

    /**
     * Method to run when the plugin is activated by a user in the
     * WordPress Dashboard admin screen.
     *
     * @uses My_WP_Plugin::checkPrereqs()
     *
     * @return void
     */
    public static function activate () {
        self::checkPrereqs();
    }

    /**
     * Checks system requirements and exits if they are not met.
     *
     * This first checks to ensure minimum WordPress and PHP versions
     * have been satisfied. If not, the plugin deactivates and exits.
     *
     * @global $wp_version
     *
     * @uses $wp_version
     * @uses My_WP_Plugin::get_minimum_wordpress_version()
     * @uses deactivate_plugins()
     * @uses plugin_basename()
     *
     * @return void
     */
    public static function checkPrereqs () {
        global $wp_version;
        $min_wp_version = self::get_minimum_wordpress_version();
        if (version_compare($min_wp_version, $wp_version) > 0) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(sprintf(
                __('My_WP_Plugin requires at least WordPress version %1$s. You have WordPress version %2$s.', 'My_WP_Plugin'),
                $min_wp_version, $wp_version
            ));
        }
    }

    /**
     * Returns the "Requires at least" value from plugin's readme.txt.
     *
     * @link https://wordpress.org/plugins/about/readme.txt WordPress readme.txt standard
     *
     * @return string
     */
    public static function get_minimum_wordpress_version () {
        $lines = @file(plugin_dir_path(__FILE__) . 'readme.txt');
        foreach ($lines as $line) {
            preg_match('/^Requires at least: ([0-9.]+)$/', $line, $m);
            if ($m) {
                return $m[1];
            }
        }
    }

    /**
     * Method to run when the plugin is deactivated by a user in the
     * WordPress Dashboard admin screen.
     *
     * @return void
     */
    public static function deactivate () {
        // TODO
    }

    /**
     * Attaches on-screen help tabs to the WordPress built-in help.
     *
     * Loads the appropriate document from the localized `help` folder
     * and inserts it as a help tab on the current screen.
     *
     * @uses WP_Screen_Help_Loader::applyTabs()
     *
     * @return void
     */
    public static function addHelpTab () {
        $help = new WP_Screen_Help_Loader(plugin_dir_path(__FILE__) . 'help');
        $help->applyTabs();
    }

    /**
     * Appends appropriate sidebar content based on current screen.
     *
     * @uses WP_Screen_Help_Loader::applySidebar()
     *
     * @return void
     */
    public static function addHelpSidebar () {
        $help = new WP_Screen_Help_Loader(plugin_dir_path(__FILE__) . 'help');
        $help->applySidebar();
    }

    /**
     * Prepares an error message for logging.
     *
     * @param string $message
     *
     * @return string
     */
    private static function error_msg ($message) {
        $dbt = debug_backtrace();
        // the "2" is so we get the name of the function that originally called debug_log()
        // This works so long as error_msg() is always called by debug_log()
        return '[' . get_called_class() . '::' . $dbt[2]['function'] . '()]: ' . $message;
    }

}

My_WP_Plugin::register();
