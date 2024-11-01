<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline_Lite_Support
 * @subpackage Wp_Timeline_Lite_Support/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Timeline_Lite_Support
 * @subpackage Wp_Timeline_Lite_Support/includes
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wp_Timeline_Lite_Support {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;
	/**
	 * Class Cunstructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		/* Beaver Builder Lite */
		if ( is_plugin_active( 'beaver-builder-lite-version/fl-builder.php' ) ) {
			add_action( 'fl_builder_ui_panel_after_modules', array( $this, 'add_wtl_widget' ) );
		}
		/* Fusion Builder */
		if ( is_plugin_active( 'fusion-builder/fusion-builder.php' ) ) {
			add_action( 'fusion_builder_before_init', array( $this, 'wtl_fusion_element' ) );
		}
		/* Fusion Page Builder */
		if ( is_plugin_active( 'fusion/fusion-core.php' ) ) {
			add_action( 'init', array( $this, 'wtl_fsn_init' ), 12 );
			add_shortcode( 'fsn_wp_timeline', array( $this, 'wtl_fsn_shortcode' ) );
		}
	}

	/**
	 * Wtl Widget.
	 *
	 * @return void
	 */
	public function add_wtl_widget() {
		?>
		<div id="fl-builder-blocks-wp-timeline-widget" class="fl-builder-blocks-section">
			<span class="fl-builder-blocks-section-title">
				<?php esc_html_e( 'WP Timeline', 'timeline-designer' ); ?>
				<i class="fas fa-chevron-down"></i>
			</span>
			<div class="fl-builder-blocks-section-content fl-builder-modules">
				<span class="fl-builder-block fl-builder-block-module" data-widget="WPT_Widget_WPTIMELINE" data-type="widget">
					<span class="fl-builder-block-title"><?php esc_html_e( 'WP Timeline', 'timeline-designer' ); ?></span>
				</span>
			</div>
		</div>
		<?php
	}

	/**
	 * Fusion Element.
	 *
	 * @return void
	 */
	public function wtl_fusion_element() {
		global $wpdb;
		$shortcodes  = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes ' );
		$wtl_layouts = array();
		if ( $shortcodes ) {
			foreach ( $shortcodes as $shortcode ) {
				$wtl_layouts[ $shortcode->shortcode_name ] = $shortcode->wtlid;
			}
		}
		fusion_builder_map(
			array(
				'name'      => 'WP Timeline',
				'shortcode' => 'wp_timeline',
				'icon'      => 'wp_timeline_icon',
				'params'    => array(
					array(
						'type'       => 'select',
						'heading'    => esc_html__( 'Select Layout', 'timeline-designer' ),
						'param_name' => 'id',
						'default'    => '',
						'value'      => $wtl_layouts,
					),
				),
			)
		);
	}

	/**
	 * Inin Function.
	 *
	 * @return void
	 */
	public function wtl_fsn_init() {
		if ( function_exists( 'fsn_map' ) ) {
			global $wpdb;
			$shortcodes  = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes ' );
			$wtl_layouts = array();
			if ( $shortcodes ) {
				foreach ( $shortcodes as $shortcode ) {
					$wtl_layouts[ $shortcode->wtlid ] = $shortcode->shortcode_name;
				}
			}
			fsn_map(
				array(
					'name'          => 'WP Timeline',
					'shortcode_tag' => 'fsn_wp_timeline',
					'description'   => esc_html__( 'WP Timeline is a step ahead wordpress plugin that allows you to modify blog page, single page and archive page layouts and design.', 'timeline-designer' ),
					'icon'          => 'fsn_blog',
					'params'        => array(
						array(
							'type'       => 'select',
							'param_name' => 'id',
							'label'      => esc_html__( 'Select WP Timeline Layout', 'timeline-designer' ),
							'options'    => $wtl_layouts,
						),
					),
				)
			);
		}
	}
	/**
	 * Shortcode function.
	 *
	 * @param array  $atts attribute.
	 * @param string $content content.
	 *
	 * @return html
	 */
	public function wtl_fsn_shortcode( $atts, $content ) {
		ob_start();
		?>
		<div class="fsn-wp_timeline_<?php echo esc_attr( fsn_style_params_class( $atts ) ); ?>">
			<?php echo do_shortcode( '[wp_timeline_design id="' . intval( $atts['id'] ) . '"]' ); ?>
		</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}
}
$wp_timeline_support = new Wp_Timeline_Lite_Support();
