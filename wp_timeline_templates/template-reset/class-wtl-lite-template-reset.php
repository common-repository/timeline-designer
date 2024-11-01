<?php
/**
 * Template Day Layout Config File
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/wp_timeline_templates
 */

/**
 * This class contain template configuration of template.
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/wp_timeline_templates
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wtl_Lite_Template_Reset {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_wtl_do_rest_layout_ajax', array( $this, 'wtl_do_rest_layout_ajax' ) );
		add_action( 'wp_ajax_nopriv_wtl_do_rest_layout_ajax', array( $this, 'wtl_do_rest_layout_ajax' ) );
		add_action( 'wp_ajax_wtl_load_default_layout_ajax', array( $this, 'wtl_load_default_layout_ajax' ) );
		add_action( 'wp_ajax_nopriv_wtl_load_default_layout_ajax', array( $this, 'wtl_load_default_layout_ajax' ) );
	}

	/**
	 * Layout Reset Ajax.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function wtl_do_rest_layout_ajax() {
		header( 'Access-Cotrol-Allow-Origin: *' );
		if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
			$lid = isset( $_POST['lid'] ) ? sanitize_text_field( wp_unslash( $_POST['lid'] ) ) : '';
		}
		if ( isset( $_POST['layout'] ) && ! empty( $_POST['layout'] ) ) {
			$layout       = sanitize_text_field( wp_unslash( $_POST['layout'] ) );
			$lid          = isset( $_POST['lid'] ) ? sanitize_text_field( wp_unslash( $_POST['lid'] ) ) : '';
			$page_display = isset( $_POST['page_display'] ) ? sanitize_text_field( wp_unslash( $_POST['page_display'] ) ) : '';
			$json         = self::get_default_layout_settings( $layout );
			$arr          = json_decode( $json );
			if ( $arr ) {
				echo wp_json_encode( $arr );
			}
		}
		die();
	}
	/**
	 * Layout Reset Ajax 2.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public static function wtl_load_default_layout_ajax() {
		header( 'Access-Cotrol-Allow-Origin: *' );
		if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
			$layout_id = 'none';
		}
		if ( isset( $_POST['layout'] ) ) {
			$layout = sanitize_text_field( wp_unslash( $_POST['layout'] ) );
			$json   = self::get_default_layout_settings( $layout );
			$arr    = json_decode( $json );
			if ( $arr ) {
				echo wp_json_encode( $arr );
			}
		}
		die();
	}
	/**
	 * Do reset layout out
	 *
	 * @since    1.0.0
	 * @param string $layout layout.
	 * @param string $lid lid.
	 * @param string $page_display peage display.
	 * @return html
	 */
	public static function do_reset_layout( $layout, $lid, $page_display ) {
		$reset_json = '';
		if ( 'advanced_layout' === $layout ) {
			include 'json/json-advanced-layout.php';
		} elseif ( 'curve_layout' === $layout ) {
			include 'json/json-curve-layout.php';
		} elseif ( 'easy_layout' === $layout ) {
			include 'json/json-easy-layout.php';
		} elseif ( 'fullwidth_layout' === $layout ) {
			include 'json/json-fullwidth-layout.php';
		} elseif ( 'hire_layout' === $layout ) {
			include 'json/json-hire-layout.php';
		} elseif ( 'soft_block' === $layout ) {
			include 'json/json-soft-block.php';
		}
		if ( $reset_json ) {
			return self::update_settings_meta( $lid, $page_display, $reset_json );
		}
	}

	/**
	 * Update Settings Meta.
	 *
	 * @since    1.0.0
	 * @param string $lid lid.
	 * @param string $page_display peage display.
	 * @param string $reset_json json.
	 * @return boolean
	 */
	public static function update_settings_meta( $lid, $page_display, $reset_json ) {
		if ( is_serialized( $reset_json ) ) {
			$wtl_settings = maybe_unserialize( $reset_json );
			if ( $page_display ) {
				$wtl_settings['wtl_page_display'] = $page_display;
			}
			$status = self::update_reset_json( $lid, $wtl_settings );
			if ( $status ) {
				return 'reset_done';
			} else {
				return false;
			}
		}
		return false;
	}

	/**
	 * Update Reset Json.
	 *
	 * @since    1.0.0
	 * @param string $lid lid.
	 * @param string $wtl_settings settings.
	 * @return array
	 */
	public static function update_reset_json( $lid, $wtl_settings ) {
		global $wpdb;
		$wtl_table_name = $wpdb->prefix . 'wtl_shortcodes';
		if ( isset( $wtl_settings ) && ! empty( $wtl_settings ) ) {
			foreach ( $wtl_settings as $single_key => $single_val ) {
				if ( is_array( $single_val ) ) {
					foreach ( $single_val as $s_key => $s_val ) {
						$wtl_settings[ $single_key ][ $s_key ] = sanitize_text_field( $s_val );
					}
				} else {
					if ( 'custom_css' === $single_key ) {
						$wtl_settings[ $single_key ] = wp_strip_all_tags( $single_val );
					} else {
						$wtl_settings[ $single_key ] = sanitize_text_field( $single_val );
					}
				}
			}
		}
		$insert = $wpdb->update(
			$wtl_table_name,
			array(
				'wtlsettngs' => maybe_serialize( $wtl_settings ),
			),
			array( 'wtlid' => $lid )
		);
		return true;
	}

	/**
	 * Update Settings Meta.
	 *
	 * @since    1.0.0
	 * @param string $layout lid.
	 * @return array
	 */
	public static function get_default_layout_settings( $layout ) {
		$reset_json = '';
		if ( 'advanced_layout' === $layout ) {
			include 'json/json-advanced-layout.php';
		} elseif ( 'curve_layout' === $layout ) {
			include 'json/json-curve-layout.php';
		} elseif ( 'easy_layout' === $layout ) {
			include 'json/json-easy-layout.php';
		} elseif ( 'fullwidth_layout' === $layout ) {
			include 'json/json-fullwidth-layout.php';
		} elseif ( 'hire_layout' === $layout ) {
			include 'json/json-hire-layout.php';
		} elseif ( 'soft_block' === $layout ) {
			include 'json/json-soft-block.php';
		}
		if ( $reset_json ) {
			return $reset_json;
		}
		return false;
	}
}
$wtl_template_config = new Wtl_Lite_Template_Reset();
