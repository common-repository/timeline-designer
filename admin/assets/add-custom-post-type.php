<?php
/**
 * The template-config functionality of the plugin.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/admin
 */

/**
 * Add/Edit Timeline Layout setting page.
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/admin
 * @author     Solwin Infotech <info@solwininfotech.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_version, $wpdb, $wp_timeline_errors, $wtl_success;
$portfolio_cpts_edit = false;
if ( ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) && isset( $_GET['id'] ) && '' != $_GET['id'] ) {
	global $wpdb;
	$cpt_id              = sanitize_text_field( wp_unslash( $_GET['id'] ) );
	$data                = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_cpts WHERE id = %d', $cpt_id ), 'ARRAY_A' );
	$cpt_data            = maybe_unserialize( $data['setting'] );
	$portfolio_cpts_edit = true;
}
if ( isset( $_GET['id'] ) ) {
	$cpt_id              = sanitize_text_field( wp_unslash( $_GET['id'] ) );
	$data                = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wtl_cpts WHERE id = %d', $cpt_id ), 'ARRAY_A' );
	$cpt_data            = maybe_unserialize( $data['setting'] );
	$portfolio_cpts_edit = true;
}

$uic_l = 'ui-corner-left';
$uic_r = 'ui-corner-right';
?>
<div class="wrap">
	<h1>
		<?php
		if ( $portfolio_cpts_edit ) {
			esc_html_e( 'Edit Custom Post Type', 'timeline-designer' ) . ' - ' . $data['name'];
		} else {
			esc_html_e( 'Add New Custom Post Type', 'timeline-designer' );
		}
		?>
	</h1>
	<?php if ( isset( $_GET['message'] ) && 'shortcode_added_msg' === $_GET['message'] ) { ?>
		<div class="updated notice">
			<p><?php esc_html_e( 'Custom Post Type has been added successfully.', 'timeline-designer' ); ?></p>
		</div>
		<?php
	}
	if ( isset( $_GET['message'] ) && 'shortcode_duplicate_msg' === $_GET['message'] ) {
		?>
		<div class="updated notice"><p><?php esc_html_e( 'Layout has been duplicated successfully.', 'timeline-designer' ); ?></p></div>
		<?php
	}
	if ( isset( $wp_timeline_errors ) ) {
		if ( is_wp_error( $wp_timeline_errors ) ) {
			?>
			<div class="error notice"><p><?php echo esc_html( $wp_timeline_errors->get_error_message() ); ?></p></div>
			<?php
		}
	}
	if ( isset( $wtl_success ) ) {
		?>
		<div class="updated notice"><p><?php echo esc_html( $wtl_success ); ?></p></div>
		<?php
	}
	?>
	<div class="splash-screen"></div>
	<form method="post" id="edit_layout_form" action="" class="wp-timeline-form-class wp-timeline-edit-layout">
		<?php
		wp_nonce_field( 'wtl-cpt-form-submit', 'wtl-cpt-form-submit-nonce' );
		$cpt_page = '';
		if ( isset( $_GET['page'] ) && '' != $_GET['page'] ) {
			$cpt_page = sanitize_text_field( wp_unslash( $_GET['page'] ) );
			?>
			<input type="hidden" name="originalpage" class="wp_timeline_originalpage" value="<?php echo esc_attr( $cpt_page ); ?>">
			<?php
		}
		?>
		<div id="poststuff">
			<div class="postbox-container wp-timeline-settings-wrappers bd_poststuff">
				<div class="wp-timeline-preview-box" id="wp-timeline-preview-box"></div>
				<div class="wp-timeline-header-wrapper">
					<div class="wp-timeline-logo-wrapper pull-left">
						<h3 style="padding-left:230px"><?php esc_html_e( 'Custom Post Type Generator', 'timeline-designer' ); ?></h3>
					</div>
					<div class="pull-right">
						<a id="wp-timeline-btn-show-submit" title="<?php esc_html_e( 'Save Changes', 'timeline-designer' ); ?>" class="show_preview button submit_fixed button-primary">
							<span><i class="fas fa-check"></i>&nbsp;&nbsp;<?php esc_html_e( 'Save Changes', 'timeline-designer' ); ?></span>
						</a>
						<input type="submit" style="display:none;" class="button-primary bloglyout_savebtn button" name="savedata" value="<?php esc_attr_e( 'Save Changes', 'timeline-designer' ); ?>" />
					</div>
				</div>
				<div class="wp-timeline-menu-setting">
					<?php
					$wp_timeline_slider_class      = '';
					$wp_timline_cpt_tax_class      = '';
					$wp_timeline_cpt_class         = '';
					$wp_timeline_slider_class_show = '';
					$wp_timline_cpt_tax_class_show = '';
					$wp_timeline_cpt_class_show    = '';
					if ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timeline_cpt', $cpt_page ) ) {
						$wp_timeline_cpt_class      = 'wp-timeline-active-tab';
						$wp_timeline_cpt_class_show = 'display: block';
					} elseif ( Wp_Timeline_Lite_Main::wtl_postbox_classes( 'wp_timline_cpt_tax', $cpt_page ) ) {
						$wp_timline_cpt_tax_class      = 'wp-timeline-active-tab';
						$wp_timline_cpt_tax_class_show = 'display: block';
					} else {
						$wp_timeline_cpt_class      = 'wp-timeline-active-tab';
						$wp_timeline_cpt_class_show = 'display: block';
					}
					?>
					<ul class="wp-timeline-setting-handle">
						<li data-show="wp_timeline_cpt" class='<?php echo esc_attr( $wp_timeline_cpt_class ); ?>'>
							<i class="fas fa-thumbtack"></i><span><?php esc_html_e( 'Custom Post Type', 'timeline-designer' ); ?></span>
						</li>

						<li data-show="wp_timline_cpt_tax" class='<?php echo esc_attr( $wp_timline_cpt_tax_class ); ?>'>
							<i class="fas fa-filter"></i><span><?php esc_html_e( 'Custom Post Type Taxonomy', 'timeline-designer' ); ?></span>
						</li>
						<?php do_action( 'wtl_layout_settings', 'tab' ); ?>
					</ul>
				</div>
				<!--- ---------- Custom Post Type Generator ----------- -->
				<div id="wp_timeline_cpt" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timeline_cpt_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li>
								<h3 class="wp-timeline-table-title">
									<?php
									if ( $portfolio_cpts_edit ) {
										esc_html_e( 'Edit Custom Post Type', 'timeline-designer' ) . ' - ' . $data['name'];
									} else {
										esc_html_e( 'Create New Cusom Post Type', 'timeline-designer' );
									}
									?>
								</h3>
								<div class="wp-timeline-setting-description"><b class="note"><?php esc_html_e( 'Caution', 'timeline-designer' ); ?>:</b> &nbsp; <?php esc_html_e( 'Be careful while creating slugs, It will appear in the URL. If you change the slugs then you may lost your data. After creating custom post, do not forgot to save permalinks ( Settings -> Permalinks ). ', 'timeline-designer' ); ?></div>
							</li>                            
							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Post Type Plural Name', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Add Custom Post Type Plural Name', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpts_plural" id="cpts_plural" value="<?php echo isset( $data['name'] ) ? esc_attr( $data['name'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Plural Name', 'timeline-designer' ); ?>">
									<br><br>
									<div class="wp-timeline-setting-description"><?php esc_html_e( 'General name for the post type, usually plural (e.g. Portfolios, Projects, Galleries).', 'timeline-designer' ); ?></div>
								</div>
							</li>
							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Post Type Singular Name', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Add Custom Post Type Singular Name', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpts_singular" id="cpts_singular" value="<?php echo isset( $cpt_data['cpts_singular'] ) ? esc_attr( $cpt_data['cpts_singular'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Singular Name', 'timeline-designer' ); ?>">
									<br><br>
									<div class="wp-timeline-setting-description"><?php esc_html_e( 'Name for one object of this post type (e.g. Portfolio, Project).', 'timeline-designer' ); ?></div>
								</div>
							</li>
							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Post Type Slug', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Add Custom Post Type Slug', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpts_slug" id="cpts_slug" value="<?php echo isset( $data['slug'] ) ? esc_attr( $data['slug'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Slug', 'timeline-designer' ); ?>">
									<br><br>
									<div class="wp-timeline-setting-description"><?php esc_html_e( 'URL friendly version of the custom post type (e.g. portfolio, project).', 'timeline-designer' ); ?></div>
								</div>
							</li>
							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Post Type Icon', 'timeline-designer' ); ?></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select option to add icon in custom post type menu', 'timeline-designer' ); ?></span></span>
									<?php $cpt_icon_type = isset( $cpt_data['cpt_icon_type'] ) ? $cpt_data['cpt_icon_type'] : '1'; ?>
									<fieldset class="wp-timeline-social-options wp-timeline-cpt_icon_type buttonset buttonset-hide ui-buttonset green">
										<input id="cpt_icon_type_1" name="cpt_icon_type" type="radio" value="1" <?php checked( 1, $cpt_icon_type ); ?> />
										<label id="wp-timeline-options-button" data-id="wtl_cpt_icon_wordpress" for="cpt_icon_type_1" class="<?php echo esc_attr( $uic_l ); ?>" <?php checked( 1, $cpt_icon_type ); ?>><?php esc_html_e( 'WordPress Icon', 'timeline-designer' ); ?></label>
										<input id="cpt_icon_type_2" name="cpt_icon_type" type="radio" value="2" <?php checked( 2, $cpt_icon_type ); ?> />
										<label id="wp-timeline-options-button" data-id="wtl_cpt_icon_custom" for="cpt_icon_type_2" <?php checked( 2, $cpt_icon_type ); ?> class="<?php echo esc_attr( $uic_r ); ?>" ><?php esc_html_e( 'Cusotm Icon', 'timeline-designer' ); ?></label>
									</fieldset>
									<br><br>
									<div class="wtl_cpt_icon_wordpress">
										<input type="text" name="cpt_icon_wordpress" id="cpt_icon_wordpress" value="<?php echo isset( $cpt_data['cpt_icon_wp'] ) ? esc_attr( $cpt_data['cpt_icon_wp'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'dashicons-portfolio', 'timeline-designer' ); ?>">
										<p class="wordpress_icon_message"><?php esc_html_e( 'Icon for your custom post type. For more icons', 'timeline-designer' ); ?> <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank"><?php esc_html_e( 'Click here', 'timeline-designer' ); ?></a></p>
									</div>
									<div class="wtl_cpt_icon_custom">
										<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Select post default image', 'timeline-designer' ); ?></span></span>
										<span class="wp_timeline_default_image_holder">
											<?php
											if ( isset( $cpt_data['cpt_img_src'] ) && '' != $cpt_data['cpt_img_src'] ) {
												$cpt_img_src = isset( $cpt_data['cpt_img_src'] ) ? $cpt_data['cpt_img_src'] : '';
												echo '<img src="' . esc_attr( $cpt_img_src ) . '"/>';
											}
											?>
										</span>
										<?php if ( isset( $cpt_data['cpt_img_src'] ) && '' != $cpt_data['cpt_img_src'] ) { ?>
											<input id="wp-timeline-image-action-button" class="button wp-timeline-remove_image_button" type="button" value="<?php esc_attr_e( 'Remove Image', 'timeline-designer' ); ?>">
										<?php } else { ?>
											<input class="button wp-timeline-upload_image_button" type="button" value="<?php esc_attr_e( 'Upload Image', 'timeline-designer' ); ?>">
										<?php } ?>
										<input type="hidden" value="<?php echo isset( $cpt_data['cpt_img_id'] ) ? esc_attr( $cpt_data['cpt_img_id'] ) : ''; ?>" name="cpt_icon_custom_img_id" id="wp_timeline_default_image_id">
										<input type="hidden" value="<?php echo isset( $cpt_data['cpt_img_src'] ) ? esc_attr( $cpt_data['cpt_img_src'] ) : ''; ?>" name="cpt_icon_custom_img_src" id="wp_timeline_default_image_src">
									</div>

								</div>
							</li>
						</ul>
					</div>
				</div>
				<!--- ---------- Custom Post Type Taxonomy Generator ----------- -->
				<div id="wp_timline_cpt_tax" class="postbox postbox-with-fw-options" style='<?php echo esc_attr( $wp_timline_cpt_tax_class_show ); ?>'>
					<div class="inside">
						<ul class="wp-timeline-settings wp-timeline-lineheight">
							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Create Custom Category', 'timeline-designer' ); ?></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( ' Enable/Disable create custom category', 'timeline-designer' ); ?></span></span>
									<?php $cpt_category = isset( $cpt_data['cpts_category'] ) ? $cpt_data['cpts_category'] : '0'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="cpt_category_1" name="cpt_category" type="radio" value="1" <?php checked( 1, $cpt_category ); ?> />
										<label id="wp-timeline-options-button" for="cpt_category_1" class="<?php echo esc_attr( $uic_l ); ?>" <?php checked( 1, $cpt_category ); ?>><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="cpt_category_0" name="cpt_category" type="radio" value="0" <?php checked( 0, $cpt_category ); ?> />
										<label id="wp-timeline-options-button" for="cpt_category_0" class="<?php echo esc_attr( $uic_r ); ?>" <?php checked( 0, $cpt_category ); ?>><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>

							<li class="li_cpt_category_name">
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Category Name', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Custom Category Name', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpt_category_name" id="cpt_category_name" value="<?php echo isset( $cpt_data['cpts_category_name'] ) ? esc_attr( $cpt_data['cpts_category_name'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Custom Category Name', 'timeline-designer' ); ?>">
								</div>
							</li>

							<li class="li_cpt_category_slug">
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Category Slug ', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Custom Category Slug', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpt_category_slug" id="cpt_category_slug" value="<?php echo isset( $cpt_data['cpts_category_slug'] ) ? esc_attr( $cpt_data['cpts_category_slug'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Custom Category Slug ', 'timeline-designer' ); ?>">
								</div>
							</li>

							<li>
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Create Custom Tag', 'timeline-designer' ); ?></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( ' Enable/Disable create custom tag', 'timeline-designer' ); ?></span></span>
									<?php $cpt_taxonomy_tag = isset( $cpt_data['cpts_tag'] ) ? $cpt_data['cpts_tag'] : '0'; ?>
									<fieldset class="buttonset buttonset-hide" data-hide='1'>
										<input id="cpt_taxonomy_tag_1" name="cpt_taxonomy_tag" type="radio" value="1" <?php checked( 1, $cpt_taxonomy_tag ); ?> />
										<label id="wp-timeline-options-button" for="cpt_taxonomy_tag_1" class="<?php echo esc_attr( $uic_l ); ?>" <?php checked( 1, $cpt_taxonomy_tag ); ?>><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
										<input id="cpt_taxonomy_tag_0" name="cpt_taxonomy_tag" type="radio" value="0" <?php checked( 0, $cpt_taxonomy_tag ); ?> />
										<label id="wp-timeline-options-button" for="cpt_taxonomy_tag_0" class="<?php echo esc_attr( $uic_r ); ?>" <?php checked( 0, $cpt_taxonomy_tag ); ?>><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
									</fieldset>
								</div>
							</li>

							<li class="li_cpt_tag_name">
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Tag Name', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Custom Tag Name', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpt_tag_name" id="cpt_tag_name" value="<?php echo isset( $cpt_data['cpts_tag_name'] ) ? esc_attr( $cpt_data['cpts_tag_name'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Custom Tag Name', 'timeline-designer' ); ?>">
								</div>
							</li>

							<li class="li_cpt_tag_slug">
								<div class="wp-timeline-left"><span class="wp-timeline-key-title"><?php esc_html_e( 'Custom Tag Slug ', 'timeline-designer' ); ?><span class="required_field">*</span></span></div>
								<div class="wp-timeline-right">
									<span class="fas fa-question-circle wp-timeline-tooltips-icon"><span class="wp-timeline-tooltips"><?php esc_html_e( 'Custom Tag Slug ', 'timeline-designer' ); ?></span></span>
									<input type="text" name="cpt_tag_slug" id="cpt_tag_slug" value="<?php echo isset( $cpt_data['cpts_tag_slug'] ) ? esc_attr( $cpt_data['cpts_tag_slug'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Custom Tag Slug ', 'timeline-designer' ); ?>">
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php do_action( 'wtl_layout_settings', 'tab_content' ); ?>
			</div>
		</div>
	</form>	
</div>
<?php
