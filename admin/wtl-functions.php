<?php
/**
 * The template-config functionality of the plugin.
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
 * @subpackage Wp_Timeline/admin
 * @author     Solwin Infotech <info@solwininfotech.com>
 */

/**
 * Insert layout.
 */
if ( ! function_exists( 'wtl_insert_layout' ) ) {
	/**
	 * Insert Layout
	 *
	 * @since  1.0.0
	 * @param  string $layout_name layout name.
	 * @param  array  $wtl_settings settings.
	 * @return int layout id
	 */
	function wtl_insert_layout( $layout_name, $wtl_settings ) {
		global $wpdb;
		$wtl_table_name = $wpdb->prefix . 'wtl_shortcodes';
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
		$insert = $wpdb->insert(
			$wtl_table_name,
			array(
				'shortcode_name' => sanitize_text_field( $layout_name ),
				'wtlsettngs'     => maybe_serialize( $wtl_settings ),
			),
			array( '%s', '%s' )
		);
		if ( false === $insert ) {
			return;
		} else {
			return $wpdb->insert_id;
		}
	}
}

if ( ! function_exists( 'wtl_lite_details_callback' ) ) {

	/**
	 * Details Callback
	 *
	 * @since  1.0.0
	 * @param  array $post post.
	 * @return void
	 */
	function wtl_lite_details_callback( $post ) {
		wp_nonce_field( 'wtl_details_save', 'wtl_single_details_meta_box_nonce' );
		$wtl_details                      = get_post_meta( $post->ID, '_wtl_single_details_key', false );
		$wtl_gallery_images               = isset( $wtl_details[0]['wtl_post_slideshow_images'] ) ? $wtl_details[0]['wtl_post_slideshow_images'] : '';
		$wtl_video_type                   = isset( $wtl_details[0]['wtl_post_video_type'] ) ? $wtl_details[0]['wtl_post_video_type'] : '';
		$wtl_video_id                     = isset( $wtl_details[0]['wtl_post_video_id'] ) ? $wtl_details[0]['wtl_post_video_id'] : '';
		$quote_text                       = isset( $wtl_details[0]['wtl_post_quote_text'] ) ? $wtl_details[0]['wtl_post_quote_text'] : '';
		$post_format                      = isset( $wtl_details[0]['wtl_post_format'] ) ? $wtl_details[0]['wtl_post_format'] : '';
		$display_post_custom_link         = isset( $wtl_details[0]['wtl_display_post_custom_link'] ) ? $wtl_details[0]['wtl_display_post_custom_link'] : 0;
		$post_custom_link                 = isset( $wtl_details[0]['wtl_post_custom_link'] ) ? $wtl_details[0]['wtl_post_custom_link'] : '';
		$wtl_single_display_timeline_icon = isset( $wtl_details[0]['wtl_single_display_timeline_icon'] ) ? $wtl_details[0]['wtl_single_display_timeline_icon'] : '';
		$wtl_single_timeline_icon         = isset( $wtl_details[0]['wtl_single_timeline_icon'] ) ? $wtl_details[0]['wtl_single_timeline_icon'] : '';
		$wtl_icon_image_src               = isset( $wtl_details[0]['wtl_icon_image_src'] ) ? $wtl_details[0]['wtl_icon_image_src'] : '';
		$wtl_icon_image_id                = isset( $wtl_details[0]['wtl_icon_image_id'] ) ? $wtl_details[0]['wtl_icon_image_id'] : '';
		$wtl_background_color             = isset( $wtl_details[0]['wtl_background_color'] ) ? $wtl_details[0]['wtl_background_color'] : '';
		$wtl_background_color_opt         = isset( $wtl_details[0]['wtl_background_color_opt'] ) ? $wtl_details[0]['wtl_background_color_opt'] : 0;
		$wtl_content_color                = isset( $wtl_details[0]['wtl_content_color'] ) ? $wtl_details[0]['wtl_content_color'] : '';
		$wtl_timeline_time                = isset( $wtl_details[0]['wtl_timeline_time'] ) ? $wtl_details[0]['wtl_timeline_time'] : '';
		$wtl_timeline_time_format         = isset( $wtl_details[0]['wtl_timeline_time_format'] ) ? $wtl_details[0]['wtl_timeline_time_format'] : '12hour';
		?>
		<div class="wtl_single_post_setting_wrapper wtl_spsw">
			<div class="wp_single_post format">
				<div class="wtl_single_fields wtl-option-wrap">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_html_e( 'Post Format', 'timeline-designer' ); ?></label></div>
					<div class="wtl-option-input">
						<select name="wtl_post_format" id="wtl_post_format">
							<option value="image" 
							<?php
							if ( 'image' === $post_format ) {
								echo 'selected="selected"';}
							?>
								><?php esc_html_e( 'Image', 'timeline-designer' ); ?></option>
							<option value="slideshow" 
							<?php
							if ( 'slideshow' === $post_format ) {
								echo 'selected="selected"';}
							?>
								><?php esc_html_e( 'Slide Show', 'timeline-designer' ); ?></option>
							<option value="video" 
							<?php
							if ( 'video' === $post_format ) {
								echo 'selected="selected"';}
							?>
								><?php esc_html_e( 'Video', 'timeline-designer' ); ?></option>
							<option value="quote" 
							<?php
							if ( 'quote' === $post_format ) {
								echo 'selected="selected"';}
							?>
								><?php esc_html_e( 'Quote', 'timeline-designer' ); ?></option>
						</select>
					</div>
				</div>
				<div class="wtl_single_image_format wtl-option-wrap">
					<span><?php esc_html_e( 'The featured image will be displayed.', 'timeline-designer' ); ?></span>
				</div>
				<div class="wtl_single_slideshow_format wtl-option-wrap">
					<div class="wtl-option-label">
						<label class="wtl-single-label"><?php esc_html_e( 'Slide Show Images', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl_option_wrap wtl-option-input">
						<div class="wtl_option_input gallery_image_wrap">
							<?php
							$allowed_html = array(
								'li'     => array(),
								'button' => array(),
								'img'    => array(
									'id'  => array(),
									'src' => array(),
								),
							);
							$gallery_html = '';
							$select_text  = esc_html__( 'Select Images', 'timeline-designer' );
							$visible      = 'hidden';
							if ( $wtl_gallery_images ) {
								$gallery_images = explode( ',', $wtl_gallery_images );
								foreach ( $gallery_images as $value ) {
									$gallery_html .= '<li><button></button><img id="' . esc_attr( $value ) . '" src="' . esc_url( wp_get_attachment_url( $value ) ) . '"></li> ';
								}
								$select_text = esc_html__( 'Edit Selection', 'timeline-designer' );
								$visible     = '';
							}
							?>
							<input type="hidden" name="wtl_gallery_images" id="wtl_gallery_images" value="<?php echo esc_attr( $wtl_gallery_images ); ?>" />
							<button class="button" id="wtl_gallery_select"><?php echo esc_attr( $select_text ); ?></button>
							<button class="button <?php echo esc_attr( $visible ); ?>" id="wtl_gallery_removeall"><?php esc_html_e( 'Remove All', 'timeline-designer' ); ?></button>
							<ul><?php echo wp_kses( $gallery_html, $allowed_html ); ?></ul>
						</div>
					</div>
				</div>
				<div class="wtl_single_video_format wtl-option-wrap">
					<div class="wtl-option-label">
						<label class="wtl-single-label"> <?php esc_html_e( 'Video Format', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<select name="wtl_single_video_type" class="wtl_single_video_type">
							<option value="youtube" 
							<?php
							if ( 'youtube' === $wtl_video_type ) {
								echo 'selected=selected'; }
							?>
							><?php esc_html_e( 'Youtube video', 'timeline-designer' ); ?></option>
							<option value="vimeo" 
							<?php
							if ( 'vimeo' === $wtl_video_type ) {
								echo 'selected=selected'; }
							?>
							><?php esc_html_e( 'Vimeo video', 'timeline-designer' ); ?></option>
							<option value="dailymotion" 
							<?php
							if ( 'dailymotion' === $wtl_video_type ) {
								echo 'selected=selected'; }
							?>
							><?php esc_html_e( 'Dailymotion video', 'timeline-designer' ); ?></option>
							<option value="html5" 
							<?php
							if ( 'html5' === $wtl_video_type ) {
								echo 'selected=selected'; }
							?>
							><?php esc_html_e( 'HTML5 Video', 'timeline-designer' ); ?></option>
						</select>
					</div>
				</div>
				<div class="wtl-option-wrap wtl-single-video-type-wrap">
					<div class="wtl-option-label">
						<label class="wtl-single-label"><?php esc_html_e( 'Video ID', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<input type="text" value="<?php echo esc_attr( $wtl_video_id ); ?>" name="wtl_single_video_id">
						<p class="post_field_desc wtl-single-video-description"> <?php esc_html_e( 'Enter the ID of video.', 'timeline-designer' ); ?></p>
					</div>
				</div>
				<div class="wtl-option-wrap wtl_single_quote_format">
					<div class="wtl-option-label">
						<label class="wtl-single-label"><?php esc_html_e( 'Quote Text', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<textarea name="wtl_post_quote_text"><?php echo esc_attr( $quote_text ); ?></textarea>
					</div>
				</div>
			</div>
			<div class="">
				<div class="wtl-option-wrap">
					<div class="wtl-option-label">
						<label class="wtl-single-label"> <?php esc_html_e( 'Display Post Custom Link', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<fieldset class="wp-timeline-social-options wp-timeline-display_author buttonset">
							<input id="display_post_custom_link_1" name="wtl_display_post_custom_link" type="radio" value="1" <?php echo checked( 1, $display_post_custom_link ); ?> />
							<label class="button ui-corner-left" for="display_post_custom_link_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>
							<input id="display_post_custom_link_0" name="wtl_display_post_custom_link" type="radio" value="0" <?php echo checked( 0, $display_post_custom_link ); ?> />
							<label class="button ui-corner-right" for="display_post_custom_link_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
						</fieldset>
					</div>
				</div>
				<div class="wtl-option-wrap wtl-post-link">
					<div class="wtl-option-label">
						<label class="wtl-single-label"> <?php esc_html_e( 'Enter Post Custom Link', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<input type="text" name="wtl_post_custom_link" value="<?php echo esc_attr( $post_custom_link ); ?>">
					</div>
				</div>
				<div class="wtl-option-wrap wtl-post-timeline-icon">
					<div class="wtl-option-label"><label class="wtl-single-label"> <?php esc_html_e( 'Post Timeline Icon', 'timeline-designer' ); ?></label></div>
					<div class="wtl-option-input">
						<select name="wtl_single_display_timeline_icon" class="wtl_single_display_timeline_icon">
							<option value="fontawesome" 
							<?php
							if ( 'fontawesome' === $wtl_single_display_timeline_icon ) {
								echo 'selected=selected'; }
							?>
							><?php esc_html_e( 'Font Awesome', 'timeline-designer' ); ?></option>
							<option value="image" 
							<?php
							if ( 'image' === $wtl_single_display_timeline_icon ) {
								echo 'selected=selected';
							}
							?>
							><?php esc_html_e( 'Image', 'timeline-designer' ); ?></option>
						</select>
					</div>
				</div>
				<div class="wtl-option-wrap wtl-option-timeline-icon-fontawesome">
					<div class="wtl-option-label">
						<label class="wtl-single-label"> <?php esc_html_e( 'Post Timeline Icon', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input wtl_single_icon_wrap">
						<input class="icon-input" id="wtl_single_timeline_icon" name="wtl_single_timeline_icon" type="text" value="<?php echo esc_attr( $wtl_single_timeline_icon ); ?>">
						<a id="" class="open button button-primary"><?php esc_html_e( 'Select icon', 'timeline-designer' ); ?></a>
						<div id="dialogbox" class="dialogbox" title="<?php esc_attr_e( 'Select Icon', 'timeline-designer' ); ?>" style="display:none">
							<input type="hidden" value="" name="" class="hidden_input_val"/>
							<input type="text" id="icon_search" placeholder="<?php esc_attr_e( 'Search icon', 'timeline-designer' ); ?>" style="margin-bottom:5px;">
							<div class="wtl_single_icon_div" id="wtl_single_icon_div">
							</div>
						</div>
					</div>
				</div>
				<div class="wtl-option-wrap wtl-option-timeline-icon-image">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_attr_e( 'Timeline Icon Image', 'timeline-designer' ); ?></label></div>
					<div class="wtl_option_wrap wtl-option-input">
						<span class="wtl_default_image_holder wtl_icon_image">
							<?php
							if ( isset( $wtl_icon_image_src ) && '' !== $wtl_icon_image_src ) {
								echo '<img src="' . esc_url( $wtl_icon_image_src ) . '"/>';
							}
							?>
						</span>
						<?php if ( isset( $wtl_icon_image_src ) && '' !== $wtl_icon_image_src ) { ?>
							<input id="wtl-image-action-button" class="button wtl_remove_image_button wtl_icon_image" type="button" value="<?php esc_attr_e( 'Remove Image', 'timeline-designer' ); ?>">
						<?php } else { ?>
							<input class="button wtl_single_upload_image_button wtl_icon_image" type="button" value="<?php esc_attr_e( 'Upload Image', 'timeline-designer' ); ?>">
						<?php } ?>
						<input type="hidden" value="<?php echo esc_attr( $wtl_icon_image_id ); ?>" name="wtl_icon_image_id" id="wtl_icon_image_id">
						<input type="hidden" value="<?php echo esc_attr( $wtl_icon_image_src ); ?>" name="wtl_icon_image_src" id="wtl_icon_image_src">
					</div>
				</div>
				<!-- Advanced Layout Template Timeline Settings [START] -->
				<div class="wtl-option-wrap"><h3><?php esc_attr_e( 'Advanced Timeline Content Settings', 'timeline-designer' ); ?></h3></div>
				<div class="wtl-option-wrap">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_attr_e( ' Background Color', 'timeline-designer' ); ?></label></div>
					<div class="blog-templatecolor-tr">
						<div class="wp-timeline-right wp-timeline-color-picker">
							<input type="text" name="wtl_background_color" id="wtl_background_color" value="<?php echo esc_attr( $wtl_background_color ); ?>"/>
						</div>
					</div>
				</div>
				<div class="wtl-option-wrap">
					<div class="wtl-option-label">
						<label class="wtl-single-label"> <?php esc_html_e( 'Set on Title Background Color Only', 'timeline-designer' ); ?></label>
					</div>
					<div class="wtl-option-input">
						<fieldset class="wp-timeline-bg-options wp-timeline-display_author buttonset">
							<input id="wtl_background_color_opt_1" name="wtl_background_color_opt" type="radio" value="1" <?php echo checked( 1, $wtl_background_color_opt ); ?> />
							<label class="button ui-corner-left" for="wtl_background_color_opt_1"><?php esc_html_e( 'Yes', 'timeline-designer' ); ?></label>						
							<input id="wtl_background_color_opt_0" name="wtl_background_color_opt" type="radio" value="0" <?php echo checked( 0, $wtl_background_color_opt ); ?> />
							<label class="button ui-corner-right" for="wtl_background_color_opt_0"><?php esc_html_e( 'No', 'timeline-designer' ); ?></label>
						</fieldset>
					</div>
				</div>
				<!-- Advanced Layout Template Timeline Settings [END] -->
				<div class="wtl-option-wrap">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_html_e( 'Content Color', 'timeline-designer' ); ?></label></div>
					<div class="blog-templatecolor-tr">
						<div class="wp-timeline-right wp-timeline-color-picker">
							<input type="text" name="wtl_content_color" id="wtl_content_color" value="<?php echo esc_attr( $wtl_content_color ); ?>"/>
						</div>
					</div>
				</div>
				<!-- Day Layout Template Timeline Settings [ Start ] -->
				<div class="wtl-option-wrap"><h3><?php esc_html_e( 'Hire Timeline Content Settings', 'timeline-designer' ); ?></h3></div>
				<!-- Day Layout Template Timeline Settings [ End ] -->
				<div class="wtl-option-wrap">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_html_e( 'Set Timeline Time', 'timeline-designer' ); ?></label></div>
					<div class="wtl-option-input">
						<select name="wtl_timeline_time" id="wtl_timeline_time">
							<option value=""
							<?php
							if ( '' === $wtl_timeline_time ) {
								echo 'selected="selected"';
							}
							?>
							>
							<?php esc_html_e( 'Select Time', 'timeline-designer' ); ?>
							</option>
							<?php
							for ( $t = 1; $t <= 12; $t++ ) {
								$tv = $t . ' am';
								if ( $tv == $wtl_timeline_time ) {
									$selected_time = 'selected="selected"';
								} else {
									$selected_time = ''; }
								echo '<option value="' . esc_attr( $tv ) . '" ' . esc_attr( $selected_time ) . '>' . esc_html( $tv ) . '</option>';
							}
							for ( $t = 1; $t <= 12; $t++ ) {
								if ( $tv == $wtl_timeline_time ) {
									$selected_time = 'selected="selected"';
								} else {
									$selected_time = ''; }
								$tv = $t . ' pm';
								echo '<option value="' . esc_attr( $tv ) . '" ' . esc_attr( $selected_time ) . '>' . esc_html( $tv ) . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="wtl-option-wrap">
					<div class="wtl-option-label"><label class="wtl-single-label"><?php esc_attr_e( 'Set Timeline Time Format', 'timeline-designer' ); ?></label></div>
					<div class="wtl-option-input">                                   
						<select name="wtl_timeline_time_format" id="wtl_timeline_time_format">
							<option value="12hour" 
								<?php
								if ( '12hour' === $wtl_timeline_time_format ) {
									echo 'selected="selected"';
								}
								?>
								>
								<?php esc_html_e( '12 Hour', 'timeline-designer' ); ?>
							</option>
							<option value="24hour" 
							<?php
							if ( '24hour' === $wtl_timeline_time_format ) {
								echo 'selected="selected"';
							}
							?>
								>
								<?php esc_html_e( '24 Hour', 'timeline-designer' ); ?>
							</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

/**
 * Settings Left label
 *
 * @param string $text text.
 * @param string $other text.
 * @return void
 */
function wtl_lite_setting_left( $text, $other = '' ) {
	echo '<div class="wp-timeline-left"><span class="wp-timeline-key-title">' . esc_html( $text ) . '</span>';
	if ( ! empty( $other ) ) {
		echo '<span class="wtd-pro-tag">' . esc_html( $other ) . '</span>';}
	echo '</div>';
}


if ( ! function_exists( 'wp_timeline_author_filter_func' ) ) {
	/**
	 * Author filter Query
	 *
	 * @param string $query query.
	 */
	function wp_timeline_author_filter_func( $query ) {
		global $wpdb, $authors, $wtl_settings;
		$query               = str_replace( "\n", ' ', $query );
		$authorarr           = ( isset( $wtl_settings['template_authors'] ) ) ? $wtl_settings['template_authors'] : array();
		$exclude_author_list = isset( $wtl_settings['exclude_author_list'] ) ? true : false;
		if ( ! empty( $authorarr ) ) {
			if ( $exclude_author_list ) {
				if ( preg_match( '/AND (\(.*term_taxonomy_id.*\)) AND/', $query, $matches ) ) {
					$query = str_replace( $matches[1], '(' . $matches[1] . " OR {$wpdb->posts}.post_author NOT IN (" . implode( ',', $authorarr ) . ' ) ) ', $query );
				} else {
					$query .= " AND {$wpdb->posts}.post_author NOT IN (" . implode( ',', $authorarr ) . ') ';
				}
			} elseif ( preg_match( '/AND (\(.*term_taxonomy_id.*\)) AND/', $query, $matches ) ) {
				$query = str_replace( $matches[1], '(' . $matches[1] . " OR {$wpdb->posts}.post_author IN (" . implode( ',', $authorarr ) . ' ) ) ', $query );
			} else {
				$query .= " AND {$wpdb->posts}.post_author IN (" . implode( ',', $authorarr ) . ') ';
			}
		}
		return $query;
	}
}

if ( ! function_exists( 'wp_timeline_pinterest' ) ) {
	/**
	 * Add pinterest button on image
	 *
	 * @param int $wp_timeline_post_id id.
	 * @return html
	 */
	function wp_timeline_pinterest( $wp_timeline_post_id ) {
		global $post;
		ob_start();
		?>
		<div class="wp-timeline-pinterest-share-image">
			<?php
			$img_url = wp_get_attachment_url( get_post_thumbnail_id( $wp_timeline_post_id ) );
			apply_filters( 'wp_timeline_pinterest_img_url', $img_url, $wp_timeline_post_id );
			?>
			<a target="_blank" href="<?php echo 'https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( $wp_timeline_post_id ) ) . '&media=' . esc_url( $img_url ) . '&description =' . esc_html( $post->post_title ); ?>"></a>
		</div>
		<?php
		$pintrest = ob_get_clean();
		return $pintrest;
	}
}

/**
 * Lazyload class add in post thumbnail.
 *
 * @param string $attr Attributes.
 * @param string $attachment Attachments.
 * @param string $size Size.
 */
function lazyload_images_modify_post_thumbnail_attr( $attr, $attachment, $size ) {
	if ( is_feed() ) {
		return $attr;
	}
	if ( isset( $attr['sizes'] ) ) {
		$data_sizes = $attr['sizes'];
		unset( $attr['sizes'] );
		$attr['data-sizes'] = $data_sizes;
	}
	if ( isset( $attr['srcset'] ) ) {
		$attr['data-srcset']   = $attr['srcset'];
		$attr['data-noscript'] = $attr['src'];
		$attr['data-src']      = $attr['src'];
		$attr['srcset']        = '';
		// $attr['src'] = '';.
	}
	$attr['class'] .= ' lazyload';
	return $attr;
}
