<?php
/**
 * Add/Edit Timeline Layout setting page.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_version, $wpdb, $wp_timeline_errors, $wtl_success, $wtl_settings;
$allowed_html   = array(
	'a' => array(
		'href'   => array(),
		'title'  => array(),
		'target' => array(),
	),
);
$uic_l          = 'ui-corner-left';
$uic_r          = 'ui-corner-right';
$shortcode_name = '';
if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
	$shortcode_id = '';
	if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
		$shortcode_id = intval( $_GET['id'] );
	}
	$get_all_settings = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_shortcodes WHERE wtlid = %d', $shortcode_id ), ARRAY_A );
	if ( ! isset( $get_all_settings[0]['wtlsettngs'] ) ) {
		echo '<div class="updated notice notice 1">';
		wp_die( esc_html__( 'You attempted to edit an item that doesn’t exist. Perhaps it was deleted?', 'timeline-designer' ) );
		echo '</div>';
	}
	$all_settings   = $get_all_settings[0]['wtlsettngs'];
	$shortcode_name = $get_all_settings[0]['shortcode_name'];
	if ( is_serialized( $all_settings ) ) {
		$wtl_settings = maybe_unserialize( $all_settings );
	}
	$msg = '&msg=updated';
} else {
	$msg = '&msg=added';
}
if ( isset( $_GET['create'] ) && 'sample' === $_GET['create'] ) {
	$wtl_success  = esc_html__( 'We have created a sample blog layout with "classical" timeline template.', 'timeline-designer' );
	$wtl_success .= ' <a href="' . esc_url( get_the_permalink( $wtl_settings['wtl_page_display'] ) ) . '" target="_blank">' . esc_html__( 'View blog page', 'timeline-designer' ) . '</a>';
}
$tempate_list = Wp_Timeline_Lite_Ajax::wtl_blog_template_list();
$loaders      = Wp_Timeline_Lite_Admin::loaders();
?>
<div class="wrap">
	<h1>
		<?php
		if ( ! ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] && isset( $_GET['id'] ) ) ) {
			echo '<div class="wp-timeline-shortcode-div">';
			esc_html_e( 'Add New Layout', 'timeline-designer' );
			echo '</div>';
		}
		?>
	</h1>
	<?php if ( isset( $_GET['message'] ) && 'shortcode_added_msg' === $_GET['message'] ) { ?>
		<div class="updated notice notice2">
			<p>
				<?php
				echo esc_html__( 'Layout has been added successfully.', 'timeline-designer' );
				if ( isset( $wtl_settings['wtl_page_display'] ) && $wtl_settings['wtl_page_display'] > 0 ) {
					?>
					<a href="<?php echo esc_url( get_the_permalink( $wtl_settings['wtl_page_display'] ) ); ?>" target="_blank"><?php echo esc_html__( 'View Layout', 'timeline-designer' ); ?></a>
					<?php
				}
				?>
			</p>
		</div>
		<?php
	}
	if ( isset( $_GET['message'] ) && 'shortcode_duplicate_msg' === $_GET['message'] ) {
		?>
		<div class="updated notice notice3"><p><?php esc_html_e( 'Layout has been duplicated successfully.', 'timeline-designer' ); ?></p></div>
		<?php
	}
	if ( isset( $wp_timeline_errors ) ) {
		if ( is_wp_error( $wp_timeline_errors ) ) {
			?>
			<div class="error notice"><p><?php echo wp_kses( $wp_timeline_errors->get_error_message(), $allowed_html ); ?></p></div>
			<?php
		}
	}
	if ( isset( $wtl_success ) ) {
		?>
		<div class="updated notice notice4"><p><?php echo wp_kses( $wtl_success, $allowed_html ); ?></p></div>
		<?php
	}
	$winter_category_txt = esc_html__( 'Choose Category Background Color', 'timeline-designer' );
	?>
	<div class="splash-screen"></div>
	<form method="post" id="edit_layout_form" action="" class="wp-timeline-form-class wp-timeline-edit-layout">
		<?php
		wp_nonce_field( 'wtl-shortcode-form-submit', 'wtl-submit-nonce' );
		$page_p = '';
		if ( isset( $_GET['page'] ) && '' != $_GET['page'] ) {
			$page_p = sanitize_text_field( wp_unslash( $_GET['page'] ) );
			?>
			<input type="hidden" name="originalpage" class="wp_timeline_originalpage" value="<?php echo esc_attr( $page_p ); ?>">
			<?php
		}
		?>
		<div id="poststuff">
			<?php
			if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] && isset( $_GET['id'] ) ) {
				$shortcode_id = intval( $_GET['id'] );
				?>
				<div class="wp-timeline-shortcode-div" lid="<?php echo esc_attr( $shortcode_id ); ?>">
					<div class= "pull-left wp_timeline_edit_layout"><h1><?php esc_html_e( 'Edit Layout', 'timeline-designer' ); ?></h1></div>
					<div class="pull-right">
						<?php
						if ( isset( $wtl_settings['wtl_page_display'] ) && ! empty( $wtl_settings['wtl_page_display'] ) ) {
							?>
							<span class="view-layout"><a title="<?php esc_attr_e( 'View this item', 'timeline-designer' ); ?>" href="<?php echo esc_url( get_the_permalink( $wtl_settings['wtl_page_display'] ) ); ?>" target="_blank"><?php esc_html_e( 'View Layout', 'timeline-designer' ); ?></a></span>
							<?php
						}
						?>
						<input type="text" readonly="" onclick="this.select()" class="copy_shortcode" title="<?php esc_attr_e( 'Copy Shortcode', 'timeline-designer' ); ?>" value='[wp_timeline_design id="<?php echo esc_attr( $shortcode_id ); ?>"]' />
						<a class="page-title-action wp_timeline_create_new_layout" href="?page=add_wtl_shortcode"><?php esc_html_e( 'Create New Layout', 'timeline-designer' ); ?></a>
					</div>
				</div>
			<?php } ?>
			<div class="postbox-container wp-timeline-settings-wrappers bd_poststuff">
				<div class="wp-timeline-preview-box" id="wp-timeline-preview-box"></div>
				<div class="wp-timeline-header-wrapper">
					<div class="wp-timeline-logo-wrapper pull-left"><h3 title="<?php esc_html_e( 'wp-timeline settings', 'timeline-designer' ); ?>">&nbsp;</h3></div>
					<div class="pull-right">
						<a id="wp-timeline-btn-show-submit" title="<?php esc_html_e( 'Save Changes', 'timeline-designer' ); ?>" class="show_preview button submit_fixed button-primary">
							<span><i class="fas fa-check"></i>&nbsp;&nbsp;<?php esc_html_e( 'Save Changes', 'timeline-designer' ); ?></span>
						</a>
						<input type="submit" style="display:none;" class="button-primary bloglyout_savebtn button" name="savedata" value="<?php esc_attr_e( 'Save Changes', 'timeline-designer' ); ?>" />
					</div>
				</div>
				<div class="wp-timeline-menu-setting">
					<?php
					$wp_timeline_general_class               = '';
					$wp_timeline_class                       = '';
					$wp_timeline_standard_class              = '';
					$wp_timeline_title_class                 = '';
					$wtl_content_class                       = '';
					$wtl_content_box_class                   = '';
					$wtl_timeline_settings_class             = '';
					$wp_timeline_media_class                 = '';
					$wp_timeline_slider_class                = '';
					$wp_timeline_filter_class                = '';
					$wp_timeline_social_class                = '';
					$wp_timeline_productsetting_class        = '';
					$wp_timeline_pagination_class            = '';
					$wp_timeline_acffieldssetting_class      = '';
					$wp_timeline_eddsetting_class            = '';
					$wp_timeline_general_class_show          = '';
					$wp_timeline_class_show                  = '';
					$wp_timeline_standard_class_show         = '';
					$wp_timeline_title_class_show            = '';
					$wtl_content_class_show                  = '';
					$wtl_content_box_class_show              = '';
					$wp_timeline_settings_class_show         = '';
					$wp_timeline_media_class_show            = '';
					$wp_timeline_slider_class_show           = '';
					$wp_timeline_filter_class_show           = '';
					$wp_timeline_social_class_show           = '';
					$wp_timeline_productsetting_class_show   = '';
					$wp_timeline_pagination_class_show       = '';
					$wp_timeline_acffieldssetting_class_show = '';
					$wp_timeline_eddsetting_class_show       = '';
					if ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_general', $page_p ) ) {
						$wp_timeline_general_class      = 'wp-timeline-active-tab';
						$wp_timeline_general_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_standard', $page_p ) ) {
						$wp_timeline_standard_class      = 'wp-timeline-active-tab';
						$wp_timeline_standard_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_title', $page_p ) ) {
						$wp_timeline_title_class      = 'wp-timeline-active-tab';
						$wp_timeline_title_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_content', $page_p ) ) {
						$wtl_content_class      = 'wp-timeline-active-tab';
						$wtl_content_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_content_box', $page_p ) ) {
						$wtl_content_box_class      = 'wp_timeline_content_box wp-timeline-active-tab';
						$wtl_content_box_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_settings', $page_p ) ) {
						$wtl_timeline_settings_class     = 'wp_timeline_settings wp-timeline-active-tab';
						$wp_timeline_settings_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_media', $page_p ) ) {
						$wp_timeline_media_class      = 'wp-timeline-active-tab';
						$wp_timeline_media_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline', $page_p ) ) {
						$wp_timeline_class      = 'wp_timeline_horizontal wp-timeline-active-tab';
						$wp_timeline_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_filter', $page_p ) ) {
						$wp_timeline_filter_class      = 'wp-timeline-active-tab';
						$wp_timeline_filter_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_pagination', $page_p ) ) {
						$wp_timeline_pagination_class      = 'wp_timeline_pagination wp-timeline-active-tab';
						$wp_timeline_pagination_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_productsetting', $page_p ) ) {
						$wp_timeline_productsetting_class      = 'wp-timeline-active-tab';
						$wp_timeline_productsetting_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_acffield', $page_p ) ) {
						$wp_timeline_social_class      = 'wp-timeline-active-tab';
						$wp_timeline_social_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_eddsetting', $page_p ) ) {
						$wp_timeline_eddsetting_class      = 'wp-timeline-active-tab';
						$wp_timeline_eddsetting_class_show = 'display: block;';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_social', $page_p ) ) {
						$wp_timeline_social_class      = 'wp-timeline-active-tab';
						$wp_timeline_social_class_show = 'display: block;';
					} else {
						$wp_timeline_general_class      = 'wp-timeline-active-tab';
						$wp_timeline_general_class_show = 'display: block;';
					}
					?>
					<ul class="wp-timeline-setting-handle">
						<li data-show="wp_timeline_general" class='<?php echo esc_attr( $wp_timeline_general_class ); ?>'><i class="fa-solid fa-gear"></i><span><?php esc_html_e( 'General Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_standard" class='<?php echo esc_attr( $wp_timeline_standard_class ); ?>'><i class="fas fa-gavel"></i><span><?php esc_html_e( 'Standard Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_settings" class='<?php echo esc_attr( $wtl_timeline_settings_class ); ?>'><i class="fa fa-align-center"></i><span><?php esc_html_e( 'Timeline Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_title" class='<?php echo esc_html( $wp_timeline_title_class ); ?>'><i class="fas fa-text-width"></i><span><?php esc_html_e( 'Post Title Settings', 'timeline-designer' ); ?></span></li> 
						<li data-show="wp_timeline_content" class='<?php echo esc_html( $wtl_content_class ); ?>'><i class="far fa-file-alt"></i><span><?php esc_html_e( 'Post Content Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_content_box" class='<?php echo esc_html( $wtl_content_box_class ); ?>'><i class="far fa-square"></i><span><?php esc_html_e( 'Content Box Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_media" class='<?php echo esc_html( $wp_timeline_media_class ); ?>'><i class="far fa-image"></i><span><?php esc_html_e( 'Media Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline" class='<?php echo esc_html( $wp_timeline_class ); ?>'><i class="far fa-clock"></i><span><?php esc_html_e( 'Horizontal Timeline Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_pagination" class='<?php echo esc_html( $wp_timeline_pagination_class ); ?>'><i class="fas fa-angle-double-right"></i><span><?php esc_html_e( 'Pagination Settings', 'timeline-designer' ); ?></span></li>
						<li data-show="wp_timeline_social" <?php echo esc_attr( $wp_timeline_social_class ); ?>>
							<i class="fas fa-share-alt"></i><span><?php esc_html_e( 'Social Share Settings', 'timeline-designer' ); ?></span>
						</li>
						<?php do_action( 'wtl_layout_settings', 'tab' ); ?>
					</ul>
				</div>
				<div id="wp_timeline_general" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_general_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li>
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Select Timeline Layout', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-left">
									<p class="wp-timeline-margin-bottom-50"><?php esc_html_e( 'Select your favorite layout from 6 powerful blog timeline layouts', 'timeline-designer' ); ?>. </p>
									<p class="wp-timeline-margin-bottom-30"><b><?php esc_html_e( 'Current Template', 'timeline-designer' ); ?>:</b> &nbsp;&nbsp;
										<span class="wp-timeline-template-name">
										<?php
										if ( isset( $wtl_settings['template_name'] ) ) {
											echo esc_html( $tempate_list[ $wtl_settings['template_name'] ]['template_name'] );
										} else {
											esc_html_e( 'Advanced Template', 'timeline-designer' );
										}
										?>
										</span>
									</p>
									<?php
									if ( isset( $_GET['page'] ) && 'add_wtl_shortcode' === $_GET['page'] && ! isset( $_GET['action'] ) ) {
										$wpt_line_create_scode = 'wp-timelinecreate-shortcode';
									} else {
										$wpt_line_create_scode = '';
									}
									if ( isset( $wtl_settings['template_name'] ) ) {
										$wtl_template_name_2 = $wtl_settings['template_name'];
									} else {
										$wtl_template_name_2 = '';
									}
									?>
									<div class="wp_timeline_select_template_button_div">
										<input type="button" class="wp_timeline_select_template" value="<?php esc_attr_e( 'Select Other Template', 'timeline-designer' ); ?>">
										<input type="hidden" class="wp_timeline_template_name <?php echo esc_attr( $wpt_line_create_scode ); ?>" value="<?php echo esc_attr( $wtl_template_name_2 ); ?>" name="template_name">
									</div>
									<?php
									if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] && isset( $_GET['id'] ) ) {
										?>
										<div class="wp_timeline_loader"><p>Loading</p></div>
										<input type="submit" class="wp-timeline-reset-data" name="resetdata" value="<?php esc_attr_e( 'Reset Layout Settings', 'timeline-designer' ); ?>" />
										<?php
									}
									?>
								</div>
								<div class="wp-timeline-right">
									<div class="select_button_upper_div">
										<div class="wp_timeline_selected_template_image">
											<?php
											if ( isset( $wtl_settings['template_name'] ) && empty( $wtl_settings['template_name'] ) ) {
												$template_name_class = 'wp_timeline_no_template_found';
											} else {
												$template_name_class = '';
											}
											?>
											<div class="<?php echo esc_attr( $template_name_class ); ?>">
												<?php
												if ( isset( $wtl_settings['template_name'] ) && ! empty( $wtl_settings['template_name'] ) ) {
													$image_name = esc_url( TLD_URL ) . '/admin/images/layouts/' . $wtl_settings['template_name'] . '.jpg';
													if ( isset( $wtl_settings['template_name'] ) ) {
														$image_alt = $tempate_list[ $wtl_settings['template_name'] ]['template_name'];
													} else {
														$image_alt = '';
													}
													if ( isset( $wtl_settings['template_name'] ) ) {
														$image_title = $tempate_list[ $wtl_settings['template_name'] ]['template_name'];
													} else {
														$image_title = '';
													}
													?>
													<img src="<?php echo esc_url( $image_name ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php echo esc_attr( $image_title ); ?>">
													<label id="template_select_name">
													<?php
													if ( isset( $wtl_settings['template_name'] ) ) {
														echo esc_html( $tempate_list[ $wtl_settings['template_name'] ]['template_name'] );
													}
													?>
													</label>
													<?php
												} else {
													esc_html_e( 'No template exist for selection', 'timeline-designer' );
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Layout Name', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter blog layout name', 'timeline-designer' ); ?></span></span>
									<input type="text" name="unique_shortcode_name" id="unique_shortcode_name" value="<?php echo esc_attr( $shortcode_name ); ?>" placeholder="<?php esc_attr_e( 'Enter layout name', 'timeline-designer' ); ?>">
								</div>
							</li>
							<li class="wtl_heading_1">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline 1st Heading', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter timeline name which appear top of timeline', 'timeline-designer' ); ?></span></span>
									<input type="text" name="timeline_heading_1" id="timeline_heading_1" value="<?php echo isset( $wtl_settings['timeline_heading_1'] ) ? esc_attr( $wtl_settings['timeline_heading_1'] ) : ''; ?>" placeholder="Enter 1st Heading">
								</div>
							</li>
							<li class="wtl_heading_2">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline 2nd Heading', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter timeline name which appear top of timeline', 'timeline-designer' ); ?></span></span>
									<input type="text" name="timeline_heading_2" id="timeline_heading_2" value="<?php echo isset( $wtl_settings['timeline_heading_2'] ) ? esc_attr( $wtl_settings['timeline_heading_2'] ) : ''; ?>" placeholder="Enter 2nd Heading">
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Select Post type', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post type for blog layout', 'timeline-designer' ); ?></span></span>
									<select name="custom_post_type" id="custom_post_type" >
										<?php
										if ( ! isset( $wtl_settings['custom_post_type'] ) || empty( $wtl_settings['custom_post_type'] ) ) {
											$wtl_settings['custom_post_type'] = 'post';
										}
										$args       = array(
											'public'   => true,
											'_builtin' => false,
										);
										$post_types = get_post_types( $args, 'objects' );
										?>
										<option value="post" 
										<?php
										if ( 'post' === $wtl_settings['custom_post_type'] ) {
											echo 'selected=selected';
										}
										?>
										>
										<?php esc_html_e( 'Post', 'timeline-designer' ); ?>
										</option>
										<?php
										if ( $post_types ) {
											foreach ( $post_types as $post_type_p ) {
												if ( 'product' != $post_type_p ) {
													?>
													<option value="<?php echo esc_attr( $post_type_p->name ); ?>" 
													<?php
													if ( $wtl_settings['custom_post_type'] == $post_type_p->name ) {
														echo 'selected=selected';
													}
													?>
													>
													<?php echo esc_attr( $post_type_p->label ); ?>
													</option>
													<?php
												}
											}
										}
										?>
									</select>
								</div>
							</li>

							<li class="wp-timeline-caution">
								<div class="wp-timeline-setting-description">
									<b class="note"><?php esc_html_e( 'Caution', 'timeline-designer' ); ?>:</b> &nbsp;
									<?php
									esc_html_e( 'You are about to select the page for your layout. This will overwrite all the content on the page that you will select. Changes once lost cannot be recovered. Please be cautious.', 'timeline-designer' );
									?>
								</div>
								<?php wtl_lite_setting_left( esc_html__( 'Select Page for Blog', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select page for display blog layout', 'timeline-designer' ); ?></span></span>
									<?php
									if ( ! isset( $wtl_settings['wtl_page_display'] ) ) {
										$wtl_settings['wtl_page_display'] = '';
									}
									echo wp_dropdown_pages(
										array(
											'name'     => 'wtl_page_display',
											'echo'     => 0,
											'show_option_none' => '--  ' . esc_html__( 'Select Page', 'timeline-designer' ) . '  --',
											'option_none_value' => '0',
											'selected' => $wtl_settings['wtl_page_display'],
											'depth'    => -1,
										)
									);
									?>
								</div>
							</li>

							<li class="wp_timeline_posts_per_page">
								<?php wtl_lite_setting_left( esc_html__( 'Number of Posts to Display', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select number of posts to display on page', 'timeline-designer' ); ?></span></span>
									<?php
									if ( ! isset( $wtl_settings['posts_per_page'] ) ) {
										$wtl_settings['posts_per_page'] = get_option( 'posts_per_page' );
									}
									?>
									<div class="input-type-number">
										<input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php echo esc_attr( $wtl_settings['posts_per_page'] ); ?>" class="" onkeypress="return isNumberKey(event)" />
									</div>
								</div>
							</li>

							<li class="wp-timeline-display-settings">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Display Settings', 'timeline-designer' ); ?></h3>

								<div class="wp-timeline-typography-wrapper wp-timeline-button-settings">
									<?php
									$custom_posttype = $wtl_settings['custom_post_type'];
									if ( 'post' !== $custom_posttype ) {
										$taxonomy_names = get_object_taxonomies( $custom_posttype, 'objects' );
										$taxonomy_names = apply_filters( 'wtl_hide_taxonomies', $taxonomy_names );
										if ( ! empty( $taxonomy_names ) ) {
											foreach ( $taxonomy_names as $taxonomy_name ) {
												if ( ! empty( $taxonomy_name ) ) {
													?>
													<div class="wp-timeline-typography-cover display-custom-taxonomy">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php echo esc_html( $taxonomy_name->label ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable ', 'timeline-designer' ) . ' ' . esc_html_e( $taxonomy_name->label, 'timeline-designer' ) . ' ' . esc_html_e( ' in blog layout', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php
															$txname             = 'display_' . $taxonomy_name->name;
															$display_custom_tax = isset( $wtl_settings[ $txname ] ) ? $wtl_settings[ $txname ] : 0;
															?>
															<fieldset class="wp-timeline-social-options wp-timeline-display_tax buttonset ui-buttonset">
																<input id="<?php echo esc_attr( $txname ) . '_1'; ?>" name="<?php echo esc_attr( $txname ); ?>" type="radio" value="1" <?php echo checked( 1, $display_custom_tax ); ?> />
																<label for="<?php echo esc_attr( $txname ) . '_1'; ?>" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
																<input id="<?php echo esc_attr( $txname ) . '_0'; ?>" name="<?php echo esc_attr( $txname ); ?>" type="radio" value="0" <?php echo checked( 0, $display_custom_tax ); ?> />
																<label for="<?php echo esc_attr( $txname ) . '_0'; ?>" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
															</fieldset>
															</label><label class="disable_link">
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
									} else {
										?>
										<div class="wp-timeline-typography-cover display-custom-taxonomy">
											<div class="wp-timeline-typography-label">
												<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Category', 'timeline-designer' ); ?></span>
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post category on blog layout', 'timeline-designer' ); ?></span></span>
											</div>
											<div class="wp-timeline-typography-content">
												<?php $display_category = isset( $wtl_settings['display_category'] ) ? $wtl_settings['display_category'] : 0; ?>
												<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
													<input id="display_category_1" name="display_category" type="radio" value="1" <?php echo checked( 1, $display_category ); ?> />
													<label for="display_category_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
													<input id="display_category_0" name="display_category" type="radio" value="0" <?php echo checked( 0, $display_category ); ?> />
													<label for="display_category_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
												</fieldset>
												<label class="disable_link">
													<input id="disable_link_category" name="disable_link_category" type="checkbox" value="1" 
													<?php
													if ( isset( $wtl_settings['disable_link_category'] ) ) {
														checked( 1, $wtl_settings['disable_link_category'] );
													}
													?>
													/>
													<?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
												</label>
											</div>
										</div>
										<div class="wp-timeline-typography-cover display-custom-taxonomy">
											<div class="wp-timeline-typography-label">
												<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Tag', 'timeline-designer' ); ?></span>
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post tag on blog layout', 'timeline-designer' ); ?></span></span>
											</div>
											<div class="wp-timeline-typography-content">
												<?php $display_tag = isset( $wtl_settings['display_tag'] ) ? $wtl_settings['display_tag'] : 1; ?>
												<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
													<input id="display_tag_1" name="display_tag" type="radio" value="1" <?php checked( 1, $display_tag ); ?> />
													<label for="display_tag_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
													<input id="display_tag_0" name="display_tag" type="radio" value="0" <?php checked( 0, $display_tag ); ?> />
													<label for="display_tag_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
												</fieldset>
												<label class="disable_link">
													<input id="disable_link_tag" name="disable_link_tag" type="checkbox" value="1" 
													<?php
													if ( isset( $wtl_settings['disable_link_tag'] ) ) {
														checked( 1, $wtl_settings['disable_link_tag'] );
													}
													?>
													/>
													<?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
												</label>
											</div>
										</div>
										<?php
									}
									?>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Author', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post author on blog layout', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
												<input id="display_author_1" name="display_author" type="radio" value="1"  <?php isset( $wtl_settings['display_author'] ) ? checked( 1, $wtl_settings['display_author'] ) : ''; ?> />
												<label for="display_author_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="display_author_0" name="display_author" type="radio" value="0" <?php isset( $wtl_settings['display_author'] ) ? checked( 0, $wtl_settings['display_author'] ) : ''; ?> />
												<label for="display_author_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
											<label class="disable_link">
												<input id="disable_link_author" name="disable_link_author" type="checkbox" value="1" 
												<?php
												if ( isset( $wtl_settings['disable_link_author'] ) ) {
													checked( 1, $wtl_settings['disable_link_author'] );
												}
												?>
												/>
												<?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
											</label>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Post Publish Date', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post publish date on blog layout', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-display_date buttonset buttonset-hide ui-buttonset" data-hide="1">
												<input id="display_date_1" name="display_date" type="radio" value="1" <?php checked( 1, $wtl_settings['display_date'] ); ?> />
												<label for="display_date_1" <?php checked( 1, $wtl_settings['display_date'] ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="display_date_0" name="display_date" type="radio" value="0" <?php checked( 0, $wtl_settings['display_date'] ); ?> />
												<label for="display_date_0" <?php checked( 0, $wtl_settings['display_date'] ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
											<label class="disable_link">
												<input id="disable_link_date" name="disable_link_date" type="checkbox" value="1" 
												<?php
												if ( isset( $wtl_settings['disable_link_date'] ) ) {
													checked( 1, $wtl_settings['disable_link_date'] );
												}
												?>
												/> <?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
											</label>
										</div>
									</div>

									<div class="wp-timeline-typography-cover display_comment">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
												<?php esc_html_e( 'Post Comment Count', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post comment on blog layout', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $display_comment_count = isset( $wtl_settings['display_comment_count'] ) ? $wtl_settings['display_comment_count'] : '1'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-display_comment_count buttonset buttonset-hide ui-buttonset" data-hide="1">
												<input id="display_comment_count_1" name="display_comment_count" type="radio" value="1" <?php checked( 1, $display_comment_count ); ?> />
												<label for="display_comment_count_1" <?php checked( 1, $display_comment_count ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="display_comment_count_0" name="display_comment_count" type="radio" value="0" <?php checked( 0, $display_comment_count ); ?> />
												<label for="display_comment_count_0" <?php checked( 0, $display_comment_count ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
											<label class="disable_link">
												<input id="disable_link_comment" name="disable_link_comment" type="checkbox" value="1" 
												<?php
												if ( isset( $wtl_settings['disable_link_comment'] ) ) {
													checked( 1, $wtl_settings['disable_link_comment'] );
												}
												?>
												/>
												<?php esc_html_e( 'Disable Link', 'timeline-designer' ); ?>
											</label>
										</div>
									</div>
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Custom CSS', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-textarea"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Write a "Custom CSS" to add your additional design for blog page', 'timeline-designer' ); ?></span></span>
									<textarea class="widefat textarea" name="custom_css" id="custom_css" placeholder=".class_name{ color:#ffffff }">
									<?php
									if ( isset( $wtl_settings['custom_css'] ) ) {
										echo esc_textarea( wp_unslash( $wtl_settings['custom_css'] ) ); }
									?>
									</textarea>
									<div class="wp-timeline-setting-description wp-timeline-note">
										<b class=""><?php esc_html_e( 'Example', 'timeline-designer' ); ?>:</b>
										<?php echo '.class_name{ color:#ffffff }'; ?>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php /* ---------- [Standard Settings] ----------*/ ?>
				<div id="wp_timeline_standard" class="postbox postbox-with-fw-options" style="<?php echo esc_attr( $wp_timeline_standard_class_show ); ?>">
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li class="blog-template-tr wp-timeline-back-color-blog">
								<?php wtl_lite_setting_left( esc_html__( 'Template Background Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select template background color', 'timeline-designer' ); ?></span></span>
									<?php $template_bgcolor = ( isset( $wtl_settings['template_bgcolor'] ) && ! empty( $wtl_settings['template_bgcolor'] ) ) ? $wtl_settings['template_bgcolor'] : ''; ?>
									<input type="text" name="template_bgcolor" id="template_bgcolor" value="<?php echo esc_attr( $template_bgcolor ); ?>"/>
								</div>
							</li>
							<li class="pro-feature">
								<?php wtl_lite_setting_left( esc_html__( 'Link Color', 'timeline-designer' ), esc_html__( 'PRO', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select link color', 'timeline-designer' ); ?></span></span>
									<?php $template_ftcolor = isset( $wtl_settings['template_ftcolor'] ) ? $wtl_settings['template_ftcolor'] : ''; ?>
									<input type="text" name="" id="template_ftcolor" value="<?php echo esc_attr( $template_ftcolor ); ?>" data-default-color="<?php echo esc_attr( $template_ftcolor ); ?>"/>
								</div>
							</li>
							<li class="pro-feature">
								<?php wtl_lite_setting_left( esc_html__( 'Link Hover Color', 'timeline-designer' ), esc_html__( 'PRO', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select link hover color', 'timeline-designer' ); ?></span></span>
									<?php $fthover = isset( $wtl_settings['template_fthovercolor'] ) ? $wtl_settings['template_fthovercolor'] : ''; ?>
									<input type="text" name="" id="template_fthovercolor" value="<?php echo esc_attr( $fthover ); ?>" data-default-color="<?php echo esc_attr( $fthover ); ?>"/>
								</div>
							</li>
							<li class="wp-timeline-post-offset">
								<?php wtl_lite_setting_left( esc_html__( 'Number of Post offset', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
								<?php $wp_timeline_post_offset = ( isset( $wtl_settings['wp_timeline_post_offset'] ) && ! empty( $wtl_settings['wp_timeline_post_offset'] ) ) ? $wtl_settings['wp_timeline_post_offset'] : '0'; ?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select number of post offset to display on blog page', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="wp_timeline_post_offset" name="wp_timeline_post_offset" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_post_offset ); ?>" placeholder="<?php esc_attr_e( 'Enter post offset', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>

							<?php /* Post Meta Typography. */ ?>
							<li>
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Post Meta Typography Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span><span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post meta font family', 'timeline-designer' ); ?></span></span></div>
										<div class="wp-timeline-typography-content">
											<?php
											if ( isset( $wtl_settings['meta_font_family'] ) && '' != $wtl_settings['meta_font_family'] ) {
												$meta_font_family = $wtl_settings['meta_font_family'];
											} else {
												$meta_font_family = '';
											}
											?>
											<div class="typo-field">
												<input type="hidden" id="meta_font_family_font_type" name="meta_font_family_font_type" value="<?php echo isset( $wtl_settings['meta_font_family_font_type'] ) ? esc_attr( $wtl_settings['meta_font_family_font_type'] ) : ''; ?>">
												<div class="select-cover">
													<select name="meta_font_family" id="meta_font_family">
														<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
														<?php
														$old_version2 = '';
														$cnt2         = 0;
														$font_family2 = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
														foreach ( $font_family2 as $key2 => $value2 ) {
															if ( $value2['version'] != $old_version2 ) {
																if ( $cnt2 > 0 ) {
																	echo '</optgroup>';
																}
																echo '<optgroup label="' . esc_attr( $value2['version'] ) . '">';
																$old_version2 = $value2['version'];
															}
															echo "<option value='" . esc_attr( str_replace( '"', '', $value2['label'] ) ) . "'";

															if ( '' != $meta_font_family && ( str_replace( '"', '', $meta_font_family ) == str_replace( '"', '', $value2['label'] ) ) ) {
																echo ' selected';
															}
															echo '>' . esc_html( $value2['label'] ) . '</option>';
															$cnt2++;
														}
														if ( count( $font_family2 ) == $cnt2 ) {
															echo '</optgroup>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"> <?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size for post meta', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $meta_fontsize = isset( $wtl_settings['meta_fontsize'] ) ? $wtl_settings['meta_fontsize'] : '18'; ?>
											<div class="grid_col_space range_slider_fontsize" id="meta_fontsize_slider" data-value="<?php echo esc_attr( $meta_fontsize ); ?>"></div>
											<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="meta_fontsize" id="meta_fontsize" value="<?php echo esc_attr( $meta_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font weight', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
										<?php $meta_font_weight = isset( $wtl_settings['meta_font_weight'] ) ? $wtl_settings['meta_font_weight'] : 'normal'; ?>
											<div class="select-cover">
												<select name="meta_font_weight" id="meta_font_weight">
													<option value="100" <?php selected( $meta_font_weight, 100 ); ?>>100</option>
													<option value="200" <?php selected( $meta_font_weight, 200 ); ?>>200</option>
													<option value="300" <?php selected( $meta_font_weight, 300 ); ?>>300</option>
													<option value="400" <?php selected( $meta_font_weight, 400 ); ?>>400</option>
													<option value="500" <?php selected( $meta_font_weight, 500 ); ?>>500</option>
													<option value="600" <?php selected( $meta_font_weight, 600 ); ?>>600</option>
													<option value="700" <?php selected( $meta_font_weight, 700 ); ?>>700</option>
													<option value="800" <?php selected( $meta_font_weight, 800 ); ?>>800</option>
													<option value="900" <?php selected( $meta_font_weight, 900 ); ?>>900</option>
													<option value="bold" <?php selected( $meta_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
													<option value="normal" <?php selected( $meta_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter line height', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input type="number" name="meta_font_line_height" id="meta_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['meta_font_line_height'] ) ? esc_attr( $wtl_settings['meta_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display italic font style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $meta_font_italic = isset( $wtl_settings['meta_font_italic'] ) ? $wtl_settings['meta_font_italic'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
												<input id="meta_font_italic_1" name="meta_font_italic" type="radio" value="1"  <?php checked( 1, $meta_font_italic ); ?> />
												<label for="meta_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="meta_font_italic_0" name="meta_font_italic" type="radio" value="0" <?php checked( 0, $meta_font_italic ); ?> />
												<label for="meta_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text transform style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
										<?php $meta_font_text_transform = isset( $wtl_settings['meta_font_text_transform'] ) ? $wtl_settings['meta_font_text_transform'] : 'none'; ?>
											<div class="select-cover">
												<select name="meta_font_text_transform" id="meta_font_text_transform">
													<option <?php selected( $meta_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text decoration style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $meta_font_text_decoration = isset( $wtl_settings['meta_font_text_decoration'] ) ? $wtl_settings['meta_font_text_decoration'] : 'none'; ?>
											<div class="select-cover">
												<select name="meta_font_text_decoration" id="meta_font_text_decoration">
													<option <?php selected( $meta_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
													<option <?php selected( $meta_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter letter spacing', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input type="number" name="meta_font_letter_spacing" id="meta_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['meta_font_letter_spacing'] ) ? esc_attr( $wtl_settings['meta_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
								</div>
							</li>

							<?php /* Post Date Typography. */ ?>
							<li class="wtl_post_date_option">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Date Typography Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span><span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post date font family', 'timeline-designer' ); ?></span></span></div>
										<div class="wp-timeline-typography-content">
											<?php
											if ( isset( $wtl_settings['date_font_family'] ) && '' != $wtl_settings['date_font_family'] ) {
												$date_font_family = $wtl_settings['date_font_family'];
											} else {
												$date_font_family = '';
											}
											?>
											<div class="typo-field">
												<input type="hidden" id="date_font_family_font_type" name="date_font_family_font_type" value="<?php echo isset( $wtl_settings['date_font_family_font_type'] ) ? esc_attr( $wtl_settings['date_font_family_font_type'] ) : ''; ?>">
												<div class="select-cover">
													<select name="date_font_family" id="date_font_family">
														<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
														<?php
														$old_version2 = '';
														$cnt2         = 0;
														$font_family2 = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
														foreach ( $font_family2 as $key2 => $value2 ) {
															if ( $value2['version'] != $old_version2 ) {
																if ( $cnt2 > 0 ) {
																	echo '</optgroup>';
																}
																echo '<optgroup label="' . esc_attr( $value2['version'] ) . '">';
																$old_version2 = $value2['version'];
															}
															echo "<option value='" . esc_attr( str_replace( '"', '', $value2['label'] ) ) . "'";

															if ( '' != $date_font_family && ( str_replace( '"', '', $date_font_family ) == str_replace( '"', '', $value2['label'] ) ) ) {
																echo ' selected';
															}
															echo '>' . esc_html( $value2['label'] ) . '</option>';
															$cnt2++;
														}
														if ( count( $font_family2 ) == $cnt2 ) {
															echo '</optgroup>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"> <?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size for post date', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $date_fontsize = isset( $wtl_settings['date_fontsize'] ) ? $wtl_settings['date_fontsize'] : '18'; ?>
											<div class="grid_col_space range_slider_fontsize" id="date_fontsize_slider" data-value="<?php echo esc_attr( $date_fontsize ); ?>"></div>
											<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="date_fontsize" id="date_fontsize" value="<?php echo esc_attr( $date_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font weight', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
										<?php $date_font_weight = isset( $wtl_settings['date_font_weight'] ) ? $wtl_settings['date_font_weight'] : 'normal'; ?>
											<div class="select-cover">
												<select name="date_font_weight" id="date_font_weight">
													<option value="100" <?php selected( $date_font_weight, 100 ); ?>>100</option>
													<option value="200" <?php selected( $date_font_weight, 200 ); ?>>200</option>
													<option value="300" <?php selected( $date_font_weight, 300 ); ?>>300</option>
													<option value="400" <?php selected( $date_font_weight, 400 ); ?>>400</option>
													<option value="500" <?php selected( $date_font_weight, 500 ); ?>>500</option>
													<option value="600" <?php selected( $date_font_weight, 600 ); ?>>600</option>
													<option value="700" <?php selected( $date_font_weight, 700 ); ?>>700</option>
													<option value="800" <?php selected( $date_font_weight, 800 ); ?>>800</option>
													<option value="900" <?php selected( $date_font_weight, 900 ); ?>>900</option>
													<option value="bold" <?php selected( $date_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
													<option value="normal" <?php selected( $date_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter line height', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input type="number" name="date_font_line_height" id="date_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['date_font_line_height'] ) ? esc_attr( $wtl_settings['date_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display italic font style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $date_font_italic = isset( $wtl_settings['date_font_italic'] ) ? $wtl_settings['date_font_italic'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
												<input id="date_font_italic_1" name="date_font_italic" type="radio" value="1"  <?php checked( 1, $date_font_italic ); ?> />
												<label for="date_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="date_font_italic_0" name="date_font_italic" type="radio" value="0" <?php checked( 0, $date_font_italic ); ?> />
												<label for="date_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text transform style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
										<?php $date_font_text_transform = isset( $wtl_settings['date_font_text_transform'] ) ? $wtl_settings['date_font_text_transform'] : 'none'; ?>
											<div class="select-cover">
												<select name="date_font_text_transform" id="date_font_text_transform">
													<option <?php selected( $date_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text decoration style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $date_font_text_decoration = isset( $wtl_settings['date_font_text_decoration'] ) ? $wtl_settings['date_font_text_decoration'] : 'none'; ?>
											<div class="select-cover">
												<select name="date_font_text_decoration" id="date_font_text_decoration">
													<option <?php selected( $date_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
													<option <?php selected( $date_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter letter spacing', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input type="number" name="date_font_letter_spacing" id="date_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['date_font_letter_spacing'] ) ? esc_attr( $wtl_settings['date_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="wp_timeline_title" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_title_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight wp-timeline-display-typography">
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Link', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display post title link', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_post_title_link = isset( $wtl_settings['wp_timeline_post_title_link'] ) ? $wtl_settings['wp_timeline_post_title_link'] : '1'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_post_title_link_1" name="wp_timeline_post_title_link" type="radio" value="1" <?php checked( 1, $wp_timeline_post_title_link ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_title_link_1" <?php checked( 1, $wp_timeline_post_title_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_post_title_link_0" name="wp_timeline_post_title_link" type="radio" value="0" <?php checked( 0, $wp_timeline_post_title_link ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_title_link_0" <?php checked( 0, $wp_timeline_post_title_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Alignment', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post title alignment', 'timeline-designer' ); ?></span></span>
									<?php
									$template_title_alignment = 'left';
									if ( isset( $wtl_settings['template_title_alignment'] ) ) {
										$template_title_alignment = $wtl_settings['template_title_alignment'];
									}
									?>
									<fieldset class="buttonset green" data-hide='1'>
											<input id="template_title_alignment_left" name="template_title_alignment" type="radio" value="left" <?php checked( 'left', $template_title_alignment ); ?> />
											<label id="wp-timeline-options-button" for="template_title_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
											<input id="template_title_alignment_center" name="template_title_alignment" type="radio" value="center" <?php checked( 'center', $template_title_alignment ); ?> />
											<label id="wp-timeline-options-button" for="template_title_alignment_center" class="template_title_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
											<input id="template_title_alignment_right" name="template_title_alignment" type="radio" value="right" <?php checked( 'right', $template_title_alignment ); ?> />
											<label id="wp-timeline-options-button" for="template_title_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wp-timeline-gray title-link-color-tr">
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( ' Select post title color', 'timeline-designer' ); ?></span></span>
									<?php $template_titlecolor = isset( $wtl_settings['template_titlecolor'] ) ? $wtl_settings['template_titlecolor'] : ''; ?>
									<input type="text" name="template_titlecolor" id="template_titlecolor" value="<?php echo esc_attr( $template_titlecolor ); ?>"/>
								</div>
							</li>
							<li class="title-link-hover-color-tr">
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Link Hover Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post title link hover color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="template_titlehovercolor" id="template_titlehovercolor" value="
									<?php
									if ( isset( $wtl_settings['template_titlehovercolor'] ) ) {
										echo esc_attr( $wtl_settings['template_titlehovercolor'] );
									} else {
										echo '#444';
									}
									?>
									"/>
								</div>
							</li>
							<li class="titlebackcolor_tr wp-timeline-gray">
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Background Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post title background color', 'timeline-designer' ); ?></span></span>
									<?php $template_titlebackcolor = isset( $wtl_settings['template_titlebackcolor'] ) ? $wtl_settings['template_titlebackcolor'] : ''; ?>
									<input type="text" name="template_titlebackcolor" id="template_titlebackcolor" value="<?php echo esc_attr( $template_titlebackcolor ); ?>"/>
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Maximum Line', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set Post Title Maximum Line', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_post_title_maxline = isset( $wtl_settings['wp_timeline_post_title_maxline'] ) ? $wtl_settings['wp_timeline_post_title_maxline'] : '0'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_post_title_maxline_1" name="wp_timeline_post_title_maxline" type="radio" value="1" <?php checked( 1, $wp_timeline_post_title_maxline ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_title_maxline_1" <?php checked( 1, $wp_timeline_post_title_maxline ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_post_title_maxline_0" name="wp_timeline_post_title_maxline" type="radio" value="0" <?php checked( 0, $wp_timeline_post_title_maxline ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_title_maxline_0" <?php checked( 0, $wp_timeline_post_title_maxline ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="post_title_maxline_num">
								<?php wtl_lite_setting_left( esc_html__( 'Display Maximum number of line ', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter Maximum number of line to show', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="post_title_maxline" name="post_title_maxline" step="1" min="0" value="<?php echo isset( $wtl_settings['post_title_maxline'] ) ? esc_attr( $wtl_settings['post_title_maxline'] ) : ""; ?>" placeholder="<?php esc_attr_e( 'Set limit of lines', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Post Title Break Words', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Break Words Type', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_post_title_wordbreak_type = isset( $wtl_settings['wp_timeline_post_title_wordbreak_type'] ) ? $wtl_settings['wp_timeline_post_title_wordbreak_type'] : 'default'; ?>
									<fieldset class="buttonset buttonset-hide green" data-hide='1'>
									<input id="wp_timeline_post_title_wordbreak_type_default" name="wp_timeline_post_title_wordbreak_type" type="radio" value="default" <?php checked( 'default', $wp_timeline_post_title_wordbreak_type ); ?> />
									<label id="wp-timeline-options-button" for="wp_timeline_post_title_wordbreak_type_default" <?php checked( 'default', $wp_timeline_post_title_wordbreak_type ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Default ', 'timeline-designer' ); ?></label>
									<input id="wp_timeline_post_title_wordbreak_type_break-all" name="wp_timeline_post_title_wordbreak_type" type="radio" value="break-all" <?php checked( 'break-all', $wp_timeline_post_title_wordbreak_type ); ?> />
									<label id="wp-timeline-options-button" for="wp_timeline_post_title_wordbreak_type_break-all" <?php checked( 'break-all', $wp_timeline_post_title_wordbreak_type ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Break All', 'timeline-designer' ); ?></label>
									<input id="wp_timeline_post_title_wordbreak_type_break-word" name="wp_timeline_post_title_wordbreak_type" type="radio" value="break-word" <?php checked( 'break-word', $wp_timeline_post_title_wordbreak_type ); ?> />
									<label id="wp-timeline-options-button" for="wp_timeline_post_title_wordbreak_type_break-word" <?php checked( 'break-word', $wp_timeline_post_title_wordbreak_type ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Break Word', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li>
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font family', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="typo-field">
												<input type="hidden" id="template_titlefontface_font_type" name="template_titlefontface_font_type" value="">
												<div class='select-cover'>
													<select name="" id="">
														<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
													</select>
												</div>
											</div>
										</div>

									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="grid_col_space range_slider_fontsize" id="template_postTitlefontsizeInput" data-value="18"></div>
											<div class="slide_val"><span></span><input readonly class="grid_col_space_val range-slider__value" name="" id="template_titlefontsize" value="18" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font weight', 'timeline-designer' ); ?></span></span>
										</div>

										<div class="wp-timeline-typography-content">
											<div class="select-cover">
												<select name="" id="">
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Line Height', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter line height', 'timeline-designer' ); ?></span></span>
										</div>

										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input readonly type="number" name="" id="" step="0.1" min="0" value="1.5" onkeypress="return isNumberKey(event)" >
											</div>
										</div>
									</div>
									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display italic font style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset ui-buttonset">
												<input id="template_title_font_italic_1" name="" type="radio" value="1" />
												<label for="template_title_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="template_title_font_italic_0" name="" type="radio" value="0"  checked="checked" />
												<label for="template_title_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text transform style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="select-cover">
												<select name="" id="">
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text decoration style', 'timeline-designer' ); ?></span></span>
										</div>

										<div class="wp-timeline-typography-content">
											<div class="select-cover">
												<div class="select-cover">
													<select name="" id="">
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover pro-feature">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?>
											</span>
											<span class="wtd-pro-tag"><?php esc_html_e( 'PRO', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter letter spacing', 'timeline-designer' ); ?></span></span>
										</div>

										<div class="wp-timeline-typography-content">
											<div class="input-type-number">
												<input readonly type="number" name="" id="template_title_font_letter_spacing" step="1" min="0" value="0" onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="wp_timeline_content" class="postbox postbox-with-fw-options wp-timeline-content-setting1" style='<?php echo esc_attr( $wtl_content_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight wp-timeline-display-typography">
							<li class="feed_excert">
								<?php wtl_lite_setting_left( esc_html__( 'For each Article in a Feed, Show', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'To display full text for each post, select full text option, otherwise select the summary option.', 'timeline-designer' ); ?></span></span>
									<fieldset class="wp-timeline-rss_use_excerpt buttonset buttonset-hide green" data-hide='1'>
										<input id="rss_use_excerpt_0" name="rss_use_excerpt" type="radio" value="0" <?php isset( $wtl_settings['rss_use_excerpt'] ) ? checked( 0, $wtl_settings['rss_use_excerpt'] ) : ''; ?> />
										<label id="wp-timeline-options-button" for="rss_use_excerpt_0" <?php isset( $wtl_settings['rss_use_excerpt'] ) ? checked( 0, $wtl_settings['rss_use_excerpt'] ) : ''; ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Full Text', 'timeline-designer' ); ?></label>
										<input id="rss_use_excerpt_1" name="rss_use_excerpt" type="radio" value="1" <?php isset( $wtl_settings['rss_use_excerpt'] ) ? checked( 1, $wtl_settings['rss_use_excerpt'] ) : ''; ?> />
										<label id="wp-timeline-options-button" for="rss_use_excerpt_1" <?php isset( $wtl_settings['rss_use_excerpt'] ) ? checked( 1, $wtl_settings['rss_use_excerpt'] ) : ''; ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Summary', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>

							<li class="post_content_from">
								<?php wtl_lite_setting_left( esc_html__( 'Show Content From', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'To display text from post content or from post excerpt', 'timeline-designer' ); ?></span></span>
									<?php $template_post_content_from = isset( $wtl_settings['template_post_content_from'] ) ? $wtl_settings['template_post_content_from'] : 'from_content'; ?>
									<select name="template_post_content_from" id="template_post_content_from">
										<option value="from_content" <?php selected( $template_post_content_from, 'from_content' ); ?> ><?php esc_html_e( 'Post Content', 'timeline-designer' ); ?></option>
										<option value="from_excerpt" <?php selected( $template_post_content_from, 'from_excerpt' ); ?>><?php esc_html_e( 'Post Excerpt', 'timeline-designer' ); ?></option>
									</select>
									<div class="wp-timeline-setting-description wp-timeline-note">
										<b class="note"><?php esc_html_e( 'Note', 'timeline-designer' ); ?>:</b>
										<?php esc_html_e( 'If Post Excerpt is empty then Content will get automatically from Post Content.', 'timeline-designer' ); ?>
									</div>
								</div>
							</li>

							<li class="display_html_tags_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Display HTML tags with Summary', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show HTML tags with summary', 'timeline-designer' ); ?></span></span>
									<?php $display_html_tags = ( isset( $wtl_settings['display_html_tags'] ) ) ? $wtl_settings['display_html_tags'] : 0; ?>
									<fieldset class="buttonset display_html_tags">
										<input id="display_html_tags_1" name="display_html_tags" type="radio" value="1" <?php checked( 1, $display_html_tags ); ?> />
										<label for="display_html_tags_1" <?php checked( 1, $display_html_tags ); ?>  class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="display_html_tags_0" name="display_html_tags" type="radio" value="0" <?php checked( 0, $display_html_tags ); ?> />
										<label for="display_html_tags_0" <?php checked( 0, $display_html_tags ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>

							<li class="content-firstletter-tr">
								<?php wtl_lite_setting_left( esc_html__( 'First letter as Dropcap', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display first letter as dropcap', 'timeline-designer' ); ?></span></span>
									<?php $firstletter_big = ( isset( $wtl_settings['firstletter_big'] ) ) ? $wtl_settings['firstletter_big'] : 0; ?>
									<fieldset class="buttonset firstletter_big">
										<input id="firstletter_big_1" name="firstletter_big" type="radio" value="1" <?php checked( 1, $firstletter_big ); ?> />
										<label for="firstletter_big_1" <?php checked( 1, $firstletter_big ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="firstletter_big_0" name="firstletter_big" type="radio" value="0" <?php checked( 0, $firstletter_big ); ?> />
										<label for="firstletter_big_0" <?php checked( 0, $firstletter_big ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="firstletter-setting wp-timeline-dropcap-settings">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Dropcap Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Dropcap Font Family', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font family for dropcap', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $firstletter_font_family = ( isset( $wtl_settings['firstletter_font_family'] ) && '' != $wtl_settings['firstletter_font_family'] ) ? $wtl_settings['firstletter_font_family'] : ''; ?>
											<div class="typo-field">
												<input type="hidden" id="firstletter_font_family_font_type" name="firstletter_font_family_font_type" value="<?php echo isset( $wtl_settings['firstletter_font_family_font_type'] ) ? esc_attr( $wtl_settings['firstletter_font_family_font_type'] ) : ''; ?>">
												<select name="firstletter_font_family" id="firstletter_font_family">
													<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
													<?php
													$old_version = '';
													$cnt         = 0;
													$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
													foreach ( $font_family as $key => $value ) {
														if ( $value['version'] != $old_version ) {
															if ( $cnt > 0 ) {
																echo '</optgroup>';
															}
															echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
															$old_version = $value['version'];
														}
														echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
														if ( '' != $firstletter_font_family && ( str_replace( '"', '', $firstletter_font_family ) == str_replace( '"', '', $value['label'] ) ) ) {
															echo ' selected';
														}
														echo '>' . esc_attr( $value['label'] ) . '</option>';
														$cnt++;
													}
													if ( count( $font_family ) == $cnt ) {
														echo '</optgroup>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Dropcap Font Size (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size for dropcap', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $firstletter_fontsize = ( isset( $wtl_settings['firstletter_fontsize'] ) && '' != $wtl_settings['firstletter_fontsize'] ) ? $wtl_settings['firstletter_fontsize'] : '35'; ?>
											<div class="grid_col_space range_slider_fontsize" id="firstletter_fontsize_slider" ></div>
											<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="firstletter_fontsize" id="firstletter_fontsize" value="<?php echo esc_attr( $firstletter_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Dropcap Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select dropcap color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content wp-timeline-color-picker">
											<?php
											if ( isset( $wtl_settings['firstletter_contentcolor'] ) ) {
												$firstletter_contentcolor = $wtl_settings['firstletter_contentcolor'];
											} else {
												$firstletter_contentcolor = '#000000';
											}
											?>
											<input type="text" name="firstletter_contentcolor" id="firstletter_contentcolor" value="<?php echo esc_attr( $firstletter_contentcolor ); ?>"/>
										</div>
									</div>
								</div>
							</li>
							<li class="excerpt_length">
								<?php wtl_lite_setting_left( esc_html__( 'Enter post content length (words)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter post content length in number of words', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="txtExcerptlength" name="txtExcerptlength" step="1" min="0" value="<?php echo esc_attr( $wtl_settings['txtExcerptlength'] ); ?>" placeholder="<?php esc_attr_e( 'Enter content length', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li class="advance_contents_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Advance Post Contents', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable advance blog contents', 'timeline-designer' ); ?></span></span>
									<?php $advance_contents = ( isset( $wtl_settings['advance_contents'] ) ) ? $wtl_settings['advance_contents'] : 0; ?>
									<fieldset class="buttonset advance_contents">
										<input id="advance_contents_1" name="advance_contents" type="radio" value="1" <?php checked( 1, $advance_contents ); ?> />
										<label for="advance_contents_1" <?php checked( 1, $advance_contents ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="advance_contents_0" name="advance_contents" type="radio" value="0" <?php checked( 0, $advance_contents ); ?> />
										<label for="advance_contents_0" <?php checked( 0, $advance_contents ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="advance_contents_tr advance_contents_settings">
								<?php wtl_lite_setting_left( esc_html__( 'Stoppage From', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display content stoppage from', 'timeline-designer' ); ?></span></span>
									<?php $contents_stopage_from = isset( $wtl_settings['contents_stopage_from'] ) ? $wtl_settings['contents_stopage_from'] : 'paragraph'; ?>
									<select name="contents_stopage_from" id="contents_stopage_from">
										<option value="paragraph" <?php selected( $contents_stopage_from, 'paragraph' ); ?> ><?php esc_html_e( 'Last Paragraph', 'timeline-designer' ); ?></option>
										<option value="character" <?php selected( $contents_stopage_from, 'character' ); ?>><?php esc_html_e( 'Characters', 'timeline-designer' ); ?></option>
									</select>
									<div class="wp-timeline-setting-description wp-timeline-note">
										<b class="note"><?php esc_html_e( 'Note', 'timeline-designer' ); ?>:</b> &nbsp;
										<?php esc_html_e( 'If "Display HTML tags with Summary" is Enable then Stoppage From Characters option is disable.', 'timeline-designer' ); ?>
									</div>
								</div>
							</li>
							<li class="advance_contents_settings_character">
								<?php wtl_lite_setting_left( esc_html__( 'Stoppage Characters', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-select"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select display content stoppage characters', 'timeline-designer' ); ?></span></span>
									<?php $contents_stopage_character = isset( $wtl_settings['contents_stopage_character'] ) ? $wtl_settings['contents_stopage_character'] : array( '.' ); ?>
									<select data-placeholder="<?php esc_attr_e( 'Choose stoppage characters', 'timeline-designer' ); ?>" class="chosen-select" multiple style="width:220px;" name="contents_stopage_character[]" id="contents_stopage_character">
										<option value="." <?php echo ( in_array( '.', $contents_stopage_character, true ) ) ? 'selected="selected"' : ''; ?>> . </option>
										<option value="?" <?php echo ( in_array( '?', $contents_stopage_character, true ) ) ? 'selected="selected"' : ''; ?>> ? </option>
										<option value="," <?php echo ( in_array( ',', $contents_stopage_character, true ) ) ? 'selected="selected"' : ''; ?>> , </option>
										<option value=";" <?php echo ( in_array( ';', $contents_stopage_character, true ) ) ? 'selected="selected"' : ''; ?>> ; </option>
										<option value=":" <?php echo ( in_array( ':', $contents_stopage_character, true ) ) ? 'selected="selected"' : ''; ?>> : </option>
									</select>
								</div>
							</li>
							<li class="contentcolor_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Post Content Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post content color', 'timeline-designer' ); ?></span></span>
									<?php $template_contentcolor = isset( $wtl_settings['template_contentcolor'] ) ? $wtl_settings['template_contentcolor'] : ''; ?>
									<input type="text" name="template_contentcolor" id="template_contentcolor" value="<?php echo esc_attr( $template_contentcolor ); ?>"/>
								</div>
							</li>
							<li>
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Post Content Typography Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post content font family', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php
											if ( isset( $wtl_settings['content_font_family'] ) && '' != $wtl_settings['content_font_family'] ) {
												$content_font_family = $wtl_settings['content_font_family'];
											} else {
												$content_font_family = '';
											}
											?>
											<div class="typo-field">
												<input type="hidden" id="content_font_family_font_type" name="content_font_family_font_type" value="<?php echo isset( $wtl_settings['content_font_family_font_type'] ) ? esc_attr( $wtl_settings['content_font_family_font_type'] ) : ''; ?>">
												<div class="select-cover">
													<select name="content_font_family" id="content_font_family">
														<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
														<?php
														$old_version = '';
														$cnt         = 0;
														$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
														foreach ( $font_family as $key => $value ) {
															if ( $value['version'] != $old_version ) {
																if ( $cnt > 0 ) {
																	echo '</optgroup>';
																}
																echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																$old_version = $value['version'];
															}
															echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
															if ( '' != $content_font_family && ( str_replace( '"', '', $content_font_family ) == str_replace( '"', '', $value['label'] ) ) ) {
																echo ' selected';
															}
															echo '>' . esc_attr( $value['label'] ) . '</option>';
															$cnt++;
														}
														if ( count( $font_family ) == $cnt ) {
															echo '</optgroup>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size for post content', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="grid_col_space range_slider_fontsize" id="content_fontsize_slider" data-value="<?php echo esc_attr( $wtl_settings['content_fontsize'] ); ?>"></div>
											<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="content_fontsize" id="content_fontsize" value="<?php echo esc_attr( $wtl_settings['content_fontsize'] ); ?>" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font weight', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $content_font_weight = isset( $wtl_settings['content_font_weight'] ) ? $wtl_settings['content_font_weight'] : 'normal'; ?>
											<div class="select-cover">
												<select name="content_font_weight" id="content_font_weight">
													<option value="100" <?php selected( $content_font_weight, 100 ); ?>>100</option>
													<option value="200" <?php selected( $content_font_weight, 200 ); ?>>200</option>
													<option value="300" <?php selected( $content_font_weight, 300 ); ?>>300</option>
													<option value="400" <?php selected( $content_font_weight, 400 ); ?>>400</option>
													<option value="500" <?php selected( $content_font_weight, 500 ); ?>>500</option>
													<option value="600" <?php selected( $content_font_weight, 600 ); ?>>600</option>
													<option value="700" <?php selected( $content_font_weight, 700 ); ?>>700</option>
													<option value="800" <?php selected( $content_font_weight, 800 ); ?>>800</option>
													<option value="900" <?php selected( $content_font_weight, 900 ); ?>>900</option>
													<option value="bold" <?php selected( $content_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
													<option value="normal" <?php selected( $content_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter line height', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="content_font_line_height" id="content_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['content_font_line_height'] ) ? esc_attr( $wtl_settings['content_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)"></div></div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display italic font style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $content_font_italic = isset( $wtl_settings['content_font_italic'] ) ? $wtl_settings['content_font_italic'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
												<input id="content_font_italic_1" name="content_font_italic" type="radio" value="1"  <?php checked( 1, $content_font_italic ); ?> />
												<label for="content_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="content_font_italic_0" name="content_font_italic" type="radio" value="0" <?php checked( 0, $content_font_italic ); ?> />
												<label for="content_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text transform style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $content_font_text_transform = isset( $wtl_settings['content_font_text_transform'] ) ? $wtl_settings['content_font_text_transform'] : 'none'; ?>
												<div class="select-cover">
													<select name="content_font_text_transform" id="content_font_text_transform">
														<option <?php selected( $content_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
														<option <?php selected( $content_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
														<option <?php selected( $content_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
														<option <?php selected( $content_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
														<option <?php selected( $content_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
													</select>
												</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text decoration style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $content_font_text_decoration = isset( $wtl_settings['content_font_text_decoration'] ) ? $wtl_settings['content_font_text_decoration'] : 'none'; ?>
											<div class="select-cover">
												<select name="content_font_text_decoration" id="content_font_text_decoration">
													<option <?php selected( $content_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $content_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
													<option <?php selected( $content_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
													<option <?php selected( $content_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter letter spacing', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="content_font_letter_spacing" id="content_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['content_font_letter_spacing'] ) ? esc_attr( $wtl_settings['content_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
									</div>
								</div>
							</li>

							<li class="display_read_more_link">
								<?php wtl_lite_setting_left( esc_html__( 'Display Read More Link', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable to show read more post link', 'timeline-designer' ); ?></span></span>
									<?php $read_more_link = isset( $wtl_settings['read_more_link'] ) ? $wtl_settings['read_more_link'] : '1'; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-read_more_link buttonset buttonset-hide ui-buttonset">
										<input id="read_more_link_1" name="read_more_link" type="radio" value="1" <?php checked( 1, $read_more_link ); ?> />
										<label for="read_more_link_1" <?php checked( 1, $read_more_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="read_more_link_0" name="read_more_link" type="radio" value="0" <?php checked( 0, $read_more_link ); ?> />
										<label for="read_more_link_0" <?php checked( 0, $read_more_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="display_read_more_on read_more_wrap">
								<?php wtl_lite_setting_left( esc_html__( 'Display Read More On', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select option for display read more button where to display', 'timeline-designer' ); ?></span></span>
									<?php $read_more_on = isset( $wtl_settings['read_more_on'] ) ? $wtl_settings['read_more_on'] : '2'; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-read_more_on buttonset buttonset-hide ui-buttonset green">
										<input id="read_more_on_1" name="read_more_on" type="radio" value="1" <?php checked( 1, $read_more_on ); ?> />
										<label id="wp-timeline-options-button" for="read_more_on_1" <?php checked( 1, $read_more_on ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Same Line', 'timeline-designer' ); ?></label>
										<input id="read_more_on_2" name="read_more_on" type="radio" value="2" <?php checked( 2, $read_more_on ); ?> />
										<label id="wp-timeline-options-button" for="read_more_on_2" <?php checked( 2, $read_more_on ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Next Line', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="read_more_text read_more_wrap">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Text', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter read more text label', 'timeline-designer' ); ?></span></span>
									<input type="text" name="txtReadmoretext" id="txtReadmoretext" value="<?php echo esc_attr( $wtl_settings['txtReadmoretext'] ); ?>" placeholder="Enter read more text">
								</div>
							</li>

							<li class="read_more_wrap">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Link', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more link type.', 'timeline-designer' ); ?></span></span>
									<?php $post_link_type = isset( $wtl_settings['post_link_type'] ) ? $wtl_settings['post_link_type'] : '0'; ?>
									<fieldset class="wp-timeline-post_link_type buttonset buttonset-hide green" data-hide='1'>
										<input id="post_link_type_0" name="post_link_type" type="radio" value="0" <?php checked( 0, $post_link_type ); ?> />
										<label id="wp-timeline-options-button" for="post_link_type_0" <?php checked( 0, $post_link_type ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Post Link', 'timeline-designer' ); ?></label>
										<input id="post_link_type_1" name="post_link_type" type="radio" value="1" <?php checked( 1, $post_link_type ); ?> />
										<label id="wp-timeline-options-button" for="post_link_type_1" <?php checked( 1, $post_link_type ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Custom Link', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="read_more_wrap custom_link_url">
								<?php wtl_lite_setting_left( esc_html__( 'Custom Link URL', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter custom link url.', 'timeline-designer' ); ?></span></span>
									<?php $custom_link_url = isset( $wtl_settings['custom_link_url'] ) ? $wtl_settings['custom_link_url'] : ''; ?>
									<input type="text" name="custom_link_url" id="custom_link_url" value="<?php echo esc_attr( $custom_link_url ); ?>" placeholder="<?php esc_html_e( 'eg.', 'timeline-designer' ) . ' ' . get_site_url(); ?>" />
								</div>
							</li>
							<li class="read_more_wrap read_more_button_alignment_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Alignment', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button alignment', 'timeline-designer' ); ?></span></span>
									<?php
									$readmore_button_alignment = 'left';
									if ( isset( $wtl_settings['readmore_button_alignment'] ) ) {
										$readmore_button_alignment = $wtl_settings['readmore_button_alignment'];
									}
									?>
									<fieldset class="buttonset green" data-hide='1'>
										<input id="readmore_button_alignment_left" name="readmore_button_alignment" type="radio" value="left" <?php checked( 'left', $readmore_button_alignment ); ?> />
										<label id="wp-timeline-options-button" for="readmore_button_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
										<input id="readmore_button_alignment_center" name="readmore_button_alignment" type="radio" value="center" <?php checked( 'center', $readmore_button_alignment ); ?> />
										<label id="wp-timeline-options-button" for="readmore_button_alignment_center" class="readmore_button_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
										<input id="readmore_button_alignment_right" name="readmore_button_alignment" type="radio" value="right" <?php checked( 'right', $readmore_button_alignment ); ?> />
										<label id="wp-timeline-options-button" for="readmore_button_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="read_more_wrap read_more_text_color">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Text Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more text color', 'timeline-designer' ); ?></span></span>
									<?php $template_readmorecolor = isset( $wtl_settings['template_readmorecolor'] ) ? $wtl_settings['template_readmorecolor'] : ''; ?>
									<input type="text" name="template_readmorecolor" id="template_readmorecolor" value="<?php echo esc_attr( $template_readmorecolor ); ?>"/>
								</div>
							</li>
							<li class="read_more_wrap read_more_hover_text_color">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Hover Text Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
								<?php $template_readmorehovercolor = isset( $wtl_settings['template_readmorehovercolor'] ) ? $wtl_settings['template_readmorehovercolor'] : ''; ?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more hover text color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="template_readmorehovercolor" id="template_readmorehovercolor" value="<?php echo esc_attr( $template_readmorehovercolor ); ?>"/>
								</div>
							</li>
							<li class="read_more_wrap read_more_text_background">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Text Background Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more text background color', 'timeline-designer' ); ?></span></span>
									<?php $template_readmorebackcolor = isset( $wtl_settings['template_readmorebackcolor'] ) ? $wtl_settings['template_readmorebackcolor'] : ''; ?>
									<input type="text" name="template_readmorebackcolor" id="template_readmorebackcolor" value="<?php echo esc_attr( $template_readmorebackcolor ); ?>"/>
								</div>
							</li>
							<li class="read_more_wrap read_more_text_hover_background">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Text Hover Background Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more text hover background color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="template_readmore_hover_backcolor" id="template_readmore_hover_backcolor" value="<?php echo ( isset( $wtl_settings['template_readmore_hover_backcolor'] ) && '' != $wtl_settings['template_readmore_hover_backcolor'] ) ? esc_attr( $wtl_settings['template_readmore_hover_backcolor'] ) : ''; ?>"/>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Border Style', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button border type', 'timeline-designer' ); ?></span></span>
									<?php $read_more_button_border_style = isset( $wtl_settings['read_more_button_border_style'] ) ? $wtl_settings['read_more_button_border_style'] : 'solid'; ?>
									<select name="read_more_button_border_style" id="read_more_button_border_style">
										<option value="none" <?php selected( $read_more_button_border_style, 'none' ); ?>><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
										<option value="dotted" <?php selected( $read_more_button_border_style, 'dotted' ); ?>><?php esc_html_e( 'Dotted', 'timeline-designer' ); ?></option>
										<option value="dashed" <?php selected( $read_more_button_border_style, 'dashed' ); ?>><?php esc_html_e( 'Dashed', 'timeline-designer' ); ?></option>
										<option value="solid" <?php selected( $read_more_button_border_style, 'solid' ); ?>><?php esc_html_e( 'Solid', 'timeline-designer' ); ?></option>
										<option value="double" <?php selected( $read_more_button_border_style, 'double' ); ?>><?php esc_html_e( 'Double', 'timeline-designer' ); ?></option>
										<option value="groove" <?php selected( $read_more_button_border_style, 'groove' ); ?>><?php esc_html_e( 'Groove', 'timeline-designer' ); ?></option>
										<option value="ridge" <?php selected( $read_more_button_border_style, 'ridge' ); ?>><?php esc_html_e( 'Ridge', 'timeline-designer' ); ?></option>
										<option value="inset" <?php selected( $read_more_button_border_style, 'inset' ); ?>><?php esc_html_e( 'Inset', 'timeline-designer' ); ?></option>
										<option value="outset" <?php selected( $read_more_button_border_style, 'outset' ); ?> ><?php esc_html_e( 'Outset', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_radius_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Border Radius(px)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button border radius', 'timeline-designer' ); ?></span></span>
									<?php $readmore_button_border_radius = isset( $wtl_settings['readmore_button_border_radius'] ) ? $wtl_settings['readmore_button_border_radius'] : '0'; ?>
									<div class="input-type-number">
										<input type="number" id="readmore_button_border_radius" name="readmore_button_border_radius" step="1" min="0" value="<?php echo esc_attr( $readmore_button_border_radius ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Border', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-border-cover">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button border', 'timeline-designer' ); ?></span></span>
									<div class="wp-timeline-border-wrap">
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label">
													<span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span>
												</div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_borderleft = isset( $wtl_settings['wp_timeline_readmore_button_borderleft'] ) ? $wtl_settings['wp_timeline_readmore_button_borderleft'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_borderleft" name="wp_timeline_readmore_button_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_borderleftcolor = isset( $wtl_settings['wp_timeline_readmore_button_borderleftcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_borderleftcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_borderleftcolor" id="wp_timeline_readmore_button_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderleftcolor ); ?>"/>
												</div>
											</div>
										</div> 
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label">
													<span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span>
												</div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_borderright = isset( $wtl_settings['wp_timeline_readmore_button_borderright'] ) ? $wtl_settings['wp_timeline_readmore_button_borderright'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_borderright" name="wp_timeline_readmore_button_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderright ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
												<?php $wp_timeline_readmore_button_borderrightcolor = isset( $wtl_settings['wp_timeline_readmore_button_borderrightcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_borderrightcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_borderrightcolor" id="wp_timeline_readmore_button_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderrightcolor ); ?>"/>
												</div>
											</div>
										</div>
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label">
													<span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span>
												</div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_bordertop = isset( $wtl_settings['wp_timeline_readmore_button_bordertop'] ) ? $wtl_settings['wp_timeline_readmore_button_bordertop'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_bordertop" name="wp_timeline_readmore_button_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_bordertop ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_bordertopcolor = isset( $wtl_settings['wp_timeline_readmore_button_bordertopcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_bordertopcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_bordertopcolor" id="wp_timeline_readmore_button_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_bordertopcolor ); ?>"/>
												</div>
											</div>
										</div>
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label">
													<span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span>
												</div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_borderbottom = isset( $wtl_settings['wp_timeline_readmore_button_borderbottom'] ) ? $wtl_settings['wp_timeline_readmore_button_borderbottom'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_borderbottom" name="wp_timeline_readmore_button_borderbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderbottom ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
												<?php $wp_timeline_readmore_button_borderbottomcolor = isset( $wtl_settings['wp_timeline_readmore_button_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_borderbottomcolor'] : ''; ?>
												<input type="text" name="wp_timeline_readmore_button_borderbottomcolor" id="wp_timeline_readmore_button_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_borderbottomcolor ); ?>"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Hover Border Style', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button hover border type', 'timeline-designer' ); ?></span></span>
									<?php $read_more_button_hover_border_style = isset( $wtl_settings['read_more_button_hover_border_style'] ) ? $wtl_settings['read_more_button_hover_border_style'] : 'solid'; ?>
									<select name="read_more_button_hover_border_style" id="read_more_button_hover_border_style">
										<option value="none" <?php selected( $read_more_button_hover_border_style, 'none' ); ?>><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
										<option value="dotted" <?php selected( $read_more_button_hover_border_style, 'dotted' ); ?>><?php esc_html_e( 'Dotted', 'timeline-designer' ); ?></option>
										<option value="dashed" <?php selected( $read_more_button_hover_border_style, 'dashed' ); ?>><?php esc_html_e( 'Dashed', 'timeline-designer' ); ?></option>
										<option value="solid" <?php selected( $read_more_button_hover_border_style, 'solid' ); ?>><?php esc_html_e( 'Solid', 'timeline-designer' ); ?></option>
										<option value="double" <?php selected( $read_more_button_hover_border_style, 'double' ); ?>><?php esc_html_e( 'Double', 'timeline-designer' ); ?></option>
										<option value="groove" <?php selected( $read_more_button_hover_border_style, 'groove' ); ?>><?php esc_html_e( 'Groove', 'timeline-designer' ); ?></option>
										<option value="ridge" <?php selected( $read_more_button_hover_border_style, 'ridge' ); ?>><?php esc_html_e( 'Ridge', 'timeline-designer' ); ?></option>
										<option value="inset" <?php selected( $read_more_button_hover_border_style, 'inset' ); ?>><?php esc_html_e( 'Inset', 'timeline-designer' ); ?></option>
										<option value="outset" <?php selected( $read_more_button_hover_border_style, 'outset' ); ?> ><?php esc_html_e( 'Outset', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_radius_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Hover Button Border Radius(px)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more hover button border radius', 'timeline-designer' ); ?></span></span>
									<?php $readmore_button_hover_border_radius = isset( $wtl_settings['readmore_button_hover_border_radius'] ) ? $wtl_settings['readmore_button_hover_border_radius'] : '0'; ?>
									<div class="input-type-number">
										<input type="number" id="readmore_button_hover_border_radius" name="readmore_button_hover_border_radius" step="1" min="0" value="<?php echo esc_attr( $readmore_button_hover_border_radius ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Hover Button Border', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-border-cover">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more hover button border', 'timeline-designer' ); ?></span></span>
									<div class="wp-timeline-border-wrap">
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label">
													<span class="wp-timeline-key-title">
														<?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?>
													</span>
												</div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_borderleft = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderleft'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderleft'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_hover_borderleft" name="wp_timeline_readmore_button_hover_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_borderleftcolor = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderleftcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderleftcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_hover_borderleftcolor" id="wp_timeline_readmore_button_hover_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderleftcolor ); ?>"/>
												</div>
											</div>
										</div> 
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_borderright = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderright'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderright'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_hover_borderright" name="wp_timeline_readmore_button_hover_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderright ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
												<?php $wp_timeline_readmore_button_hover_borderrightcolor = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderrightcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderrightcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_hover_borderrightcolor" id="wp_timeline_readmore_button_hover_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderrightcolor ); ?>"/>
												</div>
											</div>
										</div>
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_bordertop = isset( $wtl_settings['wp_timeline_readmore_button_hover_bordertop'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_bordertop'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_hover_bordertop" name="wp_timeline_readmore_button_hover_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_bordertop ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_bordertopcolor = isset( $wtl_settings['wp_timeline_readmore_button_hover_bordertopcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_bordertopcolor'] : ''; ?>
													<input type="text" name="wp_timeline_readmore_button_hover_bordertopcolor" id="wp_timeline_readmore_button_hover_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_bordertopcolor ); ?>"/>
												</div>
											</div>
										</div>
										<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
											<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-border-cover">
												<div class="wp-timeline-border-content">
													<?php $wp_timeline_readmore_button_hover_borderbottom = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderbottom'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderbottom'] : '0'; ?>
													<div class="input-type-number">
														<input type="number" id="wp_timeline_readmore_button_hover_borderbottom" name="wp_timeline_readmore_button_hover_borderbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderbottom ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="wp-timeline-border-cover wp-timeline-color-picker">
												<div class="wp-timeline-border-content">
												<?php $wp_timeline_readmore_button_hover_borderbottomcolor = isset( $wtl_settings['wp_timeline_readmore_button_hover_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_readmore_button_hover_borderbottomcolor'] : ''; ?>
												<input type="text" name="wp_timeline_readmore_button_hover_borderbottomcolor" id="wp_timeline_readmore_button_hover_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderbottomcolor ); ?>"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>							
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button padding', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-border-cover">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set read more button padding', 'timeline-designer' ); ?></span></span>
									<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_paddingleft = isset( $wtl_settings['readmore_button_paddingleft'] ) ? $wtl_settings['readmore_button_paddingleft'] : '10'; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_paddingleft" name="readmore_button_paddingleft" step="1" min="0" value="<?php echo esc_attr( $readmore_button_paddingleft ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_paddingright = isset( $wtl_settings['readmore_button_paddingright'] ) ? $wtl_settings['readmore_button_paddingright'] : '10'; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_paddingright" name="readmore_button_paddingright" step="1" min="0" value="<?php echo esc_attr( $readmore_button_paddingright ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_paddingtop = isset( $wtl_settings['readmore_button_paddingtop'] ) ? $wtl_settings['readmore_button_paddingtop'] : '10'; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_paddingtop" name="readmore_button_paddingtop" step="1" min="0" value="<?php echo esc_attr( $readmore_button_paddingtop ); ?>"  onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_paddingbottom = isset( $wtl_settings['readmore_button_paddingbottom'] ) ? $wtl_settings['readmore_button_paddingbottom'] : '10'; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_paddingbottom" name="readmore_button_paddingbottom" step="1" min="0" value="<?php echo esc_attr( $readmore_button_paddingbottom ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="read_more_wrap read_more_button_border_setting">
								<?php wtl_lite_setting_left( esc_html__( 'Read More Button Margin', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-border-cover">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set read more button margin', 'timeline-designer' ); ?></span></span>
									<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_marginleft = isset( $wtl_settings['readmore_button_marginleft'] ) ? $wtl_settings['readmore_button_marginleft'] : 0; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_marginleft" name="readmore_button_marginleft" step="1" value="<?php echo esc_attr( $readmore_button_marginleft ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_marginright = isset( $wtl_settings['readmore_button_marginright'] ) ? $wtl_settings['readmore_button_marginright'] : 0; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_marginright" name="readmore_button_marginright" step="1" value="<?php echo esc_attr( $readmore_button_marginright ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_margintop = isset( $wtl_settings['readmore_button_margintop'] ) ? $wtl_settings['readmore_button_margintop'] : 0; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_margintop" name="readmore_button_margintop" step="1" value="<?php echo esc_attr( $readmore_button_margintop ); ?>"  onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $readmore_button_marginbottom = isset( $wtl_settings['readmore_button_marginbottom'] ) ? $wtl_settings['readmore_button_marginbottom'] : 0; ?>
												<div class="input-type-number">
													<input type="number" id="readmore_button_marginbottom" name="readmore_button_marginbottom" step="1" value="<?php echo esc_attr( $readmore_button_marginbottom ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>

							<li class="read_more_wrap read_more_text_typography_setting">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Read More Typography Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Font Family', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select read more button font family', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php
											if ( isset( $wtl_settings['readmore_font_family'] ) && '' != $wtl_settings['readmore_font_family'] ) {
												$readmore_font_family = $wtl_settings['readmore_font_family'];
											} else {
												$readmore_font_family = '';
											}
											?>
											<div class="typo-field">
												<input type="hidden" id="readmore_font_family_font_type" name="readmore_font_family_font_type" value="<?php echo isset( $wtl_settings['readmore_font_family_font_type'] ) ? esc_attr( $wtl_settings['readmore_font_family_font_type'] ) : ''; ?>">
												<div class="select-cover">
													<select name="readmore_font_family" id="readmore_font_family">
														<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
														<?php
														$old_version = '';
														$cnt         = 0;
														$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
														foreach ( $font_family as $key => $value ) {
															if ( $value['version'] != $old_version ) {
																if ( $cnt > 0 ) {
																	echo '</optgroup>';
																}
																echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																$old_version = $value['version'];
															}
															echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";

															if ( '' != $readmore_font_family && ( str_replace( '"', '', $readmore_font_family ) == str_replace( '"', '', $value['label'] ) ) ) {
																echo ' selected';
															}
															echo '>' . esc_attr( $value['label'] ) . '</option>';
															$cnt++;
														}
														if ( count( $font_family ) == $cnt ) {
															echo '</optgroup>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font size for read more button', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
										<?php $readmore_fontsize = isset( $wtl_settings['readmore_fontsize'] ) ? $wtl_settings['readmore_fontsize'] : '14'; ?>
											<div class="grid_col_space range_slider_fontsize" id="readmore_fontsize_slider" data-value="<?php echo esc_attr( $readmore_fontsize ); ?>"></div>
											<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="readmore_fontsize" id="readmore_fontsize" value="<?php echo esc_attr( $readmore_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select font weight', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $readmore_font_weight = isset( $wtl_settings['readmore_font_weight'] ) ? $wtl_settings['readmore_font_weight'] : 'normal'; ?>
											<div class="select-cover">
												<select name="readmore_font_weight" id="readmore_font_weight">
													<option value="100" <?php selected( $readmore_font_weight, 100 ); ?>>100</option>
													<option value="200" <?php selected( $readmore_font_weight, 200 ); ?>>200</option>
													<option value="300" <?php selected( $readmore_font_weight, 300 ); ?>>300</option>
													<option value="400" <?php selected( $readmore_font_weight, 400 ); ?>>400</option>
													<option value="500" <?php selected( $readmore_font_weight, 500 ); ?>>500</option>
													<option value="600" <?php selected( $readmore_font_weight, 600 ); ?>>600</option>
													<option value="700" <?php selected( $readmore_font_weight, 700 ); ?>>700</option>
													<option value="800" <?php selected( $readmore_font_weight, 800 ); ?>>800</option>
													<option value="900" <?php selected( $readmore_font_weight, 900 ); ?>>900</option>
													<option value="bold" <?php selected( $readmore_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
													<option value="normal" <?php selected( $readmore_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter line height', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number"><input type="number" name="readmore_font_line_height" id="readmore_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['readmore_font_line_height'] ) ? esc_attr( $wtl_settings['readmore_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)"></div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display italic font style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $readmore_font_italic = isset( $wtl_settings['readmore_font_italic'] ) ? $wtl_settings['readmore_font_italic'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
												<input id="readmore_font_italic_1" name="readmore_font_italic" type="radio" value="1"  <?php checked( 1, $readmore_font_italic ); ?> />
												<label for="readmore_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="readmore_font_italic_0" name="readmore_font_italic" type="radio" value="0" <?php checked( 0, $readmore_font_italic ); ?> />
												<label for="readmore_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title">
											<?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?>
											</span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text transform style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $readmore_font_text_transform = isset( $wtl_settings['readmore_font_text_transform'] ) ? $wtl_settings['readmore_font_text_transform'] : 'none'; ?>
											<div class="select-cover">
												<select name="readmore_font_text_transform" id="readmore_font_text_transform">
													<option <?php selected( $readmore_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text decoration style', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $readmore_font_text_decoration = isset( $wtl_settings['readmore_font_text_decoration'] ) ? $wtl_settings['readmore_font_text_decoration'] : 'none'; ?>
											<div class="select-cover">
												<select name="readmore_font_text_decoration" id="readmore_font_text_decoration">
													<option <?php selected( $readmore_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
													<option <?php selected( $readmore_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter letter spacing', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<div class="input-type-number"><input type="number" name="readmore_font_letter_spacing" id="readmore_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['readmore_font_letter_spacing'] ) ? esc_attr( $wtl_settings['readmore_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="wp_timeline_content_box" class="postbox postbox-with-fw-options wp-timeline-content-setting1" style='<?php echo esc_attr( $wtl_content_box_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight wp-timeline-display-typography">
							<li class="wp-timeline-post-border">
								<?php wtl_lite_setting_left( esc_html__( 'Content Box border', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
								<?php
								$wp_timeline_content_border_width = ( isset( $wtl_settings['wp_timeline_content_border_width'] ) && ! empty( $wtl_settings['wp_timeline_content_border_width'] ) ) ? $wtl_settings['wp_timeline_content_border_width'] : '0';
								$wp_timeline_content_border_style = ( isset( $wtl_settings['wp_timeline_content_border_style'] ) && ! empty( $wtl_settings['wp_timeline_content_border_style'] ) ) ? $wtl_settings['wp_timeline_content_border_style'] : 'normal';
								$wp_timeline_content_border_color = ( isset( $wtl_settings['wp_timeline_content_border_color'] ) && ! empty( $wtl_settings['wp_timeline_content_border_color'] ) ) ? $wtl_settings['wp_timeline_content_border_color'] : '#ffffff';
								?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select number of post offset to display on blog page', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="wp_timeline_content_border_width" name="wp_timeline_content_border_width" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_content_border_width ); ?>" placeholder="<?php esc_attr_e( 'Enter Border', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
									<select name="wp_timeline_content_border_style" id="wp_timeline_content_border_style">
										<option value="none" <?php selected( $wp_timeline_content_border_style, 'none' ); ?>><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
										<option value="dotted" <?php selected( $wp_timeline_content_border_style, 'dotted' ); ?>><?php esc_html_e( 'Dotted', 'timeline-designer' ); ?></option>
										<option value="dashed" <?php selected( $wp_timeline_content_border_style, 'dashed' ); ?>><?php esc_html_e( 'Dashed', 'timeline-designer' ); ?></option>
										<option value="solid" <?php selected( $wp_timeline_content_border_style, 'solid' ); ?>><?php esc_html_e( 'Solid', 'timeline-designer' ); ?></option>
										<option value="double" <?php selected( $wp_timeline_content_border_style, 'double' ); ?>><?php esc_html_e( 'Double', 'timeline-designer' ); ?></option>
										<option value="groove" <?php selected( $wp_timeline_content_border_style, 'groove' ); ?>><?php esc_html_e( 'Groove', 'timeline-designer' ); ?></option>
										<option value="ridge" <?php selected( $wp_timeline_content_border_style, 'ridge' ); ?>><?php esc_html_e( 'Ridge', 'timeline-designer' ); ?></option>
										<option value="inset" <?php selected( $wp_timeline_content_border_style, 'inset' ); ?>><?php esc_html_e( 'Inset', 'timeline-designer' ); ?></option>
										<option value="outset" <?php selected( $wp_timeline_content_border_style, 'outset' ); ?> ><?php esc_html_e( 'Outset', 'timeline-designer' ); ?></option>
									</select>
									<input type="text" name="wp_timeline_content_border_color" id="wp_timeline_content_border_color" value="<?php echo esc_attr( $wp_timeline_content_border_color ); ?>" data-default-color="<?php echo esc_attr( $wp_timeline_content_border_color ); ?>"/>
								</div>
							</li>

							<li class="wp-timeline-post-border-radius">
								<?php wtl_lite_setting_left( esc_html__( 'Content Box Border Radius', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
								<?php $wp_timeline_content_border_radius = ( isset( $wtl_settings['wp_timeline_content_border_radius'] ) && ! empty( $wtl_settings['wp_timeline_content_border_radius'] ) ) ? $wtl_settings['wp_timeline_content_border_radius'] : '0'; ?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select content box border radious ', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="wp_timeline_content_border_radius" name="wp_timeline_content_border_radius" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_content_border_radius ); ?>" placeholder="<?php esc_attr_e( 'Enter post offset', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li class="blog-templatebgcolor-tr">
								<?php wtl_lite_setting_left( esc_html__( 'Content Box Background Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Content Box Background Color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="content_box_bg_color" id="content_box_bg_color" value="<?php echo isset( $wtl_settings['content_box_bg_color'] ) ? esc_attr( $wtl_settings['content_box_bg_color'] ) : '#ffffff'; ?>"/>
								</div>
							</li>
							<li class="addtocart_button_hover_box_shadow_setting">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Content Box Shadow Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
									<div class="wp-timeline-boxshadow-cover">
										<div class="wp-timeline-boxshadow-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-boxshadow-content">
											<?php $wp_timeline_top_content_box_shadow = isset( $wtl_settings['wp_timeline_top_content_box_shadow'] ) ? $wtl_settings['wp_timeline_top_content_box_shadow'] : '0'; ?>
											<div class="input-type-number">
												<input type="number" id="wp_timeline_top_content_box_shadow" name="wp_timeline_top_content_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_top_content_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="wp-timeline-boxshadow-cover">
										<div class="wp-timeline-boxshadow-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-boxshadow-content">
											<?php $wp_timeline_right_content_box_shadow = isset( $wtl_settings['wp_timeline_right_content_box_shadow'] ) ? $wtl_settings['wp_timeline_right_content_box_shadow'] : '0'; ?>
											<div class="input-type-number">
												<input type="number" id="wp_timeline_right_content_box_shadow" name="wp_timeline_right_content_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_right_content_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="wp-timeline-boxshadow-cover">
										<div class="wp-timeline-boxshadow-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-boxshadow-content">
											<?php $wp_timeline_bottom_content_box_shadow = isset( $wtl_settings['wp_timeline_bottom_content_box_shadow'] ) ? $wtl_settings['wp_timeline_bottom_content_box_shadow'] : '0'; ?>
											<div class="input-type-number">
												<input type="number" id="wp_timeline_bottom_content_box_shadow" name="wp_timeline_bottom_content_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_bottom_content_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="wp-timeline-boxshadow-cover">
										<div class="wp-timeline-boxshadow-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-boxshadow-content">
											<?php $wp_timeline_left_content_box_shadow = isset( $wtl_settings['wp_timeline_left_content_box_shadow'] ) ? $wtl_settings['wp_timeline_left_content_box_shadow'] : '0'; ?>
											<div class="input-type-number">
												<input type="number" id="wp_timeline_left_content_box_shadow" name="wp_timeline_left_content_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_left_content_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
										<div class="wp-timeline-boxshadow-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
											<?php $wp_timeline_content_box_shadow_color = isset( $wtl_settings['wp_timeline_content_box_shadow_color'] ) ? $wtl_settings['wp_timeline_content_box_shadow_color'] : ''; ?>
											<input type="text" name="wp_timeline_content_box_shadow_color" id="wp_timeline_content_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_content_box_shadow_color ); ?>"/>
										</div>
									</div>
								</div>
							</li>
							<li class="">
								<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-border-cover">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set box padding', 'timeline-designer' ); ?></span></span>
									<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $wp_timeline_content_padding_leftright = isset( $wtl_settings['wp_timeline_content_padding_leftright'] ) ? $wtl_settings['wp_timeline_content_padding_leftright'] : '0'; ?>
												<div class="input-type-number">
													<input type="number" id="wp_timeline_content_padding_leftright" name="wp_timeline_content_padding_leftright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_content_padding_leftright ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="wp-timeline-padding-cover">
											<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
											<div class="wp-timeline-padding-content">
												<?php $wp_timeline_content_padding_topbottom = isset( $wtl_settings['wp_timeline_content_padding_topbottom'] ) ? $wtl_settings['wp_timeline_content_padding_topbottom'] : '0'; ?>
												<div class="input-type-number">
													<input type="number" id="wp_timeline_content_padding_topbottom" name="wp_timeline_content_padding_topbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_content_padding_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="wp_timeline_settings" class="postbox postbox-with-fw-options wp-timeline-content-setting1" style='<?php echo esc_attr( $wp_timeline_settings_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight wp-timeline-display-typography">
							<li class="timeline_line_width">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline Line Width', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
								<?php $timeline_line_width = ( isset( $wtl_settings['timeline_line_width'] ) && ! empty( $wtl_settings['timeline_line_width'] ) ) ? $wtl_settings['timeline_line_width'] : '4'; ?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set Timeline Line width', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" id="timeline_line_width" name="timeline_line_width" step="1" min="0" value="<?php echo esc_attr( $timeline_line_width ); ?>" placeholder="<?php esc_attr_e( 'Enter Line width', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
									</div>
								</div>
							</li>
							<li class="timeline_style_type timeline_style pro-feature">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline Style', 'timeline-designer' ), esc_html__( 'PRO', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select Timeline Style', 'timeline-designer' ); ?></span></span>
									<select id="" name="">
										<option value="0" selected="selected"><?php esc_html_e( 'Default Design', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="timeline_style_view timeline_style pro-feature">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline Style View', 'timeline-designer' ), esc_html__( 'PRO', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Timeline Layout View', 'timeline-designer' ); ?></span></span>
									<fieldset class="buttonset ui-buttonset green" data-hide='1'>
											<input id="timeline_style_view_center" name="" type="radio" value="center" checked="checked"/>
											<label id="wp-timeline-options-button" for="timeline_style_view_center" class="timeline_style_view_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
											<input id="timeline_style_view_minima" name="" type="radio" value="minima" />
											<label id="wp-timeline-options-button" for="timeline_style_view_minima" class="timeline_style_view_minima"><?php esc_html_e( 'Minima', 'timeline-designer' ); ?></label>
											<input id="timeline_style_view_left" name="" type="radio" value="left"/>
											<label id="wp-timeline-options-button" for="timeline_style_view_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
											<input id="timeline_style_view_right" name="" type="radio" value="right"/>
											<label id="wp-timeline-options-button" for="timeline_style_view_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="timeline_animation timeline_style">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline Animation', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Animation on timeline style', 'timeline-designer' ); ?></span></span>
									<?php $post_status = isset( $wtl_settings['timeline_animation'] ) ? $wtl_settings['timeline_animation'] : 'fade'; ?>
									<select id="timeline_animation" name="timeline_animation">
										<option value="fade" <?php echo selected( 'fade', $post_status ); ?>><?php esc_html_e( 'Fade', 'timeline-designer' ); ?></option>
										<option value="zoom-in" <?php echo selected( 'zoom-in', $post_status ); ?>><?php esc_html_e( 'Zoom In', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="timeline-icon-border-radious pro-feature">
								<?php wtl_lite_setting_left( esc_html__( 'Timeline Icons Border Radius (%)', 'timeline-designer' ), esc_html__( 'PRO', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set Timeline Border Radious', 'timeline-designer' ); ?></span></span>
									<div class="grid_col_space range_slider_fontsize" id="template_icon_border_radiousInput" data-value="50" ></div>
									<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="" id="template_icon_border_radious" value="50" /></div>
								</div>
							</li>
							<li class="template-color">
								<?php wtl_lite_setting_left( esc_html__( 'Template Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post template color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="template_color" id="template_color" value="<?php echo isset( $wtl_settings['template_color'] ) ? esc_attr( $wtl_settings['template_color'] ) : '#000000'; ?>"/>
								</div>
							</li>
							<!-- Template Timeline Color -->
							<li class="story-s-text">
								<?php wtl_lite_setting_left( esc_html__( 'Story Startup Text', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter timeline startup text', 'timeline-designer' ); ?></span></span>
									<input type="text" name="story_startup_text" id="story_startup_text" value="<?php echo isset( $wtl_settings['story_startup_text'] ) ? esc_attr( $wtl_settings['story_startup_text'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Timeline Startup Text', 'timeline-designer' ); ?>">
								</div>
							</li>
							<li class="story-e-text">
								<?php wtl_lite_setting_left( esc_html__( 'Story Ending Text', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter timeline ending text', 'timeline-designer' ); ?></span></span>
									<input type="text" name="story_ending_text" id="story_ending_text" value="<?php echo isset( $wtl_settings['story_ending_text'] ) ? esc_attr( $wtl_settings['story_ending_text'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Timeline Ending Text', 'timeline-designer' ); ?>">
								</div>
							</li>
							<li class="hide_timeline_icon_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Hide Timeline Icon', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show/Hide Timeline Icon', 'timeline-designer' ); ?></span></span>
									<?php $hide_timeline_icon = ( isset( $wtl_settings['hide_timeline_icon'] ) ) ? $wtl_settings['hide_timeline_icon'] : 0; ?>
									<fieldset class="buttonset hide_timeline_icon">
										<input id="hide_timeline_icon_1" name="hide_timeline_icon" type="radio" value="1" <?php checked( 1, $hide_timeline_icon ); ?> />
										<label for="hide_timeline_icon_1" <?php checked( 1, $hide_timeline_icon ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="hide_timeline_icon_0" name="hide_timeline_icon" type="radio" value="0" <?php checked( 0, $hide_timeline_icon ); ?> />
										<label for="hide_timeline_icon_0" <?php checked( 0, $hide_timeline_icon ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="display_layout_type">
								<?php wtl_lite_setting_left( esc_html__( 'Layout Type', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select Layout View Horizontal or Vertical', 'timeline-designer' ); ?></span></span>
									<?php $layout_type = isset( $wtl_settings['layout_type'] ) ? $wtl_settings['layout_type'] : '2'; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-layout_type buttonset buttonset-hide ui-buttonset green">
										<input id="layout_type_1" name="layout_type" type="radio" value="1" <?php checked( 1, $layout_type ); ?> />
										<label id="wp-timeline-options-button" for="layout_type_1" <?php checked( 1, $layout_type ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Horizontal Layout', 'timeline-designer' ); ?></label>
										<input id="layout_type_2" name="layout_type" type="radio" value="2" <?php checked( 2, $layout_type ); ?> />
										<label id="wp-timeline-options-button" for="layout_type_2" <?php checked( 2, $layout_type ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Vertical Layout', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="wp_timeline_media" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_media_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li class="display_image_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Enable Media', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable post media', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_enable_media = isset( $wtl_settings['wp_timeline_enable_media'] ) ? $wtl_settings['wp_timeline_enable_media'] : '1'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_enable_media_1" name="wp_timeline_enable_media" type="radio" value="1" <?php checked( 1, $wp_timeline_enable_media ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_enable_media_1" <?php checked( 1, $wp_timeline_enable_media ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_enable_media_0" name="wp_timeline_enable_media" type="radio" value="0" <?php checked( 0, $wp_timeline_enable_media ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_enable_media_0" <?php checked( 0, $wp_timeline_enable_media ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="display_image_tr wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Post Image Link', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show post image link', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_post_image_link = isset( $wtl_settings['wp_timeline_post_image_link'] ) ? $wtl_settings['wp_timeline_post_image_link'] : '1'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_post_image_link_1" name="wp_timeline_post_image_link" type="radio" value="1" <?php checked( 1, $wp_timeline_post_image_link ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_image_link_1" <?php checked( 1, $wp_timeline_post_image_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_post_image_link_0" name="wp_timeline_post_image_link" type="radio" value="0" <?php checked( 0, $wp_timeline_post_image_link ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_post_image_link_0" <?php checked( 0, $wp_timeline_post_image_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wp-timeline-image-hover-effect display_image_tr  wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Post Image Hover Effect', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable image hover effect', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_image_hover_effect = isset( $wtl_settings['wp_timeline_image_hover_effect'] ) ? $wtl_settings['wp_timeline_image_hover_effect'] : '0'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_image_hover_effect_1" name="wp_timeline_image_hover_effect" type="radio" value="1" <?php checked( 1, $wp_timeline_image_hover_effect ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_image_hover_effect_1" <?php checked( 1, $wp_timeline_image_hover_effect ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_image_hover_effect_0" name="wp_timeline_image_hover_effect" type="radio" value="0" <?php checked( 0, $wp_timeline_image_hover_effect ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_image_hover_effect_0" <?php checked( 0, $wp_timeline_image_hover_effect ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wp-timeline-image-hover-effect-tr wp-timeline-image-hover-effect display_image_tr wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Select Post Image Hover Effect', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select image hover effect', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_image_hover_effect_type = isset( $wtl_settings['wp_timeline_image_hover_effect_type'] ) ? $wtl_settings['wp_timeline_image_hover_effect_type'] : 'zoom_in'; ?>
									<select name="wp_timeline_image_hover_effect_type" id="wp_timeline_image_hover_effect_type">
										<option value="blur" <?php echo ( 'blur' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Blur', 'timeline-designer' ); ?></option>
										<option value="flashing" <?php echo ( 'flashing' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Flashing', 'timeline-designer' ); ?></option>
										<option value="gray_scale" <?php echo ( 'gray_scale' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Gray Scale', 'timeline-designer' ); ?></option>
										<option value="opacity" <?php echo ( 'opacity' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Opacity', 'timeline-designer' ); ?></option>
										<option value="sepia" <?php echo ( 'sepia' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Sepia', 'timeline-designer' ); ?></option>
										<option value="slide" <?php echo ( 'slide' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Slide', 'timeline-designer' ); ?></option>
										<option value="shine" <?php echo ( 'shine' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Shine', 'timeline-designer' ); ?></option>
										<option value="shine_circle" <?php echo ( 'shine_circle' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Shine Circle', 'timeline-designer' ); ?></option>
										<option value="zoom_in" <?php echo ( 'zoom_in' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Zoom In', 'timeline-designer' ); ?></option>
										<option value="zoom_out" <?php echo ( 'zoom_out' === $wp_timeline_image_hover_effect_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Zoom Out', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="display_image_tr wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Select Post Default Image', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post default image', 'timeline-designer' ); ?></span></span>
									<span class="wp_timeline_default_image_holder">
										<?php
										if ( isset( $wtl_settings['wp_timeline_default_image_src'] ) && '' != $wtl_settings['wp_timeline_default_image_src'] ) {
											echo '<img src="' . esc_url( $wtl_settings['wp_timeline_default_image_src'] ) . '"/>';
										}
										?>
									</span>
									<?php if ( isset( $wtl_settings['wp_timeline_default_image_src'] ) && '' != $wtl_settings['wp_timeline_default_image_src'] ) { ?>
										<input id="wp-timeline-image-action-button" class="button wp-timeline-remove_image_button" type="button" value="<?php esc_attr_e( 'Remove Image', 'timeline-designer' ); ?>">
									<?php } else { ?>
										<input class="button wp-timeline-upload_image_button" type="button" value="<?php esc_attr_e( 'Upload Image', 'timeline-designer' ); ?>">
									<?php } ?>
									<input type="hidden" value="<?php echo isset( $wtl_settings['wp_timeline_default_image_id'] ) ? esc_attr( $wtl_settings['wp_timeline_default_image_id'] ) : ''; ?>" name="wp_timeline_default_image_id" id="wp_timeline_default_image_id">
									<input type="hidden" value="<?php echo isset( $wtl_settings['wp_timeline_default_image_src'] ) ? esc_attr( $wtl_settings['wp_timeline_default_image_src'] ) : ''; ?>" name="wp_timeline_default_image_src" id="wp_timeline_default_image_src">
								</div>
							</li>
							<li class="wp_timeline_media_size_tr display_image_tr wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Select Post Media Size', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select size of post media', 'timeline-designer' ); ?></span></span>
									<select id="wp_timeline_media_size" name="wp_timeline_media_size">
										<option value="full" <?php echo ( isset( $wtl_settings['wp_timeline_media_size'] ) && 'full' == $wtl_settings['wp_timeline_media_size'] ) ? 'selected="selected"' : ''; ?> ><?php esc_html_e( 'Original Resolution', 'timeline-designer' ); ?></option>
										<?php
										global $_wp_additional_image_sizes;
										$thumb_sizes = array();
										$image_size  = get_intermediate_image_sizes();
										foreach ( $image_size as $image_s ) {
											$thumb_sizes [ $image_s ] = array( 0, 0 );
											if ( in_array( $image_s, array( 'thumbnail', 'medium', 'large' ), true ) ) {
												?>
												<option value="<?php echo esc_attr( $image_s ); ?>" <?php echo ( isset( $wtl_settings['wp_timeline_media_size'] ) && $wtl_settings['wp_timeline_media_size'] == $image_s ) ? 'selected="selected"' : ''; ?>> <?php echo esc_attr( $image_s ) . ' (' . esc_html( get_option( $image_s . '_size_w' ) ) . 'x' . esc_html( get_option( $image_s . '_size_h' ) ) . ')'; ?> </option>
												<?php
											} else {
												if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $image_s ] ) ) {
													?>
													<option value="<?php echo esc_attr( $image_s ); ?>" <?php echo ( isset( $wtl_settings['wp_timeline_media_size'] ) && $wtl_settings['wp_timeline_media_size'] == $image_s ) ? 'selected="selected"' : ''; ?>> <?php echo esc_html( $image_s ) . ' (' . esc_html( $_wp_additional_image_sizes[ $image_s ]['width'] ) . 'x' . esc_html( $_wp_additional_image_sizes[ $image_s ]['height'] ) . ')'; ?> </option>
													<?php
												}
											}
										}
										?>
										<option value="custom" <?php echo ( isset( $wtl_settings['wp_timeline_media_size'] ) && 'custom' === $wtl_settings['wp_timeline_media_size'] ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Custom Size', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="wp_timeline_media_custom_size_tr display_image_tr wtl_mdsfild">
								<?php wtl_lite_setting_left( esc_html__( 'Add Cutom Size', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter custom size for post media', 'timeline-designer' ); ?></span></span>
									<div class="wp_timeline_media_custom_size_tbl">
										<span class="wp_timeline_custom_media_size_title">
											<?php
											esc_html_e( 'Width', 'timeline-designer' );
											echo ' (px)';
											?>
										</span>
										<div class="input-type-number">
											<input type="number" min="1" name="media_custom_width" class="media_custom_width" id="media_custom_width" value="<?php echo ( isset( $wtl_settings['media_custom_width'] ) && '' != $wtl_settings['media_custom_width'] ) ? esc_attr( $wtl_settings['media_custom_width'] ) : ''; ?>" />
										</div>
										<span class="wp_timeline_custom_media_size_title" style="margin-left: 40px;">
											<?php
											esc_html_e( 'Height', 'timeline-designer' );
											echo ' (px)';
											?>
										</span>
										<div class="input-type-number">
											<input type="number" min="1" 	name="media_custom_height" class="media_custom_height" id="media_custom_height" value="<?php echo ( isset( $wtl_settings['media_custom_height'] ) && '' != $wtl_settings['media_custom_height'] ) ? esc_attr( $wtl_settings['media_custom_height'] ) : ''; ?>"/>
										</div>
									</div>
								</div>
							</li>
							<li class="lazy_load_tr lazy_load_section_li">
								<?php wtl_lite_setting_left( esc_html__( 'Enable Lazy Load Image', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable Lazy Load Image', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_lazy_load_image = isset( $wtl_settings['wp_timeline_lazy_load_image'] ) ? $wtl_settings['wp_timeline_lazy_load_image'] : '1'; ?>
									<fieldset class="buttonset ui-buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_lazy_load_image_1" name="wp_timeline_lazy_load_image" type="radio" value="1" <?php checked( 1, $wp_timeline_lazy_load_image ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_lazy_load_image_1" class="<?php echo esc_html( $uic_l ); ?>" <?php checked( 1, $wp_timeline_lazy_load_image ); ?>><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_lazy_load_image_0" name="wp_timeline_lazy_load_image" type="radio" value="0" <?php checked( 0, $wp_timeline_lazy_load_image ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_lazy_load_image_0" class="<?php echo esc_html( $uic_r ); ?>" <?php checked( 0, $wp_timeline_lazy_load_image ); ?>><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="lazy_load_blurred_tr lazy_load_blurred_section_li">
								<?php wtl_lite_setting_left( esc_html__( 'Enable Lazy Load Blurred Image', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable Lazy Load Blurred Image', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_lazy_load_blurred_image = isset( $wtl_settings['wp_timeline_lazy_load_blurred_image'] ) ? $wtl_settings['wp_timeline_lazy_load_blurred_image'] : '1'; ?>
									<fieldset class="buttonset ui-buttonset buttonset-hide" data-hide='1'>
										<input id="wp_timeline_lazy_load_blurred_image_1" name="wp_timeline_lazy_load_blurred_image" type="radio" value="1" <?php checked( 1, $wp_timeline_lazy_load_blurred_image ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_lazy_load_blurred_image_1" class="<?php echo esc_html( $uic_l ); ?>" <?php checked( 1, $wp_timeline_lazy_load_blurred_image ); ?>><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="wp_timeline_lazy_load_blurred_image_0" name="wp_timeline_lazy_load_blurred_image" type="radio" value="0" <?php checked( 0, $wp_timeline_lazy_load_blurred_image ); ?> />
										<label id="wp-timeline-options-button" for="wp_timeline_lazy_load_blurred_image_0" class="<?php echo esc_html( $uic_r ); ?>" <?php checked( 0, $wp_timeline_lazy_load_blurred_image ); ?>><?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="lazy_load_color_tr lazy_load_color_section_li">
								<?php wtl_lite_setting_left( esc_html__( 'Select Lazy Load Color', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right wp-timeline-color-picker">
								<?php $template_lazyload_color = ( isset( $wtl_settings['template_lazyload_color'] ) && ! empty( $wtl_settings['template_lazyload_color'] ) ) ? $wtl_settings['template_lazyload_color'] : ''; ?>
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select lazy load color', 'timeline-designer' ); ?></span></span>
									<input type="text" name="template_lazyload_color" id="template_lazyload_color" value="<?php	echo esc_attr( $template_lazyload_color ); ?> "/>
								</div>
							</li>
						</ul>
					</div>
				</div>	
				<div id="wp_timeline" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings">
							<li class="wtl_hz_ts wtl_hz_ts_1">
								<?php wtl_lite_setting_left( esc_html__( 'Display Timeline Bar', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display timeline bar on blog layout', 'timeline-designer' ); ?></span></span>
									<?php $display_timeline_bar = isset( $wtl_settings['display_timeline_bar'] ) ? $wtl_settings['display_timeline_bar'] : ''; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-display_timeline_bar buttonset buttonset-hide ui-buttonset" data-hide="1">
										<input id="display_timeline_bar_0" name="display_timeline_bar" class="display_timeline_bar" type="radio" value="0" <?php checked( 0, $display_timeline_bar ); ?> />
										<label for="display_timeline_bar_0" <?php checked( 0, $display_timeline_bar ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="display_timeline_bar_1" name="display_timeline_bar" class="display_timeline_bar" type="radio" value="1" <?php checked( 1, $display_timeline_bar ); ?> />
										<label for="display_timeline_bar_1" <?php checked( 1, $display_timeline_bar ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_2">
								<?php wtl_lite_setting_left( esc_html__( 'Active Post', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right active_post_list">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post to start timeline layout with some specific post', 'timeline-designer' ); ?></span></span>
									<?php
									$timeline_start_from = ( isset( $wtl_settings['timeline_start_from'] ) && '' != $wtl_settings['timeline_start_from'] ) ? $wtl_settings['timeline_start_from'] : '';
									$post_type_hori      = isset( $wtl_settings['custom_post_type'] ) ? $wtl_settings['custom_post_type'] : 'post';
									global $post;
									$wtl_timeline_args      = array(
										'cache_results' => false,
										'no_found_rows' => true,
										'showposts'     => '-1',
										'orderby'       => 'post_date',
										'order'         => 'ASC',
										'post_status'   => 'publish',
										'post_type'     => $post_type_hori,
									);
									$wtl_timeline_the_query = get_posts( $wtl_timeline_args );
									if ( $wtl_timeline_the_query ) {
										echo '<select name="timeline_start_from" id="timeline_start_from">';
										foreach ( $wtl_timeline_the_query as $posta ) {
											setup_postdata( $posta );
											$post__id = get_the_ID();
											?>
											<option value="<?php echo esc_attr( get_the_date( 'd/m/Y', $post__id ) ); ?>" <?php echo ( get_the_date( 'd/m/Y', $post__id ) ) == $timeline_start_from ? 'selected="selected"' : ''; ?>><?php echo esc_html( get_the_title( $post__id ) ); ?></option>
											<?php
										}
										wp_reset_postdata();
										echo '</select>';
									} else {
										echo '<p>';
										esc_html__( 'No posts found', 'timeline-designer' );
										echo '</p>';
									}
									?>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_3">
								<?php wtl_lite_setting_left( esc_html__( 'Posts Effect', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select the transition effect for blog layout', 'timeline-designer' ); ?></span></span>
									<?php $template_easing = isset( $wtl_settings['template_easing'] ) ? $wtl_settings['template_easing'] : 'easeInQuad'; ?>
									<select name="template_easing" id="template_easing">
										<option value="easeInQuad" <?php echo 'easeInQuad' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInQuad', 'timeline-designer' ); ?></option>
										<option value="easeOutQuad" <?php echo 'easeOutQuad' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutQuad', 'timeline-designer' ); ?></option>
										<option value="easeInOutQuad" <?php echo 'easeInOutQuad' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutQuad', 'timeline-designer' ); ?></option>
										<option value="easeInCubic" <?php echo 'easeInCubic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInCubic', 'timeline-designer' ); ?></option>
										<option value="easeOutCubic" <?php echo 'easeInCubic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInCubic', 'timeline-designer' ); ?></option>
										<option value="easeInOutCubic" <?php echo 'easeInOutCubic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutCubic', 'timeline-designer' ); ?></option>
										<option value="easeInQuart" <?php echo 'easeInQuart' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInQuart', 'timeline-designer' ); ?></option>
										<option value="easeOutQuart" <?php echo 'easeOutQuart' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutQuart', 'timeline-designer' ); ?></option>
										<option value="easeInOutQuart" <?php echo 'easeInOutQuart' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutQuart', 'timeline-designer' ); ?></option>
										<option value="easeInQuint" <?php echo 'easeInQuint' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInQuint', 'timeline-designer' ); ?></option>
										<option value="easeOutQuint" <?php echo 'easeOutQuint' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutQuint', 'timeline-designer' ); ?></option>
										<option value="easeInOutQuint" <?php echo 'easeInOutQuint' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutQuint', 'timeline-designer' ); ?></option>
										<option value="easeInSine" <?php echo 'easeInSine' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInSine', 'timeline-designer' ); ?></option>
										<option value="easeOutSine" <?php echo 'easeOutSine' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutSine', 'timeline-designer' ); ?></option>
										<option value="easeInOutSine" <?php echo 'easeInOutSine' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutSine', 'timeline-designer' ); ?></option>
										<option value="easeInExpo" <?php echo 'easeInExpo' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInExpo', 'timeline-designer' ); ?></option>
										<option value="easeOutExpo" <?php echo 'easeOutExpo' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutExpo', 'timeline-designer' ); ?></option>
										<option value="easeInOutExpo" <?php echo 'easeInOutExpo' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutExpo', 'timeline-designer' ); ?></option>
										<option value="easeInCirc" <?php echo 'easeInCirc' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInCirc', 'timeline-designer' ); ?></option>
										<option value="easeOutCirc" <?php echo 'easeOutCirc' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutCirc', 'timeline-designer' ); ?></option>
										<option value="easeInOutCirc" <?php echo 'easeInOutCirc' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutCirc', 'timeline-designer' ); ?></option>
										<option value="easeOutCirc" <?php echo 'easeOutCirc' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutCirc', 'timeline-designer' ); ?></option>
										<option value="easeInOutCirc" <?php echo 'easeInOutCirc' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutCirc', 'timeline-designer' ); ?></option>
										<option value="easeInElastic" <?php echo 'easeInElastic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInElastic', 'timeline-designer' ); ?></option>
										<option value="easeOutElastic" <?php echo 'easeOutElastic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutElastic', 'timeline-designer' ); ?></option>
										<option value="easeInOutElastic" <?php echo 'easeInOutElastic' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutElastic', 'timeline-designer' ); ?></option>
										<option value="easeInBack" <?php echo 'easeInBack' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInBack', 'timeline-designer' ); ?></option>
										<option value="easeOutBack" <?php echo 'easeOutBack' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutBack', 'timeline-designer' ); ?></option>
										<option value="easeInOutBack" <?php echo 'easeInOutBack' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutBack', 'timeline-designer' ); ?></option>
										<option value="easeInBounce" <?php echo 'easeInBounce' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInBounce', 'timeline-designer' ); ?></option>
										<option value="easeOutBounce" <?php echo 'easeOutBounce' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeOutBounce', 'timeline-designer' ); ?></option>
										<option value="easeInOutBounce" <?php echo 'easeInOutBounce' === $template_easing ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'easeInOutBounce', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_4">
								<?php wtl_lite_setting_left( esc_html__( 'Post Width (px)', 'timeline-designer' ) ); ?>                                
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select the width of the post', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" name="item_width" id="item_width" min="100" max="1100" step="1" onblur="if (this.value <= 100)(this.value = 100)" value="<?php echo ( isset( $wtl_settings['item_width'] ) ? esc_attr( $wtl_settings['item_width'] ) : 400 ); ?>">
									</div>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_5">
								<?php wtl_lite_setting_left( esc_html__( 'Item Height (px)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select the height of the post', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" name="item_height" id="item_height" min="100" max="1100" step="1" onblur="if (this.value <= 100)(this.value = 100)" value="<?php echo ( isset( $wtl_settings['item_height'] ) ? esc_attr( $wtl_settings['item_height'] ) : 570 ); ?>">
									</div>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_6">
								<?php wtl_lite_setting_left( esc_html__( 'Margin between Blog Post (px)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select the margin for post', 'timeline-designer' ); ?></span></span>
									<?php $template_post_margin = ( isset( $wtl_settings['template_post_margin'] ) && '' != $wtl_settings['template_post_margin'] ) ? $wtl_settings['template_post_margin'] : 20; ?>
									<div class="grid_col_space range_slider_fontsize" id="template_template_post_marginInput" data-value="<?php echo esc_attr( $template_post_margin ); ?>" ></div>
									<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="template_post_margin" id="template_post_margin" value="<?php echo esc_attr( $template_post_margin ); ?>" /></div>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_7">
								<?php wtl_lite_setting_left( esc_html__( 'Enable Autoslide', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable autoslide', 'timeline-designer' ); ?></span></span>
									<?php $enable_autoslide = ( ( isset( $wtl_settings['enable_autoslide'] ) && '' != $wtl_settings['enable_autoslide'] ) ) ? $wtl_settings['enable_autoslide'] : 1; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-enable_autoslide buttonset buttonset-hide ui-buttonset" data-hide="1">
										<input id="enable_autoslide_1" name="enable_autoslide" class="enable_autoslide" type="radio" value="1" <?php checked( 1, $enable_autoslide ); ?> />
										<label for="enable_autoslide_1" <?php checked( 1, $enable_autoslide ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="enable_autoslide_0" name="enable_autoslide" class="enable_autoslide" type="radio" value="0" <?php checked( 0, $enable_autoslide ); ?> />
										<label for="enable_autoslide_0" <?php checked( 0, $enable_autoslide ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_8 scroll_speed_tr">
								<?php wtl_lite_setting_left( esc_html__( 'Scrolling Speed(ms)', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select the slide speed', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" name="scroll_speed" id="scroll_speed" min="500" step="100" onblur="if (this.value <= 500) (this.value = 500)" value="<?php echo ( isset( $wtl_settings['scroll_speed'] ) ? esc_attr( $wtl_settings['scroll_speed'] ) : 1000 ); ?>" onkeypress="return isNumberKey(event)" >
									</div>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_9">
								<?php wtl_lite_setting_left( esc_html__( 'Number of Navigation Item', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Number of Navigation Item', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" name="noof_slider_nav_itme" id="noof_slider_nav_itme" min="1" max="12" step="1" onblur="if (this.value <= 2)(this.value = 2)" value="<?php echo ( isset( $wtl_settings['noof_slider_nav_itme'] ) ? esc_attr( $wtl_settings['noof_slider_nav_itme'] ) : 2 ); ?>" onkeypress="return isNumberKey(event)" >
									</div>
								</div>
							</li>
							<li class="wtl_hz_ts wtl_hz_ts_10">
								<?php wtl_lite_setting_left( esc_html__( 'Number of Slide', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Number of Slides', 'timeline-designer' ); ?></span></span>
									<div class="input-type-number">
										<input type="number" name="noof_slide" id="noof_slide" min="1" max="4" step="1" onblur="if (this.value <= 1)(this.value = 1)" value="<?php echo ( isset( $wtl_settings['noof_slide'] ) ? esc_attr( $wtl_settings['noof_slide'] ) : 1 ); ?>" onkeypress="return isNumberKey(event)" >
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- Pagination Section -->
				<div id="wp_timeline_pagination" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_pagination_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li class="wp_timeline_pagination_type">
								<?php wtl_lite_setting_left( esc_html__( 'Pagination Type', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select pagination type', 'timeline-designer' ); ?></span></span>
									<select name="pagination_type" id="pagination_type">
										<option value="no_pagination" <?php echo selected( 'no_pagination', $wtl_settings['pagination_type'] ); ?>><?php esc_html_e( 'No Pagination', 'timeline-designer' ); ?></option>
										<option value="paged" <?php echo selected( 'paged', $wtl_settings['pagination_type'] ); ?>><?php esc_html_e( 'Paged', 'timeline-designer' ); ?></option>
									</select>
								</div>
							</li>
							<li class="wp_template_pagination_template">
								<?php wtl_lite_setting_left( esc_html__( 'Pagination Template', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select pagination template', 'timeline-designer' ); ?></span></span>
									<?php $pagination_template = isset( $wtl_settings['pagination_template'] ) ? $wtl_settings['pagination_template'] : 'template-1'; ?>
									<select name="pagination_template" id="pagination_template">
										<option value="template-1" <?php echo selected( 'template-1', $pagination_template ); ?>><?php esc_html_e( 'Template 1', 'timeline-designer' ); ?></option>
										<option value="template-2" <?php echo selected( 'template-2', $pagination_template ); ?>><?php esc_html_e( 'Template 2', 'timeline-designer' ); ?></option>
										<option value="template-3" <?php echo selected( 'template-3', $pagination_template ); ?>><?php esc_html_e( 'Template 3', 'timeline-designer' ); ?></option>
										<option value="template-4" <?php echo selected( 'template-4', $pagination_template ); ?>><?php esc_html_e( 'Template 4', 'timeline-designer' ); ?></option>
									</select>
									<div class="wp-timeline-setting-description wp-timeline-setting-pagination">
										<img class="pagination_template_images"src="<?php echo esc_url( TLD_URL ) . '/images/pagination/' . esc_attr( $pagination_template ) . '.png'; ?>">
									</div>
								</div>
							</li>
							<li class="wp_template_pagination_template">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Pagination Color Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-pagination-wrapper wp-timeline-pagination-wrapper1">
									<div class="wp-timeline-pagination-cover">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_text_color = isset( $wtl_settings['pagination_text_color'] ) ? $wtl_settings['pagination_text_color'] : '#ffffff'; ?>
											<input type="text" name="pagination_text_color" id="pagination_text_color" value="<?php echo esc_attr( $pagination_text_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_text_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover wp-timeline-pagination-background-color">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Background Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select background color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_background_color = isset( $wtl_settings['pagination_background_color'] ) ? $wtl_settings['pagination_background_color'] : '#777'; ?>
											<input type="text" name="pagination_background_color" id="pagination_background_color" value="<?php echo esc_attr( $pagination_background_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_background_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Hover Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select text hover color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_text_hover_color = isset( $wtl_settings['pagination_text_hover_color'] ) ? $wtl_settings['pagination_text_hover_color'] : ''; ?>
											<input type="text" name="pagination_text_hover_color" id="pagination_text_hover_color" value="<?php echo esc_attr( $pagination_text_hover_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_text_hover_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover wp-timeline-pagination-hover-background-color">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Hover Background Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select hover background color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_background_hover_color = isset( $wtl_settings['pagination_background_hover_color'] ) ? $wtl_settings['pagination_background_hover_color'] : ''; ?>
											<input type="text" name="pagination_background_hover_color" id="pagination_background_hover_color" value="<?php echo esc_attr( $pagination_background_hover_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_background_hover_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Active Text Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select active text color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_text_active_color = isset( $wtl_settings['pagination_text_active_color'] ) ? $wtl_settings['pagination_text_active_color'] : ''; ?>
											<input type="text" name="pagination_text_active_color" id="pagination_text_active_color" value="<?php echo esc_attr( $pagination_text_active_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_text_active_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Active Background Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select active background color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_active_background_color = isset( $wtl_settings['pagination_active_background_color'] ) ? $wtl_settings['pagination_active_background_color'] : ''; ?>
											<input type="text" name="pagination_active_background_color" id="pagination_active_background_color" value="<?php echo esc_attr( $pagination_active_background_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_active_background_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover wp-timeline-pagination-border-wrap ">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"> <?php esc_html_e( 'Border Color', 'timeline-designer' ); ?> </span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select border color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_border_color = isset( $wtl_settings['pagination_border_color'] ) ? $wtl_settings['pagination_border_color'] : '#b2b2b2'; ?>
											<input type="text" name="pagination_border_color" id="pagination_border_color" value="<?php echo esc_attr( $pagination_border_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_border_color ); ?>"/>
										</div>
									</div>
									<div class="wp-timeline-pagination-cover wp-timeline-pagination-active-border-wrap">
										<div class="wp-timeline-pagination-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Active Border Color', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select active border color', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-pagination-content wp-timeline-color-picker">
											<?php $pagination_active_border_color = isset( $wtl_settings['pagination_active_border_color'] ) ? $wtl_settings['pagination_active_border_color'] : '#007acc'; ?>
											<input type="text" name="pagination_active_border_color" id="pagination_active_border_color" value="<?php echo esc_attr( $pagination_active_border_color ); ?>" data-default-color="<?php echo esc_attr( $pagination_active_border_color ); ?>"/>
										</div>
									</div>
								</div>
							</li>							
						</ul>
					</div>
				</div>
				<?php
				if ( Wp_Timeline_Lite_Main::wtl_woocommerce_plugin() ) {
					?>
					<div id="wp_timeline_productsetting" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_productsetting_class_show ); ?>'>
						<div class="inside">
							<ul class="wp-timeline-settings wp-timeline-lineheight">
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Sale Tag', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable sale tag', 'timeline-designer' ); ?></span></span>
										<?php
										$display_sale_tag = '1';
										if ( isset( $wtl_settings['display_sale_tag'] ) ) {
											$display_sale_tag = $wtl_settings['display_sale_tag'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_sale_tag_1" name="display_sale_tag" type="radio" value="1" <?php checked( 1, $display_sale_tag ); ?> />
											<label id="wp-timeline-options-button" for="display_sale_tag_1" <?php checked( 1, $display_sale_tag ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_sale_tag_0" name="display_sale_tag" type="radio" value="0" <?php checked( 0, $display_sale_tag ); ?> />
											<label id="wp-timeline-options-button" for="display_sale_tag_0" <?php checked( 1, $display_sale_tag ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_sale_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Sale Tag Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_sale_tagtext_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag text color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_sale_tagtextcolor = ( isset( $wtl_settings['wp_timeline_sale_tagtextcolor'] ) && '' != $wtl_settings['wp_timeline_sale_tagtextcolor'] ) ? $wtl_settings['wp_timeline_sale_tagtextcolor'] : ''; ?>
												<input type="text" name="wp_timeline_sale_tagtextcolor" id="wp_timeline_sale_tagtextcolor" value="<?php echo esc_attr( $wp_timeline_sale_tagtextcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_sale_tagbgcolor = ( isset( $wtl_settings['wp_timeline_sale_tagbgcolor'] ) && '' != $wtl_settings['wp_timeline_sale_tagbgcolor'] ) ? $wtl_settings['wp_timeline_sale_tagbgcolor'] : ''; ?>
												<input type="text" name="wp_timeline_sale_tagbgcolor" id="wp_timeline_sale_tagbgcolor" value="<?php echo esc_attr( $wp_timeline_sale_tagbgcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr wp_timeline_sale_tagtext_alignment_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_sale_tagtext_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_sale_tagtext_alignment'] ) ) {
													$wp_timeline_sale_tagtext_alignment = $wtl_settings['wp_timeline_sale_tagtext_alignment'];
												}
												?>
												<select name="wp_timeline_sale_tagtext_alignment" id="wp_timeline_sale_tagtext_alignment">
													<option value="left-top" <?php echo selected( 'left-top', $wp_timeline_sale_tagtext_alignment ); ?>><?php esc_html_e( 'Left Top', 'timeline-designer' ); ?></option>
													<option value="left-bottom" <?php echo selected( 'left-bottom', $wp_timeline_sale_tagtext_alignment ); ?>><?php esc_html_e( 'Left Bottom', 'timeline-designer' ); ?></option>
													<option value="right-top" <?php echo selected( 'right-top', $wp_timeline_sale_tagtext_alignment ); ?>><?php esc_html_e( 'Right Top', 'timeline-designer' ); ?></option>
													<option value="right-bottom" <?php echo selected( 'right-bottom', $wp_timeline_sale_tagtext_alignment ); ?>><?php esc_html_e( 'Right Bottom', 'timeline-designer' ); ?></option>
												</select>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr wp_timeline_sale_tagtext_alignment_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Angle(0-360 deg)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag angle', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_sale_tag_angle = isset( $wtl_settings['wp_timeline_sale_tag_angle'] ) ? $wtl_settings['wp_timeline_sale_tag_angle'] : '0'; ?>
												<div class="input-type-number"><input type="number" id="wp_timeline_sale_tag_angle" name="wp_timeline_sale_tag_angle" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tag_angle ); ?>" onkeypress="return isNumberKey(event)"></div>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr wp_timeline_sale_tagtext_alignment_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Border Radius(%)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag border radius', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_sale_tag_border_radius = isset( $wtl_settings['wp_timeline_sale_tag_border_radius'] ) ? $wtl_settings['wp_timeline_sale_tag_border_radius'] : '0'; ?>
												<div class="input-type-number"><input type="number" id="wp_timeline_sale_tag_border_radius" name="wp_timeline_sale_tag_border_radius" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tag_border_radius ); ?>" onkeypress="return isNumberKey(event)"></div>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr wp_timeline_sale_tagtext_padding_setting_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_paddingleft = isset( $wtl_settings['wp_timeline_sale_tagtext_paddingleft'] ) ? $wtl_settings['wp_timeline_sale_tagtext_paddingleft'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_paddingleft" name="wp_timeline_sale_tagtext_paddingleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_paddingleft ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_paddingright = isset( $wtl_settings['wp_timeline_sale_tagtext_paddingright'] ) ? $wtl_settings['wp_timeline_sale_tagtext_paddingright'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_paddingright" name="wp_timeline_sale_tagtext_paddingright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_paddingright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_paddingtop = isset( $wtl_settings['wp_timeline_sale_tagtext_paddingtop'] ) ? $wtl_settings['wp_timeline_sale_tagtext_paddingtop'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_paddingtop" name="wp_timeline_sale_tagtext_paddingtop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_paddingtop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_paddingbottom = isset( $wtl_settings['wp_timeline_sale_tagtext_paddingbottom'] ) ? $wtl_settings['wp_timeline_sale_tagtext_paddingbottom'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_paddingbottom" name="wp_timeline_sale_tagtext_paddingbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_paddingbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr wp_timeline_sale_tagtext_marging_setting_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag margin', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_marginleft = isset( $wtl_settings['wp_timeline_sale_tagtext_marginleft'] ) ? $wtl_settings['wp_timeline_sale_tagtext_marginleft'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_marginleft" name="wp_timeline_sale_tagtext_marginleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_marginleft ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_marginright = isset( $wtl_settings['wp_timeline_sale_tagtext_marginright'] ) ? $wtl_settings['wp_timeline_sale_tagtext_marginright'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_marginright" name="wp_timeline_sale_tagtext_marginright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_marginright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_margintop = isset( $wtl_settings['wp_timeline_sale_tagtext_margintop'] ) ? $wtl_settings['wp_timeline_sale_tagtext_margintop'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_margintop" name="wp_timeline_sale_tagtext_margintop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_margintop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_sale_tagtext_marginbottom = isset( $wtl_settings['wp_timeline_sale_tagtext_marginbottom'] ) ? $wtl_settings['wp_timeline_sale_tagtext_marginbottom'] : '5'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_sale_tagtext_marginbottom" name="wp_timeline_sale_tagtext_marginbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_sale_tagtext_marginbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_sale_tagtext_tr">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag font family', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_sale_tagfontface'] ) && '' != $wtl_settings['wp_timeline_sale_tagfontface'] ) {
															$wp_timeline_sale_tagfontface = $wtl_settings['wp_timeline_sale_tagfontface'];
														} else {
															$wp_timeline_sale_tagfontface = '';
														}
														?>
														<div class="typo-field">
															<input type="hidden" id="wp_timeline_sale_tagfontface_font_type" name="wp_timeline_sale_tagfontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_sale_tagfontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_sale_tagfontface_font_type'] ) : ''; ?>">
															<div class="select-cover">
																<select name="wp_timeline_sale_tagfontface" id="wp_timeline_sale_tagfontface">
																	<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																	<?php
																	$old_version   = '';
																	$cnt           = 0;
																	$font_family_3 = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																	if ( $font_family_3 ) {
																		foreach ( $font_family_3 as $key3 => $value3 ) {
																			if ( $value3['version'] != $old_version ) {
																				if ( $cnt > 0 ) {
																					echo '</optgroup>';
																				}
																				echo '<optgroup label="' . esc_attr( $value3['version'] ) . '">';
																				$old_version = $value3['version'];
																			}
																			echo "<option value='" . esc_attr( str_replace( '"', '', $value3['label'] ) ) . "'";
																			if ( '' != $wp_timeline_sale_tagfontface && ( str_replace( '"', '', $wp_timeline_sale_tagfontface ) == str_replace( '"', '', $value3['label'] ) ) ) {
																				echo ' selected';
																			}
																			echo '>' . esc_html( $value3['label'] ) . '</option>';
																			$cnt++;
																		}
																	}
																	if ( count( $font_family_3 ) == $cnt ) {
																		echo '</optgroup>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag font size', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_sale_tagfontsize'] ) && '' != $wtl_settings['wp_timeline_sale_tagfontsize'] ) {
															$wp_timeline_sale_tagfontsize = $wtl_settings['wp_timeline_sale_tagfontsize'];
														} else {
															$wp_timeline_sale_tagfontsize = 14;
														}
														?>
														<div class="grid_col_space range_slider_fontsize" id="wp_timeline_sale_tagfontsizeInput" ></div>
														<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_sale_tagfontsize" id="wp_timeline_sale_tagfontsize" value="<?php echo esc_attr( $wp_timeline_sale_tagfontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag font weight', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_sale_tag_font_weight = isset( $wtl_settings['wp_timeline_sale_tag_font_weight'] ) ? $wtl_settings['wp_timeline_sale_tag_font_weight'] : 'normal'; ?>
														<div class="select-cover">
															<select name="wp_timeline_sale_tag_font_weight" id="wp_timeline_sale_tag_font_weight">
																<option value="100" <?php selected( $wp_timeline_sale_tag_font_weight, 100 ); ?>>100</option>
																<option value="200" <?php selected( $wp_timeline_sale_tag_font_weight, 200 ); ?>>200</option>
																<option value="300" <?php selected( $wp_timeline_sale_tag_font_weight, 300 ); ?>>300</option>
																<option value="400" <?php selected( $wp_timeline_sale_tag_font_weight, 400 ); ?>>400</option>
																<option value="500" <?php selected( $wp_timeline_sale_tag_font_weight, 500 ); ?>>500</option>
																<option value="600" <?php selected( $wp_timeline_sale_tag_font_weight, 600 ); ?>>600</option>
																<option value="700" <?php selected( $wp_timeline_sale_tag_font_weight, 700 ); ?>>700</option>
																<option value="800" <?php selected( $wp_timeline_sale_tag_font_weight, 800 ); ?>>800</option>
																<option value="900" <?php selected( $wp_timeline_sale_tag_font_weight, 900 ); ?>>900</option>
																<option value="bold" <?php selected( $wp_timeline_sale_tag_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																<option value="normal" <?php selected( $wp_timeline_sale_tag_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag line height', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_sale_tag_font_line_height" id="wp_timeline_sale_tag_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_sale_tag_font_line_height'] ) ? esc_attr( $wtl_settings['wp_timeline_sale_tag_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)" ></div></div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display sale tag italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_sale_tag_font_italic = isset( $wtl_settings['wp_timeline_sale_tag_font_italic'] ) ? $wtl_settings['wp_timeline_sale_tag_font_italic'] : '0'; ?>
													</div>
													<div class="wp-timeline-typography-content">
														<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
															<input id="wp_timeline_sale_tag_font_italic_1" name="wp_timeline_sale_tag_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_sale_tag_font_italic ); ?> />
															<label for="wp_timeline_sale_tag_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
															<input id="wp_timeline_sale_tag_font_italic_0" name="wp_timeline_sale_tag_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_sale_tag_font_italic ); ?> />
															<label for="wp_timeline_sale_tag_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
														</fieldset>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title">
														<?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?>
														</span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag text transform style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_sale_tag_font_text_transform = isset( $wtl_settings['wp_timeline_sale_tag_font_text_transform'] ) ? $wtl_settings['wp_timeline_sale_tag_font_text_transform'] : 'none'; ?>
															<div class="select-cover">
																<select name="wp_timeline_sale_tag_font_text_transform" id="wp_timeline_sale_tag_font_text_transform">
																	<option <?php selected( $wp_timeline_sale_tag_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_sale_tag_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_sale_tag_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_sale_tag_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_sale_tag_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
																</select>
															</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select sale tag text decoration style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_sale_tag_font_text_decoration = isset( $wtl_settings['wp_timeline_sale_tag_font_text_decoration'] ) ? $wtl_settings['wp_timeline_sale_tag_font_text_decoration'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_sale_tag_font_text_decoration" id="wp_timeline_sale_tag_font_text_decoration">
																<option <?php selected( $wp_timeline_sale_tag_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_sale_tag_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_sale_tag_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_sale_tag_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter sale tag letter spacing', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_sale_tag_font_letter_spacing" id="wp_timeline_sale_tag_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_sale_tag_font_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_sale_tag_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Product Rating', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable product rating', 'timeline-designer' ); ?></span></span>
										<?php
										$display_product_rating = '0';
										if ( isset( $wtl_settings['display_product_rating'] ) ) {
											$display_product_rating = $wtl_settings['display_product_rating'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_product_rating_1" name="display_product_rating" type="radio" value="1" <?php checked( 1, $display_product_rating ); ?> />
											<label id="wp-timeline-options-button" for="display_product_rating_1" <?php checked( 1, $display_product_rating ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_product_rating_0" name="display_product_rating" type="radio" value="0" <?php checked( 0, $display_product_rating ); ?> />
											<label id="wp-timeline-options-button" for="display_product_rating_0" <?php checked( 1, $display_product_rating ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_star_rating_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Star Rating Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_star_rating_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Star Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select star rating color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_star_rating_color = ( isset( $wtl_settings['wp_timeline_star_rating_color'] ) && '' != $wtl_settings['wp_timeline_star_rating_color'] ) ? $wtl_settings['wp_timeline_star_rating_color'] : ''; ?>
												<input type="text" name="wp_timeline_star_rating_color" id="wp_timeline_star_rating_color" value="<?php echo esc_attr( $wp_timeline_star_rating_color ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_star_rating_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select star background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_star_rating_bg_color = ( isset( $wtl_settings['wp_timeline_star_rating_bg_color'] ) && '' != $wtl_settings['wp_timeline_star_rating_bg_color'] ) ? $wtl_settings['wp_timeline_star_rating_bg_color'] : ''; ?>
												<input type="text" name="wp_timeline_star_rating_bg_color" id="wp_timeline_star_rating_bg_color" value="<?php echo esc_attr( $wp_timeline_star_rating_bg_color ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_star_rating_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon "><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select star rating alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_star_rating_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_star_rating_alignment'] ) ) {
													$wp_timeline_star_rating_alignment = $wtl_settings['wp_timeline_star_rating_alignment'];
												}
												?>
												<fieldset class="buttonset green" data-hide='1'>
													<input id="wp_timeline_star_rating_alignment_left" name="wp_timeline_star_rating_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_star_rating_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_star_rating_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_star_rating_alignment_center" name="wp_timeline_star_rating_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_star_rating_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_star_rating_alignment_center" class="wp_timeline_star_rating_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_star_rating_alignment_right" name="wp_timeline_star_rating_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_star_rating_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_star_rating_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
												</fieldset>
											</div>
										</li>
										<li class="wp_timeline_star_rating_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select star rating padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_paddingleft = isset( $wtl_settings['wp_timeline_star_rating_paddingleft'] ) ? $wtl_settings['wp_timeline_star_rating_paddingleft'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_paddingleft" name="wp_timeline_star_rating_paddingleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_star_rating_paddingleft ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_paddingright = isset( $wtl_settings['wp_timeline_star_rating_paddingright'] ) ? $wtl_settings['wp_timeline_star_rating_paddingright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_paddingright" name="wp_timeline_star_rating_paddingright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_star_rating_paddingright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_paddingtop = isset( $wtl_settings['wp_timeline_star_rating_paddingtop'] ) ? $wtl_settings['wp_timeline_star_rating_paddingtop'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_paddingtop" name="wp_timeline_star_rating_paddingtop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_star_rating_paddingtop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_paddingbottom = isset( $wtl_settings['wp_timeline_star_rating_paddingbottom'] ) ? $wtl_settings['wp_timeline_star_rating_paddingbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_paddingbottom" name="wp_timeline_star_rating_paddingbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_star_rating_paddingbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_star_rating_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select star rating margin', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_marginleft = isset( $wtl_settings['wp_timeline_star_rating_marginleft'] ) ? $wtl_settings['wp_timeline_star_rating_marginleft'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_marginleft" name="wp_timeline_star_rating_marginleft" step="1" value="<?php echo esc_attr( $wp_timeline_star_rating_marginleft ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_marginright = isset( $wtl_settings['wp_timeline_star_rating_marginright'] ) ? $wtl_settings['wp_timeline_star_rating_marginright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_marginright" name="wp_timeline_star_rating_marginright" step="1" value="<?php echo esc_attr( $wp_timeline_star_rating_marginright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_margintop = isset( $wtl_settings['wp_timeline_star_rating_margintop'] ) ? $wtl_settings['wp_timeline_star_rating_margintop'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_margintop" name="wp_timeline_star_rating_margintop" step="1" value="<?php echo esc_attr( $wp_timeline_star_rating_margintop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_star_rating_marginbottom = isset( $wtl_settings['wp_timeline_star_rating_marginbottom'] ) ? $wtl_settings['wp_timeline_star_rating_marginbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_star_rating_marginbottom" name="wp_timeline_star_rating_marginbottom" step="1" value="<?php echo esc_attr( $wp_timeline_star_rating_marginbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Price', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable price', 'timeline-designer' ); ?></span></span>
										<?php
										$display_product_price = '1';
										if ( isset( $wtl_settings['display_product_price'] ) ) {
											$display_product_price = $wtl_settings['display_product_price'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_product_price_1" name="display_product_price" type="radio" value="1" <?php checked( 1, $display_product_price ); ?> />
											<label id="wp-timeline-options-button" for="display_product_price_1" <?php checked( 1, $display_product_price ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_product_price_0" name="display_product_price" type="radio" value="0" <?php checked( 0, $display_product_price ); ?> />
											<label id="wp-timeline-options-button" for="display_product_price_0" <?php checked( 1, $display_product_price ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_price_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Price Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_pricetext_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_pricetextcolor = ( isset( $wtl_settings['wp_timeline_pricetextcolor'] ) && '' != $wtl_settings['wp_timeline_pricetextcolor'] ) ? $wtl_settings['wp_timeline_pricetextcolor'] : ''; ?>
												<input type="text" name="wp_timeline_pricetextcolor" id="wp_timeline_pricetextcolor" value="<?php echo esc_attr( $wp_timeline_pricetextcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_pricetext_tr wp_timeline_pricetext_alignment_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>                                            
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_pricetext_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_pricetext_alignment'] ) ) {
													$wp_timeline_pricetext_alignment = $wtl_settings['wp_timeline_pricetext_alignment'];
												}
												?>
												<fieldset class="buttonset green" data-hide='1'>
													<input id="wp_timeline_pricetext_alignment_left" name="wp_timeline_pricetext_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_pricetext_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_pricetext_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_pricetext_alignment_center" name="wp_timeline_pricetext_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_pricetext_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_pricetext_alignment_center" class="wp_timeline_pricetext_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_pricetext_alignment_right" name="wp_timeline_pricetext_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_pricetext_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_pricetext_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
												</fieldset>
											</div>
										</li>
										<li class="wp_timeline_pricetext_tr wp_timeline_pricetext_padding_setting_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set price text padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_paddingleft = isset( $wtl_settings['wp_timeline_pricetext_paddingleft'] ) ? $wtl_settings['wp_timeline_pricetext_paddingleft'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_paddingleft" name="wp_timeline_pricetext_paddingleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_paddingleft ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_paddingright = isset( $wtl_settings['wp_timeline_pricetext_paddingright'] ) ? $wtl_settings['wp_timeline_pricetext_paddingright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_paddingright" name="wp_timeline_pricetext_paddingright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_paddingright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_paddingtop = isset( $wtl_settings['wp_timeline_pricetext_paddingtop'] ) ? $wtl_settings['wp_timeline_pricetext_paddingtop'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_paddingtop" name="wp_timeline_pricetext_paddingtop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_paddingtop ); ?>"  onkeypress="return isNumberKey(event)">
															</diV>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_paddingbottom = isset( $wtl_settings['wp_timeline_pricetext_paddingbottom'] ) ? $wtl_settings['wp_timeline_pricetext_paddingbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_paddingbottom" name="wp_timeline_pricetext_paddingbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_paddingbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_pricetext_tr wp_timeline_pricetext_marging_setting_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text margin', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_marginleft = isset( $wtl_settings['wp_timeline_pricetext_marginleft'] ) ? $wtl_settings['wp_timeline_pricetext_marginleft'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_marginleft" name="wp_timeline_pricetext_marginleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_marginleft ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_marginright = isset( $wtl_settings['wp_timeline_pricetext_marginright'] ) ? $wtl_settings['wp_timeline_pricetext_marginright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_marginright" name="wp_timeline_pricetext_marginright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_marginright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_margintop = isset( $wtl_settings['wp_timeline_pricetext_margintop'] ) ? $wtl_settings['wp_timeline_pricetext_margintop'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_margintop" name="wp_timeline_pricetext_margintop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_margintop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_pricetext_marginbottom = isset( $wtl_settings['wp_timeline_pricetext_marginbottom'] ) ? $wtl_settings['wp_timeline_pricetext_marginbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_pricetext_marginbottom" name="wp_timeline_pricetext_marginbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_pricetext_marginbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_pricetext_tr wp_timeline_pricetext_typography_setting_tr">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font family', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_pricefontface'] ) && '' != $wtl_settings['wp_timeline_pricefontface'] ) {
															$wp_timeline_pricefontface = $wtl_settings['wp_timeline_pricefontface'];
														} else {
															$wp_timeline_pricefontface = '';
														}
														?>
														<div class="typo-field">
															<input type="hidden" id="wp_timeline_pricefontface_font_type" name="wp_timeline_pricefontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_pricefontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_pricefontface_font_type'] ) : ''; ?>">
															<div class="select-cover">
																<select name="wp_timeline_pricefontface" id="wp_timeline_pricefontface">
																	<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																	<?php
																	$old_version = '';
																	$cnt         = 0;
																	$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																	foreach ( $font_family as $key => $value ) {
																		if ( $value['version'] != $old_version ) {
																			if ( $cnt > 0 ) {
																				echo '</optgroup>';
																			}
																			echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																			$old_version = $value['version'];
																		}
																		echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
																		if ( '' != $wp_timeline_pricefontface && ( str_replace( '"', '', $wp_timeline_pricefontface ) == str_replace( '"', '', $value['label'] ) ) ) {
																			echo ' selected';
																		}
																		echo '>' . esc_attr( $value['label'] ) . '</option>';
																		$cnt++;
																	}
																	if ( count( $font_family ) == $cnt ) {
																		echo '</optgroup>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font size', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_pricefontsize'] ) && '' != $wtl_settings['wp_timeline_pricefontsize'] ) {
															$wp_timeline_pricefontsize = $wtl_settings['wp_timeline_pricefontsize'];
														} else {
															$wp_timeline_pricefontsize = 14;
														}
														?>
														<div class="grid_col_space range_slider_fontsize" id="wp_timeline_pricefontsizeInput" ></div>
														<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_pricefontsize" id="wp_timeline_pricefontsize" value="<?php echo esc_attr( $wp_timeline_pricefontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font weight', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_price_font_weight = isset( $wtl_settings['wp_timeline_price_font_weight'] ) ? $wtl_settings['wp_timeline_price_font_weight'] : 'normal'; ?>
														<div class="select-cover">
															<select name="wp_timeline_price_font_weight" id="wp_timeline_price_font_weight">
																<option value="100" <?php selected( $wp_timeline_price_font_weight, 100 ); ?>>100</option>
																<option value="200" <?php selected( $wp_timeline_price_font_weight, 200 ); ?>>200</option>
																<option value="300" <?php selected( $wp_timeline_price_font_weight, 300 ); ?>>300</option>
																<option value="400" <?php selected( $wp_timeline_price_font_weight, 400 ); ?>>400</option>
																<option value="500" <?php selected( $wp_timeline_price_font_weight, 500 ); ?>>500</option>
																<option value="600" <?php selected( $wp_timeline_price_font_weight, 600 ); ?>>600</option>
																<option value="700" <?php selected( $wp_timeline_price_font_weight, 700 ); ?>>700</option>
																<option value="800" <?php selected( $wp_timeline_price_font_weight, 800 ); ?>>800</option>
																<option value="900" <?php selected( $wp_timeline_price_font_weight, 900 ); ?>>900</option>
																<option value="bold" <?php selected( $wp_timeline_price_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																<option value="normal" <?php selected( $wp_timeline_price_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text line height', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_price_font_line_height" id="wp_timeline_price_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_price_font_line_height'] ) ? esc_attr( $wtl_settings['wp_timeline_price_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)" ></div></div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display price text italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_price_font_italic = isset( $wtl_settings['wp_timeline_price_font_italic'] ) ? $wtl_settings['wp_timeline_price_font_italic'] : '0'; ?>
													</div>
													<div class="wp-timeline-typography-content">
														<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
															<input id="wp_timeline_price_font_italic_1" name="wp_timeline_price_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_price_font_italic ); ?> />
															<label for="wp_timeline_price_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
															<input id="wp_timeline_price_font_italic_0" name="wp_timeline_price_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_price_font_italic ); ?> />
															<label for="wp_timeline_price_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
														</fieldset>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text transform style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_price_font_text_transform = isset( $wtl_settings['wp_timeline_price_font_text_transform'] ) ? $wtl_settings['wp_timeline_price_font_text_transform'] : 'none'; ?>
															<div class="select-cover">
																<select name="wp_timeline_price_font_text_transform" id="wp_timeline_price_font_text_transform">
																	<option <?php selected( $wp_timeline_price_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_price_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_price_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_price_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_price_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
																</select>
															</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text decoration style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_price_font_text_decoration = isset( $wtl_settings['wp_timeline_price_font_text_decoration'] ) ? $wtl_settings['wp_timeline_price_font_text_decoration'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_price_font_text_decoration" id="wp_timeline_price_font_text_decoration">
																<option <?php selected( $wp_timeline_price_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_price_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_price_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_price_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter price text letter spacing', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_price_font_letter_spacing" id="wp_timeline_price_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_price_font_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_price_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Add To Cart Button', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable add to cart button', 'timeline-designer' ); ?></span></span>
										<?php
										$display_addtocart_button = '1';
										if ( isset( $wtl_settings['display_addtocart_button'] ) ) {
											$display_addtocart_button = $wtl_settings['display_addtocart_button'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_addtocart_button_1" name="display_addtocart_button" type="radio" value="1" <?php checked( 1, $display_addtocart_button ); ?> />
											<label id="wp-timeline-options-button" for="display_addtocart_button_1" <?php checked( 1, $display_addtocart_button ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_addtocart_button_0" name="display_addtocart_button" type="radio" value="0" <?php checked( 0, $display_addtocart_button ); ?> />
											<label id="wp-timeline-options-button" for="display_addtocart_button_0" <?php checked( 0, $display_addtocart_button ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_cart_button_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Cart Button Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_add_to_cart_tr cart_button_alignment">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_addtocartbutton_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_addtocartbutton_alignment'] ) ) {
													$wp_timeline_addtocartbutton_alignment = $wtl_settings['wp_timeline_addtocartbutton_alignment'];
												}
												?>
												<fieldset class="buttonset green" data-hide='1'>
													<input id="wp_timeline_addtocartbutton_alignment_left" name="wp_timeline_addtocartbutton_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_addtocartbutton_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_addtocartbutton_alignment_center" name="wp_timeline_addtocartbutton_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_addtocartbutton_alignment_center" class="wp_timeline_addtocartbutton_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_addtocartbutton_alignment_right" name="wp_timeline_addtocartbutton_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_addtocartbutton_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
												</fieldset>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text color', 'timeline-designer' ); ?></span></span>
												<?php
												if ( isset( $wtl_settings['wp_timeline_addtocart_textcolor'] ) ) {
													$wp_timeline_addtocart_textcolor = $wtl_settings['wp_timeline_addtocart_textcolor'];
												} else {
													$wp_timeline_addtocart_textcolor = '';
												}
												?>
												<input type="text" name="wp_timeline_addtocart_textcolor" id="wp_timeline_addtocart_textcolor" value="<?php echo esc_attr( $wp_timeline_addtocart_textcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text hover color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_addtocart_text_hover_color = isset( $wtl_settings['wp_timeline_addtocart_text_hover_color'] ) ? $wtl_settings['wp_timeline_addtocart_text_hover_color'] : ''; ?>
												<input type="text" name="wp_timeline_addtocart_text_hover_color" id="wp_timeline_addtocart_text_hover_color" value="<?php echo esc_attr( $wp_timeline_addtocart_text_hover_color ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_addtocart_backgroundcolor = isset( $wtl_settings['wp_timeline_addtocart_backgroundcolor'] ) ? $wtl_settings['wp_timeline_addtocart_backgroundcolor'] : ''; ?>
												<input type="text" name="wp_timeline_addtocart_backgroundcolor" id="wp_timeline_addtocart_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_addtocart_backgroundcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_addtocart_hover_backgroundcolor = isset( $wtl_settings['wp_timeline_addtocart_hover_backgroundcolor'] ) ? $wtl_settings['wp_timeline_addtocart_hover_backgroundcolor'] : ''; ?>
												<input type="text" name="wp_timeline_addtocart_hover_backgroundcolor" id="wp_timeline_addtocart_hover_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_addtocart_hover_backgroundcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_addtocart_button_border_setting wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Border Radius(px)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button border radius', 'timeline-designer' ); ?></span></span>
												<?php
												$display_addtocart_button_border_radius = '0';
												if ( isset( $wtl_settings['display_addtocart_button_border_radius'] ) ) {
													$display_addtocart_button_border_radius = $wtl_settings['display_addtocart_button_border_radius'];
												}
												?>
												<div class="input-type-number">
													<input type="number" id="display_addtocart_button_border_radius" name="display_addtocart_button_border_radius" step="1" min="0" value="<?php echo esc_attr( $display_addtocart_button_border_radius ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</li>
										<li class="wp_timeline_addtocart_button_border_setting wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Border', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button border', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-border-wrap">
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_borderleft = isset( $wtl_settings['wp_timeline_addtocartbutton_borderleft'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderleft'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_borderleft" name="wp_timeline_addtocartbutton_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_borderleftcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_borderleftcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderleftcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_borderleftcolor" id="wp_timeline_addtocartbutton_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderleftcolor ); ?>"/>
															</div>
														</div>
													</div> 
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_borderright = isset( $wtl_settings['wp_timeline_addtocartbutton_borderright'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderright'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_borderright" name="wp_timeline_addtocartbutton_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderright ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content wp-timeline-color-picker">
															<?php $wp_timeline_addtocartbutton_borderrightcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_borderrightcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderrightcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_borderrightcolor" id="wp_timeline_addtocartbutton_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderrightcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_bordertop = isset( $wtl_settings['wp_timeline_addtocartbutton_bordertop'] ) ? $wtl_settings['wp_timeline_addtocartbutton_bordertop'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_bordertop" name="wp_timeline_addtocartbutton_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_bordertop ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content wp-timeline-color-picker">
																<?php $wp_timeline_addtocartbutton_bordertopcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_bordertopcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_bordertopcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_bordertopcolor" id="wp_timeline_addtocartbutton_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_bordertopcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_borderbuttom = isset( $wtl_settings['wp_timeline_addtocartbutton_borderbuttom'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderbuttom'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_borderbuttom" name="wp_timeline_addtocartbutton_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderbuttom ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
															<?php $wp_timeline_addtocartbutton_borderbottomcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_borderbottomcolor'] : ''; ?>
															<input type="text" name="wp_timeline_addtocartbutton_borderbottomcolor" id="wp_timeline_addtocartbutton_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_borderbottomcolor ); ?>"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_addtocart_button_border_hover_setting wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Border Radius(px)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover border radius', 'timeline-designer' ); ?></span></span>
												<?php
												$display_addtocart_button_border_hover_radius = '0';
												if ( isset( $wtl_settings['display_addtocart_button_border_hover_radius'] ) ) {
													$display_addtocart_button_border_hover_radius = $wtl_settings['display_addtocart_button_border_hover_radius'];
												}
												?>
												<div class="input-type-number">
													<input type="number" id="display_addtocart_button_border_hover_radius" name="display_addtocart_button_border_hover_radius" step="1" min="0" value="<?php echo esc_attr( $display_addtocart_button_border_hover_radius ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</li>
										<li class="wp_timeline_addtocart_button_border_hover_setting wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Border', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover border', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-border-wrap">
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderleft = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderleft'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderleft'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_hover_borderleft" name="wp_timeline_addtocartbutton_hover_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderleftcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderleftcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderleftcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_hover_borderleftcolor" id="wp_timeline_addtocartbutton_hover_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderleftcolor ); ?>"/>
															</div>
														</div>
													</div> 
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderright = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderright'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderright'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_addtocartbutton_hover_borderright" name="wp_timeline_addtocartbutton_hover_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderright ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderrightcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderrightcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderrightcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_hover_borderrightcolor" id="wp_timeline_addtocartbutton_hover_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderrightcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_bordertop = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_bordertop'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_bordertop'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" 	id="wp_timeline_addtocartbutton_hover_bordertop" name="wp_timeline_addtocartbutton_hover_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_bordertop ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_bordertopcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_bordertopcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_bordertopcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_hover_bordertopcolor" id="wp_timeline_addtocartbutton_hover_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_bordertopcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderbuttom = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderbuttom'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderbuttom'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" 	id="wp_timeline_addtocartbutton_hover_borderbuttom" name="wp_timeline_addtocartbutton_hover_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderbuttom ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_addtocartbutton_hover_borderbottomcolor = isset( $wtl_settings['wp_timeline_addtocartbutton_hover_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_addtocartbutton_hover_borderbottomcolor'] : ''; ?>
																<input type="text" name="wp_timeline_addtocartbutton_hover_borderbottomcolor" id="wp_timeline_addtocartbutton_hover_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderbottomcolor ); ?>"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set cart button padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_addtocartbutton_padding_leftright = isset( $wtl_settings['wp_timeline_addtocartbutton_padding_leftright'] ) ? $wtl_settings['wp_timeline_addtocartbutton_padding_leftright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" 	id="wp_timeline_addtocartbutton_padding_leftright" name="wp_timeline_addtocartbutton_padding_leftright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_padding_leftright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_addtocartbutton_padding_topbottom = isset( $wtl_settings['wp_timeline_addtocartbutton_padding_topbottom'] ) ? $wtl_settings['wp_timeline_addtocartbutton_padding_topbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_addtocartbutton_padding_topbottom" name="wp_timeline_addtocartbutton_padding_topbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_padding_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set cart button margin', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_addtocartbutton_margin_leftright = isset( $wtl_settings['wp_timeline_addtocartbutton_margin_leftright'] ) ? $wtl_settings['wp_timeline_addtocartbutton_margin_leftright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_addtocartbutton_margin_leftright" name="wp_timeline_addtocartbutton_margin_leftright" step="1" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_margin_leftright ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_addtocartbutton_margin_topbottom = isset( $wtl_settings['wp_timeline_addtocartbutton_margin_topbottom'] ) ? $wtl_settings['wp_timeline_addtocartbutton_margin_topbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_addtocartbutton_margin_topbottom" name="wp_timeline_addtocartbutton_margin_topbottom" step="1" value="<?php echo esc_attr( $wp_timeline_addtocartbutton_margin_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr addtocart_button_box_shadow_setting">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Box Shadow Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_top_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_top_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_top_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_top_box_shadow" name="wp_timeline_addtocart_button_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_right_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_right_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_right_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_right_box_shadow" name="wp_timeline_addtocart_button_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_bottom_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_bottom_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_bottom_box_shadow" name="wp_timeline_addtocart_button_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_left_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_left_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_left_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_left_box_shadow" name="wp_timeline_addtocart_button_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
														<?php $wp_timeline_addtocart_button_box_shadow_color = isset( $wtl_settings['wp_timeline_addtocart_button_box_shadow_color'] ) ? $wtl_settings['wp_timeline_addtocart_button_box_shadow_color'] : ''; ?>
														<input type="text" name="wp_timeline_addtocart_button_box_shadow_color" id="wp_timeline_addtocart_button_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_addtocart_button_box_shadow_color ); ?>"/>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr addtocart_button_hover_box_shadow_setting">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Hover Box Shadow Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_hover_top_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_hover_top_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_hover_top_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" 	id="wp_timeline_addtocart_button_hover_top_box_shadow" name="wp_timeline_addtocart_button_hover_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_hover_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_hover_right_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_hover_right_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_hover_right_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_hover_right_box_shadow" name="wp_timeline_addtocart_button_hover_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_hover_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_hover_bottom_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_hover_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_hover_bottom_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_hover_bottom_box_shadow" name="wp_timeline_addtocart_button_hover_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_hover_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_addtocart_button_hover_left_box_shadow = isset( $wtl_settings['wp_timeline_addtocart_button_hover_left_box_shadow'] ) ? $wtl_settings['wp_timeline_addtocart_button_hover_left_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_addtocart_button_hover_left_box_shadow" name="wp_timeline_addtocart_button_hover_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_addtocart_button_hover_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
														<?php $wp_timeline_addtocart_button_hover_box_shadow_color = isset( $wtl_settings['wp_timeline_addtocart_button_hover_box_shadow_color'] ) ? $wtl_settings['wp_timeline_addtocart_button_hover_box_shadow_color'] : ''; ?>
														<input type="text" name="wp_timeline_addtocart_button_hover_box_shadow_color" id="wp_timeline_addtocart_button_hover_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_addtocart_button_hover_box_shadow_color ); ?>"/>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_add_to_cart_tr">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button font family', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_addtocart_button_fontface'] ) && '' != $wtl_settings['wp_timeline_addtocart_button_fontface'] ) {
															$wp_timeline_addtocart_button_fontface = $wtl_settings['wp_timeline_addtocart_button_fontface'];
														} else {
															$wp_timeline_addtocart_button_fontface = '';
														}
														?>
														<div class="typo-field">
															<input type="hidden" id="wp_timeline_addtocart_button_fontface_font_type" name="wp_timeline_addtocart_button_fontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_addtocart_button_fontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_addtocart_button_fontface_font_type'] ) : ''; ?>">
															<div class="select-cover">
																<select name="wp_timeline_addtocart_button_fontface" id="wp_timeline_addtocart_button_fontface">
																	<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																	<?php
																	$old_version = '';
																	$cnt         = 0;
																	$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																	foreach ( $font_family as $key => $value ) {
																		if ( $value['version'] != $old_version ) {
																			if ( $cnt > 0 ) {
																				echo '</optgroup>';
																			}
																			echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																			$old_version = $value['version'];
																		}
																		echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
																		if ( '' != $wp_timeline_addtocart_button_fontface && ( str_replace( '"', '', $wp_timeline_addtocart_button_fontface ) == str_replace( '"', '', $value['label'] ) ) ) {
																			echo ' selected';
																		}
																		echo '>' . esc_attr( $value['label'] ) . '</option>';
																		$cnt++;
																	}
																	if ( count( $font_family ) == $cnt ) {
																		echo '</optgroup>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button font size', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_addtocart_button_fontsize'] ) && '' != $wtl_settings['wp_timeline_addtocart_button_fontsize'] ) {
															$wp_timeline_addtocart_button_fontsize = $wtl_settings['wp_timeline_addtocart_button_fontsize'];
														} else {
															$wp_timeline_addtocart_button_fontsize = 14;
														}
														?>
														<div class="grid_col_space range_slider_fontsize" id="wp_timeline_addtocart_button_fontsizeInput" ></div>
														<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_addtocart_button_fontsize" id="wp_timeline_addtocart_button_fontsize" value="<?php echo esc_attr( $wp_timeline_addtocart_button_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button font weight', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_addtocart_button_font_weight = isset( $wtl_settings['wp_timeline_addtocart_button_font_weight'] ) ? $wtl_settings['wp_timeline_addtocart_button_font_weight'] : 'normal'; ?>
														<div class="select-cover">
															<select name="wp_timeline_addtocart_button_font_weight" id="wp_timeline_addtocart_button_font_weight">
																<option value="100" <?php selected( $wp_timeline_addtocart_button_font_weight, 100 ); ?>>100</option>
																<option value="200" <?php selected( $wp_timeline_addtocart_button_font_weight, 200 ); ?>>200</option>
																<option value="300" <?php selected( $wp_timeline_addtocart_button_font_weight, 300 ); ?>>300</option>
																<option value="400" <?php selected( $wp_timeline_addtocart_button_font_weight, 400 ); ?>>400</option>
																<option value="500" <?php selected( $wp_timeline_addtocart_button_font_weight, 500 ); ?>>500</option>
																<option value="600" <?php selected( $wp_timeline_addtocart_button_font_weight, 600 ); ?>>600</option>
																<option value="700" <?php selected( $wp_timeline_addtocart_button_font_weight, 700 ); ?>>700</option>
																<option value="800" <?php selected( $wp_timeline_addtocart_button_font_weight, 800 ); ?>>800</option>
																<option value="900" <?php selected( $wp_timeline_addtocart_button_font_weight, 900 ); ?>>900</option>
																<option value="bold" <?php selected( $wp_timeline_addtocart_button_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																<option value="normal" <?php selected( $wp_timeline_addtocart_button_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button line height', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<div class="input-type-number">
														<?php
															$display_addtocart_button_line_height = '1.5';
														if ( isset( $wtl_settings['display_addtocart_button_line_height'] ) ) {
															$display_addtocart_button_line_height = $wtl_settings['display_addtocart_button_line_height'];
														}
														?>
														<input type="number" id="display_addtocart_button_line_height" name="display_addtocart_button_line_height" step="1" min="1.5" value="<?php echo esc_attr( $display_addtocart_button_line_height ); ?>" placeholder="<?php esc_attr_e( 'Enter line height', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display cart button italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_addtocart_button_font_italic = isset( $wtl_settings['wp_timeline_addtocart_button_font_italic'] ) ? $wtl_settings['wp_timeline_addtocart_button_font_italic'] : '0'; ?>
													</div>
													<div class="wp-timeline-typography-content">
														<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
															<input id="wp_timeline_addtocart_button_font_italic_1" name="wp_timeline_addtocart_button_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_addtocart_button_font_italic ); ?> />
															<label for="wp_timeline_addtocart_button_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
															<input id="wp_timeline_addtocart_button_font_italic_0" name="wp_timeline_addtocart_button_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_addtocart_button_font_italic ); ?> />
															<label for="wp_timeline_addtocart_button_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
														</fieldset>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text transform style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_addtocart_button_font_text_transform = isset( $wtl_settings['wp_timeline_addtocart_button_font_text_transform'] ) ? $wtl_settings['wp_timeline_addtocart_button_font_text_transform'] : 'none'; ?>
															<div class="select-cover">
																<select name="wp_timeline_addtocart_button_font_text_transform" id="wp_timeline_addtocart_button_font_text_transform">
																	<option <?php selected( $wp_timeline_addtocart_button_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtocart_button_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtocart_button_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtocart_button_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtocart_button_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
																</select>
															</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text decoration style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_addtocart_button_font_text_decoration = isset( $wtl_settings['wp_timeline_addtocart_button_font_text_decoration'] ) ? $wtl_settings['wp_timeline_addtocart_button_font_text_decoration'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_addtocart_button_font_text_decoration" id="wp_timeline_addtocart_button_font_text_decoration">
																<option <?php selected( $wp_timeline_addtocart_button_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_addtocart_button_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_addtocart_button_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_addtocart_button_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter cart button letter spacing', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_addtocart_button_letter_spacing" id="wp_timeline_addtocart_button_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_addtocart_button_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_addtocart_button_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<?php
								/* YITH WCWL */
								if ( class_exists( 'YITH_WCWL' ) ) {
									?>
																				
									<li>
										<?php wtl_lite_setting_left( esc_html__( 'Display Add To Wishlist Button', 'timeline-designer' ) ); ?>
										<div class="wp-timeline-right">
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable add to wishlist button', 'timeline-designer' ); ?></span></span>
											<?php
											$display_addtowishlist_button = '0';
											if ( isset( $wtl_settings['display_addtowishlist_button'] ) ) {
												$display_addtowishlist_button = $wtl_settings['display_addtowishlist_button'];
											}
											?>
											<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
												<input id="display_addtowishlist_button_1" name="display_addtowishlist_button" type="radio" value="1" <?php checked( 1, $display_addtowishlist_button ); ?> />
												<label id="wp-timeline-options-button" for="display_addtowishlist_button_1" <?php checked( 1, $display_addtowishlist_button ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="display_addtowishlist_button_0" name="display_addtowishlist_button" type="radio" value="0" <?php checked( 0, $display_addtowishlist_button ); ?> />
												<label id="wp-timeline-options-button" for="display_addtowishlist_button_0" <?php checked( 0, $display_addtowishlist_button ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</li>
									<li class="wp_timeline_wishlist_button_setting">
										<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Wishlist Button Settings', 'timeline-designer' ); ?></h3>
										<ul>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'DisplayButton on', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show wishlist button on', 'timeline-designer' ); ?></span></span>
													<?php
													$wp_timeline_wishlistbutton_on = '1';
													if ( isset( $wtl_settings['wp_timeline_wishlistbutton_on'] ) ) {
														$wp_timeline_wishlistbutton_on = $wtl_settings['wp_timeline_wishlistbutton_on'];
													}
													?>
													<fieldset class="buttonset green" data-hide='1'>
														<input id="wp_timeline_wishlistbutton_on_same_line" name="wp_timeline_wishlistbutton_on" type="radio" value="1" <?php checked( '1', $wp_timeline_wishlistbutton_on ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_wishlistbutton_on_same_line" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Same Line', 'timeline-designer' ); ?></label>
														<input id="wp_timeline_wishlistbutton_on_next_line" name="wp_timeline_wishlistbutton_on" type="radio" value="2" <?php checked( '2', $wp_timeline_wishlistbutton_on ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_wishlistbutton_on_next_line" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Next Line', 'timeline-designer' ); ?></label>
													</fieldset>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr cart_wishlist_button_alignment">
												<?php wtl_lite_setting_left( esc_html__( 'Wrapper Alignment', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button & wishlist button alignment', 'timeline-designer' ); ?></span></span>
													<?php
													$wp_timeline_cart_wishlistbutton_alignment = 'left';
													if ( isset( $wtl_settings['wp_timeline_cart_wishlistbutton_alignment'] ) ) {
														$wp_timeline_cart_wishlistbutton_alignment = $wtl_settings['wp_timeline_cart_wishlistbutton_alignment'];
													}
													?>
													<fieldset class="buttonset green" data-hide='1'>
														<input id="wp_timeline_cart_wishlistbutton_alignment_left" name="wp_timeline_cart_wishlistbutton_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_cart_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_cart_wishlistbutton_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
														<input id="wp_timeline_cart_wishlistbutton_alignment_center" name="wp_timeline_cart_wishlistbutton_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_cart_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" class="wp_timeline_cart_wishlistbutton_alignment_center" for="wp_timeline_cart_wishlistbutton_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
														<input id="wp_timeline_cart_wishlistbutton_alignment_right" name="wp_timeline_cart_wishlistbutton_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_cart_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_cart_wishlistbutton_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
													</fieldset>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr wishlist_button_alignment">
												<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button alignment', 'timeline-designer' ); ?></span></span>
													<?php
													$wp_timeline_wishlistbutton_alignment = 'left';
													if ( isset( $wtl_settings['wp_timeline_wishlistbutton_alignment'] ) ) {
														$wp_timeline_wishlistbutton_alignment = $wtl_settings['wp_timeline_wishlistbutton_alignment'];
													}
													?>
													<fieldset class="buttonset green" data-hide='1'>
														<input id="wp_timeline_wishlistbutton_alignment_left" name="wp_timeline_wishlistbutton_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_wishlistbutton_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
														<input id="wp_timeline_wishlistbutton_alignment_center" name="wp_timeline_wishlistbutton_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" class="wp_timeline_wishlistbutton_alignment_center" for="wp_timeline_wishlistbutton_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
														<input id="wp_timeline_wishlistbutton_alignment_right" name="wp_timeline_wishlistbutton_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_wishlistbutton_alignment ); ?> />
														<label id="wp-timeline-options-button" for="wp_timeline_wishlistbutton_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
													</fieldset>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-color-picker">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button text color', 'timeline-designer' ); ?></span></span>
													<?php
													if ( isset( $wtl_settings['wp_timeline_wishlist_textcolor'] ) ) {
														$wp_timeline_wishlist_textcolor = $wtl_settings['wp_timeline_wishlist_textcolor'];
													} else {
														$wp_timeline_wishlist_textcolor = '';
													}
													?>
													<input type="text" name="wp_timeline_wishlist_textcolor" id="wp_timeline_wishlist_textcolor" value="<?php echo esc_attr( $wp_timeline_wishlist_textcolor ); ?>"/>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Hover Text Color', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-color-picker">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist text hover color', 'timeline-designer' ); ?></span></span>
													<?php $wp_timeline_wishlist_text_hover_color = isset( $wtl_settings['wp_timeline_wishlist_text_hover_color'] ) ? $wtl_settings['wp_timeline_wishlist_text_hover_color'] : ''; ?>
													<input type="text" name="wp_timeline_wishlist_text_hover_color" id="wp_timeline_wishlist_text_hover_color" value="<?php echo esc_attr( $wp_timeline_wishlist_text_hover_color ); ?>"/>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Background Color', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-color-picker">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button background color', 'timeline-designer' ); ?></span></span>
													<?php $wp_timeline_wishlist_backgroundcolor = isset( $wtl_settings['wp_timeline_wishlist_backgroundcolor'] ) ? $wtl_settings['wp_timeline_wishlist_backgroundcolor'] : ''; ?>
													<input type="text" name="wp_timeline_wishlist_backgroundcolor" id="wp_timeline_wishlist_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_wishlist_backgroundcolor ); ?>"/>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Hover Background Color', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-color-picker">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button hover background color', 'timeline-designer' ); ?></span></span>
													<?php $wp_timeline_wishlist_hover_backgroundcolor = isset( $wtl_settings['wp_timeline_wishlist_hover_backgroundcolor'] ) ? $wtl_settings['wp_timeline_wishlist_hover_backgroundcolor'] : ''; ?>
													<input type="text" name="wp_timeline_wishlist_hover_backgroundcolor" id="wp_timeline_wishlist_hover_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_wishlist_hover_backgroundcolor ); ?>"/>
												</div>
											</li>
											<li class="wp_timeline_wishlist_button_border_setting wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Border Radius(px)', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button border radius', 'timeline-designer' ); ?></span></span>
													<?php
													$display_wishlist_button_border_radius = '0';
													if ( isset( $wtl_settings['display_wishlist_button_border_radius'] ) ) {
														$display_wishlist_button_border_radius = $wtl_settings['display_wishlist_button_border_radius'];
													}
													?>
													<div class="input-type-number">
														<input type="number" id="display_wishlist_button_border_radius" name="display_wishlist_button_border_radius" step="1" min="0" value="<?php echo esc_attr( $display_wishlist_button_border_radius ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</li>
											<li class="wp_timeline_wishlist_button_border_setting wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Border', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-border-cover">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button border', 'timeline-designer' ); ?></span></span>
													<div class="wp-timeline-border-wrap">
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderleft = isset( $wtl_settings['wp_timeline_wishlistbutton_borderleft'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderleft'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" 	id="wp_timeline_wishlistbutton_borderleft" name="wp_timeline_wishlistbutton_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderleftcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_borderleftcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderleftcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_borderleftcolor" id="wp_timeline_wishlistbutton_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderleftcolor ); ?>"/>
																</div>
															</div>
														</div> 
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderright = isset( $wtl_settings['wp_timeline_wishlistbutton_borderright'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderright'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_borderright" name="wp_timeline_wishlistbutton_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderright ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderrightcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_borderrightcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderrightcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_borderrightcolor" id="wp_timeline_wishlistbutton_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderrightcolor ); ?>"/>
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_bordertop = isset( $wtl_settings['wp_timeline_wishlistbutton_bordertop'] ) ? $wtl_settings['wp_timeline_wishlistbutton_bordertop'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_bordertop" name="wp_timeline_wishlistbutton_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_bordertop ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_bordertopcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_bordertopcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_bordertopcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_bordertopcolor" id="wp_timeline_wishlistbutton_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_bordertopcolor ); ?>"/>
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderbuttom = isset( $wtl_settings['wp_timeline_wishlistbutton_borderbuttom'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderbuttom'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_borderbuttom" name="wp_timeline_wishlistbutton_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderbuttom ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_borderbottomcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_borderbottomcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_borderbottomcolor" id="wp_timeline_wishlistbutton_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_borderbottomcolor ); ?>"/>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_wishlist_button_border_hover_setting wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Hover Border Radius', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button hover border radius', 'timeline-designer' ); ?></span></span>
													<?php
													$display_wishlist_button_border_hover_radius = '0';
													if ( isset( $wtl_settings['display_wishlist_button_border_hover_radius'] ) ) {
														$display_wishlist_button_border_hover_radius = $wtl_settings['display_wishlist_button_border_hover_radius'];
													}
													?>
													<div class="input-type-number">
														<input type="number" id="display_wishlist_button_border_hover_radius" name="display_wishlist_button_border_hover_radius" step="1" min="0" value="<?php echo esc_attr( $display_wishlist_button_border_hover_radius ); ?>" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</li>
											<li class="wp_timeline_wishlist_button_border_hover_setting wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Hover Border', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-border-cover">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button border', 'timeline-designer' ); ?></span></span>
													<div class="wp-timeline-border-wrap">
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderleft = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderleft'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderleft'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_hover_borderleft" name="wp_timeline_wishlistbutton_hover_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderleftcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderleftcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderleftcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_hover_borderleftcolor" id="wp_timeline_wishlistbutton_hover_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderleftcolor ); ?>"/>
																</div>
															</div>
														</div> 
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderright = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderright'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderright'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_hover_borderright" name="wp_timeline_wishlistbutton_hover_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderright ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderrightcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderrightcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderrightcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_hover_borderrightcolor" id="wp_timeline_wishlistbutton_hover_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderrightcolor ); ?>"/>
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_bordertop = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_bordertop'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_bordertop'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_hover_bordertop" name="wp_timeline_wishlistbutton_hover_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_bordertop ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_bordertopcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_bordertopcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_bordertopcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_hover_bordertopcolor" id="wp_timeline_wishlistbutton_hover_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_bordertopcolor ); ?>"/>
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
															<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-border-cover">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderbuttom = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderbuttom'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderbuttom'] : '0'; ?>
																	<div class="input-type-number">
																		<input type="number" id="wp_timeline_wishlistbutton_hover_borderbuttom" name="wp_timeline_wishlistbutton_hover_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderbuttom ); ?>"  onkeypress="return isNumberKey(event)">
																	</div>
																</div>
															</div>
															<div class="wp-timeline-border-cover wp-timeline-color-picker">
																<div class="wp-timeline-border-content">
																	<?php $wp_timeline_wishlistbutton_hover_borderbottomcolor = isset( $wtl_settings['wp_timeline_wishlistbutton_hover_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_wishlistbutton_hover_borderbottomcolor'] : ''; ?>
																	<input type="text" name="wp_timeline_wishlistbutton_hover_borderbottomcolor" id="wp_timeline_wishlistbutton_hover_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderbottomcolor ); ?>"/>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-border-cover">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set wishlist button padding', 'timeline-designer' ); ?></span></span>
													<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
														<div class="wp-timeline-padding-cover">
															<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-padding-content">
																<?php $wp_timeline_wishlistbutton_padding_leftright = isset( $wtl_settings['wp_timeline_wishlistbutton_padding_leftright'] ) ? $wtl_settings['wp_timeline_wishlistbutton_padding_leftright'] : '10'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_wishlistbutton_padding_leftright" name="wp_timeline_wishlistbutton_padding_leftright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_padding_leftright ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-padding-cover">
															<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-padding-content">
																<?php $wp_timeline_wishlistbutton_padding_topbottom = isset( $wtl_settings['wp_timeline_wishlistbutton_padding_topbottom'] ) ? $wtl_settings['wp_timeline_wishlistbutton_padding_topbottom'] : '10'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_wishlistbutton_padding_topbottom" name="wp_timeline_wishlistbutton_padding_topbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_padding_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
												<div class="wp-timeline-right wp-timeline-border-cover">
													<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set wishlist button margin', 'timeline-designer' ); ?></span></span>
													<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
														<div class="wp-timeline-padding-cover">
															<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-padding-content">
																<?php $wp_timeline_wishlistbutton_margin_leftright = isset( $wtl_settings['wp_timeline_wishlistbutton_margin_leftright'] ) ? $wtl_settings['wp_timeline_wishlistbutton_margin_leftright'] : '10'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_wishlistbutton_margin_leftright" name="wp_timeline_wishlistbutton_margin_leftright" step="1" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_margin_leftright ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-padding-cover">
															<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
															<div class="wp-timeline-padding-content">
																<?php $wp_timeline_wishlistbutton_margin_topbottom = isset( $wtl_settings['wp_timeline_wishlistbutton_margin_topbottom'] ) ? $wtl_settings['wp_timeline_wishlistbutton_margin_topbottom'] : '10'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_wishlistbutton_margin_topbottom" name="wp_timeline_wishlistbutton_margin_topbottom" step="1" value="<?php echo esc_attr( $wp_timeline_wishlistbutton_margin_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr wishlist_button_box_shadow_setting">
												<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Box Shadow Settings', 'timeline-designer' ); ?></h3>
												<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_top_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_top_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_top_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_top_box_shadow" name="wp_timeline_wishlist_button_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_right_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_right_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_right_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_right_box_shadow" name="wp_timeline_wishlist_button_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_bottom_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_bottom_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_bottom_box_shadow" name="wp_timeline_wishlist_button_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_left_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_left_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_left_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_left_box_shadow" name="wp_timeline_wishlist_button_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
															<?php $wp_timeline_wishlist_button_box_shadow_color = isset( $wtl_settings['wp_timeline_wishlist_button_box_shadow_color'] ) ? $wtl_settings['wp_timeline_wishlist_button_box_shadow_color'] : ''; ?>
															<input type="text" name="wp_timeline_wishlist_button_box_shadow_color" id="wp_timeline_wishlist_button_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_wishlist_button_box_shadow_color ); ?>"/>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr wishlist_button_box_hover_shadow_setting">
												<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Hover Box Shadow Settings', 'timeline-designer' ); ?></h3>
												<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_hover_top_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_hover_top_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_hover_top_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_hover_top_box_shadow" name="wp_timeline_wishlist_button_hover_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_hover_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical side value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_hover_right_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_hover_right_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_hover_right_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_hover_right_box_shadow" name="wp_timeline_wishlist_button_hover_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_hover_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_hover_bottom_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_hover_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_hover_bottom_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_hover_bottom_box_shadow" name="wp_timeline_wishlist_button_hover_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_hover_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content">
															<?php $wp_timeline_wishlist_button_hover_left_box_shadow = isset( $wtl_settings['wp_timeline_wishlist_button_hover_left_box_shadow'] ) ? $wtl_settings['wp_timeline_wishlist_button_hover_left_box_shadow'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_wishlist_button_hover_left_box_shadow" name="wp_timeline_wishlist_button_hover_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_wishlist_button_hover_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
														<div class="wp-timeline-boxshadow-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
															<?php $wp_timeline_wishlist_button_hover_box_shadow_color = isset( $wtl_settings['wp_timeline_wishlist_button_hover_box_shadow_color'] ) ? $wtl_settings['wp_timeline_wishlist_button_hover_box_shadow_color'] : ''; ?>
															<input type="text" name="wp_timeline_wishlist_button_hover_box_shadow_color" id="wp_timeline_wishlist_button_hover_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_wishlist_button_hover_box_shadow_color ); ?>"/>
														</div>
													</div>
												</div>
											</li>
											<li class="wp_timeline_add_to_wishlist_tr">
												<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
												<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button font family', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php $wp_timeline_addtowishlist_button_fontface = isset( $wtl_settings['wp_timeline_addtowishlist_button_fontface'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_fontface'] : ''; ?>
															<div class="typo-field">
																<input type="hidden" id="wp_timeline_addtowishlist_button_fontface_font_type" name="wp_timeline_addtowishlist_button_fontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_addtowishlist_button_fontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_addtowishlist_button_fontface_font_type'] ) : ''; ?>">
																<div class="select-cover">
																	<select name="wp_timeline_addtowishlist_button_fontface" id="wp_timeline_addtowishlist_button_fontface">
																		<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																		<?php
																		$old_version = '';
																		$cnt         = 0;
																		$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																		foreach ( $font_family as $key => $value ) {
																			if ( $value['version'] != $old_version ) {
																				if ( $cnt > 0 ) {
																					echo '</optgroup>';
																				}
																				echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																				$old_version = esc_attr( $value['version'] );
																			}
																			echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
																			if ( '' != $wp_timeline_addtowishlist_button_fontface && ( str_replace( '"', '', $wp_timeline_addtowishlist_button_fontface ) == str_replace( '"', '', $value['label'] ) ) ) {
																				echo ' selected';
																			}
																			echo '>' . esc_attr( $value['label'] ) . '</option>';
																			$cnt++;
																		}
																		if ( count( $font_family ) == $cnt ) {
																			echo '</optgroup>';
																		}
																		?>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button font size', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php
															if ( isset( $wtl_settings['wp_timeline_addtowishlist_button_fontsize'] ) && '' != $wtl_settings['wp_timeline_addtowishlist_button_fontsize'] ) {
																$wp_timeline_addtowishlist_button_fontsize = $wtl_settings['wp_timeline_addtowishlist_button_fontsize'];
															} else {
																$wp_timeline_addtowishlist_button_fontsize = 14;
															}
															?>
															<div class="grid_col_space range_slider_fontsize" id="wp_timeline_addtowishlist_button_fontsizeInput" ></div>
															<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_addtowishlist_button_fontsize" id="wp_timeline_addtowishlist_button_fontsize" value="<?php echo esc_attr( $wp_timeline_addtowishlist_button_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button font weight', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php $wp_timeline_addtowishlist_button_font_weight = isset( $wtl_settings['wp_timeline_addtowishlist_button_font_weight'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_font_weight'] : 'normal'; ?>
															<div class="select-cover">
																<select name="wp_timeline_addtowishlist_button_font_weight" id="wp_timeline_addtowishlist_button_font_weight">
																	<option value="100" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 100 ); ?>>100</option>
																	<option value="200" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 200 ); ?>>200</option>
																	<option value="300" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 300 ); ?>>300</option>
																	<option value="400" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 400 ); ?>>400</option>
																	<option value="500" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 500 ); ?>>500</option>
																	<option value="600" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 600 ); ?>>600</option>
																	<option value="700" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 700 ); ?>>700</option>
																	<option value="800" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 800 ); ?>>800</option>
																	<option value="900" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 900 ); ?>>900</option>
																	<option value="bold" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																	<option value="normal" <?php selected( $wp_timeline_addtowishlist_button_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
																</select>
															</div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button line height', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<div class="input-type-number">
															<?php
															$display_wishlist_button_line_height = '1.5';
															if ( isset( $wtl_settings['display_wishlist_button_line_height'] ) ) {
																$display_wishlist_button_line_height = $wtl_settings['display_wishlist_button_line_height'];
															}
															?>
														<input type="number" id="display_wishlist_button_line_height" name="display_wishlist_button_line_height" step="1" min="1.5" value="<?php echo esc_attr( $display_wishlist_button_line_height ); ?>" placeholder="<?php esc_attr_e( 'Enter line height', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display wishlist button italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_addtowishlist_button_font_italic = isset( $wtl_settings['wp_timeline_addtowishlist_button_font_italic'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_font_italic'] : '0'; ?>
														</div>
														<div class="wp-timeline-typography-content">
															<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
																<input id="wp_timeline_addtowishlist_button_font_italic_1" name="wp_timeline_addtowishlist_button_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_addtowishlist_button_font_italic ); ?> />
																<label for="wp_timeline_addtowishlist_button_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
																<input id="wp_timeline_addtowishlist_button_font_italic_0" name="wp_timeline_addtowishlist_button_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_addtowishlist_button_font_italic ); ?> />
																<label for="wp_timeline_addtowishlist_button_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
															</fieldset>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button text transform style', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php $wp_timeline_addtowishlist_button_font_text_transform = isset( $wtl_settings['wp_timeline_addtowishlist_button_font_text_transform'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_font_text_transform'] : 'none'; ?>
															<div class="select-cover">
																<select name="wp_timeline_addtowishlist_button_font_text_transform" id="wp_timeline_addtowishlist_button_font_text_transform">
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
																</select>
															</div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select wishlist button text decoration style', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content">
															<?php $wp_timeline_addtowishlist_button_font_text_decoration = isset( $wtl_settings['wp_timeline_addtowishlist_button_font_text_decoration'] ) ? $wtl_settings['wp_timeline_addtowishlist_button_font_text_decoration'] : 'none'; ?>
															<div class="select-cover">
																<select name="wp_timeline_addtowishlist_button_font_text_decoration" id="wp_timeline_addtowishlist_button_font_text_decoration">
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																	<option <?php selected( $wp_timeline_addtowishlist_button_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
																</select>
															</div>
														</div>
													</div>
													<div class="wp-timeline-typography-cover">
														<div class="wp-timeline-typography-label">
															<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
															<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter wishlist button letter spacing', 'timeline-designer' ); ?></span></span>
														</div>
														<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_addtowishlist_button_letter_spacing" id="wp_timeline_addtowishlist_button_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_addtowishlist_button_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_addtowishlist_button_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
													</div>
												</div>
											</li>
										</ul>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php
				}
				if ( 'easy-digital-downloads/easy-digital-downloads.php' ) {
					?>
					<div id="wp_timeline_eddsetting" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_eddsetting_class_show ); ?>'>
						<div class="inside">
							<ul class="wp-timeline-settings wp-timeline-lineheight">
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Price', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable product price', 'timeline-designer' ); ?></span></span>
										<?php
										$display_download_price = '1';
										if ( isset( $wtl_settings['display_download_price'] ) ) {
											$display_download_price = $wtl_settings['display_download_price'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_download_price_1" name="display_download_price" type="radio" value="1" <?php checked( 1, $display_download_price ); ?> />
											<label id="wp-timeline-options-button" for="display_download_price_1" <?php checked( 1, $display_download_price ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_download_price_0" name="display_download_price" type="radio" value="0" <?php checked( 0, $display_download_price ); ?> />
											<label id="wp-timeline-options-button" for="display_download_price_0" <?php checked( 1, $display_download_price ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_edd_price_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Product Price Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_pricetext_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_edd_price_color = ( isset( $wtl_settings['wp_timeline_edd_price_color'] ) && '' != $wtl_settings['wp_timeline_edd_price_color'] ) ? $wtl_settings['wp_timeline_edd_price_color'] : '#444444'; ?>
												<input type="text" name="wp_timeline_edd_price_color" id="wp_timeline_edd_price_color" value="<?php echo esc_attr( $wp_timeline_edd_price_color ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_edd_pricetext_tr wp_timeline_edd_pricetext_alignment_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_edd_price_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_edd_price_alignment'] ) ) {
													$wp_timeline_edd_price_alignment = $wtl_settings['wp_timeline_edd_price_alignment'];
												}
												?>
												<fieldset class="buttonset green" data-hide='1'>
													<input id="wp_timeline_edd_price_alignment_left" name="wp_timeline_edd_price_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_edd_price_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_price_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_edd_price_alignment_center" name="wp_timeline_edd_price_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_edd_price_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_price_alignment_center" class="wp_timeline_edd_price_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_edd_price_alignment_right" name="wp_timeline_edd_price_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_edd_price_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_price_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
												</fieldset>
											</div>
										</li>
										<li class="wp_timeline_edd_pricetext_tr wp_timeline_edd_pricetext_padding_setting_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set price text padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_price_paddingleft = isset( $wtl_settings['wp_timeline_edd_price_paddingleft'] ) ? $wtl_settings['wp_timeline_edd_price_paddingleft'] : '10'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_price_paddingleft" name="wp_timeline_edd_price_paddingleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_price_paddingleft ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_price_paddingright = isset( $wtl_settings['wp_timeline_edd_price_paddingright'] ) ? $wtl_settings['wp_timeline_edd_price_paddingright'] : '10'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_price_paddingright" name="wp_timeline_edd_price_paddingright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_price_paddingright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_price_paddingtop = isset( $wtl_settings['wp_timeline_edd_price_paddingtop'] ) ? $wtl_settings['wp_timeline_edd_price_paddingtop'] : '10'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_price_paddingtop" name="wp_timeline_edd_price_paddingtop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_price_paddingtop ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_price_paddingbottom = isset( $wtl_settings['wp_timeline_edd_price_paddingbottom'] ) ? $wtl_settings['wp_timeline_edd_price_paddingbottom'] : '10'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_price_paddingbottom" name="wp_timeline_edd_price_paddingbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_price_paddingbottom ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_pricetext_tr wp_timeline_edd_pricetext_typography_setting_tr">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font family', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_edd_pricefontface'] ) && '' != $wtl_settings['wp_timeline_edd_pricefontface'] ) {
															$wp_timeline_edd_pricefontface = $wtl_settings['wp_timeline_edd_pricefontface'];
														} else {
															$wp_timeline_edd_pricefontface = '';
														}
														?>
														<div class="typo-field">
															<input type="hidden" id="wp_timeline_edd_pricefontface_font_type" name="wp_timeline_edd_pricefontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_edd_pricefontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_edd_pricefontface_font_type'] ) : ''; ?>">
															<div class="select-cover">
																<select name="wp_timeline_edd_pricefontface" id="wp_timeline_edd_pricefontface">
																	<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																	<?php
																	$old_version = '';
																	$cnt         = 0;
																	$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																	foreach ( $font_family as $key => $value ) {
																		if ( $value['version'] != $old_version ) {
																			if ( $cnt > 0 ) {
																				echo '</optgroup>';
																			}
																			echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																			$old_version = $value['version'];
																		}
																		echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
																		if ( '' != $wp_timeline_edd_pricefontface && ( str_replace( '"', '', $wp_timeline_edd_pricefontface ) == str_replace( '"', '', $value['label'] ) ) ) {
																			echo ' selected';
																		}
																		echo '>' . esc_html( $value['label'] ) . '</option>';
																		$cnt++;
																	}
																	if ( count( $font_family ) == $cnt ) {
																		echo '</optgroup>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font size', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_edd_pricefontsize'] ) && '' != $wtl_settings['wp_timeline_edd_pricefontsize'] ) {
															$wp_timeline_edd_pricefontsize = $wtl_settings['wp_timeline_edd_pricefontsize'];
														} else {
															$wp_timeline_edd_pricefontsize = 14;
														}
														?>
														<div class="grid_col_space range_slider_fontsize" id="wp_timeline_edd_pricefontsizeInput"></div>
														<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_edd_pricefontsize" id="wp_timeline_edd_pricefontsize" value="<?php echo esc_attr( $wp_timeline_edd_pricefontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text font weight', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_edd_price_font_weight = isset( $wtl_settings['wp_timeline_edd_price_font_weight'] ) ? $wtl_settings['wp_timeline_edd_price_font_weight'] : 'normal'; ?>
														<div class="select-cover">
															<select name="wp_timeline_edd_price_font_weight" id="wp_timeline_edd_price_font_weight">
																<option value="100" <?php selected( $wp_timeline_edd_price_font_weight, 100 ); ?>>100</option>
																<option value="200" <?php selected( $wp_timeline_edd_price_font_weight, 200 ); ?>>200</option>
																<option value="300" <?php selected( $wp_timeline_edd_price_font_weight, 300 ); ?>>300</option>
																<option value="400" <?php selected( $wp_timeline_edd_price_font_weight, 400 ); ?>>400</option>
																<option value="500" <?php selected( $wp_timeline_edd_price_font_weight, 500 ); ?>>500</option>
																<option value="600" <?php selected( $wp_timeline_edd_price_font_weight, 600 ); ?>>600</option>
																<option value="700" <?php selected( $wp_timeline_edd_price_font_weight, 700 ); ?>>700</option>
																<option value="800" <?php selected( $wp_timeline_edd_price_font_weight, 800 ); ?>>800</option>
																<option value="900" <?php selected( $wp_timeline_edd_price_font_weight, 900 ); ?>>900</option>
																<option value="bold" <?php selected( $wp_timeline_edd_price_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																<option value="normal" <?php selected( $wp_timeline_edd_price_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text line height', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_edd_price_font_line_height" id="wp_timeline_edd_price_font_line_height" step="0.1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_edd_price_font_line_height'] ) ? esc_attr( $wtl_settings['wp_timeline_edd_price_font_line_height'] ) : '1.5'; ?>" onkeypress="return isNumberKey(event)" ></div></div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display price text italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_edd_price_font_italic = isset( $wtl_settings['wp_timeline_edd_price_font_italic'] ) ? $wtl_settings['wp_timeline_edd_price_font_italic'] : '0'; ?>
													</div>
													<div class="wp-timeline-typography-content">
														<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
															<input id="wp_timeline_edd_price_font_italic_1" name="wp_timeline_edd_price_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_edd_price_font_italic ); ?> />
															<label for="wp_timeline_edd_price_font_italic_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
															<input id="wp_timeline_edd_price_font_italic_0" name="wp_timeline_edd_price_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_edd_price_font_italic ); ?> />
															<label for="wp_timeline_edd_price_font_italic_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
														</fieldset>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select price text decoration style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_edd_price_font_text_decoration = isset( $wtl_settings['wp_timeline_edd_price_font_text_decoration'] ) ? $wtl_settings['wp_timeline_edd_price_font_text_decoration'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_edd_price_font_text_decoration" id="wp_timeline_edd_price_font_text_decoration">
																<option <?php selected( $wp_timeline_edd_price_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_price_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_price_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_price_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter price text letter spacing', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content"><div class="input-type-number"><input type="number" name="wp_timeline_edd_price_font_letter_spacing" id="wp_timeline_edd_price_font_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_edd_price_font_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_edd_price_font_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div></div>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li>
									<?php wtl_lite_setting_left( esc_html__( 'Display Purchase Button', 'timeline-designer' ) ); ?>
									<div class="wp-timeline-right">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable purchase button', 'timeline-designer' ); ?></span></span>
										<?php
										$display_edd_addtocart_button = '1';
										if ( isset( $wtl_settings['display_edd_addtocart_button'] ) ) {
											$display_edd_addtocart_button = $wtl_settings['display_edd_addtocart_button'];
										}
										?>
										<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
											<input id="display_edd_addtocart_button_1" name="display_edd_addtocart_button" type="radio" value="1" <?php checked( 1, $display_edd_addtocart_button ); ?> />
											<label id="wp-timeline-options-button" for="display_edd_addtocart_button_1" <?php checked( 1, $display_edd_addtocart_button ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
											<input id="display_edd_addtocart_button_0" name="display_edd_addtocart_button" type="radio" value="0" <?php checked( 0, $display_edd_addtocart_button ); ?> />
											<label id="wp-timeline-options-button" for="display_edd_addtocart_button_0" <?php checked( 0, $display_edd_addtocart_button ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
										</fieldset>
									</div>
								</li>
								<li class="wp_timeline_edd_cart_button_setting">
									<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Purchase Button Settings', 'timeline-designer' ); ?></h3>
									<ul>
										<li class="wp_timeline_edd_add_to_cart_tr edd_cart_button_alignment">
											<?php wtl_lite_setting_left( esc_html__( 'Alignment', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button alignment', 'timeline-designer' ); ?></span></span>
												<?php
												$wp_timeline_edd_addtocartbutton_alignment = 'left';
												if ( isset( $wtl_settings['wp_timeline_edd_addtocartbutton_alignment'] ) ) {
													$wp_timeline_edd_addtocartbutton_alignment = $wtl_settings['wp_timeline_edd_addtocartbutton_alignment'];
												}
												?>
												<fieldset class="buttonset green" data-hide='1'>
													<input id="wp_timeline_edd_addtocartbutton_alignment_left" name="wp_timeline_edd_addtocartbutton_alignment" type="radio" value="left" <?php checked( 'left', $wp_timeline_edd_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_addtocartbutton_alignment_left"><?php esc_html_e( 'Left', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_edd_addtocartbutton_alignment_center" name="wp_timeline_edd_addtocartbutton_alignment" type="radio" value="center" <?php checked( 'center', $wp_timeline_edd_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_addtocartbutton_alignment_center" class="wp_timeline_edd_addtocartbutton_alignment_center"><?php esc_html_e( 'Center', 'timeline-designer' ); ?></label>
													<input id="wp_timeline_edd_addtocartbutton_alignment_right" name="wp_timeline_edd_addtocartbutton_alignment" type="radio" value="right" <?php checked( 'right', $wp_timeline_edd_addtocartbutton_alignment ); ?> />
													<label id="wp-timeline-options-button" for="wp_timeline_edd_addtocartbutton_alignment_right"><?php esc_html_e( 'Right', 'timeline-designer' ); ?></label>
												</fieldset>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Text Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text color', 'timeline-designer' ); ?></span></span>
												<?php
												if ( isset( $wtl_settings['wp_timeline_edd_addtocart_textcolor'] ) ) {
													$wp_timeline_edd_addtocart_textcolor = $wtl_settings['wp_timeline_edd_addtocart_textcolor'];
												} else {
													$wp_timeline_edd_addtocart_textcolor = '';
												}
												?>
												<input type="text" name="wp_timeline_edd_addtocart_textcolor" id="wp_timeline_edd_addtocart_textcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_textcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Text Color', 'timeline-designer' ) ); ?>                                       
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button text hover color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_edd_addtocart_text_hover_color = isset( $wtl_settings['wp_timeline_edd_addtocart_text_hover_color'] ) ? $wtl_settings['wp_timeline_edd_addtocart_text_hover_color'] : ''; ?>
												<input type="text" name="wp_timeline_edd_addtocart_text_hover_color" id="wp_timeline_edd_addtocart_text_hover_color" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_text_hover_color ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_edd_addtocart_backgroundcolor = isset( $wtl_settings['wp_timeline_edd_addtocart_backgroundcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocart_backgroundcolor'] : ''; ?>
												<input type="text" name="wp_timeline_edd_addtocart_backgroundcolor" id="wp_timeline_edd_addtocart_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_backgroundcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Background Color', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-color-picker">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover background color', 'timeline-designer' ); ?></span></span>
												<?php $wp_timeline_edd_addtocart_hover_backgroundcolor = isset( $wtl_settings['wp_timeline_edd_addtocart_hover_backgroundcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocart_hover_backgroundcolor'] : ''; ?>
												<input type="text" name="wp_timeline_edd_addtocart_hover_backgroundcolor" id="wp_timeline_edd_addtocart_hover_backgroundcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_hover_backgroundcolor ); ?>"/>
											</div>
										</li>
										<li class="wp_timeline_edd_addtocart_button_border_setting wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Border Radius(px)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button border radius', 'timeline-designer' ); ?></span></span>
												<?php
												$display_edd_addtocart_button_border_radius = '0';
												if ( isset( $wtl_settings['display_edd_addtocart_button_border_radius'] ) ) {
													$display_edd_addtocart_button_border_radius = $wtl_settings['display_edd_addtocart_button_border_radius'];
												}
												?>
												<input type="number" id="display_edd_addtocart_button_border_radius" name="display_edd_addtocart_button_border_radius" step="1" min="0" value="<?php echo esc_attr( $display_edd_addtocart_button_border_radius ); ?>" onkeypress="return isNumberKey(event)">
											</div>
										</li>
										<li class="wp_timeline_edd_addtocart_button_border_setting wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Border', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button border', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-border-wrap">
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_borderleft = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderleft'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderleft'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_borderleft" name="wp_timeline_edd_addtocartbutton_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_borderleftcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderleftcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderleftcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_borderleftcolor" id="wp_timeline_edd_addtocartbutton_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderleftcolor ); ?>"/>
															</div>
														</div>
													</div> 
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_borderright = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderright'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderright'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_borderright" name="wp_timeline_edd_addtocartbutton_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderright ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
															<?php $wp_timeline_edd_addtocartbutton_borderrightcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderrightcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderrightcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_borderrightcolor" id="wp_timeline_edd_addtocartbutton_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderrightcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_bordertop = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_bordertop'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_bordertop'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_bordertop" name="wp_timeline_edd_addtocartbutton_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_bordertop ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_bordertopcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_bordertopcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_bordertopcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_bordertopcolor" id="wp_timeline_edd_addtocartbutton_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_bordertopcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_borderbuttom = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderbuttom'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderbuttom'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_borderbuttom" name="wp_timeline_edd_addtocartbutton_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderbuttom ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
															<?php $wp_timeline_edd_addtocartbutton_borderbottomcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_borderbottomcolor'] : ''; ?>
															<input type="text" name="wp_timeline_edd_addtocartbutton_borderbottomcolor" id="wp_timeline_edd_addtocartbutton_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderbottomcolor ); ?>"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_addtocart_button_border_hover_setting wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Border Radius(px)', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover border radius', 'timeline-designer' ); ?></span></span>
												<?php
												$display_edd_addtocart_button_border_hover_radius = '0';
												if ( isset( $wtl_settings['display_edd_addtocart_button_border_hover_radius'] ) ) {
													$display_edd_addtocart_button_border_hover_radius = $wtl_settings['display_edd_addtocart_button_border_hover_radius'];
												}
												?>
												<div class="input-type-number">
													<input type="number" id="display_edd_addtocart_button_border_hover_radius" name="display_edd_addtocart_button_border_hover_radius" step="1" min="0" value="<?php echo esc_attr( $display_edd_addtocart_button_border_hover_radius ); ?>" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_addtocart_button_border_hover_setting wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Hover Border', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button hover border', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-border-wrap">
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderleft = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderleft'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderleft'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_hover_borderleft" name="wp_timeline_edd_addtocartbutton_hover_borderleft" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderleft ); ?>"  onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderleftcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderleftcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderleftcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_hover_borderleftcolor" id="wp_timeline_edd_addtocartbutton_hover_borderleftcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderleftcolor ); ?>"/>
															</div>
														</div>
													</div> 
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderright = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderright'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderright'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_hover_borderright" name="wp_timeline_edd_addtocartbutton_hover_borderright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderright ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderrightcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderrightcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderrightcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_hover_borderrightcolor" id="wp_timeline_edd_addtocartbutton_hover_borderrightcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderrightcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_bordertop = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_bordertop'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_bordertop'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_hover_bordertop" name="wp_timeline_edd_addtocartbutton_hover_bordertop" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_bordertop ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_bordertopcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_bordertopcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_bordertopcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_hover_bordertopcolor" id="wp_timeline_edd_addtocartbutton_hover_bordertopcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_bordertopcolor ); ?>"/>
															</div>
														</div>
													</div>
													<div class="wp-timeline-border-wrapper wp-timeline-border-wrapper1">
														<div class="wp-timeline-border-cover wp-timeline-border-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Bottom(px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-border-cover">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderbuttom = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderbuttom'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderbuttom'] : '0'; ?>
																<div class="input-type-number">
																	<input type="number" id="wp_timeline_edd_addtocartbutton_hover_borderbuttom" name="wp_timeline_edd_addtocartbutton_hover_borderbuttom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderbuttom ); ?>" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="wp-timeline-border-cover wp-timeline-color-picker">
															<div class="wp-timeline-border-content">
																<?php $wp_timeline_edd_addtocartbutton_hover_borderbottomcolor = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_hover_borderbottomcolor'] : ''; ?>
																<input type="text" name="wp_timeline_edd_addtocartbutton_hover_borderbottomcolor" id="wp_timeline_edd_addtocartbutton_hover_borderbottomcolor" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderbottomcolor ); ?>"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Padding', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set purchase button padding', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_addtocartbutton_padding_leftright = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_padding_leftright'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_padding_leftright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_addtocartbutton_padding_leftright" name="wp_timeline_edd_addtocartbutton_padding_leftright" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_leftright ); ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_addtocartbutton_padding_topbottom = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_padding_topbottom'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_padding_topbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_addtocartbutton_padding_topbottom" name="wp_timeline_edd_addtocartbutton_padding_topbottom" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<?php wtl_lite_setting_left( esc_html__( 'Margin', 'timeline-designer' ) ); ?>
											<div class="wp-timeline-right wp-timeline-border-cover">
												<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-color"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Set purchase button margin', 'timeline-designer' ); ?></span></span>
												<div class="wp-timeline-padding-wrapper wp-timeline-padding-wrapper1 wp-timeline-border-wrap">
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Left-Right (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_addtocartbutton_margin_leftright = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_margin_leftright'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_margin_leftright'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_addtocartbutton_margin_leftright" name="wp_timeline_edd_addtocartbutton_margin_leftright" step="1" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_leftright ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="wp-timeline-padding-cover">
														<div class="wp-timeline-padding-label"><span class="wp-timeline-key-title"><?php esc_html_e( 'Top-Bottom (px)', 'timeline-designer' ); ?></span></div>
														<div class="wp-timeline-padding-content">
															<?php $wp_timeline_edd_addtocartbutton_margin_topbottom = isset( $wtl_settings['wp_timeline_edd_addtocartbutton_margin_topbottom'] ) ? $wtl_settings['wp_timeline_edd_addtocartbutton_margin_topbottom'] : '0'; ?>
															<div class="input-type-number">
																<input type="number" id="wp_timeline_edd_addtocartbutton_margin_topbottom" name="wp_timeline_edd_addtocartbutton_margin_topbottom" step="1" value="<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_topbottom ); ?>"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr edd_addtocart_button_box_shadow_setting">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Box Shadow Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_top_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_top_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_top_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_top_box_shadow" name="wp_timeline_edd_addtocart_button_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_right_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_right_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_right_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_right_box_shadow" name="wp_timeline_edd_addtocart_button_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_bottom_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_bottom_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_bottom_box_shadow" name="wp_timeline_edd_addtocart_button_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_left_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_left_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_left_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_left_box_shadow" name="wp_timeline_edd_addtocart_button_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
														<?php $wp_timeline_edd_addtocart_button_box_shadow_color = isset( $wtl_settings['wp_timeline_edd_addtocart_button_box_shadow_color'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_box_shadow_color'] : ''; ?>
														<input type="text" name="wp_timeline_edd_addtocart_button_box_shadow_color" id="wp_timeline_edd_addtocart_button_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_box_shadow_color ); ?>"/>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr edd_addtocart_button_hover_box_shadow_setting">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Hover Box Shadow Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-boxshadow-wrapper wp-timeline-boxshadow-wrapper1">
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'H-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select horizontal offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_hover_top_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_hover_top_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_hover_top_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_hover_top_box_shadow" name="wp_timeline_edd_addtocart_button_hover_top_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_top_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'V-offset (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select vertical offset value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_hover_right_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_hover_right_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_hover_right_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_hover_right_box_shadow" name="wp_timeline_edd_addtocart_button_hover_right_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_right_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Blur (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select blur value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_hover_bottom_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_hover_bottom_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_hover_bottom_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_hover_bottom_box_shadow" name="wp_timeline_edd_addtocart_button_hover_bottom_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_bottom_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Spread (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select spread value', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content">
														<?php $wp_timeline_edd_addtocart_button_hover_left_box_shadow = isset( $wtl_settings['wp_timeline_edd_addtocart_button_hover_left_box_shadow'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_hover_left_box_shadow'] : '0'; ?>
														<div class="input-type-number">
															<input type="number" id="wp_timeline_edd_addtocart_button_hover_left_box_shadow" name="wp_timeline_edd_addtocart_button_hover_left_box_shadow" step="1" min="0" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_left_box_shadow ); ?>"  onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-boxshadow-cover wp-timeline-boxshadow-color">
													<div class="wp-timeline-boxshadow-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Color', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select box shadow color', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-boxshadow-content wp-timeline-color-picker">
														<?php $wp_timeline_edd_addtocart_button_hover_box_shadow_color = isset( $wtl_settings['wp_timeline_edd_addtocart_button_hover_box_shadow_color'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_hover_box_shadow_color'] : ''; ?>
														<input type="text" name="wp_timeline_edd_addtocart_button_hover_box_shadow_color" id="wp_timeline_edd_addtocart_button_hover_box_shadow_color" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_box_shadow_color ); ?>"/>
													</div>
												</div>
											</div>
										</li>
										<li class="wp_timeline_edd_add_to_cart_tr">
											<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Typography Settings', 'timeline-designer' ); ?></h3>
											<div class="wp-timeline-typography-wrapper wp-timeline-typography-wrapper1">
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Family', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select cart button font family', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_edd_addtocart_button_fontface'] ) && '' != $wtl_settings['wp_timeline_edd_addtocart_button_fontface'] ) {
															$wp_timeline_edd_addtocart_button_fontface = $wtl_settings['wp_timeline_edd_addtocart_button_fontface'];
														} else {
															$wp_timeline_edd_addtocart_button_fontface = '';
														}
														?>
														<div class="typo-field">
															<input type="hidden" id="wp_timeline_edd_addtocart_button_fontface_font_type" name="wp_timeline_edd_addtocart_button_fontface_font_type" value="<?php echo isset( $wtl_settings['wp_timeline_edd_addtocart_button_fontface_font_type'] ) ? esc_attr( $wtl_settings['wp_timeline_edd_addtocart_button_fontface_font_type'] ) : ''; ?>">
															<div class="select-cover">
																<select name="wp_timeline_edd_addtocart_button_fontface" id="wp_timeline_edd_addtocart_button_fontface">
																	<option value=""><?php esc_html_e( 'Select Font Family', 'timeline-designer' ); ?></option>
																	<?php
																	$old_version = '';
																	$cnt         = 0;
																	$font_family = Wp_Timeline_Lite_Main::wtl_default_recognized_font_faces();
																	foreach ( $font_family as $key => $value ) {
																		if ( $value['version'] != $old_version ) {
																			if ( $cnt > 0 ) {
																				echo '</optgroup>';
																			}
																			echo '<optgroup label="' . esc_attr( $value['version'] ) . '">';
																			$old_version = $value['version'];
																		}
																		echo "<option value='" . esc_attr( str_replace( '"', '', $value['label'] ) ) . "'";
																		if ( '' != $wp_timeline_edd_addtocart_button_fontface && ( str_replace( '"', '', $wp_timeline_edd_addtocart_button_fontface ) == str_replace( '"', '', $value['label'] ) ) ) {
																			echo ' selected';
																		}
																		echo '>' . esc_html( $value['label'] ) . '</option>';
																		$cnt++;
																	}
																	if ( count( $font_family ) == $cnt ) {
																		echo '</optgroup>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Size (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select purchase button font size', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php
														if ( isset( $wtl_settings['wp_timeline_edd_addtocart_button_fontsize'] ) && '' != $wtl_settings['wp_timeline_edd_addtocart_button_fontsize'] ) {
															$wp_timeline_edd_addtocart_button_fontsize = $wtl_settings['wp_timeline_edd_addtocart_button_fontsize'];
														} else {
															$wp_timeline_edd_addtocart_button_fontsize = 14;
														}
														?>
														<div class="grid_col_space range_slider_fontsize" id="wp_timeline_edd_addtocart_button_fontsizeInput" ></div>
														<div class="slide_val"><span></span><input class="grid_col_space_val range-slider__value" name="wp_timeline_edd_addtocart_button_fontsize" id="wp_timeline_edd_addtocart_button_fontsize" value="<?php echo esc_attr( $wp_timeline_edd_addtocart_button_fontsize ); ?>" onkeypress="return isNumberKey(event)" /></div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Font Weight', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select purchase button font weight', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_edd_addtocart_button_font_weight = isset( $wtl_settings['wp_timeline_edd_addtocart_button_font_weight'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_font_weight'] : 'normal'; ?>
														<div class="select-cover">
															<select name="wp_timeline_edd_addtocart_button_font_weight" id="wp_timeline_edd_addtocart_button_font_weight">
																<option value="100" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 100 ); ?>>100</option>
																<option value="200" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 200 ); ?>>200</option>
																<option value="300" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 300 ); ?>>300</option>
																<option value="400" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 400 ); ?>>400</option>
																<option value="500" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 500 ); ?>>500</option>
																<option value="600" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 600 ); ?>>600</option>
																<option value="700" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 700 ); ?>>700</option>
																<option value="800" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 800 ); ?>>800</option>
																<option value="900" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 900 ); ?>>900</option>
																<option value="bold" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 'bold' ); ?> ><?php esc_html_e( 'Bold', 'timeline-designer' ); ?></option>
																<option value="normal" <?php selected( $wp_timeline_edd_addtocart_button_font_weight, 'normal' ); ?>><?php esc_html_e( 'Normal', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Line Height', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select purchase button line height', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<div class="input-type-number">
															<?php
															$display_edd_addtocart_button_line_height = '1.5';
															if ( isset( $wtl_settings['display_edd_addtocart_button_line_height'] ) ) {
																$display_edd_addtocart_button_line_height = $wtl_settings['display_edd_addtocart_button_line_height'];
															}
															?>
															<input type="number" id="display_edd_addtocart_button_line_height" name="display_edd_addtocart_button_line_height" step="1" min="1.5" value="<?php echo esc_attr( $display_edd_addtocart_button_line_height ); ?>" placeholder="<?php esc_attr_e( 'Enter line height', 'timeline-designer' ); ?>" onkeypress="return isNumberKey(event)">
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Italic Font Style', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Display purchase button italic font style', 'timeline-designer' ); ?></span></span><?php $wp_timeline_edd_addtocart_button_font_italic = isset( $wtl_settings['wp_timeline_edd_addtocart_button_font_italic'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_font_italic'] : '0'; ?>
													</div>
													<div class="wp-timeline-typography-content">
														<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
															<input id="wp_timeline_edd_addtocart_button_font_italic_1" name="wp_timeline_edd_addtocart_button_font_italic" type="radio" value="1"  <?php checked( 1, $wp_timeline_edd_addtocart_button_font_italic ); ?> />
															<label for="wp_timeline_edd_addtocart_button_font_italic_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
															<input id="wp_timeline_edd_addtocart_button_font_italic_0" name="wp_timeline_edd_addtocart_button_font_italic" type="radio" value="0" <?php checked( 0, $wp_timeline_edd_addtocart_button_font_italic ); ?> />
															<label for="wp_timeline_edd_addtocart_button_font_italic_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
														</fieldset>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Transform', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select purchase button text transform style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_edd_addtocart_button_font_text_transform = isset( $wtl_settings['wp_timeline_edd_addtocart_button_font_text_transform'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_font_text_transform'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_edd_addtocart_button_font_text_transform" id="wp_timeline_edd_addtocart_button_font_text_transform">
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_transform, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_transform, 'capitalize' ); ?> value="capitalize"><?php esc_html_e( 'Capitalize', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_transform, 'uppercase' ); ?> value="uppercase"><?php esc_html_e( 'Uppercase', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_transform, 'lowercase' ); ?> value="lowercase"><?php esc_html_e( 'Lowercase', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_transform, 'full-width' ); ?> value="full-width"><?php esc_html_e( 'Full Width', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Text Decoration', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select purchase button text decoration style', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<?php $wp_timeline_edd_addtocart_button_font_text_decoration = isset( $wtl_settings['wp_timeline_edd_addtocart_button_font_text_decoration'] ) ? $wtl_settings['wp_timeline_edd_addtocart_button_font_text_decoration'] : 'none'; ?>
														<div class="select-cover">
															<select name="wp_timeline_edd_addtocart_button_font_text_decoration" id="wp_timeline_edd_addtocart_button_font_text_decoration">
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_decoration, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_decoration, 'underline' ); ?> value="underline"><?php esc_html_e( 'Underline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_decoration, 'overline' ); ?> value="overline"><?php esc_html_e( 'Overline', 'timeline-designer' ); ?></option>
																<option <?php selected( $wp_timeline_edd_addtocart_button_font_text_decoration, 'line-through' ); ?> value="line-through"><?php esc_html_e( 'Line Through', 'timeline-designer' ); ?></option>
															</select>
														</div>
													</div>
												</div>
												<div class="wp-timeline-typography-cover">
													<div class="wp-timeline-typography-label">
														<span class="wp-timeline-key-title"><?php esc_html_e( 'Letter Spacing (px)', 'timeline-designer' ); ?></span>
														<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enter purchase button letter spacing', 'timeline-designer' ); ?></span></span>
													</div>
													<div class="wp-timeline-typography-content">
														<div class="input-type-number"><input type="number" name="wp_timeline_edd_addtocart_button_letter_spacing" id="wp_timeline_edd_addtocart_button_letter_spacing" step="1" min="0" value="<?php echo isset( $wtl_settings['wp_timeline_edd_addtocart_button_letter_spacing'] ) ? esc_attr( $wtl_settings['wp_timeline_edd_addtocart_button_letter_spacing'] ) : '0'; ?>" onkeypress="return isNumberKey(event)"></div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<?php
				}
				?>
				<?php if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) { ?>
				<div id="wp_timeline_acffieldssetting" class="postbox postbox-with-fw-options" <?php echo esc_attr( $wp_timeline_acffieldssetting_class_show ); ?>>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Display Acf Field', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Show ACF field', 'timeline-designer' ); ?></span></span>
									<?php
									$display_acf_field = '0';
									if ( isset( $wtl_settings['display_acf_field'] ) ) {
										$display_acf_field = $wtl_settings['display_acf_field'];
									}
									?>
									<fieldset class="wp-timeline-social-style buttonset buttonset-hide" data-hide='1'>
										<input id="display_acf_field_1" name="display_acf_field" type="radio" value="1" <?php checked( 1, $display_acf_field ); ?> />
										<label id="wp-timeline-options-button" for="display_acf_field_1" <?php checked( 1, $display_acf_field ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="display_acf_field_0" name="display_acf_field" type="radio" value="0" <?php checked( 0, $display_acf_field ); ?> />
										<label id="wp-timeline-options-button" for="display_acf_field_0" <?php checked( 1, $display_acf_field ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class="wp_timeline_setting_acf_field">
								<?php
								$custom_post_type = isset( $wtl_settings['custom_post_type'] ) ? $wtl_settings['custom_post_type'] : 'post';
								$post_ids         = get_posts(
									array(
										'fields'         => 'ids',
										'posts_per_page' => -1,
									)
								);
								$groups           = acf_get_field_groups(
									array(
										'post_id'   => $post_ids,
										'post_type' => $custom_post_type,
									)
								);
								if ( ! empty( $groups ) ) {
									wtl_lite_setting_left( esc_html__( 'Select ACF Field', 'timeline-designer' ) );
									?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-select"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Filter post via category', 'timeline-designer' ); ?></span></span>
									<?php $wp_timeline_acf_field = isset( $wtl_settings['wp_timeline_acf_field'] ) ? $wtl_settings['wp_timeline_acf_field'] : array(); ?>
									<select data-placeholder="<?php esc_attr_e( 'Choose acf field', 'timeline-designer' ); ?>" class="chosen-select" multiple style="width:220px;" name="wp_timeline_acf_field[]" id="wp_timeline_acf_field">
										<?php
										foreach ( $groups as $group ) {
											$group_id                                 = $group['ID'];
											$group_title                              = $group['title'];
											$all_acf_data[ $group_id ]                = array();
											$all_acf_data[ $group_id ]['group_id']    = $group_id;
											$all_acf_data[ $group_id ]['group_title'] = $group_title;
											$fields                                   = acf_get_fields( $group_id );
											if ( $fields ) {
												$all_acf_data[ $group_id ]['fields'] = array();
												$val_fields                          = 0;
												foreach ( $fields as $field ) {
													$field_id    = $field['ID'];
													$field_label = $field['label'];
													$field_key   = $field['key'];
													?>
													<option value="<?php echo esc_attr( $field_id ); ?>" 
														<?php
														if ( in_array( $field_id, $wp_timeline_acf_field, true ) ) {
															echo 'selected="selected"';
														}
														?>
													><?php echo esc_html( $field_label ); ?></option>
													<?php
												}
											}
										}
										?>
									</select>
								</div>
								<?php } ?>
							</li>
						</ul>
					</div>
				</div>
				<?php } ?>
				<div id="wp_timeline_social" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_social_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li>
								<?php wtl_lite_setting_left( esc_html__( 'Social Share', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable social share link', 'timeline-designer' ); ?></span></span>
									<?php $social_share = isset( $wtl_settings['social_share'] ) ? $wtl_settings['social_share'] : 1; ?>
									<fieldset class="wp-timeline-social-options buttonset buttonset-hide" data-hide='1'>
										<input id="social_share_1" name="social_share" type="radio" value="1" <?php checked( 1, $social_share ); ?> />
										<label id="" for="social_share_1" <?php checked( 1, $social_share ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Enable', 'timeline-designer' ); ?></label>
										<input id="social_share_0" name="social_share" type="radio" value="0" <?php checked( 0, $social_share ); ?> />
										<label id="" for="social_share_0" <?php checked( 0, $social_share ); ?> class="<?php echo esc_attr( $uic_r ); ?>"> <?php esc_html_e( 'Disable', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class ="social_share_options">
								<?php wtl_lite_setting_left( esc_html__( 'Social Share Style', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select social share style', 'timeline-designer' ); ?></span></span>
									<?php
									$social_style = '1';
									if ( isset( $wtl_settings['social_style'] ) ) {
										$social_style = $wtl_settings['social_style'];
									}
									?>
									<fieldset class="wp-timeline-social-style buttonset buttonset-hide green" data-hide='1'>
										<input id="social_style_0" name="social_style" type="radio" value="0" <?php checked( 0, $social_style ); ?> />
										<label id="wp-timeline-options-button" for="social_style_0" <?php checked( 0, $social_style ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Default', 'timeline-designer' ); ?></label>
										<input id="social_style_1" name="social_style" type="radio" value="1" <?php checked( 1, $social_style ); ?> />
										<label id="wp-timeline-options-button" for="social_style_1" <?php checked( 1, $social_style ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Custom', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class ="social_share_options shape_social_icon">
								<?php wtl_lite_setting_left( esc_html__( 'Shape of Social Icon', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select shape of social icon', 'timeline-designer' ); ?></span></span>
									<?php $social_icon_style = isset( $wtl_settings['social_icon_style'] ) ? $wtl_settings['social_icon_style'] : 1; ?>
									<fieldset class="wp-timeline-social-shape buttonset buttonset-hide green" data-hide='1'>
										<input id="social_icon_style_0" name="social_icon_style" type="radio" value="0" nhp-opts-button-hide-below <?php checked( 0, $social_icon_style ); ?> />
										<label id="wp-timeline-options-button" for="social_icon_style_0" <?php checked( 0, $social_icon_style ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Circle', 'timeline-designer' ); ?></label>
										<input id="social_icon_style_1" name="social_icon_style" type="radio" value="1" nhp-opts-button-hide-below <?php checked( 1, $social_icon_style ); ?> />
										<label id="wp-timeline-options-button" for="social_icon_style_1" <?php checked( 1, $social_icon_style ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'Square', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class ="social_share_options size_social_icon">
								<?php wtl_lite_setting_left( esc_html__( 'Size of Social Icon', 'timeline-designer' ) ); ?>                               
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select size of social icon', 'timeline-designer' ); ?></span></span>
									<?php $social_icon_size = isset( $wtl_settings['social_icon_size'] ) ? $wtl_settings['social_icon_size'] : '0'; ?>
									<fieldset class="wp-timeline-social-size buttonset buttonset-hide green wp-timeline-social-icon-size" data-hide='1'>
										<input id="social_icon_size_2" name="social_icon_size" type="radio" value="2" <?php checked( 2, $social_icon_size ); ?> />
										<label id="wp-timeline-options-button" for="social_icon_size_2" <?php checked( 2, $social_icon_size ); ?>><?php esc_html_e( 'Extra Small', 'timeline-designer' ); ?></label>
										<input id="social_icon_size_1" name="social_icon_size" type="radio" value="1" <?php checked( 1, $social_icon_size ); ?> />
										<label id="wp-timeline-options-button" for="social_icon_size_1" <?php checked( 1, $social_icon_size ); ?>><?php esc_html_e( 'Small', 'timeline-designer' ); ?></label>
										<input id="social_icon_size_0" name="social_icon_size" type="radio" value="0" <?php checked( 0, $social_icon_size ); ?> />
										<label id="wp-timeline-options-button" for="social_icon_size_0" <?php checked( 0, $social_icon_size ); ?>><?php esc_html_e( 'Large', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>
							<li class ="social_share_options default_icon_layouts">
								<?php wtl_lite_setting_left( esc_html__( 'Available Icon Themes', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon wp-timeline-tooltips-icon-social"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select icon theme from available icon theme', 'timeline-designer' ); ?></span></span>
									<?php
									$default_icon_theme = 1;
									if ( isset( $wtl_settings['default_icon_theme'] ) ) {
										$default_icon_theme = $wtl_settings['default_icon_theme'];
									}
									?>
									<div class="social-share-theme">
										<?php
										for ( $i = 1; $i <= 10; $i++ ) {
											?>
											<div class="social-cover social_share_theme_<?php echo esc_attr( $i ); ?>">
												<label>
													<input type="radio" id="default_icon_theme_<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $i ); ?>" name="default_icon_theme" <?php checked( $i, $default_icon_theme ); ?> />
													<span class="wp-timeline-social-icons facebook-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons twitter-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons linkdin-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons pin-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons whatsup-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons telegram-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons pocket-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons mail-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons reddit-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons digg-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons tumblr-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons skype-icon wp_timeline_theme_wrapper"></span>
													<span class="wp-timeline-social-icons wordpress-icon wp_timeline_theme_wrapper"></span>
												</label>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</li>
							<li class ="social_share_options wp-timeline-display-settings wp-timeline-social-share-options">
								<h3 class="wp-timeline-table-title"><?php esc_html_e( 'Social Share Links Settings', 'timeline-designer' ); ?></h3>
								<div class="wp-timeline-typography-wrapper">
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Facebook Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable facebook share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $facebook_link = isset( $wtl_settings['facebook_link'] ) ? $wtl_settings['facebook_link'] : 1; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-facebook_link buttonset buttonset-hide" data-hide='1'>
												<input id="facebook_link_1" name="facebook_link" type="radio" value="1" <?php checked( 1, $facebook_link ); ?> />
												<label id=""for="facebook_link_1" <?php checked( 1, $facebook_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="facebook_link_0" name="facebook_link" type="radio" value="0" <?php checked( 0, $facebook_link ); ?> />
												<label id="" for="facebook_link_0" <?php checked( 0, $facebook_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"> <?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
											<label class="social_link_with_count">
												<input id="facebook_link_with_count" name="facebook_link_with_count" type="checkbox" value="1" 
												<?php
												if ( isset( $wtl_settings['facebook_link_with_count'] ) ) {
													checked( 1, $wtl_settings['facebook_link_with_count'] );
												}
												?>
												/><?php esc_html_e( 'Hide Facebook Share Count', 'timeline-designer' ); ?>
											</label>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Twitter Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable twitter share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $twitter_link = isset( $wtl_settings['twitter_link'] ) ? $wtl_settings['twitter_link'] : 1; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-twitter_link buttonset buttonset-hide" data-hide='1'>
												<input id="twitter_link_1" name="twitter_link" type="radio" value="1" <?php checked( 1, $twitter_link ); ?> />
												<label for="twitter_link_1" <?php checked( 1, $twitter_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="twitter_link_0" name="twitter_link" type="radio" value="0" <?php checked( 0, $twitter_link ); ?> />
												<label for="twitter_link_0" <?php checked( 0, $twitter_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Linkedin Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable linkedin share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $linkedin_link = isset( $wtl_settings['linkedin_link'] ) ? $wtl_settings['linkedin_link'] : 1; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-linkedin_link buttonset buttonset-hide" data-hide='1'>
												<input id="linkedin_link_1" name="linkedin_link" type="radio" value="1" <?php checked( 1, $linkedin_link ); ?> />
												<label for="linkedin_link_1" <?php checked( 1, $linkedin_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="linkedin_link_0" name="linkedin_link" type="radio" value="0" <?php checked( 0, $linkedin_link ); ?> />
												<label for="linkedin_link_0" <?php checked( 0, $linkedin_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Pinterest Share link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable pinterest share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $pinterest_link = isset( $wtl_settings['pinterest_link'] ) ? $wtl_settings['pinterest_link'] : 1; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-linkedin_link buttonset buttonset-hide" data-hide='1'>
												<input id="pinterest_link_1" name="pinterest_link" type="radio" value="1" <?php checked( 1, $pinterest_link ); ?> />
												<label for="pinterest_link_1" <?php checked( 1, $pinterest_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="pinterest_link_0" name="pinterest_link" type="radio" value="0" <?php checked( 0, $pinterest_link ); ?> />
												<label for="pinterest_link_0" <?php checked( 0, $pinterest_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
											<label class="social_link_with_count">
												<input id="pinterest_link_with_count" name="pinterest_link_with_count" type="checkbox" value="1" 
												<?php
												if ( isset( $wtl_settings['pinterest_link_with_count'] ) ) {
													checked( 1, $wtl_settings['pinterest_link_with_count'] );
												}
												?>
												/>
												<?php esc_html_e( 'Hide Pinterest Share Count', 'timeline-designer' ); ?>
											</label>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Show Pinterest on Featured Image', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable pinterest share button on feature image', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $pinterest_image_share = isset( $wtl_settings['pinterest_image_share'] ) ? $wtl_settings['pinterest_image_share'] : 1; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-linkedin_link buttonset buttonset-hide" data-hide='1'>
												<input id="pinterest_image_share_1" name="pinterest_image_share" type="radio" value="1" <?php checked( 1, $pinterest_image_share ); ?> />
												<label for="pinterest_image_share_1" <?php checked( 1, $pinterest_image_share ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="pinterest_image_share_0" name="pinterest_image_share" type="radio" value="0" <?php checked( 0, $pinterest_image_share ); ?> />
												<label for="pinterest_image_share_0" <?php checked( 0, $pinterest_image_share ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Skype Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable skype share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $skype_link = isset( $wtl_settings['skype_link'] ) ? $wtl_settings['skype_link'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-twitter_link buttonset buttonset-hide" data-hide='1'>
												<input id="skype_link_1" name="skype_link" type="radio" value="1" <?php checked( 1, $skype_link ); ?> />
												<label for="skype_link_1" <?php checked( 1, $skype_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="skype_link_0" name="skype_link" type="radio" value="0" <?php checked( 0, $skype_link ); ?> />
												<label for="skype_link_0" <?php checked( 0, $skype_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Pocket Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable pocket share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $pocket_link = isset( $wtl_settings['pocket_link'] ) ? $wtl_settings['pocket_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-pocket_link buttonset buttonset-hide" data-hide='1'>
												<input id="pocket_link_1" name="pocket_link" type="radio" value="1" <?php checked( 1, $pocket_link ); ?> />
												<label for="pocket_link_1" <?php checked( 1, $pocket_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="pocket_link_0" name="pocket_link" type="radio" value="0" <?php checked( 0, $pocket_link ); ?> />
												<label for="pocket_link_0" <?php checked( 0, $pocket_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Telegram Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable telegram share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $telegram_link = isset( $wtl_settings['telegram_link'] ) ? $wtl_settings['telegram_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-telegram_link buttonset buttonset-hide" data-hide='1'>
												<input id="telegram_link_1" name="telegram_link" type="radio" value="1" <?php checked( 1, $telegram_link ); ?> />
												<label for="telegram_link_1" <?php checked( 1, $telegram_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="telegram_link_0" name="telegram_link" type="radio" value="0" <?php checked( 0, $telegram_link ); ?> />
												<label for="telegram_link_0" <?php checked( 0, $telegram_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Reddit Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable reddit share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $reddit_link = isset( $wtl_settings['reddit_link'] ) ? $wtl_settings['reddit_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-reddit_link buttonset buttonset-hide" data-hide='1'>
												<input id="reddit_link_1" name="reddit_link" type="radio" value="1" <?php checked( 1, $reddit_link ); ?> />
												<label for="reddit_link_1" <?php checked( 1, $reddit_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="reddit_link_0" name="reddit_link" type="radio" value="0" <?php checked( 0, $reddit_link ); ?> />
												<label for="reddit_link_0" <?php checked( 0, $reddit_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Digg Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable digg share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $digg_link = isset( $wtl_settings['digg_link'] ) ? $wtl_settings['digg_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-reddit_link buttonset buttonset-hide" data-hide='1'>
												<input id="digg_link_1" name="digg_link" type="radio" value="1" <?php checked( 1, $digg_link ); ?> />
												<label for="digg_link_1" <?php checked( 1, $digg_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="digg_link_0" name="digg_link" type="radio" value="0" <?php checked( 0, $digg_link ); ?> />
												<label for="digg_link_0" <?php checked( 0, $digg_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Tumblr Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable tumblr share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $tumblr_link = isset( $wtl_settings['tumblr_link'] ) ? $wtl_settings['tumblr_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-tumblr_link buttonset buttonset-hide" data-hide='1'>
												<input id="tumblr_link_1" name="tumblr_link" type="radio" value="1" <?php checked( 1, $tumblr_link ); ?> />
												<label for="tumblr_link_1" <?php checked( 1, $tumblr_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="tumblr_link_0" name="tumblr_link" type="radio" value="0" <?php checked( 0, $tumblr_link ); ?> />
												<label for="tumblr_link_0" <?php checked( 0, $tumblr_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'WordPress Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable WordPress share link', 'timeline-designer' ); ?></span></span>
										</div>
										<?php $wordpress_link = isset( $wtl_settings['wordpress_link'] ) ? $wtl_settings['wordpress_link'] : '0'; ?>
										<div class="wp-timeline-typography-content">
											<fieldset class="wp-timeline-social-options wp-timeline-wordpress_link buttonset buttonset-hide" data-hide='1'>
												<input id="wordpress_link_1" name="wordpress_link" type="radio" value="1" <?php checked( 1, $wordpress_link ); ?> />
												<label for="wordpress_link_1" <?php checked( 1, $wordpress_link ); ?> class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="wordpress_link_0" name="wordpress_link" type="radio" value="0" <?php checked( 0, $wordpress_link ); ?> />
												<label for="wordpress_link_0" <?php checked( 0, $wordpress_link ); ?> class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'Share via Mail', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable mail share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $email_link = isset( $wtl_settings['email_link'] ) ? $wtl_settings['email_link'] : 0; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-linkedin_link buttonset">
												<input id="email_link_1" class="wp-timeline-opts-button" name="email_link" type="radio" value="1" <?php checked( 1, $email_link ); ?> />
												<label id="wp-timeline-opts-button" for="email_link_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<label id="wp-timeline-opts-button" for="email_link_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
												<input id="email_link_0" class="wp-timeline-opts-button" name="email_link" type="radio" value="0" <?php checked( 0, $email_link ); ?> />
											</fieldset>
										</div>
									</div>
									<div class="wp-timeline-typography-cover">
										<div class="wp-timeline-typography-label">
											<span class="wp-timeline-key-title"><?php esc_html_e( 'WhatsApp Share Link', 'timeline-designer' ); ?></span>
											<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Enable/Disable whatsapp share link', 'timeline-designer' ); ?></span></span>
										</div>
										<div class="wp-timeline-typography-content">
											<?php $whatsapp_link = isset( $wtl_settings['whatsapp_link'] ) ? $wtl_settings['whatsapp_link'] : '0'; ?>
											<fieldset class="wp-timeline-social-options wp-timeline-whatsapp_link buttonset">
												<input id="whatsapp_link_1" class="wp-timeline-opts-button" name="whatsapp_link" type="radio" value="1" <?php checked( 1, $whatsapp_link ); ?> />
												<label id="wp-timeline-opts-button" for="whatsapp_link_1" class="<?php echo esc_attr( $uic_l ); ?>"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
												<input id="whatsapp_link_0" class="wp-timeline-opts-button" name="whatsapp_link" type="radio" value="0" <?php checked( 0, $whatsapp_link ); ?> />
												<label id="wp-timeline-opts-button" for="whatsapp_link_0" class="<?php echo esc_attr( $uic_r ); ?>"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
											</fieldset>
										</div>
									</div>
								</div>
							</li>
							<li class="social_share_options fb_access_token_div">
								<?php wtl_lite_setting_left( esc_html__( 'Facebook Access Token', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Facebook access token', 'timeline-designer' ); ?></span></span>
									<?php
									$facebook_token = '';
									if ( isset( $wtl_settings['facebook_token'] ) ) {
										$facebook_token = $wtl_settings['facebook_token'];
									}
									?>
									<input type="text" name="facebook_token" id="facebook_token" value="<?php echo esc_attr( $facebook_token ); ?>" >
								</div>
							</li>
							<li class ="social_share_options mail_share_content">
								<?php wtl_lite_setting_left( esc_html__( 'Mail Share Content', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Mail share content', 'timeline-designer' ); ?></span></span>
									<?php $mail_subject = ( isset( $wtl_settings['mail_subject'] ) && '' != $wtl_settings['mail_subject'] ) ? $wtl_settings['mail_subject'] : '[post_title]'; ?>
									<input type="text" name="mail_subject" id="mail_subject" value="<?php echo esc_attr( $mail_subject ); ?>" placeholder="<?php esc_attr_e( 'Enter Mail Subject', 'timeline-designer' ); ?>">
									<?php
									$settings = array(
										'wpautop'       => true,
										'media_buttons' => true,
										'textarea_name' => 'mail_content',
										'textarea_rows' => 10,
										'tabindex'      => '',
										'editor_css'    => '',
										'editor_class'  => '',
										'teeny'         => false,
										'dfw'           => false,
										'tinymce'       => true,
										'quicktags'     => true,
									);
									if ( isset( $wtl_settings['mail_content'] ) && '' != $wtl_settings['mail_content'] ) {
										$contents = $wtl_settings['mail_content'];
									} else {
										$contents = esc_html__( 'My Dear friends,', 'timeline-designer' ) . '<br/><br/>' . esc_html__( 'I read one good blog link and I would like to share that same link with you. That might useful for you', 'timeline-designer' ) . '<br/><br/>[post_link]<br/><br/>' . esc_html__( 'Best Regards', 'timeline-designer' ) . ',<br/>' . esc_html__( 'WP Timeline', 'timeline-designer' );
									}
									wp_editor( html_entity_decode( $contents ), 'mail_content', $settings );
									?>
									<div class="div-pre">
										<p> [post_title] => <?php esc_html_e( 'Post Title', 'timeline-designer' ); ?> </p>
										<p> [post_link] => <?php esc_html_e( 'Post Link', 'timeline-designer' ); ?> </p>
										<p> [post_thumbnail] => <?php esc_html_e( 'Post Featured Image', 'timeline-designer' ); ?> </p>
										<p> [sender_name] => <?php esc_html_e( 'Mail Sender Name', 'timeline-designer' ); ?> </p>
										<p> [sender_email] => <?php esc_html_e( 'Mail Sender Email Address', 'timeline-designer' ); ?> </p>
									</div>
								</div>
							</li>

							<li class ="social_share_options">
								<?php wtl_lite_setting_left( esc_html__( 'Social Share Count Position', 'timeline-designer' ) ); ?>

								<div class="wp-timeline-right"><span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select social share count position', 'timeline-designer' ); ?></span></span>
									<?php
									$social_count_position = 'bottom';
									if ( isset( $wtl_settings['social_count_position'] ) ) {
										$social_count_position = $wtl_settings['social_count_position'];
									}
									?>
									<div class="typo-field">
										<select name="social_count_position" id="social_sharecount">
											<option value="bottom" <?php echo selected( 'bottom', $social_count_position ); ?>><?php esc_html_e( 'Bottom', 'timeline-designer' ); ?></option>
											<option value="right" <?php echo selected( 'right', $social_count_position ); ?>><?php esc_html_e( 'Right', 'timeline-designer' ); ?></option>
											<option value="top" <?php echo selected( 'top', $social_count_position ); ?>><?php esc_html_e( 'Top', 'timeline-designer' ); ?></option>
										</select>
									</div>
								</div>
							</li>
							<li class="social_share_options social_share_position_option">
								<?php wtl_lite_setting_left( esc_html__( 'Social Share Position', 'timeline-designer' ) ); ?>
								<div class="wp-timeline-right"><span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select social share position', 'timeline-designer' ); ?></span></span>
									<?php
									$social_share_position = 'left';
									if ( isset( $wtl_settings['social_share_position'] ) ) {
										$social_share_position = $wtl_settings['social_share_position'];
									}
									?>
									<div class="typo-field">
										<select name="social_share_position" id="social_share_position">
											<option value="left" <?php echo selected( 'left', $social_share_position ); ?>><?php esc_html_e( 'Left', 'timeline-designer' ); ?></option>
											<option value="center" <?php echo selected( 'center', $social_share_position ); ?>><?php esc_html_e( 'Center', 'timeline-designer' ); ?></option>
											<option value="right" <?php echo selected( 'right', $social_share_position ); ?>><?php esc_html_e( 'Right', 'timeline-designer' ); ?></option>
										</select>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php do_action( 'wtl_layout_settings', 'tab_content' ); ?>
			</div>
		</div>
	</form>
	<div id="popupdiv" class="wp-timeline-template-popupdiv" style="display: none;">
		<?php
		foreach ( $tempate_list as $key => $value ) {
			$classes = explode( ' ', $value['class'] );
			foreach ( $classes as $class ) {
				$all_class[] = $class;
			}
		}
		$count = array_count_values( $all_class );
		?>
		<ul class="wp_timeline_template_tab">
				<li class="wp_current_tab c1">
					<a href="#all"><?php esc_html_e( 'All', 'blog-designer' ); ?></a>
				</li>
				<li class="wp_current_tab">
					<a href="#free"><?php echo esc_html__( 'Free', 'blog-designer' ) . ' (' . esc_attr( $count['free'] ) . ')'; ?></a>
				</li>
			<div class="wp-timeline-blog-template-search-cover">
				<input type="text" class="wp-timeline-template-search" id="wp-timeline-template-search" placeholder="<?php esc_html_e( 'Search Template', 'timeline-designer' ); ?>" />
				<span class="wp-timeline-template-search-clear"></span>
			</div>
		</ul>
		<?php
		echo '<div class="wp-timeline-blog-template-cover">';
		foreach ( $tempate_list as $key => $value ) {
			if ( 'soft_block' == $key || 'advanced_layout' == $key || 'hire_layout' == $key || 'fullwidth_layout' == $key || 'curve_layout' == $key || 'easy_layout' == $key ) {
				$class = 'wt-lite';
			} else {
				$class = 'wt-pro';
			}
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
				<span class="wp-timeline-span-template-name"><?php echo esc_html( $value['template_name'] ); ?></span>
			</div>
			<?php
		}
		echo '</div>';
		echo '<h3 class="no-template" style="display: none;">' . esc_html__( 'No template found. Please try again', 'timeline-designer' ) . '</h3>';
		?>
	</div>
	<div id="popuploaderdiv" class="wp-timeline-loader-popupdiv wp-timeline-wrapper" style="display: none;">
		<div class="wp-timeline-loader-style-box">
			<?php
			$total_bullets = count( $loaders );
			$allowed_html  = array(
				'div'  => array(
					'class' => array(),
				),
				'ul'   => array(
					'class' => array(),
				),
				'li'   => array(
					'class' => array(),
				),
				'span' => array(
					'class' => array(),
				),
				'i'    => array(
					'class' => array(),
				),
			);
			if ( $total_bullets > 0 ) {
				foreach ( $loaders as $key => $loader_html ) {
					?>
					<div class="wp-timeline-dialog-loader-style <?php echo esc_attr( $key ); ?>">
						<input type="hidden" class="wp-timeline-loader-style-hidden" value="<?php echo esc_attr( $key ); ?>" />
						<div class="wp-timeline-loader-style-html"><?php echo wp_kses( $loader_html, $allowed_html ); ?></div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<div id="popupnavifationdiv" class="wp-timeline-navigation-popupdiv wp-timeline-wrapper" style="display: none;">
		<div class="wp-timeline-navigation-style-box">
			<?php
			for ( $i = 1; $i <= 9; $i++ ) {
				?>
				<div class="wp-timeline-navigation-cover navigation<?php echo esc_attr( $i ); ?>">
					<input type="hidden" class="wp-timeline-navigation-style-hidden" value="navigation<?php echo esc_attr( $i ); ?>" />
					<img src="<?php echo esc_url( TLD_URL ) . '/images/navigation/navigation' . esc_attr( $i ) . '.png'; ?>">
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<div id="popuparrowdiv" class="wp-timeline-arrow-popupdiv wp-timeline-wrapper" style="display: none;">
		<div class="wp-timeline-arrow-style-box">
			<?php
			for ( $i = 1; $i <= 6; $i++ ) {
				?>
				<div class="wp-timeline-arrow-cover arrow<?php echo esc_attr( $i ); ?>">
					<input type="hidden" class="wp-timeline-arrow-style-hidden" value="arrow<?php echo esc_attr( $i ); ?>" />
					<img src="<?php echo esc_url( TLD_URL ) . '/images/arrow/arrow' . esc_attr( $i ) . '.png'; ?>">
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<div id="wtd-advertisement-popup">
		<div class="wtd-advertisement-cover">
			<a class="wtd-advertisement-link" target="_blank" href="<?php echo esc_url( 'https://codecanyon.net/item/wp-timeline-designer-pro-wordpress-timeline-plugin/29067364?ref=solwin' ); ?>">
				<img src="<?php echo esc_url( TLD_URL ) . '/images/wtd_advertisement_popup.jpg'; ?>" />
			</a>
		</div>
	</div>
</div>
