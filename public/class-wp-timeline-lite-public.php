<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/public
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wp_Timeline_Lite_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}
	/**
	 * Argument for Kses.
	 *
	 * @since    1.0.0
	 * @return  array
	 */
	public static function args_kses() {
		$common_attr = array(
			'class'            => true,
			'id'               => true,
			'style'            => true,
			'name'             => true,
			'src'              => true,
			'type'             => true,
			'for'              => true,
			'value'            => true,
			'data-placeholder' => true,
			'data-href'        => true,
			'data-url'         => true,
			'data-share'       => true,
			'checked'          => true,
		);
		$args_kses   = array(
			'div'      => array(
				'class'  => true,
				'id'     => true,
				'style'  => true,
				'script' => true,
			),
			'span'     => array(
				'class' => true,
				'id'    => true,
				'style' => true,
			),
			'script'   => array(
				'type'    => true,
				'charset' => true,
			),
			'style'    => array(
				'type' => true,
			),
			'iframe'   => array(
				'src'         => true,
				'style'       => true,
				'scrolling'   => true,
				'frameborder' => true,
			),
			'img'      => array(
				'src'      => true,
				'class'    => true,
				'height'   => true,
				'width'    => true,
				'alt'      => true,
				'style'    => true,
				'script'   => true,
				'decoding' => true,
				'sizes'    => true,
				'srcset'   => true,
				'loading'  => true,
			),
			'a'        => array(
				'href'              => true,
				'class'             => true,
				'data-href'         => true,
				'data-action'       => true,
				'tabindex'          => true,
				'target'            => true,
				'data-id'           => true,
				'data-shortcode-id' => true,
				'data-url'          => true,
				'data-media'        => true,
				'data-description'  => true,
				'data-share'        => true,
				'data-text'         => true,
				'data-title'        => true,
				'data-image'        => true,
			),
			'ul'       => array(
				'class'  => true,
				'id'     => true,
				'style'  => true,
				'script' => true,
			),
			'li'       => array(
				'class'  => true,
				'id'     => true,
				'style'  => true,
				'script' => true,
			),
			'input'    => $common_attr,
			'fieldset' => $common_attr,
			'label'    => $common_attr,
			'select'   => $common_attr,
			'option'   => array(
				'value' => true,
			),
			'i'        => array(
				'class' => true,
			),
			'figure'   => array(
				'class' => true,
			),
			'video'    => array(
				'controls' => true,
				'src'      => true,
			),
			'audio'    => array(
				'controls' => true,
				'src'      => true,
			),
			'b'        => true,
			'em'       => true,
			'sup'      => true,
		);
		return $args_kses;
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$wpt_font_icon_url = plugins_url( 'css/font-awesome.min.css', __FILE__ );
		$wpt_font_icon     = dirname( __FILE__ ) . '/css/font-awesome.min.css';
		if ( file_exists( $wpt_font_icon ) ) {
			wp_register_style( 'wp-timeline-fontawesome-stylesheets', $wpt_font_icon_url, null, '6.5.1' );
			wp_enqueue_style( 'wp-timeline-fontawesome-stylesheets' );
		}
		$wtl_gallery_slider_url = plugins_url( 'css/flexslider.css', __FILE__ );
		$wpt_gallery_slider     = dirname( __FILE__ ) . '/css/flexslider.css';
		if ( file_exists( $wpt_gallery_slider ) ) {
			wp_register_style( 'wp-timeline-gallery-slider-stylesheets', $wtl_gallery_slider_url, null, '2.7.2' );
		}
		wp_enqueue_style( 'wp-timeline-front', plugins_url( 'css/wp-timeline-public.css', __FILE__ ), null, $this->version );
		wp_enqueue_script( 'wp-timeline-gallery-image-script', plugins_url( 'js/jquery.flexslider-min.js', __FILE__ ), array( 'jquery' ), '2.7.2', false );
		wp_register_style( 'wp-timeline-soft_block-template', plugins_url( 'css/layouts/soft_block.css', __FILE__ ), null, $this->version );
		wp_register_style( 'wp-timeline-advanced_layout-template', plugins_url( 'css/layouts/advanced_layout.css', __FILE__ ), null, $this->version);
		wp_register_style( 'wp-timeline-hire_layout-template', plugins_url( 'css/layouts/hire_layout.css', __FILE__ ), null, $this->version );
		wp_register_style( 'wp-timeline-fullwidth_layout-template', plugins_url( 'css/layouts/fullwidth_layout.css', __FILE__ ), null, $this->version );
		wp_register_style( 'wp-timeline-curve_layout-template', plugins_url( 'css/layouts/curve_layout.css', __FILE__ ), null, $this->version );
		wp_register_style( 'wp-timeline-easy_layout-template', plugins_url( 'css/layouts/easy_layout.css', __FILE__ ), null, $this->version );
		wp_register_style( 'slick', plugins_url( 'css/slick.css', __FILE__ ), null, $this->version );
		wp_register_style( 'featherlight', plugins_url( 'css/featherlight.min.css', __FILE__ ), null, '1.7.13' );
		wp_register_style( 'aos', plugins_url( 'css/aos-min.css', __FILE__ ), null, $this->version );
		wp_register_style( 'wp-timeline-basic-tools', plugins_url( 'css/basic-tools-min.css', __FILE__ ), null, '1.0' );
		wp_register_style( 'choosen', plugins_url( 'admin/css/chosen.min.css', __FILE__ ), null, '1.8.7' );
		wp_enqueue_script( 'lazy_load_responsive_images_script-lazysizes', plugins_url( 'js/lazysizes.min.js', __FILE__ ), null, '2.0' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wp-timeline-ajax-script', plugins_url( 'js/wp-timeline-public.js', __FILE__ ), array( 'jquery' ), $this->version, false );
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		wp_localize_script(
			'wp-timeline-ajax-script',
			'ajax_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'is_rtl'  => ( is_rtl() ) ? 1 : 0,
			)
		);
		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'isotope', plugins_url( 'js/isotope.pkgd.min.js', __FILE__ ), array( 'jquery' ), '3.0.6', false );
		wp_register_script( 'mousewheel', plugins_url( 'js/jquery.mousewheel.js', __FILE__ ), array( 'jquery' ), '3.1.13', false );
		wp_register_script( 'slick', plugins_url( 'js/slick.min.js', __FILE__ ), array( 'jquery' ), '1.8.1', false );
		wp_register_script( 'featherlight', plugins_url( 'js/featherlight.min.js', __FILE__ ), array( 'jquery' ), '1.7.13', false );
		wp_register_script( 'aos', plugins_url( 'js/aos-min.js', __FILE__ ), array( 'jquery' ), '2.3.1', false );
		wp_register_script( 'easing', plugins_url( 'js/jquery.easing.js', __FILE__ ), array( 'jquery' ), '1.4.1', false );
		wp_register_script( 'choosen', plugins_url( 'admin/js/chosen.jquery.min.js', __FILE__ ), array( 'jquery', 'jquery-masonry' ), '1.8.7', false );
		wp_register_script( 'wp-timeline-ajax', plugins_url( 'js/ajax.js', __FILE__ ), null,  $this->version, false );
		wp_localize_script(
			'wp-timeline-ajax',
			'ajax_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'like'    => esc_html__( 'Like', 'timeline-designer' ),
				'unlike'  => esc_html__( 'Unlike', 'timeline-designer' ),
				'is_rtl'  => ( is_rtl() ) ? 1 : 0,
			)
		);
		wp_register_script( 'wp-timeline-socialShare-script', plugins_url( 'js/SocialShare.js', __FILE__ ), null, $this->version, false );
	}
}
