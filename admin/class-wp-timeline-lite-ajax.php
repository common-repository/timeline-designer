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
 * @package    Wp_Timeline_Lite_Ajax
 * @subpackage Wp_Timeline_Lite_Ajax/includes
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
 * @package    Wp_Timeline_Lite_Ajax
 * @subpackage Wp_Timeline_Lite_Ajax/includes
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
class Wp_Timeline_Lite_Ajax {

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
		add_action( 'wp_ajax_wtl_custom_post_taxonomy_display_settings', array( $this, 'wtl_custom_post_taxonomy_display_settings' ) );
		add_action( 'wp_ajax_wtl_closed_boxes', array( $this, 'wtl_closed_boxes' ) );
	}

	/**
	 * Timeline Template List
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public static function wtl_blog_template_list() {
		$tempate_list = array(
			'soft_block'             => array(
				'template_name' => esc_html__( 'Soft Block Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'soft_block.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/soft-block-template/' ),
			),
			'advanced_layout'        => array(
				'template_name' => esc_html__( 'Advanced Layout Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'advanced_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/advanced-layout-template-defualt/' ),
			),
			'hire_layout'            => array(
				'template_name' => esc_html__( 'Hire Layout Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'hire_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/hire-layout-template/' ),
			),
			'fullwidth_layout'       => array(
				'template_name' => esc_html__( 'Full Width Layout Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'fullwidth_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/full-width-layout-template/' ),
			),
			'curve_layout'           => array(
				'template_name' => esc_html__( 'Curve Layout Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'curve_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/curve-layout-template/' ),
			),
			'easy_layout'            => array(
				'template_name' => esc_html__( 'Easy Layout Template', 'timeline-designer' ),
				'class'         => 'full-width free',
				'image_name'    => 'easy_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/easy-layout-template/' ),
			),
			'cool_horizontal'        => array(
				'template_name' => esc_html__( 'Cool Horizontal Template', 'timeline-designer' ),
				'class'         => 'timeline slider',
				'image_name'    => 'cool_horizontal.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/cool-horizontal-template/' ),
			),
			'overlay_horizontal'     => array(
				'template_name' => esc_html__( 'Overlay Horizontal Template', 'timeline-designer' ),
				'class'         => 'timeline slider',
				'image_name'    => 'overlay_horizontal.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/overlay-horizontal-template/' ),
			),
			'schedule'               => array(
				'template_name' => esc_html__( 'Schedule Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'schedule.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/schedule-template/' ),
			),
			'year_layout'            => array(
				'template_name' => esc_html__( 'Year Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'year_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/year-layout-template/' ),
			),
			'milestone_layout'       => array(
				'template_name' => esc_html__( 'Milestone Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'milestone_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/milestone-layout-template/' ),
			),
			'story_layout'           => array(
				'template_name' => esc_html__( 'Story Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'story_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/story-layout-template/' ),
			),
			'glossary_layout'        => array(
				'template_name' => esc_html__( 'Glossary Layout Template', 'timeline-designer' ),
				'class'         => 'masonry',
				'image_name'    => 'glossary_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/glossary-layout/' ),
			),
			'boxy_layout'            => array(
				'template_name' => esc_html__( 'Boxy Layout Template', 'timeline-designer' ),
				'class'         => 'masonry',
				'image_name'    => 'boxy_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/boxy-layout/' ),
			),
			'wise_layout'            => array(
				'template_name' => esc_html__( 'Wise Block Layout Template', 'timeline-designer' ),
				'class'         => 'masonry',
				'image_name'    => 'wise_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/wise-layout/' ),
			),
			'cover_layout'           => array(
				'template_name' => esc_html__( 'Cover Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'cover_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/cover-layout/' ),
			),
			'rounded_layout'         => array(
				'template_name' => esc_html__( 'Rounded Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'rounded_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/rounded-layout/' ),
			),
			'accordion_layout'       => array(
				'template_name' => esc_html__( 'Accordion Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'accordion.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/accordion-layout/' ),
			),
			'attract_layout'         => array(
				'template_name' => esc_html__( 'Attract Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'attract_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/attract-timeline-layout/' ),
			),
			'classictimeline_layout' => array(
				'template_name' => esc_html__( 'ClassicTimeline Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'classictimeline_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/classic-timeline-layout/' ),
			),
			'collapsible_layout'     => array(
				'template_name' => esc_html__( 'Collapsible Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'collapsible.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/collapsible-layout/' ),
			),
			'columy_layout'          => array(
				'template_name' => esc_html__( 'Rounded Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'columy_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/columy-layout/' ),
			),
			'divide_layout'          => array(
				'template_name' => esc_html__( 'Divide Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'divide_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/divide-timeline-layout/' ),
			),
			'filledtimeline_layout'  => array(
				'template_name' => esc_html__( 'FilledTimeline Layout Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'filledtimeline_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/filled-timeline-layout/' ),
			),
			'fullhorizontal_layout'  => array(
				'template_name' => esc_html__( 'FullHorizontal Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'fullhorizontal_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/full-horizontal-layout/' ),
			),
			'fullvertical_layout'    => array(
				'template_name' => esc_html__( 'FullVertical Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'fullvertical_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/full-vertical-layout/' ),
			),
			'infographic_layout'     => array(
				'template_name' => esc_html__( 'Infographic Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'infographic_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/infographic-layout/' ),
			),
			'leafty_layout'          => array(
				'template_name' => esc_html__( 'Leafty Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'leafty_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/leafty-layout/' ),
			),
			'topdivide_layout'       => array(
				'template_name' => esc_html__( 'Top Divide Timeline Template', 'timeline-designer' ),
				'class'         => 'full-width',
				'image_name'    => 'topdivide_layout.jpg',
				'demo_link'     => esc_url( 'https://wptimeline.solwininfotech.com/divided-top-timeline-layout/' ),
			),
			'colorful_vertical_timeline_layout' =>array(
				'template_name' =>esc_html__( 'Colorful Vertical Timeline Layout', 'wp-timeline-designer-pro' ),
				'class'			=>'full-width',
				'image_name'	=>'colorful_vertical_timeline_layout.jpg',
				'demo_link'		=>esc_url( 'https://wptimeline.solwininfotech.com/colorful-vertical-timeline-layout/' ),

			),
			'box_timeline_infographic_layout' =>array(
				'template_name' =>esc_html__( 'Box Timeline Infographic Layout', 'wp-timeline-designer-pro' ),
				'class'			=>'full-width',
				'image_name'	=>'box_timeline_infographic_layout.jpg',
				'demo_link'		=>esc_url( 'https://wptimeline.solwininfotech.com/box-timeline-infographic-template/' ),

			),
			'circle_paper_infographics_layout' =>array(
				'template_name' =>esc_html__( 'Circle Paper Infographics Layout', 'wp-timeline-designer-pro' ),
				'class'			=>'full-width',
				'image_name'	=>'circle_paper_infographics_layout.jpg',
				'demo_link'		=>esc_url( 'https://wptimeline.solwininfotech.com/circle-paper-info-graphics-layout/' ),

			),
			'creative_infographic_layout' =>array(
				'template_name' =>esc_html__( 'Creative Infographic Layout', 'wp-timeline-designer-pro' ),
				'class'			=>'full-width',
				'image_name'	=>'creative_infographic_layout.jpg',
				'demo_link'		=>esc_url( 'https://wptimeline.solwininfotech.com/creative-infographic-layout/' ),

			),
		);
		ksort( $tempate_list );
		return $tempate_list;
	}

	/**
	 * Ajax handler to get custom post taxonomy display settings
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wtl_custom_post_taxonomy_display_settings() {
		ob_start();
		if ( isset( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
				wp_send_json_error( array( 'status' => 'Nonce error' ) );
				die();
			}
		}
		if ( isset( $_POST['posttype'] ) && ! empty( $_POST['posttype'] ) ) {
			$custom_posttype = sanitize_text_field( wp_unslash( $_POST['posttype'] ) );
		}
		$taxonomy_names = get_object_taxonomies( $custom_posttype, 'objects' );
		$taxonomy_names = apply_filters( 'wtl_hide_taxonomies', $taxonomy_names );
		if ( 'post' === $custom_posttype ) {
			?>
			<div class="wp-timeline-typography-cover display-custom-taxonomy">
				<div class="wp-timeline-typography-label">
					<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Category', 'timeline-designer' ); ?></span>
					<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post category on blog layout', 'timeline-designer' ); ?></span></span>
				</div>
				<div class="wp-timeline-typography-content">
					<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
						<input id="display_category_1" name="display_category" type="radio" value="1" checked="checked" />
						<label for="display_category_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
						<input id="display_category_0" name="display_category" type="radio" value="0" />
						<label for="display_category_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
					</fieldset>
					<label class="disable_link"><input id="disable_link_category" name="disable_link_category" type="checkbox" value="1" /> <?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?></label>					
				</div>
			</div>
			<div class="wp-timeline-typography-cover display-custom-taxonomy">
				<div class="wp-timeline-typography-label">
					<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Tag', 'timeline-designer' ); ?></span>
					<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post tag on blog layout', 'timeline-designer' ); ?></span></span>
				</div>
				<div class="wp-timeline-typography-content">
					<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
						<input id="display_tag_1" name="display_tag" type="radio" value="1" checked="checked" />
						<label for="display_tag_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
						<input id="display_tag_0" name="display_tag" type="radio" value="0" />
						<label for="display_tag_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
					</fieldset>
					<label class="disable_link">
						<input id="disable_link_tag" name="disable_link_tag" type="checkbox" value="1" /> <?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
					</label>
				</div>
			</div>
			<?php
		} elseif ( ! empty( $taxonomy_names ) ) {
			foreach ( $taxonomy_names as $taxonomy_name ) {
				if ( ! empty( $taxonomy_name ) ) {
					?>
					<div class="wp-timeline-typography-cover display-custom-taxonomy">
						<div class="wp-timeline-typography-label">
							<span class="wp-timeline-key-title"><?php echo esc_html( $taxonomy_name->label ); ?></span>
							<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php echo esc_html_e( 'Enable/Disable', 'timeline-designer' ) . ' ' . esc_attr( $taxonomy_name->label ) . ' ' . esc_html_e( 'in blog layout', 'timeline-designer' ); ?></span></span>
						</div>
						<div class="wp-timeline-typography-content">
							<fieldset class="wp-timeline-display_tax buttonset">
								<input id="display_<?php echo esc_attr( $taxonomy_name->name ); ?>_1" name="display_<?php echo esc_attr( $taxonomy_name->name ); ?>" type="radio" value="1" />
								<label for="display_<?php echo esc_attr( $taxonomy_name->name ); ?>_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
								<input id="display_<?php echo esc_attr( $taxonomy_name->name ); ?>_0" name="display_<?php echo esc_attr( $taxonomy_name->name ); ?>" type="radio" value="0" checked="checked"/>
								<label for="display_<?php echo esc_attr( $taxonomy_name->name ); ?>_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
							</fieldset>
							<label class="disable_link">
								<input id="disable_link_taxonomy_<?php echo esc_attr( $taxonomy_name->name ); ?>" name="disable_link_taxonomy_<?php echo esc_attr( $taxonomy_name->name ); ?>" type="checkbox" value="1" 
								<?php
								if ( isset( $wtl_settings[ 'disable_link_taxonomy_' . $taxonomy_name->name ] ) ) {
									checked( 1, $wtl_settings[ 'disable_link_taxonomy_' . $taxonomy_name->name ] );
								}
								?>
								/>
								<?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
							</label>
						</div>
					</div>
					<?php
				}
			}
		}
		$data = ob_get_clean();
		echo wp_kses( $data, Wp_Timeline_Lite_Public::args_kses() );
		die();
	}

	/**
	 * Ajax handler for Store closed box id
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wtl_closed_boxes() {
		if ( isset( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
				wp_send_json_error( array( 'status' => 'Nonce error' ) );
				die();
			}
		}
		$closed = isset( $_POST['closed'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_POST['closed'] ) ) ) : array();
		$closed = array_filter( $closed );
		$page   = isset( $_POST['page'] ) ? sanitize_text_field( wp_unslash( $_POST['page'] ) ) : '';
		if ( sanitize_key( $page ) !== $page ) {
			wp_die( 0 );
		}
		$user = wp_get_current_user();
		if ( ! $user ) {
			wp_die( -1 );
		}
		if ( is_array( $closed ) ) {
			update_user_option( $user->ID, "wptclosewptboxes_$page", $closed, true );
		}
		wp_die( 1 );
	}

}
$wp_timeline_ajax = new Wp_Timeline_Lite_Ajax();
