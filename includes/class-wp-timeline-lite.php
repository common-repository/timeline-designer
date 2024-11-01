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
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/includes
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
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/includes
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wp_Timeline_Lite {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Wp_Timeline_Lite_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
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
	 * Template Name
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array    $template_name  template name.
	 */
	public static $template_name = array();
	/**
	 * Shortcode ID
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array    $shortcode_id   Shortcode ID.
	 */
	public static $shortcode_id = array();
	/**
	 * Template Stylesheet added
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    boolean  $template_stylesheet_added  template stylesheet added.
	 */
	public static $template_stylesheet_added = 0;
	/**
	 * Template dynamic stylesheet added
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    boolean  $template_dynamic_stylesheet_added  template dynamic stylesheet added.
	 */
	public static $template_dynamic_stylesheet_added = 0;
	/**
	 * Class construct
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		if ( defined( 'TLD_VERSION' ) ) {
			$this->version = TLD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'timeline-designer';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_main_hooks();
		$this->define_public_hooks();

		/** Register Activation Hook */
		register_activation_hook( __FILE__, array( &$this, 'wp_timeline_plugin_active' ) );

		/** Redirecation after plugin active */
		add_action( 'init', array( &$this, 'wp_timeline_redirection' ), 1 );
		add_shortcode( 'wp_timeline_design', array( &$this, 'wtl_shortcode_function' ), 10 );
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_timeline_add_template_style' ), 9 );
		add_action( 'wp_footer', array( &$this, 'wp_timeline_add_template_style' ), 9 );
		add_action( 'wp_head', array( &$this, 'wtl_template_dynamic_css' ), 20 );
		add_action( 'wp_footer', array( &$this, 'wtl_template_dynamic_css' ), 20 );

		add_action( 'wp_ajax_nopriv_wtl_email_share_form', array( &$this, 'wtl_email_share_form' ), 40 );
		add_action( 'wp_ajax_wtl_email_share_form', array( &$this, 'wtl_email_share_form' ), 40 );
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Timeline_Lite_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Timeline_Lite_I18n. Defines internationalization functionality.
	 * - Wp_Timeline_Lite_Admin. Defines all hooks for the admin area.
	 * - Wp_Timeline_Lite_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-timeline-lite-loader.php';
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-timeline-lite-i18n.php';
		/**
		 * The class contain all common method which work with admin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-timeline-lite-main.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-timeline-lite-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-timeline-lite-public.php';
		$this->loader = new Wp_Timeline_Lite_Loader();
	}
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Timeline_Lite_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Wp_Timeline_Lite_I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Wp_Timeline_Lite_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}
	/**
	 * Register all of the hooks related to the main area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_main_hooks() {
		$plugin_main = new Wp_Timeline_Lite_Main( $this->get_plugin_name(), $this->get_version() );

	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Timeline_Lite_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		/* ajax url */
		add_action( 'wp_head', array( &$this, 'wp_timeline_ajaxurl' ), 5 );

	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Wp_Timeline_Lite_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	/**
	 * Create table 'wtl_shortcodes' when plugin activated
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wp_timeline_plugin_active() {
		include_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;
		// Create Table.
		$table_name = $wpdb->prefix . 'wtl_shortcodes';
		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
		$sql = "CREATE TABLE $table_name ( wtlid int(9) NOT NULL AUTO_INCREMENT, shortcode_name tinytext NOT NULL, wtlsettngs text NOT NULL, UNIQUE KEY wtlid (wtlid) ) $charset_collate;";
		dbDelta( $sql );

		/* Table for Custom Post Type*/
		$table_name = $wpdb->prefix . 'wtl_cpts';
		$sql        = "CREATE TABLE IF NOT EXISTS `$table_name` (
                    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    `name` varchar(191) NOT NULL,
                    `slug` varchar(191) NOT NULL,
                    `setting` longtext NULL
                  ) $charset_collate";
			dbDelta( $sql );

		add_option( 'wp_timeline_plugin_do_activation_redirect', true );
	}
	/**
	 * Rdirect after activate plugin
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wp_timeline_redirection() {
		if ( get_option( 'wp_timeline_plugin_do_activation_redirect', false ) ) {
			delete_option( 'wp_timeline_plugin_do_activation_redirect' );
			if ( ! isset( $_GET['activate-multi'] ) ) {
				wp_safe_redirect( esc_attr( admin_url( 'admin.php?page=wtl_layouts' ) ) );
				exit();
			}
		}
	}
	/**
	 * WP Timeline Set Ajax URL
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wp_timeline_ajaxurl() {
		?>
		<script type="text/javascript">"use strict";var ajaxurl = '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';</script>
		<?php
	}
	/**
	 * WP Timeline Shortcode function
	 *
	 * @since  1.0.0
	 * @param  array $atts attributes.
	 * @return html
	 */
	public function wtl_shortcode_function( $atts ) {
		global $wpdb;
		if ( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) {
			return '<b style="color:#ff0000">' . esc_html__( 'Error', 'timeline-designer' ) . ' : </b>' . esc_html__( 'WP Timeline Designer shortcode not found. Please cross check your Layout selection id.', 'timeline-designer' ) . '';
		}
		if ( is_numeric( $atts['id'] ) ) {
			$result2 = wp_cache_get( 'wtl_shortcode_function' );
			if ( false == $result2 ) {
				wp_cache_set( 'wtl_shortcode_function', $result2 );
			}
			/* Can be use later in case issue;  */
			$settings_val = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes WHERE wtlid = %d', $atts['id'] ), ARRAY_A );
		} else {
			$settings_val = false;
		}
		if ( ! $settings_val ) {
			return '[wp_timeline_design] ' . esc_html__( 'Invalid shortcode', 'timeline-designer' ) . '';
		}
		$allsettings = $settings_val[0]['wtlsettngs'];

		if ( is_serialized( $allsettings ) ) {
			$wtl_settings = maybe_unserialize( $allsettings );
		}
		if ( ! isset( $wtl_settings['template_name'] ) || empty( $wtl_settings['template_name'] ) ) {
			return '[wp_timeline_design] ' . esc_html__( 'Invalid shortcode', 'timeline-designer' ) . '';
		}
		self::$template_name[] = $wtl_settings['template_name'];
		self::$shortcode_id[]  = $atts['id'];
		return Wp_Timeline_Lite_Main::wtl_layout_view_portion( $atts['id'], $wtl_settings );
	}
	/**
	 * WP Timeline add Template style
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wp_timeline_add_template_style() {
		global $post, $wpdb;
		$wp_timeline_themes        = self::$template_name;
		$template_stylesheet_added = self::$template_stylesheet_added;
		$current_id                = 0;
		$current_page              = 'shortcode';
		$wp_timeline_theme_array   = array();
		if ( 0 == $template_stylesheet_added ) {
			if ( is_array( $wp_timeline_themes ) && count( $wp_timeline_themes ) > 0 ) {
				foreach ( $wp_timeline_themes as $wp_timeline_theme ) {
					$wp_timeline_theme_array[] = $wp_timeline_theme;
				}
			} elseif ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'wp_timeline' ) ) {
				$pattern = get_shortcode_regex();
				if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) ) {
					foreach ( $matches[3] as $block ) {
						$attr = shortcode_parse_atts( $block );
						if ( isset( $attr['id'] ) ) {
							$shortcode_id = intval( $attr['id'] );
							if ( '' != $shortcode_id ) {
								$wtl_settings              = Wp_Timeline_Lite_Main::wtl_get_shortcode_settings( $shortcode_id );
								$wtl_settings              = maybe_unserialize( $wtl_settings );
								$wp_timeline_theme_array[] = $wtl_settings['template_name'];
							}
						}
					}
				}
			}
			if ( isset( $wp_timeline_theme_array ) && ! empty( $wp_timeline_theme_array ) ) {
				self::$template_stylesheet_added = 1;
				foreach ( $wp_timeline_theme_array as $wp_timeline_theme ) {
					$style_name = 'wp-timeline-' . $wp_timeline_theme . '-template';
					wp_enqueue_style( $style_name );
					add_action( 'wp_footer', array( &$this, 'wtl_email_share' ), 30 );
					if ( ! wp_style_is( 'wp-timeline-fontawesome-stylesheets' ) ) {
						wp_enqueue_style( 'wp-timeline-fontawesome-stylesheets' );
					}
					if ( ! wp_script_is( 'wp-timeline-ajax', 'enqueued' ) ) {
						wp_enqueue_script( 'wp-timeline-ajax' );
					}
					if ( ! wp_style_is( 'wp-timeline-gallery-slider-stylesheets' ) ) {
						wp_enqueue_style( 'wp-timeline-gallery-slider-stylesheets' );
					}
					wp_enqueue_style( $style_name );
					wp_enqueue_script( 'aos' );
					wp_enqueue_style( 'aos' );

					if ( 'advanced_layout' === $wp_timeline_theme || 'hire_layout' === $wp_timeline_theme || 'curve_layout' === $wp_timeline_theme ) {
						wp_enqueue_script( 'slick' );
						wp_enqueue_style( 'slick' );
						wp_enqueue_script( 'featherlight' );
						wp_enqueue_style( 'featherlight' );
					}
					if ( ! wp_style_is( 'wp-timeline-basic-tools' ) ) {
						wp_enqueue_style( 'wp-timeline-basic-tools' );
					}
					if ( ! wp_style_is( 'wp-timeline-front' ) ) {
						wp_enqueue_style( 'wp-timeline-front' );
					}
					if ( is_rtl() ) {
						if ( ! wp_style_is( 'wp-timeline-front-rtl' ) ) {
							wp_enqueue_style( 'wp-timeline-front-rtl' );
						}
					}
				}
			}
		}
		wp_localize_script(
			'wp-timeline-ajax',
			'page_object',
			array(
				'current_page' => $current_page,
				'current_id'   => $current_id,
				'_wpnonce'     => wp_create_nonce( '_wpnonce' ),
			)
		);
	}
	/**
	 * WP Timeline Template Dynamic CSS
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wtl_template_dynamic_css() {
		global $post, $wpdb;
		$shortcode_id_array                = array();
		$wtl_settings_array                = array();
		$template_dynamic_stylesheet_added = self::$template_dynamic_stylesheet_added;
		if ( 0 == $template_dynamic_stylesheet_added ) {
			if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'wp_timeline_design' ) ) {
				$shortcode_id = '';
				$pattern      = self::wtl_shortcode_regex();
				if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) ) {
					foreach ( $matches[3] as $block ) {
						$attr = shortcode_parse_atts( $block );
						if ( isset( $attr['id'] ) ) {
							$shortcode_id = intval( $attr['id'] );
						}
						if ( '' != $shortcode_id ) {
							$shortcode_id_array[]                = $shortcode_id;
							$wtl_settings                        = Wp_Timeline_Lite_Main::wtl_get_shortcode_settings( $shortcode_id );
							$wtl_settings_array[ $shortcode_id ] = $wtl_settings;
						}
					}
				}
			} else {
				$wp_timeline_shortcode_ids = self::$shortcode_id;
				if ( is_array( $wp_timeline_shortcode_ids ) && count( $wp_timeline_shortcode_ids ) > 0 ) {
					foreach ( $wp_timeline_shortcode_ids as $wp_timeline_shortcode_id ) {
						if ( '' != $wp_timeline_shortcode_id ) {
							$shortcode_id_array[]                            = $wp_timeline_shortcode_id;
							$wtl_settings                                    = Wp_Timeline_Lite_Main::wtl_get_shortcode_settings( $wp_timeline_shortcode_id );
							$wtl_settings_array[ $wp_timeline_shortcode_id ] = $wtl_settings;
						}
					}
				}
			}

			if ( isset( $wtl_settings_array ) && is_array( $wtl_settings_array ) && ! empty( $wtl_settings_array ) ) {
				self::$template_dynamic_stylesheet_added = 1;
				foreach ( $wtl_settings_array as $bd_shortcode_id => $wtl_settings ) {
					$shortcode_id = $bd_shortcode_id;

					$wp_timeline_theme      = isset( $wtl_settings['template_name'] ) ? $wtl_settings['template_name'] : '';
					$wp_timeline_theme      = apply_filters( 'wp_timeline_filter_template', $wp_timeline_theme );
					$template_titlefontface = ( isset( $wtl_settings['template_titlefontface'] ) && '' != $wtl_settings['template_titlefontface'] ) ? $wtl_settings['template_titlefontface'] : '';
					$load_goog_font_blog    = array();
					if ( isset( $wtl_settings['template_titlefontface_font_type'] ) && 'Google Fonts' === $wtl_settings['template_titlefontface_font_type'] ) {
						$load_goog_font_blog[] = $template_titlefontface;
					}

					$firstletter_font_family = ( isset( $wtl_settings['firstletter_font_family'] ) && '' != $wtl_settings['firstletter_font_family'] ) ? $wtl_settings['firstletter_font_family'] : 'inherit';
					if ( isset( $wtl_settings['firstletter_font_family_font_type'] ) && 'Google Fonts' === $wtl_settings['firstletter_font_family_font_type'] ) {
						$load_goog_font_blog[] = $firstletter_font_family;
					}

					$content_font_family = ( isset( $wtl_settings['content_font_family'] ) && '' != $wtl_settings['content_font_family'] ) ? $wtl_settings['content_font_family'] : '';
					if ( isset( $wtl_settings['content_font_family_font_type'] ) && 'Google Fonts' === $wtl_settings['content_font_family_font_type'] ) {
						$load_goog_font_blog[] = $content_font_family;
					}

					$meta_font_family = ( isset( $wtl_settings['meta_font_family'] ) && '' != $wtl_settings['meta_font_family'] ) ? $wtl_settings['meta_font_family'] : '';
					if ( isset( $wtl_settings['meta_font_family_font_type'] ) && 'Google Fonts' === $wtl_settings['meta_font_family_font_type'] ) {
						$load_goog_font_blog[] = $meta_font_family;
					}

					$date_font_family = ( isset( $wtl_settings['date_font_family'] ) && '' != $wtl_settings['date_font_family'] ) ? $wtl_settings['date_font_family'] : '';
					if ( isset( $wtl_settings['date_font_family_font_type'] ) && 'Google Fonts' === $wtl_settings['date_font_family_font_type'] ) {
						$load_goog_font_blog[] = $date_font_family;
					}

					$readmore_font_family = ( isset( $wtl_settings['readmore_font_family'] ) && '' != $wtl_settings['readmore_font_family'] ) ? $wtl_settings['readmore_font_family'] : '';
					if ( isset( $wtl_settings['readmore_font_family_font_type'] ) && 'Google Fonts' === $wtl_settings['readmore_font_family_font_type'] ) {
						$load_goog_font_blog[] = $readmore_font_family;
					}

					$wp_timeline_sale_tagfontface = ( isset( $wtl_settings['wp_timeline_sale_tagfontface'] ) && '' != $wtl_settings['wp_timeline_sale_tagfontface'] ) ? $wtl_settings['wp_timeline_sale_tagfontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_sale_tagfontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_sale_tagfontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_sale_tagfontface;
					}

					$wp_timeline_pricefontface = ( isset( $wtl_settings['wp_timeline_pricefontface'] ) && '' != $wtl_settings['wp_timeline_pricefontface'] ) ? $wtl_settings['wp_timeline_pricefontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_pricefontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_pricefontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_pricefontface;
					}

					$wp_timeline_addtocart_button_fontface = ( isset( $wtl_settings['wp_timeline_addtocart_button_fontface'] ) && '' != $wtl_settings['wp_timeline_addtocart_button_fontface'] ) ? $wtl_settings['wp_timeline_addtocart_button_fontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_addtocart_button_fontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_addtocart_button_fontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_addtocart_button_fontface;
					}

					$wp_timeline_addtowishlist_button_fontface = ( isset( $wtl_settings['wp_timeline_addtowishlist_button_fontface'] ) && '' != $wtl_settings['wp_timeline_addtowishlist_button_fontface'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_fontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_addtowishlist_button_fontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_addtowishlist_button_fontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_addtowishlist_button_fontface;
					}

					$wp_timeline_edd_pricefontface = ( isset( $wtl_settings['wp_timeline_edd_pricefontface'] ) && '' != $wtl_settings['wp_timeline_edd_pricefontface'] ) ? $wtl_settings['wp_timeline_edd_pricefontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_edd_pricefontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_edd_pricefontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_edd_pricefontface;
					}

					$wp_timeline_edd_addtocart_button_fontface = ( isset( $wtl_settings['wp_timeline_edd_addtocart_button_fontface'] ) && '' != $wtl_settings['wp_timeline_edd_addtocart_button_fontface'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_fontface'] : '';
					if ( isset( $wtl_settings['wp_timeline_edd_addtocart_button_fontface_font_type'] ) && 'Google Fonts' === $wtl_settings['wp_timeline_edd_addtocart_button_fontface_font_type'] ) {
						$load_goog_font_blog[] = $wp_timeline_edd_addtocart_button_fontface;
					}
					include TLD_DIR . '/public/css/layout-dynamic-style.php';
					if ( ! empty( $load_goog_font_blog ) ) {
						$load_font_arr = array_values( array_unique( $load_goog_font_blog ) );
						foreach ( $load_font_arr as $font_family ) {
							if ( '' != $font_family ) {
								$set_base  = ( is_ssl() ) ? 'https://' : 'http://';
								$font_href = $set_base . 'fonts.googleapis.com/css?family=' . $font_family;
								wp_enqueue_style( 'wp-timeline-google-fonts-' . $font_family, $font_href, false, '1.0' );
								?>
								<script type="text/javascript">
									"use strict";
									var gfont    = document.createElement("link"),
										before   = document.getElementsByTagName("link")[0],
										loadHref = true;
									jQuery('head').find('*').each(function(){
										if (jQuery(this).attr('href') == '<?php echo esc_url( $font_href ); ?>'){loadHref = false}
									});
									if (loadHref) {
										gfont.href  = '<?php echo esc_attr( $font_href ); ?>';
										gfont.rel   = 'stylesheet';
										gfont.type  = 'text/css';
										gfont.media = 'all';
										before.parentNode.insertBefore(gfont, before);
									}
								</script>
								<?php
							}
						}
					}
				}
			}
		}
	}

	/**
	 * WP Timeline Sent mail Form
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wtl_email_share() {
		?>
		<div id="wtl_email_share" class="wtl_email_share" style="display: none;">
			<div class="wtl-close"><i class="fas fa-times"></i></div>
			<div class="wtl_email_form">
				<form method="post" id="frmEmailShare">
					<input type="hidden" value="" name="txtShortcodeId" id="txtShortcodeId" />
					<input type="hidden" value="" name="txtPostId" id="txtPostId" />
					<input type="hidden" name="action" value="wtl_email_share_form" />
					<div>
						<label for="txtToEmail"><?php esc_html_e( 'Send to Email Address', 'timeline-designer' ); ?></label>
						<input id="txtToEmail" name="txtToEmail" type="email">
					</div>
					<div>
						<label for="txtYourName"><?php esc_html_e( 'Your Name', 'timeline-designer' ); ?></label>
						<input id="txtYourName" name="txtYourName" type="text">
					</div>
					<div>
						<label for="txtYourEmail"><?php esc_html_e( 'Your Email Address', 'timeline-designer' ); ?></label>
						<input id="txtYourEmail" name="txtYourEmail" type="email">
					</div>
					<div style="margin-top: 15px;">
						<input class="wtl-mail_submit_button" type="submit" name="sbtEmailShare" value="<?php esc_html_e( 'Send Email', 'timeline-designer' ); ?>" />
						<div class="wtl-close_button"><?php esc_html_e( 'Close', 'timeline-designer' ); ?></div>
					</div>
					<input type="hidden" name="wp_nonce" value="<?php echo esc_attr( wp_create_nonce( 'wp_nonce' ) ); ?>"
				</form>
			</div>
			<div class="wtl_email_sucess"></div>
		</div>
		<?php
	}
	/**
	 * WP Timeline Sent mail
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wtl_email_share_form() {
		wp_reset_postdata();
		global $wpdb;
		if ( isset( $_POST['wp_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wp_nonce'] ) ), 'wp_nonce' ) ) {
			if ( isset( $_POST['txtShortcodeId'] ) ) {
				$settings_val = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes WHERE wtlid = %d', sanitize_text_field( wp_unslash( $_POST['txtShortcodeId'] ) ) ), ARRAY_A );
			}
			if ( $settings_val ) {
				$wtl_settings = $settings_val[0]['bdsettings'];
			}
			if ( is_serialized( $wtl_settings ) ) {
				$wtl_settings = maybe_unserialize( $wtl_settings );
			}
			$post_data  = '';
			$your_name  = '';
			$your_email = '';
			$to_email   = '';
			if ( isset( $_POST['txtPostId'] ) ) {
				$post_data = get_post( sanitize_text_field( wp_unslash( $_POST['txtPostId'] ) ), 'OBJECT' );
			}
			if ( isset( $_POST['txtYourName'] ) ) {
				$your_name = sanitize_text_field( wp_unslash( $_POST['txtYourName'] ) );
			}
			if ( isset( $_POST['txtYourEmail'] ) ) {
				$your_email = sanitize_email( wp_unslash( $_POST['txtYourEmail'] ) );
			}
			if ( isset( $_POST['txtToEmail'] ) ) {
				$to_email = sanitize_email( wp_unslash( $_POST['txtToEmail'] ) );
			}
			setup_postdata( $post_data );
			$mail_subject = ( isset( $wtl_settings['mail_subject'] ) && '' !== $wtl_settings['mail_subject'] ) ? $wtl_settings['mail_subject'] : '[post_title]';
			$mail_subject = str_replace( '[post_title]', get_the_title(), $mail_subject );
			if ( isset( $wtl_settings['mail_content'] ) && '' !== $wtl_settings['mail_content'] ) {
				$contents = $wtl_settings['mail_content'];
			} else {
				$contents = esc_html__( 'My Dear friends,', 'timeline-designer' ) . '<br/><br/>' . esc_html__( 'I read one good blog link and I would like to share that same link with you. That might useful for you', 'timeline-designer' ) . '<br/><br/>[post_link]<br/><br/>' . esc_html__( 'Best Regards', 'timeline-designer' ) . ',<br/>' . esc_html__( 'Blog Designer', 'timeline-designer' );
			}
			$reply_to_mail = isset( $wtl_settings['reply_to_mail'] ) ? $wtl_settings['reply_to_mail'] : 0;
			$contents      = apply_filters( 'the_content', $contents );
			$content       = str_replace( '[post_link]', get_the_permalink(), $contents );
			$content       = str_replace( '[post_title]', get_the_title(), $content );
			$content       = str_replace( '[sender_name]', $your_name, $content );
			$content       = str_replace( '[sender_email]', $your_email, $content );
			$content       = str_replace( '[post_thumbnail]', '<br/><img src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) . '" /> <br/><br/>', $content );
			$content       = html_entity_decode( $content );
			$wtl_to        = $to_email;
			$wtl_name      = $your_name;
			$wtl_reply_to  = $your_email;
			$wtl_from      = get_option( 'admin_email' );
			$headers       = "MIME-Version: 1.0;\r\n";
			$headers      .= "From: $wtl_name <$wtl_from>\r\n";
			if ( isset( $reply_to_mail ) && 0 == $reply_to_mail ) {
				$headers .= "reply-to: $wtl_name <$wtl_reply_to>\r\n";
			}
			$headers .= "Content-Type: text/html; charset: utf-8;\r\n";
			$headers .= "X-Priority: 3\r\n";
			$headers .= 'X-Mailer: PHP' . phpversion() . "\r\n";

			$mail_sent = wp_mail( $wtl_to, stripslashes_deep( html_entity_decode( $mail_subject, ENT_QUOTES, 'UTF-8' ) ), $content, $headers );
			if ( $mail_sent ) {
				echo 'sent';
			} else {
				echo 'not_sent';
			}
			wp_reset_postdata();
		}
		exit();
	}
	/**
	 * WP Timeline Shortcode REGEX
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function wtl_shortcode_regex() {

		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag().
		// Also, see shortcode_unautop() and shortcode.js.
		return '\\['                   // Opening bracket.
				. '(\\[?)'              // 1: Optional second opening bracket for escaping shortcodes: [[tag]].
				. '(wp_timeline_design)'  // 2: Shortcode name.
				. '(?![\\w-])'          // Not followed by word character or hyphen.
				. '('                   // 3: Unroll the loop: Inside the opening shortcode tag.
				. '[^\\]\\/]*'          // Not a closing bracket or forward slash.
				. '(?:'
				. '\\/(?!\\])'          // A forward slash not followed by a closing bracket.
				. '[^\\]\\/]*'          // Not a closing bracket or forward slash.
				. ')*?'
				. ')'
				. '(?:'
				. '(\\/)'               // 4: Self closing tag ...
				. '\\]'                 // ... and closing bracket.
				. '|'
				. '\\]'                 // Closing bracket.
				. '(?:'
				. '('                   // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags.
				. '[^\\[]*+'            // Not an opening bracket.
				. '(?:'
				. '\\[(?!\\/\\2\\])'    // An opening bracket not followed by the closing shortcode tag.
				. '[^\\[]*+'            // Not an opening bracket.
				. ')*+'
				. ')'
				. '\\[\\/\\2\\]'        // Closing shortcode tag.
				. ')?'
				. ')'
				. '(\\]?)';             // 6: Optional second closing brocket for escaping shortcodes: [[tag]].
	}
}
