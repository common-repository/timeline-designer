<?php
/**
 * The template for displaying all blog posts
 * This template can be overridden by copying it to yourtheme/wp_timeline_templates/blog/easy-layout.php.
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
$wtl_animation = isset( $wtl_settings['timeline_animation'] ) ? $wtl_settings['timeline_animation'] : 'fade';
$format        = get_post_format( $post->ID );
$post_format   = '';
if ( 'status' === $format ) {
	$post_format = 'fas fa-comment';
} elseif ( 'aside' === $format ) {
	$post_format = 'far fa-file-alt';
} elseif ( 'image' === $format ) {
	$post_format = 'far fa-file-image';
} elseif ( 'gallery' === $format ) {
	$post_format = 'far fa-file-image';
} elseif ( 'link' === $format ) {
	$post_format = 'fas fa-link';
} elseif ( 'quote' === $format ) {
	$post_format = 'fas fa-quote-left';
} elseif ( 'audio' === $format ) {
	$post_format = 'fas fa-music';
} elseif ( 'video' === $format ) {
	$post_format = 'fas fa-video';
} elseif ( 'chat' === $format ) {
	$post_format = 'fab fa-weixin';
} else {
	$post_format = 'fa-solid fa-thumbtack';
}
$post_content_color_set = isset( $wtl_details['wtl_content_color'] ) ? ' style=color:' . $wtl_details['wtl_content_color'] . ';' : '';
?>
<div data-aos="<?php echo esc_attr( $wtl_animation ); ?>" class="wtl_blog_single_post_wrapp <?php echo esc_attr( Wtl_Lite_Template_Config::get_class_category( $wtl_settings ) ); ?>">
	<?php
	$defalt_icon = Wtl_Lite_Template_Easy_Layout::get_default_icon( $wtl_settings );
	if ( $defalt_icon ) {
		$dicon = $defalt_icon;
	} else {
		$dicon = '';
	}
	$wtl_icon     = Wtl_Lite_Template_Config::get_timeline_icon();
	$allowed_html = array(
		'div' => array(
			'class' => array(),
			'title' => array(),
		),
		'img' => array(
			'src' => array(),
		),
		'i'   => array(
			'class' => array(),
		),
	);
	if ( $wtl_icon ) {
		echo wp_kses( $wtl_icon, $allowed_html );
	} else {
		if ( $dicon ) {
			echo '<div class="wtl_steps_post_format">' . wp_kses( $dicon, $allowed_html ) . '</div>';
		} else {
			echo '<div class="wtl_steps_post_format ' . esc_attr( $post_format ) . '"></div>';
		}
	}
	$label_featured_post = ( isset( $wtl_settings['label_featured_post'] ) && '' != $wtl_settings['label_featured_post'] ) ? esc_attr( $wtl_settings['label_featured_post'] ) : '';
	if ( '' != $label_featured_post && is_sticky() ) {
		?>
		<div class="label_featured_post"><span><?php echo esc_html( $label_featured_post ); ?></span></div> 
		<?php
	}
	Wtl_Lite_Template_Config::get_title( $wtl_settings );
	echo wp_kses( Wtl_Lite_Template_Config::get_post_date( $wtl_settings, true ), Wp_Timeline_Lite_Public::args_kses() );
	Wtl_Lite_Template_Easy_Layout::get_author( $wtl_settings );
	Wtl_Lite_Template_Config::get_comment( $wtl_settings );
	Wtl_Lite_Template_Easy_Layout::get_post_image( $wtl_settings );
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
	<div class="wtl-post-meta" style="padding:0">
		<?php
		Wtl_Lite_Template_Config::get_post_details( $wtl_settings );
		Wtl_Lite_Template_Config::get_category( $wtl_settings, true, true );
		Wtl_Lite_Template_Config::get_tags( $wtl_settings, true, true );
		Wtl_Lite_Template_Config::get_social_media( $wtl_settings );
		?>
	</div>    
</div>
<?php
do_action( 'wtl_separator_after_post' );
