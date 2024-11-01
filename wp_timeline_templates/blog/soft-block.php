<?php
/**
 * The template for displaying all blog posts
 * This template can be overridden by copying it to yourtheme/wp_timeline_templates/blog/soft-block.php.
 *
 * @author  Solwin Infotech
 * @version 1.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/wp_timeline_templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$category            = Wtl_Lite_Template_Config::get_class_category( $wtl_settings );
$wtl_animation       = isset( $wtl_settings['timeline_animation'] ) ? $wtl_settings['timeline_animation'] : 'fade';
$wp_timeline_post_id = $post->ID;
$image_hover_effect  = '';
if ( isset( $wtl_settings['wp_timeline_image_hover_effect'] ) && 1 == $wtl_settings['wp_timeline_image_hover_effect'] ) {
	$image_hover_effect = ( isset( $wtl_settings['wp_timeline_image_hover_effect_type'] ) && '' != $wtl_settings['wp_timeline_image_hover_effect_type'] ) ? $wtl_settings['wp_timeline_image_hover_effect_type'] : '';
}
$post_thumbnail = 'full';
$thumbnail      = Wp_Timeline_Lite_Main::wtl_get_the_thumbnail( $wtl_settings, $post_thumbnail, get_post_thumbnail_id( $wp_timeline_post_id ), $wp_timeline_post_id );
$class          = '';
if ( empty( $thumbnail ) ) {
	$post_video_thumbnail = Wp_Timeline_Lite_Main::wtl_get_first_embed_media( $post->ID, $wtl_settings );
	if ( '' == $post_video_thumbnail ) {
		$class = 'content-full-width';
	}
}
?>
<div class="wtl_blog_template soft-block-post-wrapper wtl_single_post_wrapp <?php echo esc_attr( $category ); ?>">
	<div class="soft_block_wrapper wp_timeline_wrap">
		<div class="soft-block-flex">
			<?php do_action( 'wtl_before_post_content' ); ?>
			<div class="post-content-area <?php echo esc_attr( $class ); ?>">
				<?php
				$wp_timeline_post_title_link = isset( $wtl_settings['wp_timeline_post_title_link'] ) ? $wtl_settings['wp_timeline_post_title_link'] : 1;
				if ( 1 == $wp_timeline_post_title_link ) {
					echo '<a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '">';
				} ?>
				<h2 class="wtl-post-title">
				<?php
				$wp_timeline_post_title_maxline = isset( $wtl_settings['wp_timeline_post_title_maxline'] ) ? $wtl_settings['wp_timeline_post_title_maxline'] : 1;
				if ( 1 == $wp_timeline_post_title_maxline ) {
					echo '<span>';
				}
				?>
				<?php echo wp_kses( get_the_title(), Wp_Timeline_Lite_Public::args_kses() );
				if ( 1 == $wp_timeline_post_title_maxline ) {
					echo '</span>';
				} ?>
				</h2>
				<?php
				if ( 1 == $wp_timeline_post_title_link ) {
					echo '</a>';
				}
				?>
				<div class="wtl-post-meta">
					<?php
					Wtl_Lite_Template_Config::get_author( $wtl_settings );
					if ( 1 == $wtl_settings['display_date'] ) {
						$date_link = ( isset( $wtl_settings['disable_link_date'] ) && 1 == $wtl_settings['disable_link_date'] ) ? false : true;
						?>
						<span class="wtl-date-meta">
							<?php
							$date_format      = ( isset( $wtl_settings['post_date_format'] ) && 'default' !== $wtl_settings['post_date_format'] ) ? $wtl_settings['post_date_format'] : get_option( 'date_format' );
							$wp_timeline_date = ( isset( $wtl_settings['dsiplay_date_from'] ) && 'modify' === $wtl_settings['dsiplay_date_from'] ) ? apply_filters( 'wtl_date_format', get_post_modified_time( $date_format, $post->ID ), $post->ID ) : apply_filters( 'wtl_date_format', get_the_time( $date_format, $post->ID ), $post->ID );
							$ar_year          = get_the_time( 'Y' );
							$ar_month         = get_the_time( 'm' );
							$ar_day           = get_the_time( 'd' );

							echo ' <i class="far fa-calendar-alt"></i>';
							echo ( $date_link ) ? ' <a class="mdate" href="' . esc_url( get_day_link( $ar_year, $ar_month, $ar_day ) ) . '">' : '';
							echo esc_attr( $wp_timeline_date );
							echo ( $date_link ) ? '</a>' : '';
							?>
						</span>
						<?php
					}
					Wtl_Lite_Template_Config::get_comment( $wtl_settings );
					?>
					<div class="meeting-day">
						<?php $ar_day = get_the_time( 'd' ); ?>
						<p class="day-inner"><?php echo esc_attr( $ar_day ); ?></p>
					</div>
				</div>
				<div class="wtl-post-footer">
					<div class="footer_meta">
						<?php
						Wtl_Lite_Template_Config::get_category( $wtl_settings, true, true );
						Wtl_Lite_Template_Config::get_tags( $wtl_settings, true, true );
						?>
					</div>
				</div>
				<div class="post_content">
					<?php
					echo wp_kses( Wp_Timeline_Lite_Main::wtl_get_content( $post->ID, $wtl_settings, $wtl_settings['rss_use_excerpt'], $wtl_settings['txtExcerptlength'] ), Wp_Timeline_Lite_Public::args_kses() );
					Wtl_Lite_Template_Config::get_read_more_link( $wtl_settings );
					Wtl_Lite_Template_Config::get_post_details( $wtl_settings );
					?>
				</div>
				<?php
				Wtl_Lite_Template_Config::get_read_more_link_2( $wtl_settings );
				Wp_Timeline_Lite_Main::wtl_get_social_icons( $wtl_settings );
				?>
			</div>
				<?php
				if ( empty( $thumbnail ) ) {
					$label_featured_post = ( isset( $wtl_settings['label_featured_post'] ) && '' != $wtl_settings['label_featured_post'] ) ? $wtl_settings['label_featured_post'] : '';
					if ( '' != $label_featured_post && is_sticky() ) {
						?>
						<div class="label_featured_post"><?php echo esc_html( $label_featured_post ); ?></div> 
						<?php
					}
				}
				?>
				<?php
				$enable_media = isset( $wtl_settings['wp_timeline_enable_media'] ) ? $wtl_settings['wp_timeline_enable_media'] : '';
				if ( $enable_media ) {
					if ( Wp_Timeline_Lite_Main::wtl_get_first_embed_media( $post->ID, $wtl_settings ) && 1 == $wtl_settings['rss_use_excerpt'] ) {
						?>
						<div class="wp-timeline-post-image post-video">
							<?php
							if ( 'quote' === get_post_format() ) {
								if ( has_post_thumbnail() ) {
										$post_thumbnail = 'full';
										$thumbnail      = Wp_Timeline_Lite_Main::wtl_get_the_thumbnail( $wtl_settings, $post_thumbnail, get_post_thumbnail_id(), $post->ID );
										echo wp_kses( apply_filters( 'wp_timeline_post_thumbnail_filter', $thumbnail, $post->ID ), Wp_Timeline_Lite_Public::args_kses() );
										echo '<div class="upper_image_wrapper">';
										echo wp_kses( Wp_Timeline_Lite_Main::wtl_get_first_embed_media( $post->ID, $wtl_settings ), Wp_Timeline_Lite_Public::args_kses() );
										echo '</div>';
								}
							} elseif ( 'link' === get_post_format() ) {
								if ( has_post_thumbnail() ) {
									$post_thumbnail = 'full';
									$thumbnail      = Wp_Timeline_Lite_Main::wtl_get_the_thumbnail( $wtl_settings, $post_thumbnail, get_post_thumbnail_id(), $post->ID );
									echo wp_kses( apply_filters( 'wp_timeline_post_thumbnail_filter', $thumbnail, $post->ID ), Wp_Timeline_Lite_Public::args_kses() );
									echo '<div class="upper_image_wrapper wp_timeline_link_post_format">';
									echo wp_kses( Wp_Timeline_Lite_Main::wtl_get_first_embed_media( $post->ID, $wtl_settings ), Wp_Timeline_Lite_Public::args_kses() );
									echo '</div>';
								}
							} else {
								echo wp_kses( Wp_Timeline_Lite_Main::wtl_get_first_embed_media( $post->ID, $wtl_settings ), Wp_Timeline_Lite_Public::args_kses() );
							}
							?>
						</div>
						<?php
					} else {
						$wp_timeline_post_image_link = ( isset( $wtl_settings['wp_timeline_post_image_link'] ) && 0 == $wtl_settings['wp_timeline_post_image_link'] ) ? false : true;
						if ( ! empty( $thumbnail ) ) {
							echo '<div class="post-media">';
							echo '<figure class="wp-timeline-mb-15 ' . esc_attr( $image_hover_effect ) . '">';
							$label_featured_post = ( isset( $wtl_settings['label_featured_post'] ) && '' != $wtl_settings['label_featured_post'] ) ? $wtl_settings['label_featured_post'] : '';
							if ( '' != $label_featured_post && is_sticky() ) {
								?>
								<div class="label_featured_post"><?php echo esc_html( $label_featured_post ); ?></div> 
								<?php
							}
							echo ( $wp_timeline_post_image_link ) ? '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">' : '';
							echo wp_kses( apply_filters( 'wp_timeline_post_thumbnail_filter', $thumbnail, $post->ID ), Wp_Timeline_Lite_Public::args_kses() );
							echo ( $wp_timeline_post_image_link ) ? '</a>' : '';
							if ( isset( $wtl_settings['pinterest_image_share'] ) && 1 == $wtl_settings['pinterest_image_share'] && isset( $wtl_settings['social_share'] ) && 1 == $wtl_settings['social_share'] ) {
								?>
								<div class="wp-timeline-pinterest-share-image">
									<?php $img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
									<a target="_blank" href="<?php echo 'https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink( $post->ID ) ) . '&media=' . esc_url( $img_url ); ?>"><i class="fab fa-pinterest"></i></a>
								</div>
								<?php
							}
							echo '</figure>';
							echo '</div>';
						}
					}
				}
				do_action( 'wtl_after_post_content' );
				?>
		</div>
	</div>
</div>
<?php
do_action( 'wtl_separator_after_post' );
