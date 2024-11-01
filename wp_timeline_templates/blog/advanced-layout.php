<?php
/**
 * The template for displaying all blog posts
 * This template can be overridden by copying it to yourtheme/wp_timeline_templates/blog/advanced-layout.php.
 *
 * @author  Solwin Infotech
 * @version 1.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/wp_timeline_templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;

$image_hover_effect = '';
if ( isset( $wtl_settings['wp_timeline_image_hover_effect'] ) && 1 == $wtl_settings['wp_timeline_image_hover_effect'] ) {
	$image_hover_effect = ( isset( $wtl_settings['wp_timeline_image_hover_effect_type'] ) && '' != $wtl_settings['wp_timeline_image_hover_effect_type'] ) ? $wtl_settings['wp_timeline_image_hover_effect_type'] : '';
}
$wtl_details            = get_post_meta( $post->ID, '_wtl_single_details_key', true );
$wtl_all_post_type      = array( 'product', 'download', 'post' );
$post_content_color_set = isset( $wtl_details['wtl_content_color'] ) ? ' style=color:' . $wtl_details['wtl_content_color'] . ';' : '';
$wtl_content_color      = isset( $wtl_details['wtl_content_color'] ) ? $wtl_details['wtl_content_color'] : '';
$wtl_background_color   = isset( $wtl_details['wtl_background_color'] ) ? $wtl_details['wtl_background_color'] : '';
$i                      = $count;
$layout_type            = $wtl_settings['layout_type'];
$wtl_animation          = isset( $wtl_settings['timeline_animation'] ) ? $wtl_settings['timeline_animation'] : 'fade';
/* Horizental Only */
if ( 1 == $layout_type ) {
	/*----------------------------------------------------------------------*/
	?>
	<div class="wtl-slitem <?php echo esc_attr( 'post_' . Wtl_Lite_Template_Advanced_Layout::even_odd( $i ) ); ?>" data-slick-index="<?php echo esc_attr( $i ); ?>" id="wtl_layout_<?php echo esc_attr( $post->ID ); ?>">
		<style>
			<?php
			$title_color = Wtl_Lite_Template_Advanced_Layout::post_background_color();
			if ( $title_color ) {
				?>
					#wtl_layout_<?php echo esc_attr( $post->ID ); ?> .wtl-post-title{background:<?php echo esc_attr( $title_color ); ?> !important}
					#wtl_layout_<?php echo esc_attr( $post->ID ); ?> .wtl-post-center-image{background:<?php echo esc_attr( $title_color ); ?> !important}
				<?php
			}
			?>
		</style>
		<?php
		Wtl_Lite_Template_Config::get_title( $wtl_settings );
		Wtl_Lite_Template_Advanced_Layout::get_post_image( $wtl_settings );
		?>
		<div class="wtl-post-content" <?php echo esc_attr( $post_content_color_set ); ?>>
			<?php
			do_action( 'wtl_before_post_content' );
			Wtl_Lite_Template_Config::get_content( $wtl_settings );
			Wtl_Lite_Template_Config::get_read_more_link( $wtl_settings );
			Wtl_Lite_Template_Config::get_read_more_link_2( $wtl_settings );
			do_action( 'wtl_after_post_content' );
			if ( Wtl_Lite_Template_Advanced_Layout::get_category( $wtl_settings ) || Wtl_Lite_Template_Advanced_Layout::get_tags( $wtl_settings ) || Wtl_Lite_Template_Advanced_Layout::social_icon( $wtl_settings ) || ( isset( $wtl_settings['display_author'] ) && 1 == $wtl_settings['display_author'] ) || ( isset( $wtl_settings['display_comment_count'] ) && 1 == $wtl_settings['display_comment_count'] ) ) {
				?>
				<div class="wtl-post-footer">
					<?php
					Wtl_Lite_Template_Config::get_author( $wtl_settings );
					Wtl_Lite_Template_Config::get_comment( $wtl_settings );
					Wtl_Lite_Template_Config::get_post_details( $wtl_settings );
					Wtl_Lite_Template_Config::get_category( $wtl_settings, true, true );
					Wtl_Lite_Template_Config::get_tags( $wtl_settings, true, true );
					Wp_Timeline_Lite_Main::wtl_get_social_icons( $wtl_settings );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	/*----------------------------------------------------------------------*/
} else {
	/* Vertical Only */
	?>
	<style>
		<?php
		$title_color = Wtl_Lite_Template_Advanced_Layout::post_background_color();
		if ( $title_color ) {
			?>
				#wtl_layout_<?php echo esc_attr( $post->ID ); ?> .wtl-post-title{
					background:<?php echo esc_attr( $title_color ); ?> !important
				}
			<?php
			/* Dynami Arrow */

			?>
				/* layout veiw center */                
				.wtl_layout_even_<?php echo esc_attr( $post->ID ); ?>:before{  border-color: transparent transparent transparent <?php echo esc_attr( $title_color ); ?> !important}
				.wtl_layout_odd_<?php echo esc_attr( $post->ID ); ?>:before{  border-color: transparent <?php echo esc_attr( $title_color ); ?> transparent transparent !important}
				<?php

				if ( isset( $wtl_background_color ) && ! empty( $wtl_background_color ) ) {
					?>
			.post_odd #wtl_layout_<?php echo esc_attr( $post->ID ); ?>.wtl_post_content_schedule::before {
				border-color: transparent <?php echo esc_attr( $wtl_background_color ); ?> transparent transparent;
			}
			.post_even #wtl_layout_<?php echo esc_attr( $post->ID ); ?>.wtl_post_content_schedule::before {
				border-color: transparent transparent transparent <?php echo esc_attr( $wtl_background_color ); ?>;
			}
			<?php } ?>
			.post_odd .wtl_dateeicon_<?php echo esc_attr( $post->ID ); ?> .wtl-post-date span,
			.post_odd .wtl_dateeicon_<?php echo esc_attr( $post->ID ); ?> .wtl-post-date a,
			.post_even .wtl_dateeicon_<?php echo esc_attr( $post->ID ); ?> .wtl-post-date span,
			.post_even .wtl_dateeicon_<?php echo esc_attr( $post->ID ); ?> .wtl-post-date a
			{color:<?php echo esc_attr( $title_color ); ?> !important}
			<?php
		}
		?>
	</style>
		<div class="wtl-schedule-post-content <?php echo esc_attr( 'post_' . Wtl_Lite_Template_Advanced_Layout::even_odd( $i ) ); ?>">
			<div class="wtl_year wtl_year_<?php echo esc_attr( get_the_time( 'Y' ) ); ?>" data-post-year="<?php echo esc_attr( get_the_time( 'Y' ) ); ?>">
				<a href="<?php echo esc_url( get_year_link( get_the_time( 'Y' ) ) ); ?>"><span><?php echo esc_html( get_the_time( 'Y' ) ); ?></span></a>
			</div>
			<div class="wtl_dateeicon wtl_dateeicon_<?php echo esc_attr( $post->ID ); ?>">
			<?php
			Wtl_Lite_Template_Advanced_Layout::get_post_date( $wtl_settings, false );
			Wtl_Lite_Template_Advanced_Layout::get_timeline_icon( $wtl_settings );
			?>
			</div>

			<div data-aos="<?php echo esc_attr( $wtl_animation ); ?>" id="wtl_layout_<?php echo esc_attr( $post->ID ); ?>" class="wtl_layout_<?php echo esc_attr( Wtl_Lite_Template_Advanced_Layout::even_odd( $i ) ); ?>_<?php echo esc_attr( $post->ID ); ?> wtl-schedule-all-post-content wtl_post_content_schedule aos-init aos-animate" <?php echo esc_attr( Wtl_Lite_Template_Advanced_Layout::content_box_background_color( $wtl_settings ) ); ?>>
				<?php
				Wtl_Lite_Template_Config::get_title( $wtl_settings );
				Wtl_Lite_Template_Config::get_post_image( $wtl_settings );

				?>
				<div class="wtl-post-content" <?php echo esc_attr( $post_content_color_set ); ?>>
					<?php
					do_action( 'wtl_before_post_content' );
					Wtl_Lite_Template_Config::get_content( $wtl_settings );
					Wtl_Lite_Template_Config::get_read_more_link( $wtl_settings );
					Wtl_Lite_Template_Config::get_read_more_link_2( $wtl_settings );
					do_action( 'wtl_after_post_content' );
					?>
				</div>        
				<?php
				if ( Wtl_Lite_Template_Advanced_Layout::get_category( $wtl_settings ) || Wtl_Lite_Template_Advanced_Layout::get_tags( $wtl_settings ) || Wtl_Lite_Template_Advanced_Layout::social_icon( $wtl_settings ) || ( isset( $wtl_settings['display_author'] ) && 1 == $wtl_settings['display_author'] ) || ( isset( $wtl_settings['display_comment_count'] ) && 1 == $wtl_settings['display_comment_count'] ) ) {
					?>
					<div class="wtl-post-footer">
						<?php
						Wtl_Lite_Template_Config::get_author( $wtl_settings );
						Wtl_Lite_Template_Config::get_comment( $wtl_settings );
						Wtl_Lite_Template_Config::get_post_details( $wtl_settings );
						Wtl_Lite_Template_Config::get_category( $wtl_settings, true, true );
						Wtl_Lite_Template_Config::get_tags( $wtl_settings, true, true );
						Wp_Timeline_Lite_Main::wtl_get_social_icons( $wtl_settings );
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	<?php
}
$i++;
do_action( 'wtl_separator_after_post' );
