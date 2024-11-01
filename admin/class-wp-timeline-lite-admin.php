<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/admin
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wp_Timeline_Lite_Admin {
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
	 * Wp-timeline plugin error
	 *
	 * @var string
	 */
	public $wtl_errors;
	/**
	 * Wp-timeline layout setting
	 *
	 * @var array
	 */
	public $wtl_settings;
	/**
	 * Wp-timeline shortcode plugin table
	 *
	 * @var string
	 */
	public $wtl_table_name;
	/**
	 * Success message
	 *
	 * @var string
	 */
	public $wtl_success;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		global $wpdb, $wtl_table_name, $wtl_errors, $import_success, $font_success, $template_base, $pagenow;
		$wtl_table_name  = $wpdb->prefix . 'wp_timeline_shortcodes';
		$wtl_admin_page  = false;
		$wtl_admin_pages = array( 'wtl_layouts', 'add_wtl_shortcode', 'wtl_export', 'designer_welcome_page' );
		require_once ABSPATH . 'wp-includes/pluggable.php';
		if ( ! is_plugin_active( 'updraftplus/updraftplus.php' ) ) {
			if ( isset( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
				if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
					wp_send_json_error( array( 'status' => 'Nonce error' ) );
					die();
				}
			}
		}
		if ( isset( $_GET['page'] ) && ( in_array( $_GET['page'], $wtl_admin_pages, true ) ) ) {
			$wtl_admin_page = true;
		}
		add_action( 'admin_menu', array( &$this, 'wtl_add_menu' ) );
		add_action( 'admin_init', array( &$this, 'wtl_default_settings_function' ), 1 );
		add_action( 'admin_init', array( &$this, 'wtl_table_status' ), 2 );
		add_action( 'admin_init', array( &$this, 'wtl_save_layouts' ), 3 );
		add_action( 'admin_init', array( &$this, 'wtl_delete_layout' ), 4 );
		add_action( 'admin_init', array( &$this, 'wtl_multiple_delete_layouts' ), 5 );
		add_action( 'admin_init', array( &$this, 'wtl_duplicate_layout' ), 6 );
		add_action( 'admin_init', array( &$this, 'wtl_multiple_export_layouts' ), 7 );
		add_action( 'admin_init', array( &$this, 'wtl_upload_import_file' ), 8 );
		add_action( 'admin_head', array( &$this, 'wtl_plugin_path_js' ), 9 );
		add_action( 'add_meta_boxes', array( &$this, 'wtl_details_meta_box' ), 11 );
		add_action( 'save_post', array( &$this, 'wtl_details_save' ), 12 );
		add_action( 'wp_ajax_nopriv_wtl_template_search_result', array( &$this, 'wtl_template_search_result' ), 13 );
		add_action( 'wp_ajax_wtl_template_search_result', array( &$this, 'wtl_template_search_result' ), 14 );
		add_filter( 'set-screen-option', array( &$this, 'wtl_set_screen_option' ), 10, 3 );
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$wpt_font_icon_url = TLD_URL . '/public/css/font-awesome.min.css';
		wp_register_style( 'font-awesome', $wpt_font_icon_url, array(), '6.5.1' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-timeline-admin.css', array(), $this->version, 'all' );
		$wtl_admin_pages = array( 'wtl_layouts', 'add_wtl_shortcode', 'wtl_export', 'wp-timeline-ads-license', 'add_wtl_cpt' );
		if ( isset( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
				wp_send_json_error( array( 'status' => 'Nonce error' ) );
				die();
			}
		}
		if ( isset( $_GET['page'] ) && ( in_array( $_GET['page'], $wtl_admin_pages, true ) ) ) {
			$admin_rtl_css_url = plugins_url( 'css/admin-rtl.css', __FILE__ );
			if ( is_rtl() ) {
				wp_register_style( 'wp-timeline-rtl-stylesheets', $admin_rtl_css_url, null, '1.0' );
				wp_enqueue_style( 'wp-timeline-rtl-stylesheets' );
			}
			wp_enqueue_script( 'jquery' );
			if ( function_exists( 'wp_enqueue_code_editor' ) ) {
				wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
			}
			wp_register_style( 'wp-timeline-basic-tools-min', esc_url( TLD_URL ) . '/public/css/basic-tools-min.css', null, '1.0' );
			wp_enqueue_style( 'wp-timeline-basic-tools-min' );
			wp_register_script( 'wp-timeline-front-social', esc_url( TLD_URL ) . '/public/js/SocialShare.js', null, $this->version, false );
			wp_enqueue_script( 'wp-timeline-front-social' );
			wp_enqueue_style( 'wp-timeline-aristo', esc_url( TLD_URL ) . '/admin/css/aristo.css', null, '1.8.7' );
			wp_enqueue_style( 'wp-timeline-aristo' );
		}
		wp_register_style( 'wp-timeline-admin-cpts', esc_url( TLD_URL ) . '/admin/css/admin-cpts.css', null,  $this->version );
		wp_enqueue_style( 'wp-timeline-admin-cpts' );
	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $wp_version;
		wp_enqueue_style( 'wp-timeline-support', plugins_url( 'css/wp_timeline_support.css', __FILE__ ), null, $this->version );
		$wtl_admin_pages = array( 'wtl_layouts', 'add_wtl_shortcode', 'wtl_export', 'designer_welcome_page', 'add_wtl_cpt' );
		if ( isset( $_GET['page'] ) && ( in_array( $_GET['page'], $wtl_admin_pages, true ) ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}
			if ( isset( $_GET['page'] ) && ( 'add_wtl_shortcode' === $_GET['page'] ) ) {
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'wp-timeline-admin', plugins_url( 'js/wp-timeline-admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker', 'jquery-ui-core', 'jquery-ui-dialog', 'jquery-ui-datepicker' ), $this->version, false );
			wp_localize_script(
				'wp-timeline-admin',
				'wp_timeline_js',
				array(
					'wp_version'                  => $wp_version,
					'nothing_found'               => esc_html__( 'Oops, nothing found!', 'timeline-designer' ),
					'default_style_template'      => esc_html__( 'Apply default style of this selected template', 'timeline-designer' ),
					'no_template_exist'           => esc_html__( 'No template exist for selection', 'timeline-designer' ),
					'close'                       => esc_html__( 'Close', 'timeline-designer' ),
					'choose_blog_template'        => esc_html__( 'Choose the blog timeline template you love', 'timeline-designer' ),
					'set_blog_template'           => esc_html__( 'Set Timeline Template', 'timeline-designer' ),
					'select_arrow'                => esc_html__( 'Select Arrow', 'timeline-designer' ),
					'choose_single_post_template' => esc_html__( 'Choose the template you love for your single post', 'wp-timeline-pro' ),
					'reset_data'                  => esc_html__( 'Do you want to reset data?', 'timeline-designer' ),
					'enter_font_url'              => esc_html__( 'Please enter font URL', 'timeline-designer' ),
					'please_enter_font_url'       => esc_html__( 'Please enter a valid font URL', 'timeline-designer' ),
					'remove'                      => esc_html__( 'Remove', 'timeline-designer' ),
					'remove_font'                 => esc_html__( 'Remove Font', 'timeline-designer' ),
					'font_added'                  => esc_html__( 'Font added successfully.', 'timeline-designer' ),
					'font_not_added'              => esc_html__( 'Font not added successfully.', 'timeline-designer' ),
					'delete_google_font'          => esc_html__( 'Are you sure want to delete google font?', 'timeline-designer' ),
					'font_deleted'                => esc_html__( 'Font deleted successfully.', 'timeline-designer' ),
					'font_not_deleted'            => esc_html__( 'Font not deleted successfully.', 'timeline-designer' ),
					'readmore'                    => esc_html__( 'Read More', 'timeline-designer' ),
					'loadmore'                    => esc_html__( 'Load More', 'timeline-designer' ),
					'info'                        => esc_html__( 'info.', 'timeline-designer' ),
					'information'                 => esc_html__( 'information', 'timeline-designer' ),
					'about'                       => esc_html__( 'About', 'timeline-designer' ),
					'learn_more'                  => esc_html__( 'Learn More', 'timeline-designer' ),
					'view_more'                   => esc_html__( 'View More', 'timeline-designer' ),
					'info_about'                  => esc_html__( 'Information about', 'timeline-designer' ),
					'read_more_hover'             => esc_html__( 'Read More Link Hover Color', 'timeline-designer' ),
					'wp_timeline_font_base'       => ( is_ssl() ) ? 'https://' : 'http://',
					'startup_text'                => esc_html__( 'STARTUP', 'timeline-designer' ),
					'is_rtl'                      => ( is_rtl() ) ? 1 : 0,
					'copied'                      => esc_html__( 'Copied', 'timeline-designer' ),
					'copy_for_support'            => esc_html__( 'Copy for Support', 'timeline-designer' ),
					'_wpnonce'                    => wp_create_nonce( '_wpnonce' ),
				)
			);
			wp_enqueue_script( 'choosen', plugins_url( 'js/chosen.jquery.min.js', __FILE__ ), null, '1.8.7', false );
			wp_enqueue_style( 'choosen', plugins_url( 'css/chosen.min.css', __FILE__ ), null, '1.8.7' );
		}
		wp_enqueue_script( 'wp-timeline-cpts', plugins_url( 'js/wp-timeline-cpts.js', __FILE__ ), array( 'jquery', 'wp-color-picker', 'jquery-ui-core', 'jquery-ui-dialog' ), $this->version, false );
		$wtl_cpts_translations = array(
			'select_gallery'      => esc_html__( 'Select Images for Gallery', 'timeline-designer' ),
			'custom_field_remove' => esc_html__( 'Require atleast one field', 'timeline-designer' ),
			'conformation'        => esc_html__( 'Are you sure you want to remove image?', 'timeline-designer' ),
		);
		wp_localize_script( 'wp-timeline-cpts', 'wtl_admin_cpts_translations', $wtl_cpts_translations );
	}

	/**
	 * Add menu at admin panel.
	 *
	 * @global string $wtl_screen_option_page
	 */
	public function wtl_add_menu() {
		global $wtl_screen_option_page, $wtl_screen_option_page2;
		$manage_blog_designs    = $this->wtl_manage();
		$wtl_screen_option_page = add_menu_page( esc_html__( 'WP Timeline Designer', 'timeline-designer' ), esc_html__( 'WP Timeline', 'timeline-designer' ), $manage_blog_designs, 'wtl_layouts', array( $this, 'wtl_display_shortcode_list' ), esc_url( TLD_URL ) . '/images/wp-timeline.png' );
		add_action( "load-$wtl_screen_option_page", array( $this, 'wtl_screen_options' ) );
		add_submenu_page( 'wtl_layouts', esc_html__( 'Timeline Layouts', 'timeline-designer' ), esc_html__( 'Timeline Layouts', 'timeline-designer' ), $manage_blog_designs, 'wtl_layouts', array( $this, 'wtl_display_shortcode_list' ) );
		add_submenu_page( 'wtl_layouts', esc_html__( 'Timeline Layout Settings', 'timeline-designer' ), esc_html__( 'Add Timeline Layout', 'timeline-designer' ), $manage_blog_designs, 'add_wtl_shortcode', array( $this, 'wtl_edit_shortcode_layout' ) );
		$wtl_screen_option_page2 = add_submenu_page( 'wtl_layouts', esc_html__( 'Custom Post Type', 'timeline-designer' ), esc_html__( 'Custom Post Type', 'timeline-designer' ), $manage_blog_designs, 'wtl_cpts', array( $this, 'wtl_display_cpts_list' ) );
		add_action( "load-$wtl_screen_option_page2", array( $this, 'wtl_screen_options2' ) );
		add_submenu_page( 'wtl_layouts', esc_html__( 'Add Custom Post Type', 'timeline-designer' ), esc_html__( 'Add Custom Post Type', 'timeline-designer' ), $manage_blog_designs, 'add_wtl_cpt', array( $this, 'wtl_custom_post_type' ) );
		add_submenu_page( 'wtl_layouts', esc_html__( 'Import Layouts', 'timeline-designer' ), esc_html__( 'Import Layouts', 'timeline-designer' ), $manage_blog_designs, 'wtl_export', array( $this, 'wtl_import_layouts' ) );
		global $submenu;
		$submenu['wtl_layouts'][1][4] = 'wtl-hidden-menu';
		$submenu['wtl_layouts'][3][4] = 'wtl-hidden-menu';
	}

	/**
	 * Capability to admin menu.
	 *
	 * @return capability
	 */
	private function wtl_manage() {
		$manage_options_cap = apply_filters( 'wtl_manage_capability', 'manage_options' );
		return $manage_options_cap;
	}

	/**
	 * Add per page option in screen option in Timeline Layout templates list
	 *
	 * @global string $wtl_screen_option_page
	 */
	public function wtl_screen_options() {
		global $wtl_screen_option_page;
		$screen = get_current_screen();
		// get out of here if we are not on our settings page.
		if ( ! is_object( $screen ) || $screen->id != $wtl_screen_option_page ) {
			return;
		}
		$args = array(
			'label'   => esc_html__( 'Number of items per page:', 'timeline-designer' ),
			'default' => 10,
			'option'  => 'wtl_per_page',
		);
		add_screen_option( 'per_page', $args );
	}
	/**
	 * Add per page option in screen option in Timeline Layout templates list 2nd
	 *
	 * @global string $wtl_screen_option_page
	 */
	public function wtl_screen_options2() {
		global $wtl_screen_option_page2;
		$screen = get_current_screen();
		// get out of here if we are not on our settings page.
		if ( ! is_object( $screen ) || $screen->id != $wtl_screen_option_page2 ) {
			return;
		}
		$args = array(
			'label'   => esc_html__( 'Number of items per page:', 'timeline-designer' ),
			'default' => 10,
			'option'  => 'wtl_per_page',
		);
		add_screen_option( 'per_page', $args );
	}

	/**
	 * Validate Timeline Layout templates list screen options on update.
	 *
	 * @param bool   $status   Whether to save or skip saving the screen option value. Default false.
	 * @param string $option The option name.
	 * @param int    $value  The number of rows to use.
	 * @return type
	 */
	public function wtl_set_screen_option( $status, $option, $value ) {
		if ( 'wtl_per_page' == $option ) {
			return $value;
		}
	}

	/**
	 * Include admin Timeline Layout list page
	 *
	 * @return void
	 */
	public static function wtl_display_shortcode_list() {
		include_once 'assets/admin-shortcode-list.php';
	}

	/**
	 * Include admin edit form.
	 *
	 * @return void
	 */
	public static function wtl_edit_shortcode_layout() {
		include_once 'assets/admin-layout-settings.php';
	}

	/**
	 * Include admin Timeline Custom Post Type list page.
	 *
	 * @return void
	 */
	public static function wtl_display_cpts_list() {
		include_once 'assets/admin-custom-post-type-list.php';
	}

	/**
	 * Add Custom Post Type.
	 *
	 * @return void
	 */
	public static function wtl_custom_post_type() {
		include_once 'assets/add-custom-post-type.php';
	}

	/**
	 * Include Import data form Page.
	 *
	 * @return void
	 */
	public static function wtl_import_layouts() {
		include_once 'assets/admin-import-form.php';
	}

	/**
	 * Search template.
	 *
	 * @return void
	 */
	public function wtl_template_search_result() {
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), '_wpnonce' ) ) {
			$template_name = isset( $_POST['temlate_name'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['temlate_name'] ) ) ) : '';
			$tempate_list  = Wp_Timeline_Lite_Ajax::wtl_blog_template_list();
			foreach ( $tempate_list as $key => $value ) {
				if ( 'soft_block' == $key || 'advanced_layout' == $key || 'hire_layout' == $key || 'fullwidth_layout' == $key || 'curve_layout' == $key || 'easy_layout' == $key ) {
					$class = 'wt-lite';
				} else {
					$class = 'wt-pro';
				}
				if ( '' === $template_name ) {
					?>
					<div class="template-thumbnail <?php echo esc_attr( $value['class'] . ' ' . $class ); ?>" <?php echo ( isset( $value['data'] ) && '' != $value['data'] ) ? 'data-value="' . esc_attr( $value['data'] ) . '"' : ''; ?>>
						<div class="template-thumbnail-inner">
							<img src="<?php echo esc_url( TLD_URL ) . '/admin/images/layouts/' . esc_attr( $value['image_name'] ); ?>" data-value="<?php echo esc_attr( $key ); ?>" alt="<?php echo esc_attr( $value['template_name'] ); ?>" title="<?php echo esc_attr( $value['template_name'] ); ?>">
							<?php if ( 'wt-lite' === $class ) { ?>
								<div class="hover_overlay">
									<div class="popup-template-name">
										<div class="popup-select"><a href="#"><?php esc_html_e( 'Select Template', 'timeline-designer' ); ?></a></div>
										<div class="popup-view"><a href="<?php echo esc_attr( $value['demo_link'] ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'timeline-designer' ); ?></a></div>
									</div>
								</div>
							<?php } else { ?>
								<div class="wtl_overlay"></div>
								<div class="wtl-img-hover_overlay">
									<img src="<?php echo esc_url( TLD_URL ) . '/admin/images/pro-tag.png'; ?>" alt="Available in Pro" />
								</div>
								<div class="hover_overlay">
									<div class="popup-template-name">
										<div class="popup-view"><a href="<?php echo esc_attr( $value['demo_link'] ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'timeline-designer' ); ?></a></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<span class="wp-timeline-span-template-name"><?php echo esc_attr( $value['template_name'] ); ?></span>
					</div>
					<?php
				} elseif ( preg_match( '/' . trim( $template_name ) . '/', $key ) ) {
					?>
					<div class="template-thumbnail <?php echo esc_attr( $value['class'] . ' ' . $class ); ?>" <?php echo ( isset( $value['data'] ) && '' != $value['data'] ) ? 'data-value="' . esc_attr( $value['data'] ) . '"' : ''; ?>>
						<div class="template-thumbnail-inner">
							<img src="<?php echo esc_url( TLD_URL ) . '/admin/images/layouts/' . esc_attr( $value['image_name'] ); ?>" data-value="<?php echo esc_attr( $key ); ?>" alt="<?php echo esc_attr( $value['template_name'] ); ?>" title="<?php echo esc_attr( $value['template_name'] ); ?>">
							<?php if ( 'wt-lite' === $class ) { ?>
								<div class="hover_overlay">
									<div class="popup-template-name">
										<div class="popup-select"><a href="#"><?php esc_html_e( 'Select Template', 'timeline-designer' ); ?></a></div>
										<div class="popup-view"><a href="<?php echo esc_attr( $value['demo_link'] ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'timeline-designer' ); ?></a></div>
									</div>
								</div>
							<?php } else { ?>
								<div class="wtl_overlay"></div>
								<div class="wtl-img-hover_overlay">
									<img src="<?php echo esc_url( TLD_URL ) . '/admin/images/pro-tag.png'; ?>" alt="Available in Pro" />
								</div>
								<div class="hover_overlay">
									<div class="popup-template-name">
										<div class="popup-view"><a href="<?php echo esc_attr( $value['demo_link'] ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'timeline-designer' ); ?></a></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<span class="wp-timeline-span-template-name"><?php echo esc_attr( $value['template_name'] ); ?></span>
					</div>
					<?php
				}
			}
		}
		exit();
	}
	/**
	 *
	 * Set default value
	 *
	 * @global array $wtl_settings
	 */
	public function wtl_default_settings_function() {
		global $wtl_settings, $wpdb;
		if ( empty( $wtl_settings ) ) {
			$wtl_settings = array(
				'pagination_type'                          => 'paged',
				'pagination_text_color'                    => '#ffffff',
				'pagination_background_color'              => '#777777',
				'pagination_text_hover_color'              => '',
				'pagination_background_hover_color'        => '',
				'pagination_text_active_color'             => '',
				'pagination_active_background_color'       => '',
				'pagination_border_color'                  => '#b2b2b2',
				'pagination_active_border_color'           => '#007acc',
				'display_category'                         => '0',
				'display_tag'                              => '0',
				'display_author'                           => '0',
				'display_author_data'                      => '0',
				'display_author_biography'                 => '0',
				'display_date'                             => '0',
				'disable_link_category'                    => '0',
				'disable_link_tag'                         => '0',
				'disable_link_author'                      => '0',
				'disable_link_date'                        => '0',
				'disable_link_comment'                     => '0',
				'display_story_year'                       => '1',
				'display_thumbnail'                        => '0',
				'display_comment_count'                    => '0',
				'display_comment'                          => '0',
				'display_navigation'                       => '0',
				'template_name'                            => 'advanced_layout',
				'template_alternativebackground'           => '0',
				'rss_use_excerpt'                          => '1',
				'social_share'                             => '1',
				'social_style'                             => '1',
				'social_icon_style'                        => '1',
				'social_icon_size'                         => '1',
				'facebook_link'                            => '1',
				'twitter_link'                             => '1',
				'linkedin_link'                            => '1',
				'email_link'                               => '1',
				'whatsapp_link'                            => '1',
				'pinterest_link'                           => '1',
				'facebook_link_with_count'                 => '0',
				'pinterest_link_with_count'                => '0',
				'social_count_position'                    => 'bottom',
				'wp_timeline_post_offset'                  => '0',
				'template_bgcolor'                         => '#ffffff',
				'template_color'                           => '#000',
				'template_title_alignment'                 => 'left',
				'template_titlecolor'                      => '#222222',
				'template_titlehovercolor'                 => '#666666',
				'template_titlebackcolor'                  => '',
				'template_titlefontsize'                   => '30',
				'template_titlefontface'                   => '',
				'template_contentfontface'                 => '',
				'related_post_by'                          => 'category',
				'wp_timeline_related_post_order_by'        => 'date',
				'wp_timeline_related_post_order'           => 'DESC',
				'txtExcerptlength'                         => '50',
				'content_fontsize'                         => '14',
				'firstletter_fontsize'                     => '20',
				'firstletter_contentcolor'                 => '#000000',
				'template_contentcolor'                    => '#7b95a6',
				'txtReadmoretext'                          => 'Read More',
				'readmore_font_family_font_type'           => '',
				'readmore_font_family'                     => '',
				'readmore_fontsize'                        => '14',
				'readmore_font_weight'                     => 'normal',
				'readmore_font_line_height'                => '1.5',
				'readmore_font_text_transform'             => 'none',
				'readmore_font_text_decoration'            => 'none',
				'readmore_font_letter_spacing'             => '0',
				'read_more_on'                             => '2',
				'template_readmorecolor'                   => '#2376ad',
				'template_readmorehovercolor'              => '#2376ad',
				'template_readmorebackcolor'               => '#dcdee0',
				'readmore_button_border_radius'            => '0',
				'readmore_button_alignment'                => 'left',
				'readmore_button_paddingleft'              => '10',
				'readmore_button_paddingright'             => '10',
				'readmore_button_paddingtop'               => '3',
				'readmore_button_paddingbottom'            => '3',
				'readmore_button_marginleft'               => '0',
				'readmore_button_marginright'              => '0',
				'readmore_button_margintop'                => '0',
				'readmore_button_marginbottom'             => '0',
				'read_more_button_border_style'            => 'solid',
				'read_more_button_hover_border_style'      => 'solid',
				'readmore_button_hover_border_radius'      => '0',
				'wp_timeline_readmore_button_hover_borderleft' => '0',
				'wp_timeline_readmore_button_hover_borderleftcolor' => '',
				'wp_timeline_readmore_button_hover_borderright' => '0',
				'wp_timeline_readmore_button_hover_borderrightcolor' => '',
				'wp_timeline_readmore_button_hover_bordertop' => '0',
				'wp_timeline_readmore_button_hover_bordertopcolor' => '',
				'wp_timeline_readmore_button_hover_borderbottom' => '0',
				'wp_timeline_readmore_button_hover_borderbottomcolor' => '',
				'wp_timeline_readmore_button_borderleft'   => '0',
				'wp_timeline_readmore_button_borderleftcolor' => '',
				'wp_timeline_readmore_button_borderright'  => '0',
				'wp_timeline_readmore_button_borderrightcolor' => '',
				'wp_timeline_readmore_button_bordertop'    => '0',
				'wp_timeline_readmore_button_bordertopcolor' => '',
				'wp_timeline_readmore_button_borderbottom' => '0',
				'wp_timeline_readmore_button_borderbottomcolor' => '',
				'template_columns'                         => '2',
				'template_grid_skin'                       => 'default',
				'template_grid_height'                     => '300',
				'wp_timeline_blog_order_by'                => '',
				'wp_timeline_blog_order'                   => 'DESC',
				'related_post_title'                       => esc_html__( 'Related Posts', 'timeline-designer' ),
				'date_color_of_readmore'                   => '0',
				'template_easing'                          => 'easeOutSine',
				'display_timeline_bar'                     => '0',
				'item_width'                               => '400',
				'item_height'                              => '570',
				'display_arrows'                           => '1',
				'enable_autoslide'                         => '0',
				'scroll_speed'                             => '1000',
				'easy_timeline_effect'                     => 'flip-effect',
				'display_feature_image'                    => '0',
				'thumbnail_skin'                           => '0',
				'display_sale_tag'                         => '0',
				'wp_timeline_sale_tagtext_alignment'       => 'left-top',
				'wp_timeline_sale_tagtext_marginleft'      => '5',
				'wp_timeline_sale_tagtext_marginright'     => '5',
				'wp_timeline_sale_tagtext_margintop'       => '5',
				'wp_timeline_sale_tagtext_marginbottom'    => '5',
				'wp_timeline_sale_tagtext_paddingleft'     => '5',
				'wp_timeline_sale_tagtext_paddingright'    => '5',
				'wp_timeline_sale_tagtext_paddingtop'      => '5',
				'wp_timeline_sale_tagtext_paddingbottom'   => '5',
				'wp_timeline_sale_tagtextcolor'            => '#ffffff',
				'wp_timeline_sale_tagbgcolor'              => '#777777',
				'wp_timeline_sale_tag_angle'               => '0',
				'wp_timeline_sale_tag_border_radius'       => '0',
				'wp_timeline_sale_tagfontface'             => '',
				'wp_timeline_sale_tagfontsize'             => '18',
				'wp_timeline_sale_tag_font_weight'         => '700',
				'wp_timeline_sale_tag_font_line_height'    => '1.5',
				'wp_timeline_sale_tag_font_italic'         => '0',
				'wp_timeline_sale_tag_font_text_transform' => 'none',
				'wp_timeline_sale_tag_font_text_decoration' => 'none',
				'display_product_rating'                   => '0',
				'wp_timeline_star_rating_bg_color'         => '#000000',
				'wp_timeline_star_rating_color'            => '#d3ced2',
				'wp_timeline_star_rating_alignment'        => 'left',
				'wp_timeline_star_rating_paddingleft'      => '5',
				'wp_timeline_star_rating_paddingright'     => '5',
				'wp_timeline_star_rating_paddingtop'       => '5',
				'wp_timeline_star_rating_paddingbottom'    => '5',
				'wp_timeline_star_rating_marginleft'       => '5',
				'wp_timeline_star_rating_marginright'      => '5',
				'wp_timeline_star_rating_margintop'        => '5',
				'wp_timeline_star_rating_marginbottom'     => '5',
				'display_product_price'                    => '0',
				'wp_timeline_pricetext_alignment'          => 'left',
				'wp_timeline_pricetext_paddingleft'        => '5',
				'wp_timeline_pricetext_paddingright'       => '5',
				'wp_timeline_pricetext_paddingtop'         => '5',
				'wp_timeline_pricetext_paddingbottom'      => '5',
				'wp_timeline_pricetext_marginleft'         => '5',
				'wp_timeline_pricetext_marginright'        => '5',
				'wp_timeline_pricetext_margintop'          => '5',
				'wp_timeline_pricetext_marginbottom'       => '5',
				'wp_timeline_pricetextcolor'               => '#444444',
				'wp_timeline_pricefontface_font_type'      => '',
				'wp_timeline_pricefontface'                => '',
				'wp_timeline_pricefontsize'                => '18',
				'wp_timeline_price_font_weight'            => '700',
				'wp_timeline_price_font_line_height'       => '1.5',
				'wp_timeline_price_font_italic'            => '0',
				'wp_timeline_price_font_letter_spacing'    => '0',
				'wp_timeline_price_font_text_transform'    => 'none',
				'wp_timeline_price_font_text_decoration'   => 'none',
				'wp_timeline_addtocart_button_font_text_transform' => 'none',
				'wp_timeline_addtocart_button_font_text_decoration' => 'none',
				'wp_timeline_addtowishlist_button_font_text_transform' => 'none',
				'wp_timeline_addtowishlist_button_font_text_decoration' => 'none',
				'display_addtocart_button'                 => '0',
				'wp_timeline_addtocart_button_fontface_font_type' => '',
				'wp_timeline_addtocart_button_fontface'    => '',
				'wp_timeline_addtocart_button_fontsize'    => '14',
				'wp_timeline_addtocart_button_font_weight' => 'normal',
				'wp_timeline_addtocart_button_font_italic' => '0',
				'wp_timeline_addtocart_button_letter_spacing' => '0',
				'display_addtocart_button_line_height'     => '1.5',
				'wp_timeline_addtocart_textcolor'          => '#ffffff',
				'wp_timeline_addtocart_backgroundcolor'    => '#777777',
				'wp_timeline_addtocart_text_hover_color'   => '#ffffff',
				'wp_timeline_addtocart_hover_backgroundcolor' => '#333333',
				'wp_timeline_addtocartbutton_borderleft'   => '0',
				'wp_timeline_addtocartbutton_borderleftcolor' => '',
				'wp_timeline_addtocartbutton_borderright'  => '0',
				'wp_timeline_addtocartbutton_borderrightcolor' => '',
				'wp_timeline_addtocartbutton_bordertop'    => '0',
				'wp_timeline_addtocartbutton_bordertopcolor' => '',
				'wp_timeline_addtocartbutton_borderbottom' => '0',
				'wp_timeline_addtocartbutton_borderbottomcolor' => '',
				'wp_timeline_addtocartbutton_hover_borderleft' => '0',
				'wp_timeline_addtocartbutton_hover_borderleftcolor' => '',
				'wp_timeline_addtocartbutton_hover_borderright' => '0',
				'wp_timeline_addtocartbutton_hover_borderrightcolor' => '',
				'wp_timeline_addtocartbutton_hover_bordertop' => '0',
				'wp_timeline_addtocartbutton_hover_bordertopcolor' => '',
				'wp_timeline_addtocartbutton_hover_borderbottom' => '0',
				'wp_timeline_addtocartbutton_hover_borderbottomcolor' => '',
				'display_addtocart_button_border_hover_radius' => '0',
				'wp_timeline_addtocartbutton_hover_padding_leftright' => '0',
				'wp_timeline_addtocartbutton_hover_padding_topbottom' => '0',
				'wp_timeline_addtocartbutton_hover_margin_topbottom' => '0',
				'wp_timeline_addtocartbutton_hover_margin_leftright' => '0',
				'wp_timeline_addtocartbutton_padding_leftright' => '10',
				'wp_timeline_addtocartbutton_padding_topbottom' => '10',
				'wp_timeline_addtocartbutton_margin_leftright' => '15',
				'wp_timeline_addtocartbutton_margin_topbottom' => '10',
				'wp_timeline_addtocartbutton_alignment'    => 'left',
				'display_addtocart_button_border_radius'   => '0',
				'wp_timeline_addtocart_button_left_box_shadow' => '0',
				'wp_timeline_addtocart_button_right_box_shadow' => '0',
				'wp_timeline_addtocart_button_top_box_shadow' => '0',
				'wp_timeline_addtocart_button_bottom_box_shadow' => '0',
				'wp_timeline_addtocart_button_box_shadow_color' => '',
				'wp_timeline_addtocart_button_hover_left_box_shadow' => '0',
				'wp_timeline_addtocart_button_hover_right_box_shadow' => '0',
				'wp_timeline_addtocart_button_hover_top_box_shadow' => '0',
				'wp_timeline_addtocart_button_hover_bottom_box_shadow' => '0',
				'wp_timeline_addtocart_button_hover_box_shadow_color' => '',
				'display_addtowishlist_button'             => '0',
				'wp_timeline_wishlistbutton_alignment'     => 'left',
				'wp_timeline_cart_wishlistbutton_alignment' => 'left',
				'wp_timeline_wishlistbutton_on'            => '1',
				'wp_timeline_addtowishlist_button_fontface_font_type' => '',
				'wp_timeline_addtowishlist_button_fontface' => '',
				'wp_timeline_addtowishlist_button_fontsize' => '14',
				'wp_timeline_addtowishlist_button_font_weight' => 'normal',
				'wp_timeline_addtowishlist_button_font_italic' => '0',
				'wp_timeline_addtowishlist_button_letter_spacing' => '0',
				'display_wishlist_button_line_height'      => '1.5',
				'wp_timeline_wishlist_textcolor'           => '#ffffff',
				'wp_timeline_wishlist_text_hover_color'    => '#ffffff',
				'wp_timeline_wishlist_backgroundcolor'     => '#777777',
				'wp_timeline_wishlist_hover_backgroundcolor' => '#333333',
				'display_wishlist_button_border_radius'    => '0',
				'wp_timeline_wishlistbutton_borderleft'    => '0',
				'wp_timeline_wishlistbutton_borderleftcolor' => '',
				'wp_timeline_wishlistbutton_borderright'   => '0',
				'wp_timeline_wishlistbutton_borderrightcolor' => '',
				'wp_timeline_wishlistbutton_bordertop'     => '0',
				'wp_timeline_wishlistbutton_bordertopcolor' => '',
				'wp_timeline_wishlistbutton_borderbuttom'  => '0',
				'wp_timeline_wishlistbutton_borderbottomcolor' => '',
				'wp_timeline_wishlistbutton_hover_borderleft' => '0',
				'wp_timeline_wishlistbutton_hover_borderleftcolor' => '',
				'wp_timeline_wishlistbutton_hover_borderright' => '0',
				'wp_timeline_wishlistbutton_hover_borderrightcolor' => '',
				'wp_timeline_wishlistbutton_hover_bordertop' => '0',
				'wp_timeline_wishlistbutton_hover_bordertopcolor' => '',
				'wp_timeline_wishlistbutton_hover_borderbuttom' => '0',
				'wp_timeline_wishlistbutton_hover_borderbottomcolor' => '',
				'wp_timeline_wishlistbutton_padding_leftright' => '10',
				'wp_timeline_wishlistbutton_padding_topbottom' => '10',
				'wp_timeline_wishlistbutton_margin_leftright' => '10',
				'wp_timeline_wishlistbutton_margin_topbottom' => '10',
				'wp_timeline_wishlistbutton_hover_margin_topbottom' => '5',
				'wp_timeline_wishlistbutton_hover_margin_leftright' => '5',
				'display_acf_field'                        => '0',
				'wp_timeline_acf_field'                    => '',
				'display_download_price'                   => '0',
				'wp_timeline_edd_price_alignment'          => 'left',
				'wp_timeline_edd_price_paddingleft'        => '5',
				'wp_timeline_edd_price_paddingright'       => '5',
				'wp_timeline_edd_price_paddingtop'         => '5',
				'wp_timeline_edd_price_paddingbottom'      => '5',
				'wp_timeline_edd_price_color'              => '#444444',
				'wp_timeline_edd_pricefontface_font_type'  => '',
				'wp_timeline_edd_pricefontface'            => '',
				'wp_timeline_edd_pricefontsize'            => '18',
				'wp_timeline_edd_price_font_weight'        => '700',
				'wp_timeline_edd_price_font_line_height'   => '1.5',
				'wp_timeline_edd_price_font_italic'        => '0',
				'wp_timeline_edd_price_font_letter_spacing' => '0',
				'wp_timeline_edd_price_font_text_decoration' => 'none',
				'display_edd_addtocart_button'             => '0',
				'wp_timeline_edd_addtocart_button_fontface_font_type' => '',
				'wp_timeline_edd_addtocart_button_fontface' => '',
				'wp_timeline_edd_addtocart_button_fontsize' => '14',
				'wp_timeline_edd_addtocart_button_font_weight' => 'normal',
				'wp_timeline_edd_addtocart_button_font_italic' => '0',
				'wp_timeline_edd_addtocart_button_letter_spacing' => '0',
				'display_edd_addtocart_button_line_height' => '1.5',
				'wp_timeline_edd_addtocart_textcolor'      => '#ffffff',
				'wp_timeline_edd_addtocart_backgroundcolor' => '#777777',
				'wp_timeline_edd_addtocart_text_hover_color' => '#ffffff',
				'wp_timeline_edd_addtocart_hover_backgroundcolor' => '#333333',
				'wp_timeline_edd_addtocartbutton_borderleft' => '0',
				'wp_timeline_edd_addtocartbutton_borderleftcolor' => '',
				'wp_timeline_edd_addtocartbutton_borderright' => '0',
				'wp_timeline_edd_addtocartbutton_borderrightcolor' => '',
				'wp_timeline_edd_addtocartbutton_bordertop' => '0',
				'wp_timeline_edd_addtocartbutton_bordertopcolor' => '',
				'wp_timeline_edd_addtocartbutton_borderbottom' => '0',
				'wp_timeline_edd_addtocartbutton_borderbottomcolor' => '',
				'wp_timeline_edd_addtocartbutton_hover_borderleft' => '0',
				'wp_timeline_edd_addtocartbutton_hover_borderleftcolor' => '',
				'wp_timeline_edd_addtocartbutton_hover_borderright' => '0',
				'wp_timeline_edd_addtocartbutton_hover_borderrightcolor' => '',
				'wp_timeline_edd_addtocartbutton_hover_bordertop' => '0',
				'wp_timeline_edd_addtocartbutton_hover_bordertopcolor' => '',
				'wp_timeline_edd_addtocartbutton_hover_borderbottom' => '0',
				'wp_timeline_edd_addtocartbutton_hover_borderbottomcolor' => '',
				'display_edd_addtocart_button_border_hover_radius' => '0',
				'wp_timeline_edd_addtocartbutton_hover_padding_leftright' => '0',
				'wp_timeline_edd_addtocartbutton_hover_padding_topbottom' => '0',
				'wp_timeline_edd_addtocartbutton_hover_margin_topbottom' => '0',
				'wp_timeline_edd_addtocartbutton_hover_margin_leftright' => '0',
				'wp_timeline_edd_addtocartbutton_padding_leftright' => '10',
				'wp_timeline_edd_addtocartbutton_padding_topbottom' => '10',
				'wp_timeline_edd_addtocartbutton_margin_leftright' => '15',
				'wp_timeline_edd_addtocartbutton_margin_topbottom' => '10',
				'wp_timeline_edd_addtocartbutton_alignment' => 'left',
				'display_edd_addtocart_button_border_radius' => '0',
				'wp_timeline_edd_addtocart_button_left_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_right_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_top_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_bottom_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_box_shadow_color' => '',
				'wp_timeline_edd_addtocart_button_hover_left_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_hover_right_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_hover_top_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_hover_bottom_box_shadow' => '0',
				'wp_timeline_edd_addtocart_button_hover_box_shadow_color' => '',
			);
			$wtl_settings = apply_filters( 'wp_timeline_change_default_settings', $wtl_settings );
		}
	}

	/**
	 *
	 * Create table if table not found when plugin is active
	 *
	 * @global object $wpdb
	 */
	public function wtl_table_status() {
		global $wpdb;
		if ( is_plugin_active( 'timeline-designer/timeline-designer.php' ) ) {
			$wp_timeline_ro_shortcode = $wpdb->prefix . 'wtl_shortcodes';
			$wp_timeline_ro_cpts      = $wpdb->prefix . 'wtl_cpts';
			if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "wtl_shortcodes'" ) != $wp_timeline_ro_shortcode ) {
				$this->wtl_create_shortcodes_table();
			}
			if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "wtl_cpts'" ) != $wp_timeline_ro_cpts ) {
				self::wtl_create_cpts_table();
			}
		}
	}

	/**
	 * Create Table for Shortcode
	 */
	public function wtl_create_shortcodes_table() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'wtl_shortcodes';
		$charset_collate = '';
		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
		$sql = "CREATE TABLE $table_name (
			wtlid int(9) NOT NULL AUTO_INCREMENT,
			shortcode_name tinytext NOT NULL,
			wtlsettngs text NOT NULL,
			UNIQUE KEY wtlid (wtlid)
		) $charset_collate;";
		// reference to upgrade.php file.
		include_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Create Custom post type table.
	 *
	 * @return void;
	 */
	public static function wtl_create_cpts_table() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'wtl_cpts';
		$charset_collate = '';
		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
		$sql = "CREATE TABLE  $table_name (id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,name varchar(191) NOT NULL,slug varchar(191) NOT NULL,setting longtext NULL) $charset_collate;";
		include_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Save template at admin side
	 *
	 * @global object $wpdb
	 * @global array $wtl_settings
	 * @global WP_Error $wtl_errors
	 * @global string $wtl_success
	 */
	public function wtl_save_layouts() {
		global $wpdb, $wtl_settings, $wtl_errors, $wtl_success;
		$table_name = $wpdb->prefix . 'wtl_shortcodes';
		if ( isset( $_GET['page'] ) && ( 'wtl_layouts' === $_GET['page'] || 'add_wtl_shortcode' === $_GET['page'] ) ) {
			$user   = wp_get_current_user();
			$closed = array( 'wp_timeline_general' );
			$closed = array_filter( $closed );
			if ( 'wtl_layouts' === $_GET['page'] ) {
				update_user_option( $user->ID, 'wptclosewptboxes_add_wtl_shortcode', $closed, true );
			}
		}
		/** Save Timeline Layout Template */
		if ( isset( $_GET['page'] ) && 'add_wtl_shortcode' === $_GET['page'] ) {
			if ( ! isset( $_GET['action'] ) || '' === $_GET['action'] ) {
				$user   = wp_get_current_user();
				$closed = array( 'wp_timeline_general' );
				$closed = array_filter( $closed );
				update_user_option( $user->ID, 'wptclosewptboxes_add_wtl_shortcode', $closed, true );
			}
			if ( isset( $_POST['savedata'] ) || ( isset( $_POST['resetdata'] ) && '' !== $_POST['resetdata'] ) ) {
				$templates = array();
				if ( isset( $_POST['wtl-submit-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wtl-submit-nonce'] ) ), 'wtl-shortcode-form-submit' ) ) {
					$f1   = isset( $_POST['wtl-submit-nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl-submit-nonce'] ) ) : '';
					$f2   = isset( $_POST['_wp_http_referer'] ) ? sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) : '';
					$f3   = isset( $_POST['originalpage'] ) ? sanitize_text_field( wp_unslash( $_POST['originalpage'] ) ) : '';
					$f4   = isset( $_POST['savedata'] ) ? sanitize_text_field( wp_unslash( $_POST['savedata'] ) ) : '';
					$f5   = isset( $_POST['template_name'] ) ? sanitize_text_field( wp_unslash( $_POST['template_name'] ) ) : '';
					$f6   = isset( $_POST['unique_shortcode_name'] ) ? sanitize_text_field( wp_unslash( $_POST['unique_shortcode_name'] ) ) : '';
					$f7   = isset( $_POST['timeline_heading_1'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline_heading_1'] ) ) : '';
					$f8   = isset( $_POST['timeline_heading_2'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline_heading_2'] ) ) : '';
					$f9   = isset( $_POST['custom_post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_post_type'] ) ) : '';
					$f10  = isset( $_POST['wtl_page_display'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_page_display'] ) ) : '';
					$f11  = isset( $_POST['posts_per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['posts_per_page'] ) ) : '';
					$f12  = isset( $_POST['display_category'] ) ? sanitize_text_field( wp_unslash( $_POST['display_category'] ) ) : '';
					$f13  = isset( $_POST['display_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['display_tag'] ) ) : '';
					$f14  = isset( $_POST['display_author'] ) ? sanitize_text_field( wp_unslash( $_POST['display_author'] ) ) : '';
					$f15  = isset( $_POST['display_date'] ) ? sanitize_text_field( wp_unslash( $_POST['display_date'] ) ) : '';
					$f16  = isset( $_POST['display_comment_count'] ) ? sanitize_text_field( wp_unslash( $_POST['display_comment_count'] ) ) : '';
					$f17  = isset( $_POST['custom_css'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_css'] ) ) : '';
					$f18  = isset( $_POST['template_bgcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_bgcolor'] ) ) : '';
					$f19  = isset( $_POST['wp_timeline_post_offset'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_post_offset'] ) ) : '';
					$f20  = isset( $_POST['meta_font_family_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_family_font_type'] ) ) : '';
					$f21  = isset( $_POST['meta_font_family'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_family'] ) ) : '';
					$f22  = isset( $_POST['meta_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_fontsize'] ) ) : '';
					$f23  = isset( $_POST['meta_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_weight'] ) ) : '';
					$f24  = isset( $_POST['meta_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_line_height'] ) ) : '';
					$f25  = isset( $_POST['meta_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_italic'] ) ) : '';
					$f26  = isset( $_POST['meta_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_text_transform'] ) ) : '';
					$f27  = isset( $_POST['meta_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_text_decoration'] ) ) : '';
					$f28  = isset( $_POST['meta_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['meta_font_letter_spacing'] ) ) : '';
					$f29  = isset( $_POST['date_font_family_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_family_font_type'] ) ) : '';
					$f30  = isset( $_POST['date_font_family'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_family'] ) ) : '';
					$f31  = isset( $_POST['date_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['date_fontsize'] ) ) : '';
					$f32  = isset( $_POST['date_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_weight'] ) ) : '';
					$f33  = isset( $_POST['date_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_line_height'] ) ) : '';
					$f34  = isset( $_POST['date_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_italic'] ) ) : '';
					$f35  = isset( $_POST['date_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_text_transform'] ) ) : '';
					$f36  = isset( $_POST['date_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_text_decoration'] ) ) : '';
					$f37  = isset( $_POST['date_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['date_font_letter_spacing'] ) ) : '';
					$f38  = isset( $_POST['wp_timeline_post_title_link'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_post_title_link'] ) ) : '';
					$f39  = isset( $_POST['template_title_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['template_title_alignment'] ) ) : '';
					$f40  = isset( $_POST['template_titlecolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_titlecolor'] ) ) : '';
					$f41  = isset( $_POST['template_titlehovercolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_titlehovercolor'] ) ) : '';
					$f42  = isset( $_POST['template_titlebackcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_titlebackcolor'] ) ) : '';
					$f43  = isset( $_POST['template_titlefontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['template_titlefontface_font_type'] ) ) : '';
					$f44  = isset( $_POST['rss_use_excerpt'] ) ? sanitize_text_field( wp_unslash( $_POST['rss_use_excerpt'] ) ) : '';
					$f45  = isset( $_POST['template_post_content_from'] ) ? sanitize_text_field( wp_unslash( $_POST['template_post_content_from'] ) ) : '';
					$f46  = isset( $_POST['display_html_tags'] ) ? sanitize_text_field( wp_unslash( $_POST['display_html_tags'] ) ) : '';
					$f47  = isset( $_POST['firstletter_big'] ) ? sanitize_text_field( wp_unslash( $_POST['firstletter_big'] ) ) : '';
					$f48  = isset( $_POST['firstletter_font_family_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['firstletter_font_family_font_type'] ) ) : '';
					$f49  = isset( $_POST['firstletter_font_family'] ) ? sanitize_text_field( wp_unslash( $_POST['firstletter_font_family'] ) ) : '';
					$f50  = isset( $_POST['firstletter_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['firstletter_fontsize'] ) ) : '';
					$f51  = isset( $_POST['firstletter_contentcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['firstletter_contentcolor'] ) ) : '';
					$f52  = isset( $_POST['txtExcerptlength'] ) ? sanitize_text_field( wp_unslash( $_POST['txtExcerptlength'] ) ) : '';
					$f53  = isset( $_POST['advance_contents'] ) ? sanitize_text_field( wp_unslash( $_POST['advance_contents'] ) ) : '';
					$f54  = isset( $_POST['contents_stopage_from'] ) ? sanitize_text_field( wp_unslash( $_POST['contents_stopage_from'] ) ) : '';
					$f55  = isset( $_POST['contents_stopage_character'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['contents_stopage_character'] ) ) : array( '.' );
					$f56  = isset( $_POST['template_contentcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_contentcolor'] ) ) : '';
					$f57  = isset( $_POST['content_font_family_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_family_font_type'] ) ) : '';
					$f58  = isset( $_POST['content_font_family'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_family'] ) ) : '';
					$f59  = isset( $_POST['content_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['content_fontsize'] ) ) : '';
					$f60  = isset( $_POST['content_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_weight'] ) ) : '';
					$f61  = isset( $_POST['content_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_line_height'] ) ) : '';
					$f62  = isset( $_POST['content_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_italic'] ) ) : '';
					$f63  = isset( $_POST['content_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_text_transform'] ) ) : '';
					$f64  = isset( $_POST['content_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_text_decoration'] ) ) : '';
					$f65  = isset( $_POST['content_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['content_font_letter_spacing'] ) ) : '';
					$f66  = isset( $_POST['read_more_link'] ) ? sanitize_text_field( wp_unslash( $_POST['read_more_link'] ) ) : '';
					$f67  = isset( $_POST['read_more_on'] ) ? sanitize_text_field( wp_unslash( $_POST['read_more_on'] ) ) : '';
					$f68  = isset( $_POST['txtReadmoretext'] ) ? sanitize_text_field( wp_unslash( $_POST['txtReadmoretext'] ) ) : '';
					$f69  = isset( $_POST['post_link_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_link_type'] ) ) : '';
					$f70  = isset( $_POST['custom_link_url'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_link_url'] ) ) : '';
					$f71  = isset( $_POST['readmore_button_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_alignment'] ) ) : '';
					$f72  = isset( $_POST['template_readmorecolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_readmorecolor'] ) ) : '';
					$f73  = isset( $_POST['template_readmorehovercolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_readmorehovercolor'] ) ) : '';
					$f74  = isset( $_POST['template_readmorebackcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_readmorebackcolor'] ) ) : '';
					$f75  = isset( $_POST['template_readmore_hover_backcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['template_readmore_hover_backcolor'] ) ) : '';
					$f76  = isset( $_POST['read_more_button_border_style'] ) ? sanitize_text_field( wp_unslash( $_POST['read_more_button_border_style'] ) ) : '';
					$f77  = isset( $_POST['readmore_button_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_border_radius'] ) ) : '';
					$f78  = isset( $_POST['wp_timeline_readmore_button_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderleft'] ) ) : '';
					$f79  = isset( $_POST['wp_timeline_readmore_button_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderleftcolor'] ) ) : '';
					$f80  = isset( $_POST['wp_timeline_readmore_button_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderright'] ) ) : '';
					$f81  = isset( $_POST['wp_timeline_readmore_button_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderrightcolor'] ) ) : '';
					$f82  = isset( $_POST['wp_timeline_readmore_button_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_bordertop'] ) ) : '';
					$f83  = isset( $_POST['wp_timeline_readmore_button_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_bordertopcolor'] ) ) : '';
					$f84  = isset( $_POST['wp_timeline_readmore_button_borderbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderbottom'] ) ) : '';
					$f85  = isset( $_POST['wp_timeline_readmore_button_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_borderbottomcolor'] ) ) : '';
					$f86  = isset( $_POST['read_more_button_hover_border_style'] ) ? sanitize_text_field( wp_unslash( $_POST['read_more_button_hover_border_style'] ) ) : '';
					$f87  = isset( $_POST['readmore_button_hover_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_hover_border_radius'] ) ) : '';
					$f88  = isset( $_POST['wp_timeline_readmore_button_hover_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderleft'] ) ) : '';
					$f89  = isset( $_POST['wp_timeline_readmore_button_hover_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderleftcolor'] ) ) : '';
					$f90  = isset( $_POST['wp_timeline_readmore_button_hover_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderright'] ) ) : '';
					$f91  = isset( $_POST['wp_timeline_readmore_button_hover_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderrightcolor'] ) ) : '';
					$f92  = isset( $_POST['wp_timeline_readmore_button_hover_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_bordertop'] ) ) : '';
					$f93  = isset( $_POST['wp_timeline_readmore_button_hover_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_bordertopcolor'] ) ) : '';
					$f94  = isset( $_POST['wp_timeline_readmore_button_hover_borderbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderbottom'] ) ) : '';
					$f95  = isset( $_POST['wp_timeline_readmore_button_hover_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_readmore_button_hover_borderbottomcolor'] ) ) : '';
					$f96  = isset( $_POST['readmore_button_paddingleft'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_paddingleft'] ) ) : '';
					$f97  = isset( $_POST['readmore_button_paddingright'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_paddingright'] ) ) : '';
					$f98  = isset( $_POST['readmore_button_paddingtop'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_paddingtop'] ) ) : '';
					$f99  = isset( $_POST['readmore_button_paddingbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_paddingbottom'] ) ) : '';
					$f100 = isset( $_POST['readmore_button_marginleft'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_marginleft'] ) ) : '';
					$f101 = isset( $_POST['readmore_button_marginright'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_marginright'] ) ) : '';
					$f102 = isset( $_POST['readmore_button_margintop'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_margintop'] ) ) : '';
					$f103 = isset( $_POST['readmore_button_marginbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_button_marginbottom'] ) ) : '';
					$f104 = isset( $_POST['readmore_font_family_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_family_font_type'] ) ) : '';
					$f105 = isset( $_POST['readmore_font_family'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_family'] ) ) : '';
					$f106 = isset( $_POST['readmore_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_fontsize'] ) ) : '';
					$f107 = isset( $_POST['readmore_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_weight'] ) ) : '';
					$f108 = isset( $_POST['readmore_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_line_height'] ) ) : '';
					$f109 = isset( $_POST['readmore_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_italic'] ) ) : '';
					$f110 = isset( $_POST['readmore_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_text_transform'] ) ) : '';
					$f111 = isset( $_POST['readmore_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_text_decoration'] ) ) : '';
					$f112 = isset( $_POST['readmore_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['readmore_font_letter_spacing'] ) ) : '';
					$f113 = isset( $_POST['wp_timeline_content_border_width'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_border_width'] ) ) : '';
					$f114 = isset( $_POST['wp_timeline_content_border_style'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_border_style'] ) ) : '';
					$f115 = isset( $_POST['wp_timeline_content_border_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_border_color'] ) ) : '';
					$f116 = isset( $_POST['wp_timeline_content_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_border_radius'] ) ) : '';
					$f117 = isset( $_POST['content_box_bg_color'] ) ? sanitize_text_field( wp_unslash( $_POST['content_box_bg_color'] ) ) : '';
					$f118 = isset( $_POST['wp_timeline_top_content_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_top_content_box_shadow'] ) ) : '';
					$f119 = isset( $_POST['wp_timeline_right_content_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_right_content_box_shadow'] ) ) : '';
					$f120 = isset( $_POST['wp_timeline_bottom_content_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_bottom_content_box_shadow'] ) ) : '';
					$f121 = isset( $_POST['wp_timeline_left_content_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_left_content_box_shadow'] ) ) : '';
					$f122 = isset( $_POST['wp_timeline_content_box_shadow_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_box_shadow_color'] ) ) : '';
					$f123 = isset( $_POST['wp_timeline_content_padding_leftright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_padding_leftright'] ) ) : '';
					$f124 = isset( $_POST['wp_timeline_content_padding_topbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_content_padding_topbottom'] ) ) : '';
					$f125 = isset( $_POST['timeline_line_width'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline_line_width'] ) ) : '';
					$f126 = isset( $_POST['timeline_animation'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline_animation'] ) ) : '';
					$f127 = isset( $_POST['template_color'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color'] ) ) : '';
					$f128 = isset( $_POST['story_startup_text'] ) ? sanitize_text_field( wp_unslash( $_POST['story_startup_text'] ) ) : '';
					$f129 = isset( $_POST['story_ending_text'] ) ? sanitize_text_field( wp_unslash( $_POST['story_ending_text'] ) ) : '';
					$f130 = isset( $_POST['hide_timeline_icon'] ) ? sanitize_text_field( wp_unslash( $_POST['hide_timeline_icon'] ) ) : '';
					$f131 = isset( $_POST['layout_type'] ) ? sanitize_text_field( wp_unslash( $_POST['layout_type'] ) ) : '';
					$f132 = isset( $_POST['wp_timeline_enable_media'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_enable_media'] ) ) : '';
					$f133 = isset( $_POST['wp_timeline_post_image_link'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_post_image_link'] ) ) : '';
					$f134 = isset( $_POST['wp_timeline_image_hover_effect'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_image_hover_effect'] ) ) : '';
					$f135 = isset( $_POST['wp_timeline_image_hover_effect_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_image_hover_effect_type'] ) ) : '';
					$f136 = isset( $_POST['wp_timeline_default_image_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_default_image_id'] ) ) : '';
					$f137 = isset( $_POST['wp_timeline_default_image_src'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_default_image_src'] ) ) : '';
					$f138 = isset( $_POST['wp_timeline_media_size'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_media_size'] ) ) : '';
					$f139 = isset( $_POST['media_custom_width'] ) ? sanitize_text_field( wp_unslash( $_POST['media_custom_width'] ) ) : '';
					$f140 = isset( $_POST['media_custom_height'] ) ? sanitize_text_field( wp_unslash( $_POST['media_custom_height'] ) ) : '';
					$f141 = isset( $_POST['display_timeline_bar'] ) ? sanitize_text_field( wp_unslash( $_POST['display_timeline_bar'] ) ) : '';
					$f142 = isset( $_POST['timeline_start_from'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline_start_from'] ) ) : '';
					$f143 = isset( $_POST['template_easing'] ) ? sanitize_text_field( wp_unslash( $_POST['template_easing'] ) ) : '';
					$f144 = isset( $_POST['item_width'] ) ? sanitize_text_field( wp_unslash( $_POST['item_width'] ) ) : '';
					$f145 = isset( $_POST['item_height'] ) ? sanitize_text_field( wp_unslash( $_POST['item_height'] ) ) : '';
					$f146 = isset( $_POST['template_post_margin'] ) ? sanitize_text_field( wp_unslash( $_POST['template_post_margin'] ) ) : '';
					$f147 = isset( $_POST['enable_autoslide'] ) ? sanitize_text_field( wp_unslash( $_POST['enable_autoslide'] ) ) : '';
					$f148 = isset( $_POST['scroll_speed'] ) ? sanitize_text_field( wp_unslash( $_POST['scroll_speed'] ) ) : '';
					$f149 = isset( $_POST['noof_slider_nav_itme'] ) ? sanitize_text_field( wp_unslash( $_POST['noof_slider_nav_itme'] ) ) : '';
					$f150 = isset( $_POST['noof_slide'] ) ? sanitize_text_field( wp_unslash( $_POST['noof_slide'] ) ) : '';
					$f151 = isset( $_POST['pagination_type'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_type'] ) ) : '';
					$f152 = isset( $_POST['pagination_template'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_template'] ) ) : '';
					$f153 = isset( $_POST['pagination_text_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_text_color'] ) ) : '';
					$f154 = isset( $_POST['pagination_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_background_color'] ) ) : '';
					$f155 = isset( $_POST['pagination_text_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_text_hover_color'] ) ) : '';
					$f156 = isset( $_POST['pagination_background_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_background_hover_color'] ) ) : '';
					$f157 = isset( $_POST['pagination_text_active_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_text_active_color'] ) ) : '';
					$f158 = isset( $_POST['pagination_active_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_active_background_color'] ) ) : '';
					$f159 = isset( $_POST['pagination_border_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_border_color'] ) ) : '';
					$f160 = isset( $_POST['pagination_active_border_color'] ) ? sanitize_text_field( wp_unslash( $_POST['pagination_active_border_color'] ) ) : '';
					$f161 = isset( $_POST['display_sale_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['display_sale_tag'] ) ) : '';
					$f162 = isset( $_POST['wp_timeline_sale_tagtextcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtextcolor'] ) ) : '';
					$f163 = isset( $_POST['wp_timeline_sale_tagbgcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagbgcolor'] ) ) : '';
					$f164 = isset( $_POST['wp_timeline_sale_tagtext_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_alignment'] ) ) : '';
					$f165 = isset( $_POST['wp_timeline_sale_tag_angle'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_angle'] ) ) : '';
					$f166 = isset( $_POST['wp_timeline_sale_tag_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_border_radius'] ) ) : '';
					$f167 = isset( $_POST['wp_timeline_sale_tagtext_paddingleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_paddingleft'] ) ) : '';
					$f168 = isset( $_POST['wp_timeline_sale_tagtext_paddingright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_paddingright'] ) ) : '';
					$f169 = isset( $_POST['wp_timeline_sale_tagtext_paddingtop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_paddingtop'] ) ) : '';
					$f170 = isset( $_POST['wp_timeline_sale_tagtext_paddingbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_paddingbottom'] ) ) : '';
					$f171 = isset( $_POST['wp_timeline_sale_tagtext_marginleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_marginleft'] ) ) : '';
					$f172 = isset( $_POST['wp_timeline_sale_tagtext_marginright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_marginright'] ) ) : '';
					$f173 = isset( $_POST['wp_timeline_sale_tagtext_margintop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_margintop'] ) ) : '';
					$f174 = isset( $_POST['wp_timeline_sale_tagtext_marginbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagtext_marginbottom'] ) ) : '';
					$f175 = isset( $_POST['wp_timeline_sale_tagfontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagfontface_font_type'] ) ) : '';
					$f176 = isset( $_POST['wp_timeline_sale_tagfontface'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagfontface'] ) ) : '';
					$f177 = isset( $_POST['wp_timeline_sale_tagfontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tagfontsize'] ) ) : '';
					$f178 = isset( $_POST['wp_timeline_sale_tag_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_weight'] ) ) : '';
					$f179 = isset( $_POST['wp_timeline_sale_tag_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_line_height'] ) ) : '';
					$f180 = isset( $_POST['wp_timeline_sale_tag_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_italic'] ) ) : '';
					$f181 = isset( $_POST['wp_timeline_sale_tag_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_text_transform'] ) ) : '';
					$f182 = isset( $_POST['wp_timeline_sale_tag_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_text_decoration'] ) ) : '';
					$f183 = isset( $_POST['wp_timeline_sale_tag_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_sale_tag_font_letter_spacing'] ) ) : '';
					$f184 = isset( $_POST['display_product_rating'] ) ? sanitize_text_field( wp_unslash( $_POST['display_product_rating'] ) ) : '';
					$f185 = isset( $_POST['wp_timeline_star_rating_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_color'] ) ) : '';
					$f186 = isset( $_POST['wp_timeline_star_rating_bg_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_bg_color'] ) ) : '';
					$f187 = isset( $_POST['wp_timeline_star_rating_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_alignment'] ) ) : '';
					$f188 = isset( $_POST['wp_timeline_star_rating_paddingleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_paddingleft'] ) ) : '';
					$f189 = isset( $_POST['wp_timeline_star_rating_paddingright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_paddingright'] ) ) : '';
					$f190 = isset( $_POST['wp_timeline_star_rating_paddingtop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_paddingtop'] ) ) : '';
					$f191 = isset( $_POST['wp_timeline_star_rating_paddingbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_paddingbottom'] ) ) : '';
					$f192 = isset( $_POST['wp_timeline_star_rating_marginleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_marginleft'] ) ) : '';
					$f193 = isset( $_POST['wp_timeline_star_rating_marginright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_marginright'] ) ) : '';
					$f194 = isset( $_POST['wp_timeline_star_rating_margintop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_margintop'] ) ) : '';
					$f195 = isset( $_POST['wp_timeline_star_rating_marginbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_star_rating_marginbottom'] ) ) : '';
					$f196 = isset( $_POST['display_product_price'] ) ? sanitize_text_field( wp_unslash( $_POST['display_product_price'] ) ) : '';
					$f197 = isset( $_POST['wp_timeline_pricetextcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetextcolor'] ) ) : '';
					$f198 = isset( $_POST['wp_timeline_pricetext_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_alignment'] ) ) : '';
					$f199 = isset( $_POST['wp_timeline_pricetext_paddingleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_paddingleft'] ) ) : '';
					$f200 = isset( $_POST['wp_timeline_pricetext_paddingright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_paddingright'] ) ) : '';
					$f201 = isset( $_POST['wp_timeline_pricetext_paddingtop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_paddingtop'] ) ) : '';
					$f202 = isset( $_POST['wp_timeline_pricetext_paddingbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_paddingbottom'] ) ) : '';
					$f203 = isset( $_POST['wp_timeline_pricetext_marginleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_marginleft'] ) ) : '';
					$f204 = isset( $_POST['wp_timeline_pricetext_marginright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_marginright'] ) ) : '';
					$f205 = isset( $_POST['wp_timeline_pricetext_margintop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_margintop'] ) ) : '';
					$f206 = isset( $_POST['wp_timeline_pricetext_marginbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricetext_marginbottom'] ) ) : '';
					$f207 = isset( $_POST['wp_timeline_pricefontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricefontface_font_type'] ) ) : '';
					$f208 = isset( $_POST['wp_timeline_pricefontface'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricefontface'] ) ) : '';
					$f209 = isset( $_POST['wp_timeline_pricefontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_pricefontsize'] ) ) : '';
					$f210 = isset( $_POST['wp_timeline_price_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_weight'] ) ) : '';
					$f211 = isset( $_POST['wp_timeline_price_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_line_height'] ) ) : '';
					$f212 = isset( $_POST['wp_timeline_price_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_italic'] ) ) : '';
					$f213 = isset( $_POST['wp_timeline_price_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_text_transform'] ) ) : '';
					$f214 = isset( $_POST['wp_timeline_price_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_text_decoration'] ) ) : '';
					$f215 = isset( $_POST['wp_timeline_price_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_price_font_letter_spacing'] ) ) : '';
					$f216 = isset( $_POST['display_addtocart_button'] ) ? sanitize_text_field( wp_unslash( $_POST['display_addtocart_button'] ) ) : '';
					$f217 = isset( $_POST['wp_timeline_addtocartbutton_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_alignment'] ) ) : '';
					$f218 = isset( $_POST['wp_timeline_addtocart_textcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_textcolor'] ) ) : '';
					$f219 = isset( $_POST['wp_timeline_addtocart_text_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_text_hover_color'] ) ) : '';
					$f220 = isset( $_POST['wp_timeline_addtocart_backgroundcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_backgroundcolor'] ) ) : '';
					$f221 = isset( $_POST['wp_timeline_addtocart_hover_backgroundcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_hover_backgroundcolor'] ) ) : '';
					$f222 = isset( $_POST['display_addtocart_button_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['display_addtocart_button_border_radius'] ) ) : '';
					$f223 = isset( $_POST['wp_timeline_addtocartbutton_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderleft'] ) ) : '';
					$f224 = isset( $_POST['wp_timeline_addtocartbutton_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderleftcolor'] ) ) : '';
					$f225 = isset( $_POST['wp_timeline_addtocartbutton_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderright'] ) ) : '';
					$f226 = isset( $_POST['wp_timeline_addtocartbutton_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderrightcolor'] ) ) : '';
					$f227 = isset( $_POST['wp_timeline_addtocartbutton_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_bordertop'] ) ) : '';
					$f228 = isset( $_POST['wp_timeline_addtocartbutton_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_bordertopcolor'] ) ) : '';
					$f229 = isset( $_POST['wp_timeline_addtocartbutton_borderbuttom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderbuttom'] ) ) : '';
					$f230 = isset( $_POST['wp_timeline_addtocartbutton_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_borderbottomcolor'] ) ) : '';
					$f231 = isset( $_POST['display_addtocart_button_border_hover_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['display_addtocart_button_border_hover_radius'] ) ) : '';
					$f232 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderleft'] ) ) : '';
					$f233 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderleftcolor'] ) ) : '';
					$f234 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderright'] ) ) : '';
					$f235 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderrightcolor'] ) ) : '';
					$f236 = isset( $_POST['wp_timeline_addtocartbutton_hover_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_bordertop'] ) ) : '';
					$f237 = isset( $_POST['wp_timeline_addtocartbutton_hover_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_bordertopcolor'] ) ) : '';
					$f238 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderbuttom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderbuttom'] ) ) : '';
					$f239 = isset( $_POST['wp_timeline_addtocartbutton_hover_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_hover_borderbottomcolor'] ) ) : '';
					$f240 = isset( $_POST['wp_timeline_addtocartbutton_padding_leftright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_padding_leftright'] ) ) : '';
					$f241 = isset( $_POST['wp_timeline_addtocartbutton_padding_topbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_padding_topbottom'] ) ) : '';
					$f242 = isset( $_POST['wp_timeline_addtocartbutton_margin_leftright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_margin_leftright'] ) ) : '';
					$f243 = isset( $_POST['wp_timeline_addtocartbutton_margin_topbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocartbutton_margin_topbottom'] ) ) : '';
					$f244 = isset( $_POST['wp_timeline_addtocart_button_top_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_top_box_shadow'] ) ) : '';
					$f245 = isset( $_POST['wp_timeline_addtocart_button_right_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_right_box_shadow'] ) ) : '';
					$f246 = isset( $_POST['wp_timeline_addtocart_button_bottom_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_bottom_box_shadow'] ) ) : '';
					$f247 = isset( $_POST['wp_timeline_addtocart_button_left_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_left_box_shadow'] ) ) : '';
					$f248 = isset( $_POST['wp_timeline_addtocart_button_box_shadow_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_box_shadow_color'] ) ) : '';
					$f249 = isset( $_POST['wp_timeline_addtocart_button_hover_top_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_hover_top_box_shadow'] ) ) : '';
					$f250 = isset( $_POST['wp_timeline_addtocart_button_hover_right_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_hover_right_box_shadow'] ) ) : '';
					$f251 = isset( $_POST['wp_timeline_addtocart_button_hover_bottom_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_hover_bottom_box_shadow'] ) ) : '';
					$f252 = isset( $_POST['wp_timeline_addtocart_button_hover_left_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_hover_left_box_shadow'] ) ) : '';
					$f253 = isset( $_POST['wp_timeline_addtocart_button_hover_box_shadow_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_hover_box_shadow_color'] ) ) : '';
					$f254 = isset( $_POST['wp_timeline_addtocart_button_fontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_fontface_font_type'] ) ) : '';
					$f255 = isset( $_POST['wp_timeline_addtocart_button_fontface'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_fontface'] ) ) : '';
					$f256 = isset( $_POST['wp_timeline_addtocart_button_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_fontsize'] ) ) : '';
					$f257 = isset( $_POST['wp_timeline_addtocart_button_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_font_weight'] ) ) : '';
					$f258 = isset( $_POST['display_addtocart_button_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['display_addtocart_button_line_height'] ) ) : '';
					$f259 = isset( $_POST['wp_timeline_addtocart_button_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_font_italic'] ) ) : '';
					$f260 = isset( $_POST['wp_timeline_addtocart_button_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_font_text_transform'] ) ) : '';
					$f261 = isset( $_POST['wp_timeline_addtocart_button_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_font_text_decoration'] ) ) : '';
					$f262 = isset( $_POST['wp_timeline_addtocart_button_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_addtocart_button_letter_spacing'] ) ) : '';
					$f263 = isset( $_POST['display_download_price'] ) ? sanitize_text_field( wp_unslash( $_POST['display_download_price'] ) ) : '';
					$f264 = isset( $_POST['wp_timeline_edd_price_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_color'] ) ) : '';
					$f265 = isset( $_POST['wp_timeline_edd_price_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_alignment'] ) ) : '';
					$f266 = isset( $_POST['wp_timeline_edd_price_paddingleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_paddingleft'] ) ) : '';
					$f267 = isset( $_POST['wp_timeline_edd_price_paddingright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_paddingright'] ) ) : '';
					$f268 = isset( $_POST['wp_timeline_edd_price_paddingtop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_paddingtop'] ) ) : '';
					$f269 = isset( $_POST['wp_timeline_edd_price_paddingbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_paddingbottom'] ) ) : '';
					$f270 = isset( $_POST['wp_timeline_edd_pricefontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_pricefontface_font_type'] ) ) : '';
					$f271 = isset( $_POST['wp_timeline_edd_pricefontface'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_pricefontface'] ) ) : '';
					$f272 = isset( $_POST['wp_timeline_edd_pricefontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_pricefontsize'] ) ) : '';
					$f273 = isset( $_POST['wp_timeline_edd_price_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_font_weight'] ) ) : '';
					$f274 = isset( $_POST['wp_timeline_edd_price_font_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_font_line_height'] ) ) : '';
					$f275 = isset( $_POST['wp_timeline_edd_price_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_font_italic'] ) ) : '';
					$f276 = isset( $_POST['wp_timeline_edd_price_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_font_text_decoration'] ) ) : '';
					$f277 = isset( $_POST['wp_timeline_edd_price_font_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_price_font_letter_spacing'] ) ) : '';
					$f278 = isset( $_POST['display_edd_addtocart_button'] ) ? sanitize_text_field( wp_unslash( $_POST['display_edd_addtocart_button'] ) ) : '';
					$f279 = isset( $_POST['wp_timeline_edd_addtocartbutton_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_alignment'] ) ) : '';
					$f280 = isset( $_POST['wp_timeline_edd_addtocart_textcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_textcolor'] ) ) : '';
					$f281 = isset( $_POST['wp_timeline_edd_addtocart_text_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_text_hover_color'] ) ) : '';
					$f282 = isset( $_POST['wp_timeline_edd_addtocart_backgroundcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_backgroundcolor'] ) ) : '';
					$f283 = isset( $_POST['wp_timeline_edd_addtocart_hover_backgroundcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_hover_backgroundcolor'] ) ) : '';
					$f284 = isset( $_POST['display_edd_addtocart_button_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['display_edd_addtocart_button_border_radius'] ) ) : '';
					$f285 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderleft'] ) ) : '';
					$f286 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderleftcolor'] ) ) : '';
					$f287 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderright'] ) ) : '';
					$f288 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderrightcolor'] ) ) : '';
					$f289 = isset( $_POST['wp_timeline_edd_addtocartbutton_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_bordertop'] ) ) : '';
					$f290 = isset( $_POST['wp_timeline_edd_addtocartbutton_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_bordertopcolor'] ) ) : '';
					$f291 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderbuttom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderbuttom'] ) ) : '';
					$f292 = isset( $_POST['wp_timeline_edd_addtocartbutton_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_borderbottomcolor'] ) ) : '';
					$f293 = isset( $_POST['display_edd_addtocart_button_border_hover_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['display_edd_addtocart_button_border_hover_radius'] ) ) : '';
					$f294 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderleft'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderleft'] ) ) : '';
					$f295 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderleftcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderleftcolor'] ) ) : '';
					$f296 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderright'] ) ) : '';
					$f297 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderrightcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderrightcolor'] ) ) : '';
					$f298 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_bordertop'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_bordertop'] ) ) : '';
					$f299 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_bordertopcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_bordertopcolor'] ) ) : '';
					$f300 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderbuttom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderbuttom'] ) ) : '';
					$f301 = isset( $_POST['wp_timeline_edd_addtocartbutton_hover_borderbottomcolor'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_hover_borderbottomcolor'] ) ) : '';
					$f302 = isset( $_POST['wp_timeline_edd_addtocartbutton_padding_leftright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_padding_leftright'] ) ) : '';
					$f303 = isset( $_POST['wp_timeline_edd_addtocartbutton_padding_topbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_padding_topbottom'] ) ) : '';
					$f304 = isset( $_POST['wp_timeline_edd_addtocartbutton_margin_leftright'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_margin_leftright'] ) ) : '';
					$f305 = isset( $_POST['wp_timeline_edd_addtocartbutton_margin_topbottom'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocartbutton_margin_topbottom'] ) ) : '';
					$f306 = isset( $_POST['wp_timeline_edd_addtocart_button_top_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_top_box_shadow'] ) ) : '';
					$f307 = isset( $_POST['wp_timeline_edd_addtocart_button_right_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_right_box_shadow'] ) ) : '';
					$f308 = isset( $_POST['wp_timeline_edd_addtocart_button_bottom_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_bottom_box_shadow'] ) ) : '';
					$f309 = isset( $_POST['wp_timeline_edd_addtocart_button_left_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_left_box_shadow'] ) ) : '';
					$f310 = isset( $_POST['wp_timeline_edd_addtocart_button_box_shadow_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_box_shadow_color'] ) ) : '';
					$f311 = isset( $_POST['wp_timeline_edd_addtocart_button_hover_top_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_hover_top_box_shadow'] ) ) : '';
					$f312 = isset( $_POST['wp_timeline_edd_addtocart_button_hover_right_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_hover_right_box_shadow'] ) ) : '';
					$f313 = isset( $_POST['wp_timeline_edd_addtocart_button_hover_bottom_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_hover_bottom_box_shadow'] ) ) : '';
					$f314 = isset( $_POST['wp_timeline_edd_addtocart_button_hover_left_box_shadow'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_hover_left_box_shadow'] ) ) : '';
					$f315 = isset( $_POST['wp_timeline_edd_addtocart_button_hover_box_shadow_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_hover_box_shadow_color'] ) ) : '';
					$f316 = isset( $_POST['wp_timeline_edd_addtocart_button_fontface_font_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_fontface_font_type'] ) ) : '';
					$f317 = isset( $_POST['wp_timeline_edd_addtocart_button_fontface'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_fontface'] ) ) : '';
					$f318 = isset( $_POST['wp_timeline_edd_addtocart_button_fontsize'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_fontsize'] ) ) : '';
					$f319 = isset( $_POST['wp_timeline_edd_addtocart_button_font_weight'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_font_weight'] ) ) : '';
					$f320 = isset( $_POST['display_edd_addtocart_button_line_height'] ) ? sanitize_text_field( wp_unslash( $_POST['display_edd_addtocart_button_line_height'] ) ) : '';
					$f321 = isset( $_POST['wp_timeline_edd_addtocart_button_font_italic'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_font_italic'] ) ) : '';
					$f322 = isset( $_POST['wp_timeline_edd_addtocart_button_font_text_transform'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_font_text_transform'] ) ) : '';
					$f323 = isset( $_POST['wp_timeline_edd_addtocart_button_font_text_decoration'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_font_text_decoration'] ) ) : '';
					$f324 = isset( $_POST['wp_timeline_edd_addtocart_button_letter_spacing'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_edd_addtocart_button_letter_spacing'] ) ) : '';
					$f325 = isset( $_POST['social_share'] ) ? sanitize_text_field( wp_unslash( $_POST['social_share'] ) ) : '';
					$f326 = isset( $_POST['social_style'] ) ? sanitize_text_field( wp_unslash( $_POST['social_style'] ) ) : '';
					$f327 = isset( $_POST['social_icon_style'] ) ? sanitize_text_field( wp_unslash( $_POST['social_icon_style'] ) ) : '';
					$f328 = isset( $_POST['social_icon_size'] ) ? sanitize_text_field( wp_unslash( $_POST['social_icon_size'] ) ) : '';
					$f329 = isset( $_POST['default_icon_theme'] ) ? sanitize_text_field( wp_unslash( $_POST['default_icon_theme'] ) ) : '';
					$f330 = isset( $_POST['facebook_link'] ) ? sanitize_text_field( wp_unslash( $_POST['facebook_link'] ) ) : '';
					$f331 = isset( $_POST['facebook_link_with_count'] ) ? sanitize_text_field( wp_unslash( $_POST['facebook_link_with_count'] ) ) : '';
					$f332 = isset( $_POST['twitter_link'] ) ? sanitize_text_field( wp_unslash( $_POST['twitter_link'] ) ) : '';
					$f333 = isset( $_POST['linkedin_link'] ) ? sanitize_text_field( wp_unslash( $_POST['linkedin_link'] ) ) : '';
					$f334 = isset( $_POST['pinterest_link'] ) ? sanitize_text_field( wp_unslash( $_POST['pinterest_link'] ) ) : '';
					$f335 = isset( $_POST['pinterest_link_with_count'] ) ? sanitize_text_field( wp_unslash( $_POST['pinterest_link_with_count'] ) ) : '';
					$f336 = isset( $_POST['pinterest_image_share'] ) ? sanitize_text_field( wp_unslash( $_POST['pinterest_image_share'] ) ) : '';
					$f337 = isset( $_POST['skype_link'] ) ? sanitize_text_field( wp_unslash( $_POST['skype_link'] ) ) : '';
					$f338 = isset( $_POST['pocket_link'] ) ? sanitize_text_field( wp_unslash( $_POST['pocket_link'] ) ) : '';
					$f339 = isset( $_POST['telegram_link'] ) ? sanitize_text_field( wp_unslash( $_POST['telegram_link'] ) ) : '';
					$f340 = isset( $_POST['reddit_link'] ) ? sanitize_text_field( wp_unslash( $_POST['reddit_link'] ) ) : '';
					$f341 = isset( $_POST['digg_link'] ) ? sanitize_text_field( wp_unslash( $_POST['digg_link'] ) ) : '';
					$f342 = isset( $_POST['tumblr_link'] ) ? sanitize_text_field( wp_unslash( $_POST['tumblr_link'] ) ) : '';
					$f343 = isset( $_POST['wordpress_link'] ) ? sanitize_text_field( wp_unslash( $_POST['wordpress_link'] ) ) : '';
					$f344 = isset( $_POST['email_link'] ) ? sanitize_text_field( wp_unslash( $_POST['email_link'] ) ) : '';
					$f345 = isset( $_POST['whatsapp_link'] ) ? sanitize_text_field( wp_unslash( $_POST['whatsapp_link'] ) ) : '';
					$f346 = isset( $_POST['facebook_token'] ) ? sanitize_text_field( wp_unslash( $_POST['facebook_token'] ) ) : '';
					$f347 = isset( $_POST['mail_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['mail_subject'] ) ) : '';
					$f348 = isset( $_POST['mail_content'] ) ? sanitize_text_field( wp_unslash( $_POST['mail_content'] ) ) : '';
					$f349 = isset( $_POST['social_count_position'] ) ? sanitize_text_field( wp_unslash( $_POST['social_count_position'] ) ) : '';
					$f350 = isset( $_POST['social_share_position'] ) ? sanitize_text_field( wp_unslash( $_POST['social_share_position'] ) ) : '';
					$f351 = isset( $_POST['disable_link_category'] ) ? sanitize_text_field( wp_unslash( $_POST['disable_link_category'] ) ) : '';
					$f352 = isset( $_POST['disable_link_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['disable_link_tag'] ) ) : '';
					$f353 = isset( $_POST['disable_link_author'] ) ? sanitize_text_field( wp_unslash( $_POST['disable_link_author'] ) ) : '';
					$f354 = isset( $_POST['disable_link_date'] ) ? sanitize_text_field( wp_unslash( $_POST['disable_link_date'] ) ) : '';
					$f355 = isset( $_POST['disable_link_comment'] ) ? sanitize_text_field( wp_unslash( $_POST['disable_link_comment'] ) ) : '';
					$f356 = isset( $_POST['wp_timeline_lazy_load_image'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_lazy_load_image'] ) ) : '';
					$f357 = isset( $_POST['wp_timeline_lazy_load_blurred_image'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_timeline_lazy_load_blurred_image'] ) ) : '';
					$f358 = isset( $_POST['template_lazyload_color'] ) ? sanitize_text_field( wp_unslash( $_POST['template_lazyload_color'] ) ) : '';

					$wtl_settings = array(
						'wtl-submit-nonce'                 => $f1,
						'_wp_http_referer'                 => $f2,
						'originalpage'                     => $f3,
						'savedata'                         => $f4,
						'template_name'                    => $f5,
						'unique_shortcode_name'            => $f6,
						'timeline_heading_1'               => $f7,
						'timeline_heading_2'               => $f8,
						'custom_post_type'                 => $f9,
						'wtl_page_display'                 => $f10,
						'posts_per_page'                   => $f11,
						'display_category'                 => $f12,
						'display_tag'                      => $f13,
						'display_author'                   => $f14,
						'display_date'                     => $f15,
						'display_comment_count'            => $f16,
						'custom_css'                       => $f17,
						'template_bgcolor'                 => $f18,
						'wp_timeline_post_offset'          => $f19,
						'meta_font_family_font_type'       => $f20,
						'meta_font_family'                 => $f21,
						'meta_fontsize'                    => $f22,
						'meta_font_weight'                 => $f23,
						'meta_font_line_height'            => $f24,
						'meta_font_italic'                 => $f25,
						'meta_font_text_transform'         => $f26,
						'meta_font_text_decoration'        => $f27,
						'meta_font_letter_spacing'         => $f28,
						'date_font_family_font_type'       => $f29,
						'date_font_family'                 => $f30,
						'date_fontsize'                    => $f31,
						'date_font_weight'                 => $f32,
						'date_font_line_height'            => $f33,
						'date_font_italic'                 => $f34,
						'date_font_text_transform'         => $f35,
						'date_font_text_decoration'        => $f36,
						'date_font_letter_spacing'         => $f37,
						'wp_timeline_post_title_link'      => $f38,
						'template_title_alignment'         => $f39,
						'template_titlecolor'              => $f40,
						'template_titlehovercolor'         => $f41,
						'template_titlebackcolor'          => $f42,
						'template_titlefontface_font_type' => $f43,
						'rss_use_excerpt'                  => $f44,
						'template_post_content_from'       => $f45,
						'display_html_tags'                => $f46,
						'firstletter_big'                  => $f47,
						'firstletter_font_family_font_type' => $f48,
						'firstletter_font_family'          => $f49,
						'firstletter_fontsize'             => $f50,
						'firstletter_contentcolor'         => $f51,
						'txtExcerptlength'                 => $f52,
						'advance_contents'                 => $f53,
						'contents_stopage_from'            => $f54,
						'contents_stopage_character'       => $f55,
						'template_contentcolor'            => $f56,
						'content_font_family_font_type'    => $f57,
						'content_font_family'              => $f58,
						'content_fontsize'                 => $f59,
						'content_font_weight'              => $f60,
						'content_font_line_height'         => $f61,
						'content_font_italic'              => $f62,
						'content_font_text_transform'      => $f63,
						'content_font_text_decoration'     => $f64,
						'content_font_letter_spacing'      => $f65,
						'read_more_link'                   => $f66,
						'read_more_on'                     => $f67,
						'txtReadmoretext'                  => $f68,
						'post_link_type'                   => $f69,
						'custom_link_url'                  => $f70,
						'readmore_button_alignment'        => $f71,
						'template_readmorecolor'           => $f72,
						'template_readmorehovercolor'      => $f73,
						'template_readmorebackcolor'       => $f74,
						'template_readmore_hover_backcolor' => $f75,
						'read_more_button_border_style'    => $f76,
						'readmore_button_border_radius'    => $f77,
						'wp_timeline_readmore_button_borderleft' => $f78,
						'wp_timeline_readmore_button_borderleftcolor' => $f79,
						'wp_timeline_readmore_button_borderright' => $f80,
						'wp_timeline_readmore_button_borderrightcolor' => $f81,
						'wp_timeline_readmore_button_bordertop' => $f82,
						'wp_timeline_readmore_button_bordertopcolor' => $f83,
						'wp_timeline_readmore_button_borderbottom' => $f84,
						'wp_timeline_readmore_button_borderbottomcolor' => $f85,
						'read_more_button_hover_border_style' => $f86,
						'readmore_button_hover_border_radius' => $f87,
						'wp_timeline_readmore_button_hover_borderleft' => $f88,
						'wp_timeline_readmore_button_hover_borderleftcolor' => $f89,
						'wp_timeline_readmore_button_hover_borderright' => $f90,
						'wp_timeline_readmore_button_hover_borderrightcolor' => $f91,
						'wp_timeline_readmore_button_hover_bordertop' => $f92,
						'wp_timeline_readmore_button_hover_bordertopcolor' => $f93,
						'wp_timeline_readmore_button_hover_borderbottom' => $f94,
						'wp_timeline_readmore_button_hover_borderbottomcolor' => $f95,
						'readmore_button_paddingleft'      => $f96,
						'readmore_button_paddingright'     => $f97,
						'readmore_button_paddingtop'       => $f98,
						'readmore_button_paddingbottom'    => $f99,
						'readmore_button_marginleft'       => $f100,
						'readmore_button_marginright'      => $f101,
						'readmore_button_margintop'        => $f102,
						'readmore_button_marginbottom'     => $f103,
						'readmore_font_family_font_type'   => $f104,
						'readmore_font_family'             => $f105,
						'readmore_fontsize'                => $f106,
						'readmore_font_weight'             => $f107,
						'readmore_font_line_height'        => $f108,
						'readmore_font_italic'             => $f109,
						'readmore_font_text_transform'     => $f110,
						'readmore_font_text_decoration'    => $f111,
						'readmore_font_letter_spacing'     => $f112,
						'wp_timeline_content_border_width' => $f113,
						'wp_timeline_content_border_style' => $f114,
						'wp_timeline_content_border_color' => $f115,
						'wp_timeline_content_border_radius' => $f116,
						'content_box_bg_color'             => $f117,
						'wp_timeline_top_content_box_shadow' => $f118,
						'wp_timeline_right_content_box_shadow' => $f119,
						'wp_timeline_bottom_content_box_shadow' => $f120,
						'wp_timeline_left_content_box_shadow' => $f121,
						'wp_timeline_content_box_shadow_color' => $f122,
						'wp_timeline_content_padding_leftright' => $f123,
						'wp_timeline_content_padding_topbottom' => $f124,
						'timeline_line_width'              => $f125,
						'timeline_animation'               => $f126,
						'template_color'                   => $f127,
						'story_startup_text'               => $f128,
						'story_ending_text'                => $f129,
						'hide_timeline_icon'               => $f130,
						'layout_type'                      => $f131,
						'wp_timeline_enable_media'         => $f132,
						'wp_timeline_post_image_link'      => $f133,
						'wp_timeline_image_hover_effect'   => $f134,
						'wp_timeline_image_hover_effect_type' => $f135,
						'wp_timeline_default_image_id'     => $f136,
						'wp_timeline_default_image_src'    => $f137,
						'wp_timeline_media_size'           => $f138,
						'media_custom_width'               => $f139,
						'media_custom_height'              => $f140,
						'display_timeline_bar'             => $f141,
						'timeline_start_from'              => $f142,
						'template_easing'                  => $f143,
						'item_width'                       => $f144,
						'item_height'                      => $f145,
						'template_post_margin'             => $f146,
						'enable_autoslide'                 => $f147,
						'scroll_speed'                     => $f148,
						'noof_slider_nav_itme'             => $f149,
						'noof_slide'                       => $f150,
						'pagination_type'                  => $f151,
						'pagination_template'              => $f152,
						'pagination_text_color'            => $f153,
						'pagination_background_color'      => $f154,
						'pagination_text_hover_color'      => $f155,
						'pagination_background_hover_color' => $f156,
						'pagination_text_active_color'     => $f157,
						'pagination_active_background_color' => $f158,
						'pagination_border_color'          => $f159,
						'pagination_active_border_color'   => $f160,
						'display_sale_tag'                 => $f161,
						'wp_timeline_sale_tagtextcolor'    => $f162,
						'wp_timeline_sale_tagbgcolor'      => $f163,
						'wp_timeline_sale_tagtext_alignment' => $f164,
						'wp_timeline_sale_tag_angle'       => $f165,
						'wp_timeline_sale_tag_border_radius' => $f166,
						'wp_timeline_sale_tagtext_paddingleft' => $f167,
						'wp_timeline_sale_tagtext_paddingright' => $f168,
						'wp_timeline_sale_tagtext_paddingtop' => $f169,
						'wp_timeline_sale_tagtext_paddingbottom' => $f170,
						'wp_timeline_sale_tagtext_marginleft' => $f171,
						'wp_timeline_sale_tagtext_marginright' => $f172,
						'wp_timeline_sale_tagtext_margintop' => $f173,
						'wp_timeline_sale_tagtext_marginbottom' => $f174,
						'wp_timeline_sale_tagfontface_font_type' => $f175,
						'wp_timeline_sale_tagfontface'     => $f176,
						'wp_timeline_sale_tagfontsize'     => $f177,
						'wp_timeline_sale_tag_font_weight' => $f178,
						'wp_timeline_sale_tag_font_line_height' => $f179,
						'wp_timeline_sale_tag_font_italic' => $f180,
						'wp_timeline_sale_tag_font_text_transform' => $f181,
						'wp_timeline_sale_tag_font_text_decoration' => $f182,
						'wp_timeline_sale_tag_font_letter_spacing' => $f183,
						'display_product_rating'           => $f184,
						'wp_timeline_star_rating_color'    => $f185,
						'wp_timeline_star_rating_bg_color' => $f186,
						'wp_timeline_star_rating_alignment' => $f187,
						'wp_timeline_star_rating_paddingleft' => $f188,
						'wp_timeline_star_rating_paddingright' => $f189,
						'wp_timeline_star_rating_paddingtop' => $f190,
						'wp_timeline_star_rating_paddingbottom' => $f191,
						'wp_timeline_star_rating_marginleft' => $f192,
						'wp_timeline_star_rating_marginright' => $f193,
						'wp_timeline_star_rating_margintop' => $f194,
						'wp_timeline_star_rating_marginbottom' => $f195,
						'display_product_price'            => $f196,
						'wp_timeline_pricetextcolor'       => $f197,
						'wp_timeline_pricetext_alignment'  => $f198,
						'wp_timeline_pricetext_paddingleft' => $f199,
						'wp_timeline_pricetext_paddingright' => $f200,
						'wp_timeline_pricetext_paddingtop' => $f201,
						'wp_timeline_pricetext_paddingbottom' => $f202,
						'wp_timeline_pricetext_marginleft' => $f203,
						'wp_timeline_pricetext_marginright' => $f204,
						'wp_timeline_pricetext_margintop'  => $f205,
						'wp_timeline_pricetext_marginbottom' => $f206,
						'wp_timeline_pricefontface_font_type' => $f207,
						'wp_timeline_pricefontface'        => $f208,
						'wp_timeline_pricefontsize'        => $f209,
						'wp_timeline_price_font_weight'    => $f210,
						'wp_timeline_price_font_line_height' => $f211,
						'wp_timeline_price_font_italic'    => $f212,
						'wp_timeline_price_font_text_transform' => $f213,
						'wp_timeline_price_font_text_decoration' => $f214,
						'wp_timeline_price_font_letter_spacing' => $f215,
						'display_addtocart_button'         => $f216,
						'wp_timeline_addtocartbutton_alignment' => $f217,
						'wp_timeline_addtocart_textcolor'  => $f218,
						'wp_timeline_addtocart_text_hover_color' => $f219,
						'wp_timeline_addtocart_backgroundcolor' => $f220,
						'wp_timeline_addtocart_hover_backgroundcolor' => $f221,
						'display_addtocart_button_border_radius' => $f222,
						'wp_timeline_addtocartbutton_borderleft' => $f223,
						'wp_timeline_addtocartbutton_borderleftcolor' => $f224,
						'wp_timeline_addtocartbutton_borderright' => $f225,
						'wp_timeline_addtocartbutton_borderrightcolor' => $f226,
						'wp_timeline_addtocartbutton_bordertop' => $f227,
						'wp_timeline_addtocartbutton_bordertopcolor' => $f228,
						'wp_timeline_addtocartbutton_borderbuttom' => $f229,
						'wp_timeline_addtocartbutton_borderbottomcolor' => $f230,
						'display_addtocart_button_border_hover_radius' => $f231,
						'wp_timeline_addtocartbutton_hover_borderleft' => $f232,
						'wp_timeline_addtocartbutton_hover_borderleftcolor' => $f233,
						'wp_timeline_addtocartbutton_hover_borderright' => $f234,
						'wp_timeline_addtocartbutton_hover_borderrightcolor' => $f235,
						'wp_timeline_addtocartbutton_hover_bordertop' => $f236,
						'wp_timeline_addtocartbutton_hover_bordertopcolor' => $f237,
						'wp_timeline_addtocartbutton_hover_borderbuttom' => $f238,
						'wp_timeline_addtocartbutton_hover_borderbottomcolor' => $f239,
						'wp_timeline_addtocartbutton_padding_leftright' => $f240,
						'wp_timeline_addtocartbutton_padding_topbottom' => $f241,
						'wp_timeline_addtocartbutton_margin_leftright' => $f242,
						'wp_timeline_addtocartbutton_margin_topbottom' => $f243,
						'wp_timeline_addtocart_button_top_box_shadow' => $f244,
						'wp_timeline_addtocart_button_right_box_shadow' => $f245,
						'wp_timeline_addtocart_button_bottom_box_shadow' => $f246,
						'wp_timeline_addtocart_button_left_box_shadow' => $f247,
						'wp_timeline_addtocart_button_box_shadow_color' => $f248,
						'wp_timeline_addtocart_button_hover_top_box_shadow' => $f249,
						'wp_timeline_addtocart_button_hover_right_box_shadow' => $f250,
						'wp_timeline_addtocart_button_hover_bottom_box_shadow' => $f251,
						'wp_timeline_addtocart_button_hover_left_box_shadow' => $f252,
						'wp_timeline_addtocart_button_hover_box_shadow_color' => $f253,
						'wp_timeline_addtocart_button_fontface_font_type' => $f254,
						'wp_timeline_addtocart_button_fontface' => $f255,
						'wp_timeline_addtocart_button_fontsize' => $f256,
						'wp_timeline_addtocart_button_font_weight' => $f257,
						'display_addtocart_button_line_height' => $f258,
						'wp_timeline_addtocart_button_font_italic' => $f259,
						'wp_timeline_addtocart_button_font_text_transform' => $f260,
						'wp_timeline_addtocart_button_font_text_decoration' => $f261,
						'wp_timeline_addtocart_button_letter_spacing' => $f262,
						'display_download_price'           => $f263,
						'wp_timeline_edd_price_color'      => $f264,
						'wp_timeline_edd_price_alignment'  => $f265,
						'wp_timeline_edd_price_paddingleft' => $f266,
						'wp_timeline_edd_price_paddingright' => $f267,
						'wp_timeline_edd_price_paddingtop' => $f268,
						'wp_timeline_edd_price_paddingbottom' => $f269,
						'wp_timeline_edd_pricefontface_font_type' => $f270,
						'wp_timeline_edd_pricefontface'    => $f271,
						'wp_timeline_edd_pricefontsize'    => $f272,
						'wp_timeline_edd_price_font_weight' => $f273,
						'wp_timeline_edd_price_font_line_height' => $f274,
						'wp_timeline_edd_price_font_italic' => $f275,
						'wp_timeline_edd_price_font_text_decoration' => $f276,
						'wp_timeline_edd_price_font_letter_spacing' => $f277,
						'display_edd_addtocart_button'     => $f278,
						'wp_timeline_edd_addtocartbutton_alignment' => $f279,
						'wp_timeline_edd_addtocart_textcolor' => $f280,
						'wp_timeline_edd_addtocart_text_hover_color' => $f281,
						'wp_timeline_edd_addtocart_backgroundcolor' => $f282,
						'wp_timeline_edd_addtocart_hover_backgroundcolor' => $f283,
						'display_edd_addtocart_button_border_radius' => $f284,
						'wp_timeline_edd_addtocartbutton_borderleft' => $f285,
						'wp_timeline_edd_addtocartbutton_borderleftcolor' => $f286,
						'wp_timeline_edd_addtocartbutton_borderright' => $f287,
						'wp_timeline_edd_addtocartbutton_borderrightcolor' => $f288,
						'wp_timeline_edd_addtocartbutton_bordertop' => $f289,
						'wp_timeline_edd_addtocartbutton_bordertopcolor' => $f290,
						'wp_timeline_edd_addtocartbutton_borderbuttom' => $f291,
						'wp_timeline_edd_addtocartbutton_borderbottomcolor' => $f292,
						'display_edd_addtocart_button_border_hover_radius' => $f293,
						'wp_timeline_edd_addtocartbutton_hover_borderleft' => $f294,
						'wp_timeline_edd_addtocartbutton_hover_borderleftcolor' => $f295,
						'wp_timeline_edd_addtocartbutton_hover_borderright' => $f296,
						'wp_timeline_edd_addtocartbutton_hover_borderrightcolor' => $f297,
						'wp_timeline_edd_addtocartbutton_hover_bordertop' => $f298,
						'wp_timeline_edd_addtocartbutton_hover_bordertopcolor' => $f299,
						'wp_timeline_edd_addtocartbutton_hover_borderbuttom' => $f300,
						'wp_timeline_edd_addtocartbutton_hover_borderbottomcolor' => $f301,
						'wp_timeline_edd_addtocartbutton_padding_leftright' => $f302,
						'wp_timeline_edd_addtocartbutton_padding_topbottom' => $f303,
						'wp_timeline_edd_addtocartbutton_margin_leftright' => $f304,
						'wp_timeline_edd_addtocartbutton_margin_topbottom' => $f305,
						'wp_timeline_edd_addtocart_button_top_box_shadow' => $f306,
						'wp_timeline_edd_addtocart_button_right_box_shadow' => $f307,
						'wp_timeline_edd_addtocart_button_bottom_box_shadow' => $f308,
						'wp_timeline_edd_addtocart_button_left_box_shadow' => $f309,
						'wp_timeline_edd_addtocart_button_box_shadow_color' => $f310,
						'wp_timeline_edd_addtocart_button_hover_top_box_shadow' => $f311,
						'wp_timeline_edd_addtocart_button_hover_right_box_shadow' => $f312,
						'wp_timeline_edd_addtocart_button_hover_bottom_box_shadow' => $f313,
						'wp_timeline_edd_addtocart_button_hover_left_box_shadow' => $f314,
						'wp_timeline_edd_addtocart_button_hover_box_shadow_color' => $f315,
						'wp_timeline_edd_addtocart_button_fontface_font_type' => $f316,
						'wp_timeline_edd_addtocart_button_fontface' => $f317,
						'wp_timeline_edd_addtocart_button_fontsize' => $f318,
						'wp_timeline_edd_addtocart_button_font_weight' => $f319,
						'display_edd_addtocart_button_line_height' => $f320,
						'wp_timeline_edd_addtocart_button_font_italic' => $f321,
						'wp_timeline_edd_addtocart_button_font_text_transform' => $f322,
						'wp_timeline_edd_addtocart_button_font_text_decoration' => $f323,
						'wp_timeline_edd_addtocart_button_letter_spacing' => $f324,
						'social_share'                     => $f325,
						'social_style'                     => $f326,
						'social_icon_style'                => $f327,
						'social_icon_size'                 => $f328,
						'default_icon_theme'               => $f329,
						'facebook_link'                    => $f330,
						'facebook_link_with_count'         => $f331,
						'twitter_link'                     => $f332,
						'linkedin_link'                    => $f333,
						'pinterest_link'                   => $f334,
						'pinterest_link_with_count'        => $f335,
						'pinterest_image_share'            => $f336,
						'skype_link'                       => $f337,
						'pocket_link'                      => $f338,
						'telegram_link'                    => $f339,
						'reddit_link'                      => $f340,
						'digg_link'                        => $f341,
						'tumblr_link'                      => $f342,
						'wordpress_link'                   => $f343,
						'email_link'                       => $f344,
						'whatsapp_link'                    => $f345,
						'facebook_token'                   => $f346,
						'mail_subject'                     => $f347,
						'mail_content'                     => $f348,
						'social_count_position'            => $f349,
						'social_share_position'            => $f350,
						'disable_link_category'            => $f351,
						'disable_link_tag'                 => $f352,
						'disable_link_author'              => $f353,
						'disable_link_date'                => $f354,
						'disable_link_comment'             => $f355,
						'wp_timeline_lazy_load_image'      => $f356,
						'wp_timeline_lazy_load_blurred_image' => $f357,
						'template_lazyload_color'          => $f358,
					);
					$wtl_settings = isset( $_POST ) ? $_POST : '';
					if ( isset( $wtl_settings ) && ! empty( $wtl_settings ) ) {
						foreach ( $wtl_settings as $single_key => $single_val ) {
							if ( is_array( $single_val ) ) {
								foreach ( $single_val as $s_key => $s_val ) {
									$wtl_settings[ $single_key ][ $s_key ] = sanitize_text_field( $s_val );
								}
							} elseif ( 'custom_css' === $single_key ) {
								$wtl_settings[ $single_key ] = wp_strip_all_tags( $single_val );
							} else {
								$wtl_settings[ $single_key ] = sanitize_text_field( $single_val );
							}
						}
					}
					if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
						if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
							$shortcode_id = intval( $_GET['id'] );
						} else {
							$shortcode_id = '';
						}
						$wtl_settings = apply_filters( 'wtl_update_blog_layout_settings', $wtl_settings );
						$save         = $wpdb->update(
							$table_name,
							array(
								'shortcode_name' => isset( $_POST['unique_shortcode_name'] ) ? sanitize_text_field( wp_unslash( $_POST['unique_shortcode_name'] ) ) : '',
								'wtlsettngs'     => maybe_serialize( $wtl_settings ),
							),
							array( 'wtlid' => $shortcode_id ),
							array( '%s', '%s' ),
							array( '%d' )
						);
						if ( false == $save ) {
							$wtl_errors = new WP_Error( 'save_error', esc_html__( 'Error in updating shortcode.', 'timeline-designer' ) );
						} else {
							$templates['ID']           = isset( $_POST['wtl_page_display'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_page_display'] ) ) : '';
							$templates['post_content'] = '[wp_timeline_design id="' . $shortcode_id . '"]';
							wp_update_post( $templates );
							if ( isset( $_POST['resetdata'] ) && '' !== $_POST['resetdata'] ) {
								$wtl_success = esc_html__( 'Layout reset successfully.', 'timeline-designer' );
								do_action( 'wp_timeline_reset_shortcode', $shortcode_id );
							} else {
								$wtl_success = esc_html__( 'Layout updated successfully. ', 'timeline-designer' );
								do_action( 'wp_timeline_update_shortcode', $shortcode_id );
							}
							if ( isset( $_POST['wtl_page_display'] ) && $_POST['wtl_page_display'] > 0 ) {
								$wtl_success .= ' <a href="' . esc_url( get_the_permalink( sanitize_text_field( wp_unslash( $_POST['wtl_page_display'] ) ) ) ) . '" target="_blank">' . esc_html__( 'View Layout', 'timeline-designer' ) . '</a>';
							}
						}
					} else {
						$wtl_settings          = apply_filters( 'wtl_add_blog_layout_settings', $wtl_settings );
						$unique_shortcode_name = isset( $_POST['unique_shortcode_name'] ) ? sanitize_text_field( wp_unslash( $_POST['unique_shortcode_name'] ) ) : '';
						$shortcode_id          = wtl_insert_layout( $unique_shortcode_name, $wtl_settings );
						$shortcode_id          = intval( $shortcode_id );
						if ( $shortcode_id > 0 ) {
							$message = 'shortcode_added_msg';
						} else {
							wp_die( esc_html__( 'Error in Adding shortcode.', 'timeline-designer' ) );
						}
						$templates['ID']           = sanitize_text_field( wp_unslash( $_POST['wtl_page_display'] ) );
						$templates['post_content'] = '[wp_timeline_design id="' . $shortcode_id . '"]';
						wp_update_post( $templates );
						$send = admin_url( 'admin.php?page=add_wtl_shortcode&action=edit&id=' . $shortcode_id );
						$send = add_query_arg( 'message', $message, $send );
						do_action( 'wtl_add_blog_shortcode', $shortcode_id );
						wp_safe_redirect( $send );
						exit();
					}
				} else {
					wp_safe_redirect( '?page=wtl_layouts' );
				}
			}
		}
	}

	/**
	 * Duplicate Layout
	 */
	public function wtl_duplicate_layout() {
		/** Duplicate Timeline Layout */
		if ( ( isset( $_GET['wplayout'] ) && '' !== $_GET['wplayout'] ) && ( isset( $_GET['action'] ) && 'duplicate_post_in_edit' === $_GET['action'] ) ) {
			$user   = wp_get_current_user();
			$closed = array( 'wp_timeline_general' );
			$closed = array_filter( $closed );
			update_user_option( $user->ID, 'wptclosewptboxes_add_wtl_shortcode', $closed, true );
			$wplayout       = isset( $_GET['wplayout'] ) ? sanitize_text_field( wp_unslash( $_GET['wplayout'] ) ) : '';
			$layout_setting = Wp_Timeline_Lite_Main::wtl_get_shortcode_settings( $wplayout );
			if ( $layout_setting ) {
				$layout_setting['wtl_page_display'] = 0;
				$shortcode_name                     = $layout_setting['unique_shortcode_name'] . ' ' . esc_html__( 'Copy', 'timeline-designer' );
				$shortcode_id                       = wtl_insert_layout( $shortcode_name, $layout_setting );
				if ( $shortcode_id > 0 ) {
					$message = 'shortcode_duplicate_msg';
				} else {
					wp_die( esc_html__( 'Error in Adding shortcode.', 'timeline-designer' ) );
				}
				do_action( 'wtl_duplicate_layout_settings', $shortcode_id );
				$send = admin_url( 'admin.php?page=add_wtl_shortcode&action=edit&id=' . $shortcode_id );
				$send = add_query_arg( 'message', $message, $send );
				wp_safe_redirect( $send );
				exit();
			} else {
				wp_die( esc_html__( 'No layout to duplicate has been supplied!', 'timeline-designer' ) );
			}
		}
	}

	/**
	 * Delete Layout
	 *
	 * @global object $wpdb
	 */
	public function wtl_delete_layout() {
		global $wpdb;
		if ( isset( $_GET['page'] ) && 'wtl_layouts' === $_GET['page'] && isset( $_GET['action'] ) && 'delete' === $_GET['action'] ) {
			if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
				if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
					$shortcode_id = intval( $_GET['id'] );
				} else {
					$shortcode_id = '';
				}
			}
			do_action( 'wtl_delete_shortcode', $shortcode_id );
			$wtl_table_name        = $wpdb->prefix . 'wtl_shortcodes';
			$wp_timeline_is_delete = $wpdb->delete( $wtl_table_name, array( 'wtlid' => $shortcode_id ) );
		}
	}
	/**
	 * Multiple Deletion of shortcode
	 *
	 * @global object $wpdb
	 */
	public function wtl_multiple_delete_layouts() {
		global $wpdb;
		$wtl_table_name = $wpdb->prefix . 'wtl_shortcodes';
		if ( isset( $_POST['take_action'] ) ) {
			if ( isset( $_GET['page'] ) && 'wtl_layouts' == $_GET['page'] && isset( $_POST['chk_remove_all'] ) && ! empty( $_POST['chk_remove_all'] ) ) {
				if ( ( isset( $_POST['wtl-action-top'] ) && 'delete_pr' == $_POST['wtl-action-top'] ) || ( isset( $_POST['wtl-action-top2'] ) && 'delete_pr' == $_POST['wtl-action-top2'] ) ) {
					if ( isset( $_POST['_wpnonce'] ) ) {
						$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );
						if ( wp_verify_nonce( $nonce, '_wpnonce' ) ) {
							$shortcodes = array_map( 'sanitize_text_field', wp_unslash( $_POST['chk_remove_all'] ) );
							if ( isset( $_GET['page'] ) ) {
								$result = wp_cache_get( 'wtl_wtl_shortcodes' );
								if ( false == $result ) {
									wp_cache_set( 'wtl_wtl_shortcodes', $result );
								}
								if ( is_array( $shortcodes ) ) {
									foreach ( $shortcodes as $shortcode ) {
										$shortcode = intval( $shortcode );
										do_action( 'wtl_delete_shortcode', $shortcode );
										$wpdb->delete( $wtl_table_name, array( 'wtlid' => $shortcode ) );
									}
								}
							}
						}
					}
				}
			}
		}
	}


	/**
	 * Export Layout
	 *
	 * @since 1.0
	 */
	public function wtl_multiple_export_layouts() {
		global $wpdb;
		if ( isset( $_POST['take_action'] ) ) {
			if ( isset( $_GET['page'] ) && 'wtl_layouts' === $_GET['page'] && isset( $_POST['chk_remove_all'] ) && ! empty( $_POST['chk_remove_all'] ) ) {
				if ( ( isset( $_POST['wtl-action-top'] ) && 'wtl_export' === $_POST['wtl-action-top'] ) || ( isset( $_POST['wtl-action-top2'] ) && 'wtl_export' === $_POST['wtl-action-top2'] ) ) {
					if ( isset( $_POST['_wpnonce'] ) ) {
						$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );
						if ( wp_verify_nonce( $nonce, '_wpnonce' ) ) {
							$export_layout = array();
							$shortcodes    = array_map( 'sanitize_text_field', wp_unslash( $_POST['chk_remove_all'] ) );
							if ( is_array( $shortcodes ) ) {
								foreach ( $shortcodes as $shortcode ) {
									$shortcode = intval( $shortcode );
									$get_data  = '';
									if ( is_numeric( $shortcode ) ) {
										$get_data = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes WHERE wtlid = %d', $shortcode ), ARRAY_A );
									}
									do_action( 'wtl_export_blog_layout_settings', $shortcode );
									if ( ! empty( $get_data ) ) {
										$wptsettings                     = maybe_unserialize( $get_data['wtlsettngs'] );
										$wptsettings['wtl_page_display'] = '0';
										$get_data['wtlsettngs']          = maybe_serialize( $wptsettings );
										$export_layout[]                 = $get_data;
									}
								}
							}
							if ( count( $export_layout ) > 0 ) {
								$output = base64_encode( maybe_serialize( $export_layout ) );
								$this->save_as_txt_file( 'wp_timeline_layouts.txt', $output );
							}
						}
					}
				}
			}
		}
	}
	/**
	 * Save Text file.
	 *
	 * @param string $file_name file name.
	 * @param string $output output.
	 * @return void
	 */
	public function save_as_txt_file( $file_name, $output ) {
		header( 'Content-type: application/text', true, 200 );
		header( "Content-Disposition: attachment; filename=$file_name" );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		echo esc_html( $output );
		exit;
	}

	/**
	 * Import layouts.
	 *
	 * @global string $import_success
	 * @global object $wpdb
	 * @global string $import_error
	 */
	public function wtl_upload_import_file() {
		if ( ! empty( $_POST ) && ! empty( $_FILES['wtl_import'] ) && check_admin_referer( 'wtl_import', 'wtl_import_nonce' ) ) {
			// check_admin_referer prints fail page and dies.
			global $import_success, $wpdb, $import_error;
			// Uploaded file.
			$uploaded_file = array_map( 'sanitize_text_field', wp_unslash( $_FILES['wtl_import'] ) );
			if ( isset( $_POST['wtl_layout_import_types'] ) && '' === $_POST['wtl_layout_import_types'] ) {
				$import_error = esc_html__( 'You must have to select import type', 'timeline-designer' );
				return;
			}
			// Check file type.
			$mimes                = array(
				'txt' => 'text/plain',
			);
			$wp_timeline_filetype = wp_check_filetype( $uploaded_file['name'], $mimes );
			if ( 'txt' !== $wp_timeline_filetype['ext'] && ! wp_match_mime_types( 'txt', $wp_timeline_filetype['type'] ) ) {
				$import_error = esc_html__( 'You must upload a .txt file generated by this plugin.', 'timeline-designer' );
				return;
			}
			// Upload file and check uploading error.
			$file_data = wp_handle_upload(
				$uploaded_file,
				array(
					'test_type' => false,
					'test_form' => false,
				)
			);
			if ( isset( $file_data['error'] ) ) {
				$import_error = $file_data['error'];
				return;
			}
			// Check file exists or not.
			if ( ! file_exists( $file_data['file'] ) ) {
				$import_error = esc_html__( 'Import file could not be found. Please try again.', 'timeline-designer' );
				return;
			}
			$content = $this->import_layouts( $file_data['file'] );
			if ( $content ) {
				/** Import Blog Layout */
				if ( isset( $_POST['wtl_layout_import_types'] ) && 'wp_timeline_blog_layouts' === $_POST['wtl_layout_import_types'] ) {
					$wtl_table_name = $wpdb->prefix . 'wtl_shortcodes';
					if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "wtl_shortcodes'" ) == $wtl_table_name ) {
						foreach ( $content as $single_content ) {
							$shortcode_name = isset( $single_content['shortcode_name'] ) ? $single_content['shortcode_name'] : '';
							$wtlsettngs     = isset( $single_content['wtlsettngs'] ) ? maybe_unserialize( $single_content['wtlsettngs'] ) : '';
							if ( isset( $wtlsettngs ) && ! empty( $wtl_settings ) ) {
								foreach ( $wtlsettngs as $single_key => $single_val ) {
									if ( is_array( $single_val ) ) {
										foreach ( $single_val as $s_key => $s_val ) {
											$wtlsettngs[ $single_key ][ $s_key ] = sanitize_text_field( $s_val );
										}
									} elseif ( 'custom_css' === $single_key ) {
										$wtlsettngs[ $single_key ] = wp_strip_all_tags( $single_val );
									} else {
										$wtlsettngs[ $single_key ] = sanitize_text_field( $single_val );
									}
								}
							}
							$blog_layout_id = $wpdb->insert(
								$wtl_table_name,
								array(
									'shortcode_name' => sanitize_text_field( $shortcode_name ),
									'wtlsettngs'     => maybe_serialize( $wtlsettngs ),
								)
							);
							do_action( 'wtl_import_blog_layout_settings', $shortcode_name );
						}
						$import_success = esc_html__( 'Timeline Layout imported successfully', 'timeline-designer' );
					} else {
						$import_error = esc_html__( 'Table not found. Please try again.', 'timeline-designer' );
						return;
					}
				}
				/** Import Custom Post Type */
				if ( isset( $_POST['wtl_layout_import_types'] ) && 'wp_timeline_cpt' === $_POST['wtl_layout_import_types'] ) {
					$wtl_table_name = $wpdb->prefix . 'wtl_cpts';
					if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "wtl_cpts'" ) == $wtl_table_name ) {
						foreach ( $content as $single_content ) {
							$shortcode_name = isset( $single_content['name'] ) ? $single_content['name'] : '';
							$slug           = isset( $single_content['slug'] ) ? $single_content['slug'] : '';
							$wtlsettngs     = isset( $single_content['setting'] ) ? maybe_unserialize( $single_content['setting'] ) : '';
							if ( isset( $wtlsettngs ) && ! empty( $wtl_settings ) ) {
								foreach ( $wtlsettngs as $single_key => $single_val ) {
									if ( is_array( $single_val ) ) {
										foreach ( $single_val as $s_key => $s_val ) {
											$wtlsettngs[ $single_key ][ $s_key ] = sanitize_text_field( $s_val );
										}
									}
								}
							}
							$blog_layout_id = $wpdb->insert(
								$wtl_table_name,
								array(
									'name'    => sanitize_text_field( $shortcode_name ),
									'slug'    => sanitize_text_field( $slug ),
									'setting' => maybe_serialize( $wtlsettngs ),
								)
							);
						}
						$import_success = esc_html__( 'Timeline Custom Post Type imported successfully', 'timeline-designer' );
					} else {
						$import_error = esc_html__( 'Table not found. Please try again.', 'timeline-designer' );
						return;
					}
				}
			}
		}
	}

	/**
	 * Import layouts.
	 *
	 * @param string $file file.
	 * @return unserialized content
	 */
	public function import_layouts( $file ) {
		global $import_error;
		if ( file_exists( $file ) ) {
			$file_content = $this->wtl_file_contents( $file );
			if ( is_serialized( base64_decode( $file_content ) ) ) {
				$unserialized_content = maybe_unserialize( base64_decode( $file_content ) );
				if ( isset( $_POST['wtl_import_nonce'] ) || wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wtl_import_nonce'] ) ), 'wtl_import' ) ) {
					if ( is_array( $unserialized_content ) && isset( $_POST['wtl_layout_import_types'] ) && 'wp_timeline_blog_layouts' == $_POST['wtl_layout_import_types'] && ! empty( $unserialized_content[0]['wtlid'] ) ) {
						return $unserialized_content;
					} elseif ( is_array( $unserialized_content ) && isset( $_POST['wtl_layout_import_types'] ) && 'wp_timeline_cpt' == $_POST['wtl_layout_import_types'] && ! empty( $unserialized_content[0]['id'] ) ) {
						return $unserialized_content;
					} else {
						$import_error = esc_html__( 'Please check your file format or import type.', 'wp-timeline-designer-pro' );
						return;
					}
				}
			} else {
				$import_error = esc_html__( 'Import file is empty. Please try again.', 'timeline-designer' );
				return;
			}
		} else {
			$import_error = esc_html__( 'Import file could not be found. Please try again.', 'timeline-designer' );
			return;
		}
	}

	/**
	 * File Contents.
	 *
	 * @param string $path path.
	 * @return string $wtl_content
	 */
	public function wtl_file_contents( $path ) {
		global $wp_filesystem;
		$wtl_content = '';
		if ( function_exists( 'realpath' ) ) {
			$filepath = realpath( $path );
		}
		if ( ! $filepath || ! is_file( $filepath ) ) {
			return '';
		}
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		return $wp_filesystem->get_contents( $filepath );
	}

	/**
	 * Set style path, home page path and plugin path for js use
	 */
	public function wtl_plugin_path_js() {
		?>
		<script type="text/javascript">
			"use strict";
			var plugin_path = '<?php echo esc_url( TLD_URL ); ?>';
			var style_path = '<?php echo esc_url( get_stylesheet_uri() ); ?>';
			var home_path = '<?php echo esc_url( get_home_url() ); ?>';
		</script>
		<?php
	}

	/**
	 * Details Meta Box
	 *
	 * @return void
	 */
	public function wtl_details_meta_box() {
		add_meta_box( 'wtl_single_settings', esc_html__( 'Single Post Settings', 'timeline-designer' ), 'wtl_lite_details_callback', 'post' );
		global $wpdb;
		$result = wp_cache_get( 'wtl_wtl_cpts' );
		if ( false == $result ) {
			wp_cache_set( 'wtl_wtl_cpts', $result );
		}
		$datas = $wpdb->get_results( "SELECT slug FROM `{$wpdb->prefix}wtl_cpts`", ARRAY_A ); // PHPCS:db call ok.
		if ( ! empty( $datas ) ) {
			foreach ( $datas as $data ) {
				$slug = $data['slug'];
				add_meta_box( 'wtl_single_settings', 'Single Post settings', 'wtl_lite_details_callback', $slug );
			}
		}
	}

	/**
	 * Save Details.
	 *
	 * @param int $post_id post id.
	 * @return void
	 */
	public function wtl_details_save( $post_id ) {
		if ( ! isset( $_POST['wtl_single_details_meta_box_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wtl_single_details_meta_box_nonce'] ) ), 'wtl_details_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$personal_details = array(
			'wtl_post_format'                  => isset( $_POST['wtl_post_format'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_post_format'] ) ) : '',
			'wtl_post_slideshow_images'        => isset( $_POST['wtl_gallery_images'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_gallery_images'] ) ) : '',
			'wtl_post_video_type'              => isset( $_POST['wtl_single_video_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_single_video_type'] ) ) : '',
			'wtl_post_video_id'                => isset( $_POST['wtl_single_video_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_single_video_id'] ) ) : '',
			'wtl_post_quote_text'              => isset( $_POST['wtl_post_quote_text'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_post_quote_text'] ) ) : '',
			'wtl_display_post_custom_link'     => isset( $_POST['wtl_display_post_custom_link'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_display_post_custom_link'] ) ) : '',
			'wtl_post_custom_link'             => isset( $_POST['wtl_post_custom_link'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_post_custom_link'] ) ) : '',
			'wtl_single_display_timeline_icon' => isset( $_POST['wtl_single_display_timeline_icon'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_single_display_timeline_icon'] ) ) : '',
			'wtl_single_timeline_icon'         => isset( $_POST['wtl_single_timeline_icon'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_single_timeline_icon'] ) ) : '',
			'wtl_icon_image_src'               => isset( $_POST['wtl_icon_image_src'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_icon_image_src'] ) ) : '',
			'wtl_icon_image_id'                => isset( $_POST['wtl_icon_image_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_icon_image_id'] ) ) : '',
			'wtl_background_color'             => isset( $_POST['wtl_background_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_background_color'] ) ) : '',
			'wtl_background_color_opt'         => isset( $_POST['wtl_background_color_opt'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_background_color_opt'] ) ) : '',
			'wtl_content_color'                => isset( $_POST['wtl_content_color'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_content_color'] ) ) : '',
			'wtl_timeline_time'                => isset( $_POST['wtl_timeline_time'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_timeline_time'] ) ) : '',
			'wtl_timeline_time_format'         => isset( $_POST['wtl_timeline_time_format'] ) ? sanitize_text_field( wp_unslash( $_POST['wtl_timeline_time_format'] ) ) : '',
		);
		update_post_meta( $post_id, '_wtl_single_details_key', $personal_details );
	}
	/**
	 * Animation Loader Icons
	 *
	 * @return array
	 */
	public static function loaders() {
		$loaders = array(
			'circularG'               => '<div class="wtl-circularG-wrapper"><div class="wtl-circularG wtl-circularG_1"></div><div class="wtl-circularG wtl-circularG_2"></div><div class="wtl-circularG wtl-circularG_3"></div><div class="wtl-circularG wtl-circularG_4"></div><div class="wtl-circularG wtl-circularG_5"></div><div class="wtl-circularG wtl-circularG_6"></div><div class="wtl-circularG wtl-circularG_7"></div><div class="wtl-circularG wtl-circularG_8"></div></div>',
			'floatingCirclesG'        => '<div class="wtl-floatingCirclesG"><div class="wtl-f_circleG wtl-frotateG_01"></div><div class="wtl-f_circleG wtl-frotateG_02"></div><div class="wtl-f_circleG wtl-frotateG_03"></div><div class="wtl-f_circleG wtl-frotateG_04"></div><div class="wtl-f_circleG wtl-frotateG_05"></div><div class="wtl-f_circleG wtl-frotateG_06"></div><div class="wtl-frotateG_07 wtl-f_circleG"></div><div class="wtl-frotateG_08 wtl-f_circleG"></div></div>',
			'spinloader'              => '<div class="wtl-spinloader"></div>',
			'doublecircle'            => '<div class="wtl-doublec-container"><ul class="wtl-doublec-flex-container"><li><span class="wtl-doublec-loading"></span></li></ul></div>',
			'wBall'                   => '<div class="wtl-windows8"><div class="wtl-wBall wtl-wBall_1"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_2"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_3"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_4"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall_5 wtl-wBall"><div class="wtl-wInnerBall"></div></div></div>',
			'cssanim'                 => '<div class="wtl-cssload-aim"></div>',
			'thecube'                 => '<div class="wtl-cssload-thecube"><div class="wtl-cssload-cube wtl-cssload-c1"></div><div class="wtl-cssload-cube wtl-cssload-c2"></div><div class="wtl-cssload-cube wtl-cssload-c4"></div><div class="wtl-cssload-cube wtl-cssload-c3"></div></div>',
			'ballloader'              => '<div class="wtl-ballloader"><div class="wtl-loader-inner wtl-ball-grid-pulse"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>',
			'squareloader'            => '<div class="wtl-squareloader"><div class="wtl-square"></div><div class="wtl-square"></div><div class="wtl-square last"></div><div class="wtl-square clear"></div><div class="wtl-square"></div><div class="wtl-square last"></div><div class="wtl-square clear"></div><div class="wtl-square"></div><div class="wtl-square last"></div></div>',
			'loadFacebookG'           => '<div class="wtl-loadFacebookG"><div class="wtl-blockG_1 wtl-facebook_blockG"></div><div class="wtl-blockG_2 wtl-facebook_blockG"></div><div class="wtl-facebook_blockG wtl-blockG_3"></div></div>',
			'floatBarsG'              => '<div class="wtl-floatBarsG-wrapper"><div class="wtl-floatBarsG_1 wtl-floatBarsG"></div><div class="wtl-floatBarsG_2 wtl-floatBarsG"></div><div class="wtl-floatBarsG_3 wtl-floatBarsG"></div><div class="wtl-floatBarsG_4 wtl-floatBarsG"></div><div class="wtl-floatBarsG_5 wtl-floatBarsG"></div><div class="wtl-floatBarsG_6 wtl-floatBarsG"></div><div class="wtl-floatBarsG_7 wtl-floatBarsG"></div><div class="wtl-floatBarsG_8 wtl-floatBarsG"></div></div>',
			'movingBallG'             => '<div class="wtl-movingBallG-wrapper"><div class="wtl-movingBallLineG"></div><div class="wtl-movingBallG_1 wtl-movingBallG"></div></div>',
			'ballsWaveG'              => '<div class="wtl-ballsWaveG-wrapper"><div class="wtl-ballsWaveG_1 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_2 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_3 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_4 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_5 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_6 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_7 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_8 wtl-ballsWaveG"></div></div>',
			'fountainG'               => '<div class="fountainG-wrapper"><div class="wtl-fountainG_1 wtl-fountainG"></div><div class="wtl-fountainG_2 wtl-fountainG"></div><div class="wtl-fountainG_3 wtl-fountainG"></div><div class="wtl-fountainG_4 wtl-fountainG"></div><div class="wtl-fountainG_5 wtl-fountainG"></div><div class="wtl-fountainG_6 wtl-fountainG"></div><div class="wtl-fountainG_7 wtl-fountainG"></div><div class="wtl-fountainG_8 wtl-fountainG"></div></div>',
			'audio_wave'              => '<div class="wtl-audio_wave"><span></span><span></span><span></span><span></span><span></span></div>',
			'warningGradientBarLineG' => '<div class="wtl-warningGradientOuterBarG"><div class="wtl-warningGradientFrontBarG wtl-warningGradientAnimationG"><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div></div></div>',
			'floatingBarsG'           => '<div class="wtl-floatingBarsG"><div class="wtl-rotateG_01 wtl-blockG"></div><div class="wtl-rotateG_02 wtl-blockG"></div><div class="wtl-rotateG_03 wtl-blockG"></div><div class="wtl-rotateG_04 wtl-blockG"></div><div class="wtl-rotateG_05 wtl-blockG"></div><div class="wtl-rotateG_06 wtl-blockG"></div><div class="wtl-rotateG_07 wtl-blockG"></div><div class="wtl-rotateG_08 wtl-blockG"></div></div>',
			'rotatecircle'            => '<div class="wtl-cssload-loader"><div class="wtl-cssload-inner wtl-cssload-one"></div><div class="wtl-cssload-inner wtl-cssload-two"></div><div class="wtl-cssload-inner wtl-cssload-three"></div></div>',
			'overlay-loader'          => '<div class="wtl-overlay-loader"><div class="wtl-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>',
			'circlewave'              => '<div class="wtl-circlewave"></div>',
			'cssload-ball'            => '<div class="wtl-cssload-ball"></div>',
			'cssheart'                => '<div class="wtl-cssload-main"><div class="wtl-cssload-heart"><span class="wtl-cssload-heartL"></span><span class="wtl-cssload-heartR"></span><span class="wtl-cssload-square"></span></div><div class="wtl-cssload-shadow"></div></div>',
			'spinload'                => '<div class="wtl-spinload-loading"><i></i><i></i><i></i></div>',
			'bigball'                 => '<div class="wtl-bigball-container"><div class="wtl-bigball-loading"><i></i><i></i><i></i></div></div>',
			'bubblec'                 => '<div class="wtl-bubble-container"><div class="wtl-bubble-loading"><i></i><i></i></div></div>',
			'csball'                  => '<div class="wtl-csball-container"><div class="wtl-csball-loading"><i></i><i></i><i></i><i></i></div></div>',
			'ccball'                  => '<div class="wtl-ccball-container"><div class="wtl-ccball-loading"><i></i><i></i></div></div>',
			'circulardot'             => '<div class="wtl-cssload-wrap"><div class="wtl-circulardot-container"><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span></div></div>',
		);
		return $loaders;
	}
}
