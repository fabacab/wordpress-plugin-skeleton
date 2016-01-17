<?php
/**
 * My_WP_Plugin uninstaller.
 *
 * @link https://developer.wordpress.org/plugins/the-basics/uninstall-methods/#uninstall-php
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2016 by My Name
 *
 * @package WordPress\Plugin\My_WP_Plugin\Uninstaller
 */

// Don't execute any uninstall code unless WordPress core requests it.
if (!defined('WP_UNINSTALL_PLUGIN')) { exit(); }

require_once plugin_dir_path(__FILE__) . 'my_wp_plugin.php';

$my_prefix = My_WP_Plugin::$prefix;

// Delete plugin options.
delete_option("{$my_prefix}_settings");

foreach (get_users() as $usr) {
    // Delete all custom user profile data.
}
