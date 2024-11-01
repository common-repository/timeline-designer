<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.solwininfotech.com/product/wordpress-plugins/timeline-designer/
 * @since             1.0.0
 * @package           Wp_Timeline
 *
 * @wordpress-plugin
 * Plugin Name:       Timeline Designer
 * Plugin URI:        https://www.solwininfotech.com/product/wordpress-plugins/timeline-designer/
 * Description:       Best WordPress Timeline Plugin to create a stunning timeline on your website.
 * Version:           1.4
 * Author:            Solwin Infotech
 * Author URI:        https://www.solwininfotech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-timeline
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TLD_VERSION', '1.4' );
define( 'TLD_TEXTDOMAIN', 'timeline-designer' );
define( 'TLD_DIR', plugin_dir_path( __FILE__ ) );
define( 'TLD_URL', plugins_url( '', __FILE__ ) );

require_once 'admin/wtl-functions.php';
require_once 'admin/class-wp-timeline-lite-ajax.php';
require_once 'admin/class-wp-timeline-lite-support.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-timeline-lite-activator.php
 */
function wtl_lite_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-timeline-lite-activator.php';
	Wp_Timeline_Lite_Activator::activate();
	if ( is_plugin_active( 'wp-timeline-designer-pro/wp-timeline-designer-pro.php' ) ) {
		deactivate_plugins( 'wp-timeline-designer-pro/wp-timeline-designer-pro.php' );
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-timeline-lite-deactivator.php
 */
function wtl_lite_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-timeline-lite-deactivator.php';
	Wp_Timeline_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wtl_lite_activate' );
register_deactivation_hook( __FILE__, 'wtl_lite_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-timeline-lite.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_timeline_lite() {
	$plugin = new Wp_Timeline_Lite();
	$plugin->run();
}
run_wp_timeline_lite();

if ( ! function_exists( 'wtl_remove_more_link' ) ) {
	/**
	 * Remove More Link.
	 *
	 * @param string $link Link.
	 */
	function wtl_remove_more_link( $link ) {
		$link = '';
		return $link;
	}
}

require_once 'admin/class-wtl-lite-custom-post-type.php';
require_once 'wp_timeline_templates/class-wtl-lite-template-config.php';
