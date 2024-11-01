<?php
/**
 * Layout Templates Dynamic Style Start.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/public
 */

?>
<style id="wtl_dynamic_style_<?php echo esc_attr( $shortcode_id ); ?>">
<?php
foreach ( $wtl_settings as $key => $val ) {
	if ( ! is_array( $val ) ) {
		${$key} = $val;
	}
}
$layout_id        = '.layout_id_' . esc_attr( $shortcode_id );
$layout_filter_id = '.layout_filter_id_' . esc_attr( $shortcode_id );

if ( 1 == $wtl_settings['display_timeline_bar'] ) {
	echo esc_attr( $layout_id );
	?>
	.wtl_al_nav{display: none !important; opacity: 0 !important}
	<?php
}
$template_color                             = isset( $wtl_settings['template_color'] ) ? $wtl_settings['template_color'] : '';
$wp_timeline_filter_borderleftstyle         = isset( $wtl_settings['wp_timeline_filter_borderleftstyle'] ) ? $wtl_settings['wp_timeline_filter_borderleftstyle'] : '';
$wp_timeline_filter_borderright             = isset( $wtl_settings['wp_timeline_filter_borderright'] ) ? $wtl_settings['wp_timeline_filter_borderright'] : '';
$wp_timeline_filter_bordertopcolor          = isset( $wtl_settings['wp_timeline_filter_bordertopcolor'] ) ? $wtl_settings['wp_timeline_filter_bordertopcolor'] : '';
$wp_timeline_filter_borderbottomstyle       = isset( $wtl_settings['wp_timeline_filter_borderbottomstyle'] ) ? $wtl_settings['wp_timeline_filter_borderbottomstyle'] : '';
$wp_timeline_filter_borderbottomcolor       = isset( $wtl_settings['wp_timeline_filter_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_filter_borderbottomcolor'] : '';
$filter_color                               = isset( $wtl_settings['filter_color'] ) ? $wtl_settings['filter_color'] : '';
$filter_background_color                    = isset( $wtl_settings['filter_background_color'] ) ? $wtl_settings['filter_background_color'] : '';
$wp_timeline_filter_hover_borderleft        = isset( $wtl_settings['wp_timeline_filter_hover_borderleft'] ) ? $wtl_settings['wp_timeline_filter_hover_borderleft'] : '';
$wp_timeline_filter_hover_borderleftstyle   = isset( $wtl_settings['wp_timeline_filter_hover_borderleftstyle'] ) ? $wtl_settings['wp_timeline_filter_hover_borderleftstyle'] : '';
$wp_timeline_filter_hover_borderleftcolor   = isset( $wtl_settings['wp_timeline_filter_hover_borderleftcolor'] ) ? $wtl_settings['wp_timeline_filter_hover_borderleftcolor'] : '';
$wp_timeline_filter_hover_borderright       = isset( $wtl_settings['wp_timeline_filter_hover_borderright'] ) ? $wtl_settings['wp_timeline_filter_hover_borderright'] : '';
$wp_timeline_filter_hover_borderrightstyle  = isset( $wtl_settings['wp_timeline_filter_hover_borderrightstyle'] ) ? $wtl_settings['wp_timeline_filter_hover_borderrightstyle'] : '';
$wp_timeline_filter_hover_borderrightcolor  = isset( $wtl_settings['wp_timeline_filter_hover_borderrightcolor'] ) ? $wtl_settings['wp_timeline_filter_hover_borderrightcolor'] : '';
$wp_timeline_filter_hover_bordertop         = isset( $wtl_settings['wp_timeline_filter_hover_bordertop'] ) ? $wtl_settings['wp_timeline_filter_hover_bordertop'] : '';
$wp_timeline_filter_hover_bordertopstyle    = isset( $wtl_settings['wp_timeline_filter_hover_bordertopstyle'] ) ? $wtl_settings['wp_timeline_filter_hover_bordertopstyle'] : '';
$wp_timeline_filter_hover_bordertopcolor    = isset( $wtl_settings['wp_timeline_filter_hover_bordertopcolor'] ) ? $wtl_settings['wp_timeline_filter_hover_bordertopcolor'] : '';
$wp_timeline_filter_hover_borderbottom      = isset( $wtl_settings['wp_timeline_filter_hover_borderbottom'] ) ? $wtl_settings['wp_timeline_filter_hover_borderbottom'] : '';
$wp_timeline_filter_hover_borderbottomstyle = isset( $wtl_settings['wp_timeline_filter_hover_borderbottomstyle'] ) ? $wtl_settings['wp_timeline_filter_hover_borderbottomstyle'] : '';
$wp_timeline_filter_hover_borderbottomcolor = isset( $wtl_settings['wp_timeline_filter_hover_borderbottomcolor'] ) ? $wtl_settings['wp_timeline_filter_hover_borderbottomcolor'] : '';
$filter_hover_color                         = isset( $wtl_settings['filter_hover_color'] ) ? $wtl_settings['filter_hover_color'] : '';
$filter_paddingtop                          = isset( $wtl_settings['filter_paddingtop'] ) ? $wtl_settings['filter_paddingtop'] : '';
$filter_paddingright                        = isset( $wtl_settings['filter_paddingright'] ) ? $wtl_settings['filter_paddingright'] : '';
$filter_paddingbottom                       = isset( $wtl_settings['filter_paddingbottom'] ) ? $wtl_settings['filter_paddingbottom'] : '';
$filter_paddingleft                         = isset( $wtl_settings['filter_paddingleft'] ) ? $wtl_settings['filter_paddingleft'] : '';
$filter_margintop                           = isset( $wtl_settings['filter_margintop'] ) ? $wtl_settings['filter_margintop'] : '';
$filter_marginright                         = isset( $wtl_settings['filter_marginright'] ) ? $wtl_settings['filter_marginright'] : '';
$filter_marginbottom                        = isset( $wtl_settings['filter_marginbottom'] ) ? $wtl_settings['filter_marginbottom'] : '';
$filter_marginleft                          = isset( $wtl_settings['filter_marginleft'] ) ? $wtl_settings['filter_marginleft'] : '';
$wp_timeline_filter_borderleft              = isset( $wtl_settings['wp_timeline_filter_borderleft'] ) ? $wtl_settings['wp_timeline_filter_borderleft'] : '';
$wp_timeline_star_rating_alignment          = isset( $wtl_settings['wp_timeline_star_rating_alignment'] ) ? $wtl_settings['wp_timeline_star_rating_alignment'] : '';
$social_style                               = isset( $wtl_settings['social_style'] ) ? $wtl_settings['social_style'] : '';
$wp_timeline_lazy_load_image                = isset( $wtl_settings['wp_timeline_lazy_load_image'] ) ? $wtl_settings['wp_timeline_lazy_load_image'] : 0;
$wp_timeline_lazy_load_blurred_image        = isset( $wtl_settings['wp_timeline_lazy_load_blurred_image'] ) ? $wtl_settings['wp_timeline_lazy_load_blurred_image'] : 0;
$wp_timeline_post_title_maxline        = isset( $wtl_settings['wp_timeline_post_title_maxline'] ) ? $wtl_settings['wp_timeline_post_title_maxline'] : 0;
$post_title_maxline        = isset( $wtl_settings['post_title_maxline'] ) && !empty ( $wtl_settings['post_title_maxline'] )? $wtl_settings['post_title_maxline'] : 2;
$wp_timeline_post_title_wordbreak_type        = isset( $wtl_settings['wp_timeline_post_title_wordbreak_type'] ) ? $wtl_settings['wp_timeline_post_title_wordbreak_type'] : '';
$wp_timeline_post_title_wordbreak_type		= 'default' == $wp_timeline_post_title_wordbreak_type ? '' : $wp_timeline_post_title_wordbreak_type;
if ( isset( $social_icon_style ) && isset( $social_style ) && 0 == $social_icon_style && 0 == $social_style ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .social-component a {border-radius: 100%}
	<?php
}
if ( isset( $read_more_link ) && isset( $read_more_on ) && 1 == $read_more_link && '2' === $read_more_on ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-read-more-div a.more-tag {
		<?php
		if ( isset( $readmore_font_family ) && '' !== $readmore_font_family ) {
			?>
			font-family: <?php echo esc_attr( $readmore_font_family ); ?><?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_borderleft ) && '' !== $wp_timeline_readmore_button_borderleft ) {
			?>
			border-left:<?php echo esc_attr( $wp_timeline_readmore_button_borderleft ) . 'px'; ?> <?php echo esc_attr( $read_more_button_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_borderright ) && '' !== $wp_timeline_readmore_button_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_readmore_button_borderright ) . 'px'; ?> <?php echo esc_attr( $read_more_button_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_bordertop ) && '' !== $wp_timeline_readmore_button_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_readmore_button_bordertop ) . 'px'; ?> <?php echo esc_attr( $read_more_button_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_borderbottom ) && '' !== $wp_timeline_readmore_button_borderbottom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_readmore_button_borderbottom ) . 'px'; ?> <?php echo esc_attr( $read_more_button_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_border_radius ) && '' !== $readmore_button_border_radius ) {
			?>
			border-radius: <?php echo esc_attr( $readmore_button_border_radius ) . 'px'; ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-read-more-div a.wtl-read-more:hover {
		<?php
		if ( isset( $wp_timeline_readmore_button_hover_borderleft ) && '' !== $wp_timeline_readmore_button_hover_borderleft ) {
			?>
			border-left:<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderleft ) . 'px'; ?> <?php echo esc_attr( $read_more_button_hover_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_hover_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_hover_borderright ) && '' !== $wp_timeline_readmore_button_hover_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderright ) . 'px'; ?> <?php echo esc_attr( $read_more_button_hover_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_hover_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_hover_bordertop ) && '' !== $wp_timeline_readmore_button_hover_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_readmore_button_hover_bordertop ) . 'px'; ?> <?php echo esc_attr( $read_more_button_hover_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_hover_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_readmore_button_hover_borderbottom ) && '' !== $wp_timeline_readmore_button_hover_borderbottom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_readmore_button_hover_borderbottom ) . 'px'; ?> <?php echo esc_attr( $read_more_button_hover_border_style ); ?> <?php echo esc_attr( $wp_timeline_readmore_button_hover_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_hover_border_radius ) && '' !== $readmore_button_hover_border_radius ) {
			?>
			border-radius: <?php echo esc_attr( $readmore_button_hover_border_radius ) . 'px'; ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-read-more-div {
		<?php
		if ( isset( $readmore_button_margintop ) && '' !== $readmore_button_margintop ) {
			?>
			margin-top:<?php echo esc_attr( $readmore_button_margintop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_marginright ) && '' !== $readmore_button_marginright ) {
			?>
			margin-right:<?php echo esc_attr( $readmore_button_marginright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_marginbottom ) && '' !== $readmore_button_marginbottom ) {
			?>
			margin-bottom:<?php echo esc_attr( $readmore_button_marginbottom ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_marginleft ) && '' !== $readmore_button_marginleft ) {
			?>
			margin-left:<?php echo esc_attr( $readmore_button_marginleft ) . 'px'; ?>;<?php } ?>
		display: inline-block;
	}
	<?php
		/* Read More Padding */
		echo esc_attr( $layout_id );
	?>
		.wtl_blog_template .wtl-read-more-div a.wtl-read-more {
		<?php
		if ( isset( $readmore_button_paddingtop ) && '' !== $readmore_button_paddingtop ) {
			?>
			padding-top: <?php echo esc_attr( $readmore_button_paddingtop ) . 'px'; ?>; <?php } ?>
		<?php
		if ( isset( $readmore_button_paddingbottom ) && '' !== $readmore_button_paddingbottom ) {
			?>
			padding-bottom: <?php echo esc_attr( $readmore_button_paddingbottom ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_paddingright ) && '' !== $readmore_button_paddingright ) {
			?>
			padding-right: <?php echo esc_attr( $readmore_button_paddingright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $readmore_button_paddingleft ) && '' !== $readmore_button_paddingleft ) {
			?>
			padding-left: <?php echo esc_attr( $readmore_button_paddingleft ) . 'px'; ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-read-more-div {
		<?php
		if ( isset( $readmore_button_alignment ) && '' !== $readmore_button_alignment ) {
			?>
			text-align: <?php echo esc_attr( $readmore_button_alignment ); ?>; <?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-read-more-div .wtl-read-more{
		display: inline-block;
	}
<?php } ?>
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template a.wtl-read-more {
	<?php
	if ( isset( $readmore_fontsize ) && '' !== $readmore_fontsize ) {
		?>
		font-size: <?php echo esc_attr( $readmore_fontsize ) . 'px'; ?>; <?php } ?>
	<?php
	if ( isset( $template_readmorecolor ) && '' !== $template_readmorecolor ) {
		?>
		color:<?php echo esc_attr( $template_readmorecolor ); ?> !important;<?php } ?>
	<?php
	if ( isset( $readmore_font_weight ) && '' !== $readmore_font_weight ) {
		?>
		font-weight: <?php echo esc_attr( $readmore_font_weight ); ?>;<?php } ?>
	<?php
	if ( isset( $readmore_font_line_height ) && '' !== $readmore_font_line_height ) {
		?>
		line-height: <?php echo esc_attr( $readmore_font_line_height ); ?>;<?php } ?>
	<?php
	if ( isset( $readmore_font_italic ) && 1 == $readmore_font_italic ) {
		?>
		font-style: <?php echo 'italic'; ?>;<?php } ?>
	<?php
	if ( isset( $readmore_font_text_transform ) && '' !== $readmore_font_text_transform ) {
		?>
		text-transform: <?php echo esc_attr( $readmore_font_text_transform ); ?>;<?php } ?>
	<?php
	if ( isset( $readmore_font_text_decoration ) && '' !== $readmore_font_text_decoration ) {
		?>
		text-decoration: <?php echo esc_attr( $readmore_font_text_decoration ); ?>;<?php } ?>
	<?php
	if ( isset( $readmore_font_letter_spacing ) && '' !== $readmore_font_letter_spacing ) {
		?>
		letter-spacing: <?php echo esc_attr( $readmore_font_letter_spacing ) . 'px'; ?>;<?php } ?>
} 
<?php
if ( isset( $template_readmorehovercolor ) && '' !== $template_readmorehovercolor ) {
	echo esc_attr( $layout_id );
	?>
	.wtl_blog_template a.wtl-read-more:hover {
		color:<?php echo esc_attr( $template_readmorehovercolor ); ?> !important;
	}
	<?php
}
?>

/** Next Line Read more button css */
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-pinterest-share-image a {background-image: url("<?php echo esc_url( TLD_URL ); ?>/images/pinterest.png")}
<?php
// Same line read more button css.
if ( isset( $read_more_link ) && isset( $read_more_on ) && 1 == $read_more_link && 1 == $read_more_on ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template a.more-tag {margin-left: 5px;padding: 0;border: none;background:none}
	<?php
}
if ( 1 == $wp_timeline_lazy_load_image ) {
	if ( 1 == $wp_timeline_lazy_load_blurred_image ) {
		?>
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-thumbnail .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-thumbnail .lazyloading,
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-post-image .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-post-image .lazyloading,
		<?php echo esc_attr( $layout_id ); ?> .post-media .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .post-media .lazyloading {
		-webkit-filter: blur(10px);
		filter: blur(10px);
		transition: filter 6000ms, -webkit-filter 6000ms;
	}
		<?php
	}
	if ( ! empty( $template_lazyload_color ) ) {
		?>
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-thumbnail .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-thumbnail .lazyloading,
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-post-image .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-post-image .lazyloading,
		<?php echo esc_attr( $layout_id ); ?> .post-media .lazyload,
		<?php echo esc_attr( $layout_id ); ?> .post-media .lazyloading {
		background-color: <?php echo esc_attr( $template_lazyload_color ); ?>;
	}
		<?php
	}
}
/** Easy Digital Download Setting Css */
if ( 'easy-digital-downloads/easy-digital-downloads.php' ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_edd_price_wrapper {
		<?php
		if ( isset( $wp_timeline_edd_price_alignment ) && '' !== $wp_timeline_edd_price_alignment ) {
			?>
			text-align: <?php echo esc_attr( $wp_timeline_edd_price_alignment ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_edd_price_wrapper .edd_price {
		<?php
		if ( isset( $wp_timeline_edd_price_paddingleft ) && '' !== $wp_timeline_edd_price_paddingleft ) {
			?>
			padding-left: <?php echo esc_attr( $wp_timeline_edd_price_paddingleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_paddingright ) && '' !== $wp_timeline_edd_price_paddingright ) {
			?>
			padding-right: <?php echo esc_attr( $wp_timeline_edd_price_paddingright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_paddingtop ) && '' !== $wp_timeline_edd_price_paddingtop ) {
			?>
			padding-top: <?php echo esc_attr( $wp_timeline_edd_price_paddingtop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_paddingbottom ) && '' !== $wp_timeline_edd_price_paddingbottom ) {
			?>
			padding-bottom: <?php echo esc_attr( $wp_timeline_edd_price_paddingbottom ) . 'px'; ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_edd_price_wrapper .edd_price span {padding:0}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_edd_price_wrapper .edd_price,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_edd_price_wrapper .edd_price span {
		<?php
		if ( isset( $wp_timeline_edd_price_color ) && '' !== $wp_timeline_edd_price_color ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_edd_price_color ); ?> !important; <?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_pricefontsize ) && '' !== $wp_timeline_edd_pricefontsize ) {
			?>
			font-size: <?php echo esc_attr( $wp_timeline_edd_pricefontsize ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_pricefontface ) && '' !== $wp_timeline_edd_pricefontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_edd_pricefontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_font_weight ) && '' !== $wp_timeline_edd_price_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_edd_price_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_font_line_height ) && '' !== $wp_timeline_edd_price_font_line_height ) {
			?>
			line-height: <?php echo esc_attr( $wp_timeline_edd_price_font_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_font_italic ) && 1 == $wp_timeline_edd_price_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_font_letter_spacing ) && '' !== $wp_timeline_edd_price_font_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_edd_price_font_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_price_font_text_decoration ) && '' !== $wp_timeline_edd_price_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $wp_timeline_edd_price_font_text_decoration ); ?>;<?php } ?>
		width: auto;word-break: break-all;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button a.wp_timeline_edd_view_button,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd_go_to_checkout,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart-label,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart {
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_fontface ) && '' !== $wp_timeline_edd_addtocart_button_fontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_fontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_fontsize ) && '' !== $wp_timeline_edd_addtocart_button_fontsize ) {
			?>
			font-size: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_fontsize ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_font_weight ) && '' !== $wp_timeline_edd_addtocart_button_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $display_edd_addtocart_button_line_height ) && '' !== $display_edd_addtocart_button_line_height ) {
			?>
			line-height: <?php echo esc_attr( $display_edd_addtocart_button_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_font_italic ) && 1 == $wp_timeline_edd_addtocart_button_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_letter_spacing ) && '' !== $wp_timeline_edd_addtocart_button_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_font_text_transform ) && '' !== $wp_timeline_edd_addtocart_button_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_font_text_decoration ) && '' !== $wp_timeline_edd_addtocart_button_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_font_text_decoration ); ?> !important;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_textcolor ) && '' !== $wp_timeline_edd_addtocart_textcolor ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_edd_addtocart_textcolor ); ?> !important;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button a.wp_timeline_edd_view_button,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd_go_to_checkout,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart { 
		<?php
		if ( isset( $wp_timeline_edd_addtocart_backgroundcolor ) && '' !== $wp_timeline_edd_addtocart_backgroundcolor ) {
			?>
			background-color: <?php echo esc_attr( $wp_timeline_edd_addtocart_backgroundcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_borderleft ) && '' !== $wp_timeline_edd_addtocartbutton_borderleft ) {
			?>
			border-left:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_borderright ) && '' !== $wp_timeline_edd_addtocartbutton_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_bordertop ) && '' !== $wp_timeline_edd_addtocartbutton_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_borderbuttom ) && '' !== $wp_timeline_edd_addtocartbutton_borderbuttom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $display_edd_addtocart_button_border_radius ) && '' !== $display_edd_addtocart_button_border_radius ) {
			?>
			border-radius:<?php echo esc_attr( $display_edd_addtocart_button_border_radius ) . 'px'; ?>;<?php } ?>
		<?php if ( isset( $wp_timeline_edd_addtocartbutton_padding_topbottom ) && '' !== $wp_timeline_edd_addtocartbutton_padding_topbottom ) { ?>
			padding-top: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_topbottom ) . 'px'; ?>;
			padding-bottom: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_topbottom ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_edd_addtocartbutton_padding_leftright ) && '' !== $wp_timeline_edd_addtocartbutton_padding_leftright ) { ?>
			padding-left: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_leftright ) . 'px'; ?>;
			padding-right: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_padding_leftright ) . 'px'; ?>;
		<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_box_shadow_color ) && '' !== $wp_timeline_edd_addtocart_button_box_shadow_color ) {
			?>
			box-shadow: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_box_shadow_color ); ?>; <?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button {
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_alignment ) && '' !== $wp_timeline_edd_addtocartbutton_alignment ) {
			?>
			text-align: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_alignment ); ?>;<?php } ?>
		<?php if ( isset( $wp_timeline_edd_addtocartbutton_margin_topbottom ) && '' !== $wp_timeline_edd_addtocartbutton_margin_topbottom ) { ?>
			margin-top: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_topbottom ) . 'px'; ?>;
			margin-bottom: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_topbottom ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_edd_addtocartbutton_margin_leftright ) && '' !== $wp_timeline_edd_addtocartbutton_margin_leftright ) { ?>
			margin-left: <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_leftright ) . 'px'; ?>;
			margin-right:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_margin_leftright ) . 'px'; ?>
		<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button a.wp_timeline_edd_view_button:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd_go_to_checkout:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart:hover {
		<?php
		if ( isset( $wp_timeline_edd_addtocart_hover_backgroundcolor ) && '' !== $wp_timeline_edd_addtocart_hover_backgroundcolor ) {
			?>
			background-color: <?php echo esc_attr( $wp_timeline_edd_addtocart_hover_backgroundcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_hover_borderleft ) && '' !== $wp_timeline_edd_addtocartbutton_hover_borderleft ) {
			?>
			border-left:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_hover_borderright ) && '' !== $wp_timeline_edd_addtocartbutton_hover_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_hover_bordertop ) && '' !== $wp_timeline_edd_addtocartbutton_hover_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocartbutton_hover_borderbuttom ) && '' !== $wp_timeline_edd_addtocartbutton_hover_borderbuttom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_edd_addtocartbutton_hover_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $display_edd_addtocart_button_border_hover_radius ) && '' !== $display_edd_addtocart_button_border_hover_radius ) {
			?>
			border-radius:<?php echo esc_attr( $display_edd_addtocart_button_border_hover_radius ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_edd_addtocart_button_hover_box_shadow_color ) && '' !== $wp_timeline_edd_addtocart_button_hover_box_shadow_color ) {
			?>
			box-shadow: <?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_edd_addtocart_button_hover_box_shadow_color ); ?>; <?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart:hover .edd-add-to-cart-label,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button a.wp_timeline_edd_view_button:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd_go_to_checkout:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl_edd_download_buy_button .edd-add-to-cart:hover {
		<?php
		if ( isset( $wp_timeline_edd_addtocart_text_hover_color ) && '' !== $wp_timeline_edd_addtocart_text_hover_color ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_edd_addtocart_text_hover_color ); ?> !important;<?php } ?>
	}
	<?php
}

/** Pagination Css */
if ( isset( $pagination_type ) && 'paged' === $pagination_type ) {
	?>
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-2 .paging-navigation ul.page-numbers li a.next:before{
		content: '<?php echo esc_html__( 'Next', 'timeline-designer' ); ?>';    
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-2 .paging-navigation ul.page-numbers li a.prev:after{
		content: '<?php echo esc_html__( 'Prev', 'timeline-designer' ); ?>';
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-2 .paging-navigation ul.page-numbers li a.prev:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-2 .paging-navigation ul.page-numbers li a.next:before {
		visibility: visible;
		padding: 6px 11px;
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.next:before {
		content: '<?php echo esc_html__( 'Next', 'timeline-designer' ); ?>'; visibility: visible;padding: 7px;
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.prev:after
	{
		content: '<?php echo esc_html__( 'Prev', 'timeline-designer' ); ?>'; visibility: visible;padding: 7px;
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.prev:after
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.next:before {
		visibility: visible;padding: 7px;top: 2px;
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li span.current{
		<?php
		if ( isset( $pagination_active_background_color ) && '' !== $pagination_active_background_color ) {
			?>
			background: <?php echo esc_attr( $pagination_active_background_color ); ?>;<?php } ?>
		<?php
		if ( isset( $pagination_text_active_color ) && '' !== $pagination_text_active_color ) {
			?>
			color: <?php echo esc_attr( $pagination_text_active_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next:before,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev:before
	{
		<?php
		if ( isset( $pagination_background_color ) && '' !== $pagination_background_color ) {
			?>
			background: <?php echo esc_attr( $pagination_background_color ); ?>;<?php } ?>
		<?php
		if ( isset( $pagination_text_color ) && '' !== $pagination_text_color ) {
			?>
			color: <?php echo esc_attr( $pagination_text_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next:hover:before,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev:hover:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers:hover,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers:focus,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next:hover,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.next:focus,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev:hover,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a.prev:focus{
		<?php
		if ( isset( $pagination_text_hover_color ) && '' !== $pagination_text_hover_color ) {
			?>
			color: <?php echo esc_attr( $pagination_text_hover_color ); ?>;<?php } ?>
		<?php
		if ( isset( $pagination_background_hover_color ) && '' !== $pagination_background_hover_color ) {
			?>
			background: <?php echo esc_attr( $pagination_background_hover_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-1 .paging-navigation ul.page-numbers li a,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-1 .paging-navigation ul.page-numbers li span.current{
		border: none;
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li span.current,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-4 .paging-navigation ul.page-numbers li span.current,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li a,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box .paging-navigation ul.page-numbers li span.current,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.next:before,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.prev:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-3 .paging-navigation ul.page-numbers li a.page-numbers{
		<?php
		if ( isset( $pagination_border_color ) && '' !== $pagination_border_color ) {
			?>
			border:1px solid <?php echo esc_attr( $pagination_border_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-4 .paging-navigation ul.page-numbers li span.current:after,
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-4 .paging-navigation ul.page-numbers li span.current:before{
		<?php
		if ( isset( $pagination_active_border_color ) && '' !== $pagination_active_border_color ) {
			?>
			border-top:2px solid <?php echo esc_attr( $pagination_active_border_color ); ?>;<?php } ?>
		<?php
		if ( isset( $pagination_active_border_color ) && '' !== $pagination_active_border_color ) {
			?>
			border-left:1px solid <?php esc_attr( $pagination_active_border_color ); ?>;<?php } ?>
		<?php
		if ( isset( $pagination_active_border_color ) && '' !== $pagination_active_border_color ) {
			?>
			border-right:1px solid <?php esc_attr( $pagination_active_border_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-4 .paging-navigation ul.page-numbers li span.current{
		<?php
		if ( isset( $pagination_active_border_color ) && '' !== $pagination_active_border_color ) {
			?>
			border-top:2px solid <?php esc_attr( $pagination_active_border_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper .wl_pagination_box.template-4 .paging-navigation ul.page-numbers li a.page-numbers{
		<?php
		if ( isset( $pagination_border_color ) && '' !== $pagination_border_color ) {
			?>
			border:1px solid <?php echo esc_attr( $pagination_border_color ); ?> !important;<?php } ?>
	} 
	<?php
}
/* Social Share Style Css  */
if ( isset( $social_style ) && 1 == $social_style ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component a.social-share-default{
		padding: 0;border:0;box-shadow: none;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.large a.social-share-default{
		padding: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component{
		margin-top: 10px;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share,
	<?php echo esc_attr( $layout_id ); ?> .blog_template.wtl_blog_template .social-component > a {
		margin: 10px 8px 0 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.left_position .social-share {float: left;}
	<?php
}
if ( isset( $social_style ) && 0 == $social_style ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share a {
		<?php
		if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
			?>
			color: <?php echo esc_attr( $template_contentcolor ); ?>;
			border-color: <?php echo esc_attr( $template_contentcolor ); ?>;
			<?php } ?>
	}
	<?php
}
/** Social Share count position */
if ( isset( $social_count_position ) && 'bottom' === $social_count_position ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count {
		<?php
		if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
			?>
			color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
		background-color: transparent;border: 1px solid #ddd;border-radius: 5px;clear: both;float: left;line-height: 1;margin: 10px 0 0;padding: 5px 4%;text-align: center;width: 38px;position: relative;word-wrap: break-word;height: auto;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.large .social-share .count {
		width: 45px;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count:before {
		border-bottom: 8px solid #ddd;border-left: 8px solid rgba(0,0,0,0);border-right: 8px dashed rgba(0,0,0,0);content: "";left: 0;margin: 0 auto;position: absolute;right: 0;top: -8px;width: 0;
	}
	<?php
} elseif ( isset( $social_count_position ) && 'top' === $social_count_position ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count {
		<?php
		if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
			?>
			color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
		background-color: transparent;border: 1px solid #dddddd;border-radius: 5px;clear: both;float: none;line-height: 1;margin: 0 0 10px 0;padding: 5px 4%;text-align: center;width: 38px;position: relative;height: auto;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.large .social-share .count {
		width: 45px;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template.even_class .social-component .social-share .count{
		float: none;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count:before {
		border-top: 8px solid #ddd;border-left: 8px solid rgba(0, 0, 0, 0);border-right: 8px dashed rgba(0, 0, 0, 0);content: "";left: 0;margin: 0 auto;position: absolute;right: 0;bottom: -9px;width: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .blog_template.wtl_blog_template .social-component > a{
		display: inline-block;margin-bottom: 0;float:none;vertical-align: bottom;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share {
		display: inline-block;float: none;
	}
	<?php
} else {
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count {
		<?php
		if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
			?>
			color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
		background-color: transparent;border: 1px solid #ddd;border-radius: 5px;float: right;line-height: 20px;margin: 0 0 0 10px;padding: 8px 0;text-align: center;width: 38px;height: 38px;position: relative;box-sizing: border-box;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.large .social-share .count {
		margin: 0 0 0 7px;padding: 12px 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.large .social-share .count:before {
		top: 30%;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component .social-share .count:before {
		border-top: 8px solid rgba(0,0,0,0);border-bottom:8px dashed rgba(0,0,0,0);border-right: 8px solid #ddd;content: "";margin: 0 auto;position: absolute;left: -8px;top: 27%;width: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .social-component.extra_small .social-share .count:before {
		border-top: 6px solid rgba(0,0,0,0);border-bottom:8px dashed rgba(0,0,0,0);border-right: 6px solid #ddd;content: "";left: -33px;margin: 0 auto;position: absolute;right: 0;top: 27%;width: 0;
	}
	<?php
}
?>
/* ------------------------- Post Title ------------------------- */
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title {
	<?php
	if ( isset( $template_title_alignment ) && '' !== $template_title_alignment ) {
		?>
		text-align: <?php echo esc_attr( $template_title_alignment ); ?> !important;<?php } ?>
}
.wtl-post-title a,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title a,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title,
.wtl-fl-box .wtl-post-title a,
.wtl-fl-box .wtl-post-title{
	<?php
	if ( isset( $template_titlecolor ) && '' !== $template_titlecolor ) {
		?>
		color: <?php echo esc_attr( $template_titlecolor ); ?> !important;<?php } ?>
	<?php
	if ( isset( $content_font_family ) && '' !== $content_font_family ) {
		?>
		font-family: <?php echo esc_attr( $content_font_family ); ?>;<?php } ?>
}
.wtl-post-title a span,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title a span,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title span,
.wtl-fl-box .wtl-post-title a span,
.wtl-fl-box .wtl-post-title span{
	<?php
		if ( isset( $wp_timeline_post_title_maxline ) && $wp_timeline_post_title_maxline ){ ?>
			overflow: hidden;
  			text-overflow: ellipsis;
			  -webkit-box-orient: vertical;
			  display: -webkit-box;
			  -webkit-line-clamp: <?php echo esc_attr( $post_title_maxline ); ?>;
  	<?php
		}
	if ( isset( $wp_timeline_post_title_wordbreak_type ) && '' !== $wp_timeline_post_title_wordbreak_type ) {
		?>
		word-break: <?php echo esc_attr( $wp_timeline_post_title_wordbreak_type ); ?>; <?php
		}
	?>
}
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title a:hover, <?php echo esc_attr( $layout_id ); ?> .soft-block-flex .post-content-area a h2:hover {
	<?php
	if ( isset( $template_titlehovercolor ) && '' !== $template_titlehovercolor ) {
		?>
		color:<?php echo esc_attr( $template_titlehovercolor ); ?> !important;<?php } ?>
}
/** Apply content Font Family */
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-content,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-content p,
.wtl-fl-box .wtl-post-content,
.wtl-fl-box .wtl-post-content p{
	<?php
	if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
		?>
		color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
	<?php
	if ( isset( $content_font_family ) && '' !== $content_font_family ) {
		?>
		font-family: <?php echo esc_attr( $content_font_family ); ?> !important; <?php } ?>
}   
/** Font Awesome apply */
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .post_hentry.fas {font-family: 'Font Awesome 5 Free';}
<?php if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) { ?>       
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .metacomments a,
	<?php echo esc_attr( $layout_id ); ?> .blog_template .social-component a,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .post_content a {
		color:<?php echo esc_attr( $template_contentcolor ); ?>;
	}
	<?php echo esc_attr( $layout_id ); ?> .blog_template .social-component a {
		border-color:<?php echo esc_attr( $template_contentcolor ); ?>;
	}
<?php } ?>
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-title {
<?php
if ( isset( $template_titlebackcolor ) && '' !== $template_titlebackcolor ) {
	?>
	background: <?php echo esc_attr( $template_titlebackcolor ); ?>;<?php } ?>
}
/* --------------------------- Meta Link Color --------------------------- */
<?php echo esc_attr( $layout_id ); ?> .wtl-author a,
<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a,
<?php echo esc_attr( $layout_id ); ?> .wtl-comment a,
<?php echo esc_attr( $layout_id ); ?> .mcomments a {
	<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) : ''; ?>
}
<?php echo esc_attr( $layout_id ); ?> .wtl-author a:hover,
<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover,
<?php echo esc_attr( $layout_id ); ?> .wtl-comment a:hover,
<?php echo esc_attr( $layout_id ); ?> .mcomments a:hover{
	<?php echo isset( $template_contentcolor ) ? 'color:' . esc_attr( $template_contentcolor ) . ' !important' : ''; ?>
}
/** Apply Link Hover Color */
<?php
if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
	echo esc_attr( $layout_id );
	?>
	.blog_template .upper_image_wrapper.wp_timeline_link_post_format a:hover{
		color: <?php echo esc_attr( $template_contentcolor ); ?>;
	}
<?php } ?>
/** Apply Content Setting */
.wtl-post-content,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-content,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .label_featured_post,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .label_featured_post span,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-post-content p,
.wtl-fl-box .wtl-post-content,
<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .post_content,
.wtl-fl-box .wtl-post-content p{
	<?php
	if ( isset( $content_fontsize ) && '' !== $content_fontsize ) {
		?>
		font-size: <?php echo esc_attr( $content_fontsize ) . 'px'; ?>;<?php } ?>
	<?php
	if ( isset( $content_font_weight ) && '' !== $content_font_weight ) {
		?>
		font-weight: <?php echo esc_attr( $content_font_weight ); ?>;<?php } ?>
	<?php
	if ( isset( $content_font_line_height ) && '' !== $content_font_line_height ) {
		?>
		line-height: <?php echo esc_attr( $content_font_line_height ); ?>;<?php } ?>
	<?php
	if ( isset( $content_font_italic ) && 1 == $content_font_italic ) {
		?>
		font-style: <?php echo 'italic'; ?>;<?php } ?>
	<?php
	if ( isset( $content_font_text_transform ) && '' !== $content_font_text_transform ) {
		?>
		text-transform: <?php echo esc_attr( $content_font_text_transform ); ?>;<?php } ?>
	<?php
	if ( isset( $content_font_text_decoration ) && '' !== $content_font_text_decoration ) {
		?>
		text-decoration: <?php echo esc_attr( $content_font_text_decoration ); ?>;<?php } ?>
	<?php
	if ( isset( $content_font_letter_spacing ) && '' !== $content_font_letter_spacing ) {
		?>
		letter-spacing: <?php echo esc_attr( $content_font_letter_spacing ) . 'px'; ?>;<?php } ?>
}
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .upper_image_wrapper blockquote,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .upper_image_wrapper blockquote p{
	<?php
	if ( isset( $content_fontsize ) && '' !== $content_fontsize ) {
		?>
		font-size: <?php echo esc_attr( $content_fontsize ) + 3 . 'px'; ?>;<?php } ?>
	<?php
	if ( isset( $content_font_family ) && '' !== $content_font_family ) {
		?>
		font-family: <?php echo esc_attr( $content_font_family ); ?>;<?php } ?>
	<?php
	if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
		?>
		color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
}
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .upper_image_wrapper blockquote:before{
	<?php
	if ( isset( $content_fontsize ) && '' !== $content_fontsize ) {
		?>
		font-size: <?php echo esc_attr( $content_fontsize ) + 5 . 'px'; ?>;<?php } ?>
	<?php
	if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
		?>
		color: <?php echo esc_attr( $template_contentcolor ); ?><?php } ?>
}
<?php echo esc_attr( $layout_id ); ?> .blog_template .upper_image_wrapper.wp_timeline_link_post_format a{
	<?php
	if ( isset( $content_fontsize ) && '' !== $content_fontsize ) {
		?>
		font-size: <?php echo esc_attr( $content_fontsize ) + 5 . 'px'; ?>;<?php } ?>
	<?php
	if ( isset( $content_font_family ) && '' !== $content_font_family ) {
		?>
		font-family: <?php echo esc_attr( $content_font_family ); ?>;<?php } ?>
	<?php
	if ( isset( $template_bgcolor ) && '' !== $template_bgcolor ) {
		?>
		background: <?php echo esc_attr( Wp_Timeline_Lite_Main::wtl_hex2rgba( $template_bgcolor, 0.9 ) ); ?>;<?php } ?>
	<?php
	if ( isset( $template_contentcolor ) && '' !== $template_contentcolor ) {
		?>
		color: <?php echo esc_attr( $template_contentcolor ); ?>;<?php } ?>
}
/** Woocommerce Layout Settings */
<?php
if ( ( Wp_Timeline_Lite_Main::wtl_woocommerce_plugin() || class_exists( 'woocommerce' ) ) && ( ! is_archive() || is_product_tag() || is_product_category() ) ) {
	echo esc_attr( $layout_id );
	?>
	.wp_timeline_woocommerce_price_wrap {

		<?php
		if ( isset( $wp_timeline_pricetext_paddingleft ) && '' !== $wp_timeline_pricetext_paddingleft ) {
			?>
			padding-left: <?php echo esc_attr( $wp_timeline_pricetext_paddingleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_paddingright ) && '' !== $wp_timeline_pricetext_paddingright ) {
			?>
			padding-right: <?php echo esc_attr( $wp_timeline_pricetext_paddingright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_paddingtop ) && '' !== $wp_timeline_pricetext_paddingtop ) {
			?>
			padding-top: <?php echo esc_attr( $wp_timeline_pricetext_paddingtop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_paddingbottom ) && '' !== $wp_timeline_pricetext_paddingbottom ) {
			?>
			padding-bottom: <?php echo esc_attr( $wp_timeline_pricetext_paddingbottom ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_marginleft ) && '' !== $wp_timeline_pricetext_marginleft ) {
			?>
			margin-left:<?php echo esc_attr( $wp_timeline_pricetext_marginleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_marginright ) && '' !== $wp_timeline_pricetext_marginright ) {
			?>
			margin-right:<?php echo esc_attr( $wp_timeline_pricetext_marginright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_margintop ) && '' !== $wp_timeline_pricetext_margintop ) {
			?>
			margin-top: <?php echo esc_attr( $wp_timeline_pricetext_margintop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_marginbottom ) && '' !== $wp_timeline_pricetext_marginbottom ) {
			?>
			margin-bottom: <?php echo esc_attr( $wp_timeline_pricetext_marginbottom ) . 'px'; ?>;<?php } ?>

		<?php
		if ( isset( $wp_timeline_pricetext_alignment ) && ! empty( $wp_timeline_pricetext_alignment ) ) {
			?>
			text-align: <?php echo esc_attr( $wp_timeline_pricetext_alignment ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap.right-top span.onsale{
		right: 0;left: auto !important;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap.left-bottom span.onsale{
		top: auto !important;bottom: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap.right-bottom span.onsale{
		right: 0;left: auto !important;bottom: 0;top: auto !important;
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_price_wrap .price del .woocommerce-Price-amount {
		text-decoration: line-through;
	}  
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap.right-top span.onsale{
		top: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap.left-top span.onsale {
		left: 0;top: 0;
	}   
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale:before,
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale:after {content: '' !important;border: none !important;}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .star-rating {overflow: hidden;position: relative;height: 1em;line-height: 1;font-size: 1em;width: 5.4em;font-family: star;}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_star_wrap {
		float: left; width: 100%;		
		<?php
		if ( isset( $wp_timeline_star_rating_paddingleft ) && '' !== $wp_timeline_star_rating_paddingleft ) {
			?>
			padding-left: <?php echo esc_attr( $wp_timeline_star_rating_paddingleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_paddingright ) && '' !== $wp_timeline_star_rating_paddingright ) {
			?>
			padding-right: <?php echo esc_attr( $wp_timeline_star_rating_paddingright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_paddingtop ) && '' !== $wp_timeline_star_rating_paddingtop ) {
			?>
			padding-top: <?php echo esc_attr( $wp_timeline_star_rating_paddingtop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_paddingbottom ) && '' !== $wp_timeline_star_rating_paddingbottom ) {
			?>
			padding-bottom: <?php echo esc_attr( $wp_timeline_star_rating_paddingbottom ) . 'px'; ?>;
			<?php
		}
		if ( isset( $wp_timeline_star_rating_marginleft ) && '' !== $wp_timeline_star_rating_marginleft ) {
			?>
			margin-left: <?php echo esc_attr( $wp_timeline_star_rating_marginleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_marginright ) && '' !== $wp_timeline_star_rating_marginright ) {
			?>
			margin-right: <?php echo esc_attr( $wp_timeline_star_rating_marginright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_margintop ) && '' !== $wp_timeline_star_rating_margintop ) {
			?>
			margin-top: <?php echo esc_attr( $wp_timeline_star_rating_margintop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_star_rating_marginbottom ) && '' !== $wp_timeline_star_rating_marginbottom ) {
			?>
			margin-bottom: <?php echo esc_attr( $wp_timeline_star_rating_marginbottom ) . 'px'; ?>;
			<?php
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_star_wrap .star-rating {
		<?php
		if ( 'left' === $wp_timeline_star_rating_alignment ) {
			?>
			float: left;
			<?php
		} elseif ( 'center' === $wp_timeline_star_rating_alignment ) {
			?>
			margin:0 auto !important;
			<?php

		} elseif ( 'right' === $wp_timeline_star_rating_alignment ) {
			?>
			float: right;
			<?php
		}
		?>
	}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .star-rating {line-height: 1;font-size: 1em;font-family: star;}
	<?php echo esc_attr( $layout_id ); ?> .star-rating {float: none;}
	<?php echo esc_attr( $layout_id ); ?> .star-rating:before {
		color: 
		<?php
		if ( isset( $wp_timeline_star_rating_color ) && '' != $wp_timeline_star_rating_color ) {
			echo esc_attr( $wp_timeline_star_rating_color );
		} else {
			echo esc_attr( $template_contentcolor );
		}
		?>
		;
	}
	<?php echo esc_attr( $layout_id ); ?> .star-rating span {
		color: 
		<?php
		if ( isset( $wp_timeline_star_rating_bg_color ) && '' != $wp_timeline_star_rating_bg_color ) {
			echo esc_attr( $wp_timeline_star_rating_bg_color );
		} else {
			echo esc_attr( $template_contentcolor ); }
		?>
		;
	}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .star-rating:before {
		content: '\73\73\73\73\73';float: left;top: 0;left: 0;position: absolute;
	}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .star-rating span {
		overflow: hidden;float: left;top: 0;left: 0;position: absolute;padding-top: 1.5em;
	}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .star-rating span:before {
		content: '\53\53\53\53\53';top: 0;position: absolute;left: 0;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale {
		z-index: 1 !important;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale {
		min-height: 0;min-width: 0;
	}
	body:not(.woocommerce) <?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale{
		position: absolute;
		text-align: center;
		left: 0;
		z-index: 1 !important;
		color: #fff;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_woo_sale_wrap span.onsale {
		<?php
		if ( isset( $wp_timeline_sale_tagtextcolor ) && '' !== $wp_timeline_sale_tagtextcolor ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_sale_tagtextcolor ); ?> !important;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagfontsize ) && '' !== $wp_timeline_sale_tagfontsize ) {
			?>
			font-size: <?php echo esc_attr( $wp_timeline_sale_tagfontsize ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagfontface ) && '' !== $wp_timeline_sale_tagfontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_sale_tagfontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_weight ) && '' !== $wp_timeline_sale_tag_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_sale_tag_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_line_height ) && '' !== $wp_timeline_sale_tag_font_line_height ) {
			?>
			line-height: <?php echo esc_attr( $wp_timeline_sale_tag_font_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_italic ) && '1' == $wp_timeline_sale_tag_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_letter_spacing ) && '' !== $wp_timeline_sale_tag_font_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_sale_tag_font_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_text_transform ) && '' !== $wp_timeline_sale_tag_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $wp_timeline_sale_tag_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_font_text_decoration ) && '' !== $wp_timeline_sale_tag_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $wp_timeline_sale_tag_font_text_decoration ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagbgcolor ) && '' !== $wp_timeline_sale_tagbgcolor ) {
			?>
			background-color: <?php echo esc_attr( $wp_timeline_sale_tagbgcolor ); ?>; <?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_marginleft ) && '' !== $wp_timeline_sale_tagtext_marginleft ) {
			?>
			margin-left: <?php echo esc_attr( $wp_timeline_sale_tagtext_marginleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_marginright ) && '' !== $wp_timeline_sale_tagtext_marginright ) {
			?>
			margin-right: <?php echo esc_attr( $wp_timeline_sale_tagtext_marginright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_margintop ) && '' !== $wp_timeline_sale_tagtext_margintop ) {
			?>
			margin-top: <?php echo esc_attr( $wp_timeline_sale_tagtext_margintop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_marginbottom ) && '' !== $wp_timeline_sale_tagtext_marginbottom ) {
			?>
			margin-bottom: <?php echo esc_attr( $wp_timeline_sale_tagtext_marginbottom ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_paddingleft ) && '' !== $wp_timeline_sale_tagtext_paddingleft ) {
			?>
			padding-left: <?php echo esc_attr( $wp_timeline_sale_tagtext_paddingleft ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_paddingright ) && '' !== $wp_timeline_sale_tagtext_paddingright ) {
			?>
			padding-right: <?php echo esc_attr( $wp_timeline_sale_tagtext_paddingright ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_paddingtop ) && '' !== $wp_timeline_sale_tagtext_paddingtop ) {
			?>
			padding-top: <?php echo esc_attr( $wp_timeline_sale_tagtext_paddingtop ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tagtext_paddingbottom ) && '' !== $wp_timeline_sale_tagtext_paddingbottom ) {
			?>
			padding-bottom: <?php echo esc_attr( $wp_timeline_sale_tagtext_paddingbottom ) . 'px'; ?>;<?php } ?>
		width: auto;
		<?php
		if ( isset( $wp_timeline_sale_tag_angle ) && '' !== $wp_timeline_sale_tag_angle ) {
			?>
			transform: rotate(<?php echo esc_attr( $wp_timeline_sale_tag_angle ); ?>deg); <?php } ?>
		<?php
		if ( isset( $wp_timeline_sale_tag_border_radius ) && '' !== $wp_timeline_sale_tag_border_radius ) {
			?>
			border-radius: <?php echo esc_attr( $wp_timeline_sale_tag_border_radius ); ?>%; <?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_price_wrap .price .woocommerce-Price-amount span {
		<?php
		if ( isset( $wp_timeline_pricetextcolor ) && '' !== $wp_timeline_pricetextcolor ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_pricetextcolor ); ?> !important;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_price_wrap .price .woocommerce-Price-amount {
		<?php
		if ( isset( $wp_timeline_pricetextcolor ) && '' !== $wp_timeline_pricetextcolor ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_pricetextcolor ); ?> !important;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricefontsize ) && '' !== $wp_timeline_pricefontsize ) {
			?>
			font-size: <?php echo esc_attr( $wp_timeline_pricefontsize ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricefontface ) && '' !== $wp_timeline_pricefontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_pricefontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_weight ) && '' !== $wp_timeline_price_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_price_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_line_height ) && '' !== $wp_timeline_price_font_line_height ) {
			?>
			line-height: <?php echo esc_attr( $wp_timeline_price_font_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_italic ) && 1 == $wp_timeline_price_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_letter_spacing ) && '' !== $wp_timeline_price_font_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_price_font_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_text_transform ) && '' !== $wp_timeline_price_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $wp_timeline_price_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_price_font_text_decoration ) && '' !== $wp_timeline_price_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $wp_timeline_price_font_text_decoration ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_pricetext_alignment ) && '' !== $wp_timeline_pricetext_alignment ) {
			?>
			text-align: <?php echo esc_attr( $wp_timeline_pricetext_alignment ); ?>;<?php } ?>
		width: auto;
		word-break: break-all;
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .add_to_cart_button,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .add_to_cart_button .wpbm-span,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_external,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_grouped,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_simple {
		<?php
		if ( isset( $wp_timeline_addtocart_button_fontsize ) && '' !== $wp_timeline_addtocart_button_fontsize ) {
			?>
			font-size: <?php echo esc_attr( $wp_timeline_addtocart_button_fontsize ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_fontface ) && '' !== $wp_timeline_addtocart_button_fontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_addtocart_button_fontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_weight ) && '' !== $wp_timeline_addtocart_button_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_addtocart_button_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $display_addtocart_button_line_height ) && '' !== $display_addtocart_button_line_height ) {
			?>
			line-height: <?php echo esc_attr( $display_addtocart_button_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_italic ) && 1 == $wp_timeline_addtocart_button_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_letter_spacing ) && '' !== $wp_timeline_addtocart_button_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_addtocart_button_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_text_transform ) && '' !== $wp_timeline_addtocart_button_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $wp_timeline_addtocart_button_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_text_decoration ) && '' !== $wp_timeline_addtocart_button_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $wp_timeline_addtocart_button_font_text_decoration ); ?> !important;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .added_to_cart {
		display: inline-block;
		<?php if ( isset( $wp_timeline_addtocartbutton_padding_topbottom ) && '' !== $wp_timeline_addtocartbutton_padding_topbottom ) { ?>
			padding-top: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_topbottom ) . 'px'; ?>;
			padding-bottom: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_topbottom ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_addtocartbutton_padding_leftright ) && '' !== $wp_timeline_addtocartbutton_padding_leftright ) { ?>
			padding-left: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_leftright ) . 'px'; ?>;
			padding-right: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_leftright ) . 'px'; ?>;
		<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_fontface ) && '' !== $wp_timeline_addtocart_button_fontface ) {
			?>
			font-family: <?php echo esc_attr( $wp_timeline_addtocart_button_fontface ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_weight ) && '' !== $wp_timeline_addtocart_button_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $wp_timeline_addtocart_button_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $display_addtocart_button_line_height ) && '' !== $display_addtocart_button_line_height ) {
			?>
			line-height: <?php echo esc_attr( $display_addtocart_button_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_italic ) && 1 == $wp_timeline_addtocart_button_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_letter_spacing ) && '' !== $wp_timeline_addtocart_button_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $wp_timeline_addtocart_button_letter_spacing ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_text_transform ) && '' !== $wp_timeline_addtocart_button_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $wp_timeline_addtocart_button_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_font_text_decoration ) && '' !== $wp_timeline_addtocart_button_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_html( $wp_timeline_addtocart_button_font_text_decoration ); ?> !important;<?php } ?>
	}
	/* Cart Buttion Setting*/
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .add_to_cart_button,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_external,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_grouped,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_simple  {
		<?php
		if ( isset( $wp_timeline_addtocart_textcolor ) && '' !== $wp_timeline_addtocart_textcolor ) {
			?>
			color: <?php echo esc_html( $wp_timeline_addtocart_textcolor ); ?> !important;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_backgroundcolor ) && '' !== $wp_timeline_addtocart_backgroundcolor ) {
			?>
			background: <?php echo esc_html( $wp_timeline_addtocart_backgroundcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_borderleft ) && '' !== $wp_timeline_addtocartbutton_borderleft ) {
			?>
			border-left:<?php echo esc_html( $wp_timeline_addtocartbutton_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_borderright ) && '' !== $wp_timeline_addtocartbutton_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_addtocartbutton_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_bordertop ) && '' !== $wp_timeline_addtocartbutton_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_addtocartbutton_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_borderbuttom ) && '' !== $wp_timeline_addtocartbutton_borderbuttom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_addtocartbutton_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $display_addtocart_button_border_radius ) && '' !== $display_addtocart_button_border_radius ) {
			?>
			border-radius:<?php echo esc_attr( $display_addtocart_button_border_radius ) . 'px'; ?>;<?php } ?>
		<?php if ( isset( $wp_timeline_addtocartbutton_padding_topbottom ) && '' !== $wp_timeline_addtocartbutton_padding_topbottom ) { ?>
			padding-top: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_topbottom ) . 'px'; ?>;
			padding-bottom: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_topbottom ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_addtocartbutton_padding_leftright ) && '' !== $wp_timeline_addtocartbutton_padding_leftright ) { ?>
			padding-left: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_leftright ) . 'px'; ?>;
			padding-right: <?php echo esc_attr( $wp_timeline_addtocartbutton_padding_leftright ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_addtocartbutton_margin_topbottom ) && '' !== $wp_timeline_addtocartbutton_margin_topbottom ) { ?>
			margin-top: <?php echo esc_attr( $wp_timeline_addtocartbutton_margin_topbottom ) . 'px'; ?>;
			margin-bottom: <?php echo esc_attr( $wp_timeline_addtocartbutton_margin_topbottom ) . 'px'; ?>;
		<?php } ?>
		<?php if ( isset( $wp_timeline_addtocartbutton_margin_leftright ) && '' !== $wp_timeline_addtocartbutton_margin_leftright ) { ?>
			margin-left: <?php echo esc_attr( $wp_timeline_addtocartbutton_margin_leftright ) . 'px'; ?>;
			margin-right:<?php echo esc_attr( $wp_timeline_addtocartbutton_margin_leftright ) . 'px'; ?>;
		<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_box_shadow_color ) && '' !== $wp_timeline_addtocart_button_box_shadow_color ) {
			?>
			box-shadow: <?php echo esc_attr( $wp_timeline_addtocart_button_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_box_shadow_color ); ?>; <?php } ?>
		display: inline-block;
	}

	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .add_to_cart_button:hover,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .add_to_cart_button:focus,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_external:hover,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_external:focus,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_grouped:hover,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_grouped:focus,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_simple:hover,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap .product_type_simple:focus  {
		<?php
		if ( isset( $wp_timeline_addtocart_text_hover_color ) && '' !== $wp_timeline_addtocart_text_hover_color ) {
			?>
			color: <?php echo esc_attr( $wp_timeline_addtocart_text_hover_color ); ?> !important;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_hover_backgroundcolor ) && '' !== $wp_timeline_addtocart_hover_backgroundcolor ) {
			?>
			background: <?php echo esc_attr( $wp_timeline_addtocart_hover_backgroundcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_hover_borderleft ) && '' !== $wp_timeline_addtocartbutton_hover_borderleft ) {
			?>
			border-left:<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderleftcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_hover_borderright ) && '' !== $wp_timeline_addtocartbutton_hover_borderright ) {
			?>
			border-right:<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderrightcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_hover_bordertop ) && '' !== $wp_timeline_addtocartbutton_hover_bordertop ) {
			?>
			border-top:<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_hover_bordertopcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocartbutton_hover_borderbuttom ) && '' !== $wp_timeline_addtocartbutton_hover_borderbuttom ) {
			?>
			border-bottom:<?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_addtocartbutton_hover_borderbottomcolor ); ?>;<?php } ?>
		<?php
		if ( isset( $display_addtocart_button_border_hover_radius ) && '' !== $display_addtocart_button_border_hover_radius ) {
			?>
			border-radius:<?php echo esc_attr( $display_addtocart_button_border_hover_radius ) . 'px'; ?>;<?php } ?>
		<?php
		if ( isset( $wp_timeline_addtocart_button_hover_box_shadow_color ) && '' !== $wp_timeline_addtocart_button_hover_box_shadow_color ) {
			?>
			box-shadow: <?php echo esc_attr( $wp_timeline_addtocart_button_hover_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_hover_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_hover_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_hover_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_addtocart_button_hover_box_shadow_color ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .yith-wcwl-add-to-wishlist{ margin-top: 0 }
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_wishlistbutton_on_same_line.wp_timeline_cartwishlist_wrapp {
		<?php
		if ( isset( $wp_timeline_cart_wishlistbutton_alignment ) && '' !== $wp_timeline_cart_wishlistbutton_alignment ) {
			?>
			text-align : <?php echo esc_attr( $wp_timeline_cart_wishlistbutton_alignment ); ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_wishlistbutton_on_same_line .wp_timeline_woocommerce_add_to_wishlist_wrap ,
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_wishlistbutton_on_same_line .wp_timeline_woocommerce_add_to_cart_wrap {
		display : inline-block;
	}
	<?php if ( isset( $wp_timeline_wishlistbutton_on ) && isset( $display_addtowishlist_button ) && 1 == $wp_timeline_wishlistbutton_on && 1 == $display_addtowishlist_button ) { ?>
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_wishlistbutton_on_same_line.wp_timeline_cartwishlist_wrapp{
			<?php
			if ( isset( $wp_timeline_cart_wishlistbutton_alignment ) && '' !== $wp_timeline_cart_wishlistbutton_alignment ) {
				?>
				text-align : <?php echo esc_attr( $wp_timeline_cart_wishlistbutton_alignment ); ?>;<?php } ?>
		}
	<?php } else { ?>
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_cart_wrap {
			<?php
			if ( isset( $wp_timeline_addtocartbutton_alignment ) && '' !== $wp_timeline_addtocartbutton_alignment ) {
				?>
				text-align:<?php echo esc_attr( $wp_timeline_addtocartbutton_alignment ); ?>;<?php } ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-add-button,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse ,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse{
			<?php
			if ( isset( $wp_timeline_wishlistbutton_alignment ) && '' !== $wp_timeline_wishlistbutton_alignment ) {
				?>
				text-align:<?php echo esc_attr( $wp_timeline_wishlistbutton_alignment ); ?>;<?php } ?>
		}
	<?php } ?>
	<?php if ( class_exists( 'YITH_WCWL' ) ) { ?>
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse .feedback,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse .feedback{ 
			display: none !important; 
		}
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .add_to_wishlist,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse a,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse a {
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_fontsize ) && '' !== $wp_timeline_addtowishlist_button_fontsize ) {
				?>
				font-size: <?php echo esc_attr( $wp_timeline_addtowishlist_button_fontsize ) . 'px'; ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_fontface ) && '' !== $wp_timeline_addtowishlist_button_fontface ) {
				?>
				font-family: <?php echo esc_attr( $wp_timeline_addtowishlist_button_fontface ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_weight ) && '' !== $wp_timeline_addtowishlist_button_font_weight ) {
				?>
				font-weight: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_weight ); ?>;<?php } ?>
			<?php
			if ( isset( $display_wishlist_button_line_height ) && '' !== $display_wishlist_button_line_height ) {
				?>
				line-height: <?php echo esc_attr( $display_wishlist_button_line_height ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_italic ) && 1 == $wp_timeline_addtowishlist_button_font_italic ) {
				?>
				font-style: <?php echo 'italic'; ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_letter_spacing ) && '' !== $wp_timeline_addtowishlist_button_letter_spacing ) {
				?>
				letter-spacing: <?php echo esc_attr( $wp_timeline_addtowishlist_button_letter_spacing ) . 'px'; ?>; <?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_text_transform ) && '' !== $wp_timeline_addtowishlist_button_font_text_transform ) {
				?>
				text-transform: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_text_transform ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_text_decoration ) && '' !== $wp_timeline_addtowishlist_button_font_text_decoration ) {
				?>
				text-decoration: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_text_decoration ); ?> !important;<?php } ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .add_to_wishlist,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse a,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse a{
			<?php
			if ( isset( $wp_timeline_wishlist_textcolor ) && '' !== $wp_timeline_wishlist_textcolor ) {
				?>
				color: <?php echo esc_attr( $wp_timeline_wishlist_textcolor ); ?> !important;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlist_backgroundcolor ) && '' !== $wp_timeline_wishlist_backgroundcolor ) {
				?>
				background: <?php echo esc_attr( $wp_timeline_wishlist_backgroundcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_borderleft ) && '' !== $wp_timeline_wishlistbutton_borderleft ) {
				?>
				border-left:<?php echo esc_attr( $wp_timeline_wishlistbutton_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_borderleftcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_borderright ) && '' !== $wp_timeline_wishlistbutton_borderright ) {
				?>
				border-right:<?php echo esc_attr( $wp_timeline_wishlistbutton_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_borderrightcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_bordertop ) && '' !== $wp_timeline_wishlistbutton_bordertop ) {
				?>
				border-top:<?php echo esc_attr( $wp_timeline_wishlistbutton_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_bordertopcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_borderbuttom ) && '' !== $wp_timeline_wishlistbutton_borderbuttom ) {
				?>
				border-bottom:<?php echo esc_attr( $wp_timeline_wishlistbutton_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_borderbottomcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $display_wishlist_button_border_radius ) && '' !== $display_wishlist_button_border_radius ) {
				?>
				border-radius:<?php echo esc_attr( $display_wishlist_button_border_radius ) . 'px'; ?>;<?php } ?>
			<?php if ( isset( $wp_timeline_wishlistbutton_padding_topbottom ) && '' !== $wp_timeline_wishlistbutton_padding_topbottom ) { ?>
				padding-top: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_topbottom ) . 'px'; ?>;
				padding-bottom: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_topbottom ) . 'px'; ?>;
			<?php } ?>
			<?php if ( isset( $wp_timeline_wishlistbutton_padding_leftright ) && '' !== $wp_timeline_wishlistbutton_padding_leftright ) { ?>
				padding-left: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_leftright ) . 'px'; ?>;
				padding-right: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_leftright ) . 'px'; ?>;
			<?php } ?>
			<?php if ( isset( $wp_timeline_wishlistbutton_padding_topbottom ) && '' !== $wp_timeline_wishlistbutton_padding_topbottom ) { ?>
				padding-top: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_topbottom ) . 'px'; ?>;
				padding-bottom: <?php echo esc_attr( $wp_timeline_wishlistbutton_padding_topbottom ) . 'px'; ?>;
			<?php } ?>
			<?php if ( isset( $wp_timeline_wishlistbutton_margin_topbottom ) && '' !== $wp_timeline_wishlistbutton_margin_topbottom ) { ?>
				margin-left: <?php echo esc_attr( $wp_timeline_wishlistbutton_margin_topbottom ) . 'px'; ?>;
				margin-right: <?php echo esc_attr( $wp_timeline_wishlistbutton_margin_topbottom ) . 'px'; ?>;
			<?php } ?>
			<?php if ( isset( $wp_timeline_wishlistbutton_margin_leftright ) && '' !== $wp_timeline_wishlistbutton_margin_leftright ) { ?>
				margin-top: <?php echo esc_attr( $wp_timeline_wishlistbutton_margin_leftright ) . 'px'; ?>;
				margin-bottom: <?php echo esc_attr( $wp_timeline_wishlistbutton_margin_leftright ) . 'px'; ?>;
			<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlist_button_box_shadow_color ) && $wp_timeline_wishlist_button_box_shadow_color ) {
				?>
				box-shadow: <?php echo esc_attr( $wp_timeline_wishlist_button_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_box_shadow_color ); ?> !important;<?php } ?>
					display: inline-block;
		}
		<?php echo esc_attr( $layout_id ); ?> .add_to_wishlist:before {
			content: "\f08a";
			font-family: fontawesome;
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_weight ) && '' !== $wp_timeline_addtowishlist_button_font_weight ) {
				?>
				font-weight: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_weight ); ?>;<?php } ?>
			vertical-align: middle;
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_italic ) && 1 == $wp_timeline_addtowishlist_button_font_italic ) {
				?>
				font-style: <?php echo 'italic'; ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_fontsize ) && '' !== $wp_timeline_addtowishlist_button_fontsize ) {
				?>
				font-size: <?php echo esc_attr( $wp_timeline_addtowishlist_button_fontsize ) . 'px'; ?>;<?php } ?>
			<?php
			if ( isset( $display_wishlist_button_line_height ) && '' !== $display_wishlist_button_line_height ) {
				?>
				line-height: <?php echo esc_attr( $display_wishlist_button_line_height ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_letter_spacing ) && '' !== $wp_timeline_addtowishlist_button_letter_spacing ) {
				?>
				letter-spacing: <?php echo esc_attr( $wp_timeline_addtowishlist_button_letter_spacing ) . 'px'; ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_text_transform ) && '' !== $wp_timeline_addtowishlist_button_font_text_transform ) {
				?>
				text-transform: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_text_transform ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_addtowishlist_button_font_text_decoration ) && '' !== $wp_timeline_addtowishlist_button_font_text_decoration ) {
				?>
				text-decoration: <?php echo esc_attr( $wp_timeline_addtowishlist_button_font_text_decoration ); ?>;<?php } ?>
		}
		<?php if ( isset( $wp_timeline_wishlistbutton_on ) && isset( $display_addtowishlist_button ) && 1 == $wp_timeline_wishlistbutton_on && 1 == $display_addtowishlist_button ) { ?>
			<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_meta_box .wp_timeline_wishlistbutton_on_same_line {
				padding: 3px;
			}
			<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_meta_box .wp_timeline_wishlistbutton_on_same_line .wp_timeline_woocommerce_add_to_cart_wrap {
				display: inline-block;width: auto;vertical-align: top;
			}
			<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_meta_box .wp_timeline_wishlistbutton_on_same_line .wp_timeline_woocommerce_add_to_wishlist_wrap {
				display: inline-block;width: auto;vertical-align: top;
			}
		<?php } ?>
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .add_to_wishlist:hover,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .add_to_wishlist:focus,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistexistsbrowse a:focus,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_add_to_wishlist_wrap .yith-wcwl-wishlistaddedbrowse a:focus {
			<?php
			if ( isset( $wp_timeline_wishlist_text_hover_color ) && '' !== $wp_timeline_wishlist_text_hover_color ) {
				?>
				color: <?php echo esc_attr( $wp_timeline_wishlist_text_hover_color ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlist_hover_backgroundcolor ) && '' !== $wp_timeline_wishlist_hover_backgroundcolor ) {
				?>
				background: <?php echo esc_attr( $wp_timeline_wishlist_hover_backgroundcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_hover_borderleft ) && '' !== $wp_timeline_wishlistbutton_hover_borderleft ) {
				?>
				border-left:<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderleft ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderleftcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_hover_borderright ) && '' !== $wp_timeline_wishlistbutton_hover_borderright ) {
				?>
				border-right:<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderright ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderrightcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_hover_bordertop ) && '' !== $wp_timeline_wishlistbutton_hover_bordertop ) {
				?>
				border-top:<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_bordertop ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_hover_bordertopcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlistbutton_hover_borderbuttom ) && '' !== $wp_timeline_wishlistbutton_hover_borderbuttom ) {
				?>
				border-bottom:<?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderbuttom ) . 'px'; ?> solid <?php echo esc_attr( $wp_timeline_wishlistbutton_hover_borderbottomcolor ); ?>;<?php } ?>
			<?php
			if ( isset( $display_wishlist_button_border_hover_radius ) && '' !== $display_wishlist_button_border_hover_radius ) {
				?>
				border-radius:<?php echo esc_attr( $display_wishlist_button_border_hover_radius ) . 'px'; ?>;<?php } ?>
			<?php
			if ( isset( $wp_timeline_wishlist_button_hover_box_shadow_color ) && '' !== $wp_timeline_wishlist_button_hover_box_shadow_color ) {
				?>
				box-shadow: <?php echo esc_attr( $wp_timeline_wishlist_button_hover_top_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_hover_right_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_hover_bottom_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_hover_left_box_shadow ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_wishlist_button_hover_box_shadow_color ); ?>;<?php } ?>;
		}
	<?php } ?>
	<?php echo esc_attr( $layout_id ); ?> .wp_timeline_woocommerce_price_wrap .price ins {
		background: none;
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template img.ajax-loading {
		display: none !important;
	}
<?php } ?>
/** End Woocommerce Layout settingd */

/** Link label css */
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl-comment i,
<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .link-lable {
	color : <?php echo esc_attr( $template_contentcolor ); ?>;
}
<?php echo esc_attr( $layout_id ); ?> .blog_template. .wtl-read-more-div a.wtl-read-more{
	<?php
	if ( isset( $read_more_on ) && isset( $template_readmorebackcolor ) && 2 == $read_more_on && '' !== $template_readmorebackcolor ) {
		?>
		background: <?php echo esc_attr( $template_readmorebackcolor ); ?>;<?php } ?>
	<?php
	if ( isset( $template_readmorecolor ) && '' == $template_readmorecolor ) {
		?>
		color:<?php echo esc_attr( $template_readmorecolor ); ?>;<?php } ?>
	<?php
	if ( isset( $read_more_on ) && isset( $template_readmorebackcolor ) && 2 == $read_more_on && '' !== $template_readmorebackcolor ) {
		?>
		border-color: <?php echo esc_attr( $template_readmorebackcolor ); ?>;<?php } ?>
	<?php
	if ( isset( $read_more_on ) && 1 == $read_more_on ) {
		?>
		border: none;<?php } ?>
}
<?php
/*------------------ Template: Soft Layout --------------- */
if ( 'soft_block' === $wp_timeline_theme ) {
	?>
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .meeting-day .day-inner,
	<?php echo esc_attr( $layout_id ); ?> .soft-block-post-wrapper .soft_block_wrapper:before {
		background: <?php echo esc_attr( $template_contentcolor ); ?>;
	}
	<?php echo esc_attr( $layout_id ); ?> .post_content{  color: <?php echo esc_attr( $template_contentcolor ); ?>; }
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-has-links a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .post-author a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .date-meta a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .footer_meta a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta span,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .footer_meta .seperater,
	<?php echo esc_attr( $layout_id ); ?>.soft_block_cover .wtl-post-meta .comments-link{
		color: <?php echo esc_attr( $template_contentcolor ); ?>;
		font-size: <?php echo esc_attr( $meta_fontsize ) . 'px'; ?>;
		<?php
		if ( isset( $meta_font_family ) && '' != $meta_font_family ) {
			?>
			font-family: <?php echo esc_attr( $meta_font_family ); ?>; <?php } ?>
		<?php
		if ( isset( $meta_font_italic ) && 1 == $meta_font_italic ) {
			?>
			font-style: <?php echo 'italic'; ?>;<?php } ?>
		<?php
		if ( isset( $meta_font_weight ) && $meta_font_weight ) {
			?>
			font-weight: <?php echo esc_attr( $meta_font_weight ); ?>;<?php } ?>
		<?php
		if ( isset( $meta_font_line_height ) && $meta_font_line_height ) {
			?>
			line-height: <?php echo esc_attr( $meta_font_line_height ); ?>;<?php } ?>
		<?php
		if ( isset( $meta_font_text_transform ) && '' !== $meta_font_text_transform ) {
			?>
			text-transform: <?php echo esc_attr( $meta_font_text_transform ); ?>;<?php } ?>
		<?php
		if ( isset( $meta_font_text_decoration ) && '' !== $meta_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $meta_font_text_decoration ); ?>;
			<?php
		}
		if ( isset( $meta_font_letter_spacing ) && $meta_font_letter_spacing ) {
			?>
			letter-spacing: <?php echo esc_attr( $meta_font_letter_spacing ) . 'px'; ?>;<?php } ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta span i,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .link-lable,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-wrapper-like a i {
		color: <?php echo esc_attr( $template_contentcolor ); ?>;
	}
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-title{
		background: <?php echo esc_attr( $template_titlebackcolor ); ?>;
	}

	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link i,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category span,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category i,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags span,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags i,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-has-links a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .post-author a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-author a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-author i,	
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-date-meta a,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-date-meta i,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-comment i
	{
		<?php echo isset( $wtl_settings['content_color'] ) ? 'color:' . esc_attr( $wtl_settings['content_color'] ) . ' !important' : ''; ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-meta a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .category-link i:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category span:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-post-category i:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags span:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .tags i:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-has-links a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .post-author a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-author a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-author i:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-date-meta a:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-date-meta i:hover,
	<?php echo esc_attr( $layout_id ); ?> .soft_block_wrapper .wtl-comment i:hover{
		color: <?php echo esc_attr( $template_contentcolor ); ?> !important;
	}
	<?php
	echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::post_date_typography( $wtl_settings, $layout_id ) );
}
if ( isset( $firstletter_big ) && 1 == $firstletter_big ) {
	$first_letter_line_height = $firstletter_fontsize * 75 / 100;
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post-content > *:first-child:first-letter,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post-content > p:first-child:first-letter,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post-content:first-letter,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post_content > *:first-child:first-letter,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post_content > p:first-child:first-letter,
	<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template div.post_content:first-letter ,
	<?php echo esc_attr( $layout_id ); ?> .wtl-first-letter{
		<?php
		if ( isset( $firstletter_font_family ) && $firstletter_font_family ) {
			?>
			font-family:<?php echo esc_attr( $firstletter_font_family ); ?>; <?php } ?>
		font-size:<?php echo esc_attr( $firstletter_fontsize ) . 'px'; ?>;
		color: <?php echo esc_attr( $firstletter_contentcolor ); ?>;
		margin-right:5px;
		line-height: <?php echo esc_attr( $first_letter_line_height ) . 'px'; ?>;
		display: inline-block;
		<?php
		if ( isset( $content_font_text_decoration ) && $content_font_text_decoration ) {
			?>
			text-decoration: <?php echo esc_attr( $content_font_text_decoration ); ?>;<?php } ?>
	}
	<?php
}
$filter_background_hover_color = isset( $wtl_settings['filter_background_hover_color'] ) ? $wtl_settings['filter_background_hover_color'] : '';
echo esc_attr( $layout_filter_id );
?>
.wp_timeline_filter_post_ul li a {
	padding: <?php echo esc_attr( $filter_paddingtop ) . 'px'; ?> <?php echo esc_attr( $filter_paddingright ) . 'px'; ?> <?php echo esc_attr( $filter_paddingbottom ) . 'px'; ?> <?php echo esc_attr( $filter_paddingleft ) . 'px'; ?>;
	margin: <?php echo esc_attr( $filter_margintop ) . 'px'; ?> <?php echo esc_attr( $filter_marginright ) . 'px'; ?> <?php echo esc_attr( $filter_marginbottom ) . 'px'; ?> <?php echo esc_attr( $filter_marginleft ) . 'px'; ?>;
	border-left: <?php echo esc_attr( $wp_timeline_filter_borderleft ) . 'px'; ?> <?php echo isset( $wtl_settings['wp_timeline_filter_borderleftstyle'] ) ? esc_attr( $wtl_settings['wp_timeline_filter_borderleftstyle'] ) : ''; ?> <?php echo isset( $wtl_settings['wp_timeline_filter_borderleftcolor'] ) ? esc_attr( $wtl_settings['wp_timeline_filter_borderleftcolor'] ) : ''; ?>;
	border-right: <?php echo esc_attr( $wp_timeline_filter_borderright ) . 'px'; ?> <?php echo isset( $wtl_settings['wp_timeline_filter_borderrightstyle'] ) ? esc_attr( $wp_timeline_filter_borderrightstyle ) : ''; ?> <?php echo isset( $wtl_settings['wp_timeline_filter_borderrightcolor'] ) ? esc_attr( $wp_timeline_filter_borderrightcolor ) : ''; ?>;
	border-top: <?php echo isset( $wtl_settings['wp_timeline_filter_bordertop'] ) ? esc_attr( $wp_timeline_filter_bordertop ) . 'px' : ''; ?> <?php echo isset( $wtl_settings['wp_timeline_filter_bordertopstyle'] ) ? esc_attr( $wp_timeline_filter_bordertopstyle ) : ''; ?> <?php echo esc_attr( $wp_timeline_filter_bordertopcolor ); ?>;
	border-bottom: <?php echo isset( $wtl_settings['wp_timeline_filter_borderbottom'] ) ? esc_attr( $wp_timeline_filter_borderbottom ) . 'px' : ''; ?> <?php echo esc_attr( $wp_timeline_filter_borderbottomstyle ); ?> <?php echo esc_attr( $wp_timeline_filter_borderbottomcolor ); ?>;
	color: <?php echo esc_attr( $filter_color ); ?> !important;
	background-color: <?php echo esc_attr( $filter_background_color ); ?> !important;	
}
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li a.wp_timeline_post_selected,
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li a:hover {
	border-left: <?php echo esc_attr( $wp_timeline_filter_hover_borderleft ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderleftstyle ); ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderleftcolor ); ?>;
	border-right: <?php echo esc_attr( $wp_timeline_filter_hover_borderright ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderrightstyle ); ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderrightcolor ); ?>;
	border-top: <?php echo esc_attr( $wp_timeline_filter_hover_bordertop ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_filter_hover_bordertopstyle ); ?> <?php echo esc_attr( $wp_timeline_filter_hover_bordertopcolor ); ?>;
	border-bottom: <?php echo esc_attr( $wp_timeline_filter_hover_borderbottom ) . 'px'; ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderbottomstyle ); ?> <?php echo esc_attr( $wp_timeline_filter_hover_borderbottomcolor ); ?>;
	transition: border-color 0.6s ease;
	transition: background-color 0.6s ease;
	transition: color 0.6s ease;
}
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li a.wp_timeline_post_selected,
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li a:hover,
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li span {
	color: <?php echo esc_attr( $filter_hover_color ); ?> !important;
	background-color: <?php echo esc_attr( $filter_background_hover_color ); ?> !important;
}
<?php echo esc_attr( $layout_filter_id ); ?> .wp_timeline_filter_post_ul li span:before {
	border-top: 5px solid <?php echo esc_attr( $filter_background_hover_color ); ?> !important;
}
<?php
/* ------------------ Template: Hire Layout --------------- */
if ( 'hire_layout' === $wp_timeline_theme ) {
	$template_color                     = isset( $wtl_settings['template_color'] ) ? esc_attr( $wtl_settings['template_color'] ) : '#fff';
	$content_box_bg_color = isset( $wtl_settings['content_box_bg_color'] ) ? $wtl_settings['content_box_bg_color'] : '#fff';
	/* background color */
	echo esc_attr( $layout_id );
	?>.wtl_wrapper{ <?php echo isset( $wtl_settings['template_bgcolor'] ) ? 'background:' . esc_attr( $wtl_settings['template_bgcolor'] ) . ';' : ''; ?> }
	/* Progress bar color */
	<?php echo esc_attr( $layout_id ); ?> .wtl-progress.wtl_blue  .wtl_fill,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal  .wtl-progress .wtl_fill{
		<?php
		if ( $template_color ) {
			echo 'stroke:' . esc_attr( $template_color ) . ' !important;';
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtlcircle i,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-date,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-date span,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-ss-right,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-ss-left,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtlcircle i,
	<?php echo esc_attr( $layout_id ); ?> .wtl_main_title h1,
	<?php echo esc_attr( $layout_id ); ?> .wtl_main_title h3{
		<?php
		if ( $template_color ) {
			echo 'color:' . esc_attr( $template_color ) . ' !important;';
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-progress .wtl_time_value{
		<?php
		if ( $template_color ) {
			echo 'fill:' . esc_attr( $template_color );
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_progress-circle::before{
		<?php
		if ( $template_color ) {
			echo 'border-left-color:' . esc_attr( $template_color );
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-slitem_nav::after{
		<?php
		if ( $template_color ) {
			echo 'background:' . esc_attr( $template_color );
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_progress-circle:after{
		<?php
		if ( $template_color ) {
			echo 'border-color:' . esc_attr( $template_color );
		}
		?>
		   
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-all-post-content{
	<?php
	if ( $content_box_bg_color ) {
		echo 'background:' . esc_attr( $content_box_bg_color ) . ';';
		echo 'z-index:999;';
	}
		echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
	?>
	}
	<?php
	echo esc_attr( Wtl_Lite_Template_Config::dropcap( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::post_content_color( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::post_meta_typography( $wtl_settings, $layout_id ) );
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap:before{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a,
	<?php echo esc_attr( $layout_id ); ?> .author-name a{
		<?php
		if ( $template_contentcolor ) {
			echo 'color:' . esc_attr( $template_contentcolor ) . ';';
			echo 'border-color:' . esc_attr( $template_contentcolor );
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover,
	<?php echo esc_attr( $layout_id ); ?> .author-name a:hover{
		<?php
		if ( $template_contentcolor ) {
			echo 'color:' . esc_attr( $template_contentcolor ) . ';';
			echo 'border-color:' . esc_attr( $template_contentcolor );
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_progress-circle{
		<?php echo isset( $wtl_settings['pbar_bg_color'] ) ? 'background:' . esc_attr( $wtl_settings['pbar_bg_color'] ) . ' !important;' : ''; ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-progress .wtl_track{
		<?php echo isset( $wtl_settings['pbar_track_color'] ) ? 'stroke:' . esc_attr( $wtl_settings['pbar_track_color'] ) . ' !important;' : ''; ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl_progress-circle:after{
		<?php echo isset( $wtl_settings['pbar_track_color'] ) ? 'color:' . esc_attr( $wtl_settings['pbar_track_color'] ) . ' !important;' : ''; ?>   
	}
	<?php
	echo esc_attr( Wtl_Lite_Template_Config::post_date_typography( $wtl_settings, $layout_id ) );
}
/* ------------------ Template: Curve Layout --------------- */
if ( 'curve_layout' === $wp_timeline_theme ) {
	/* background color */
	?>
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper{
		<?php echo isset( $wtl_settings['template_bgcolor'] ) ? 'background:' . esc_attr( $wtl_settings['template_bgcolor'] ) . ' !important;' : ''; ?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-all-post-content, <?php echo esc_attr( $layout_id ); ?> .slick-track .wtl-schedule-post-content{
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
		?>
	}
	<?php
	echo esc_attr( Wtl_Lite_Template_Config::dropcap( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::post_content_color( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
	echo esc_attr( Wtl_Lite_Template_Config::post_meta_typography( $wtl_settings, $layout_id ) );
	?>
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a,
	<?php echo esc_attr( $layout_id ); ?> .wtl-author a{
		<?php
		$template_contentcolor = isset( $wtl_settings['template_contentcolor'] ) ? esc_attr( $wtl_settings['template_contentcolor'] ) : '';
		if ( $template_contentcolor ) {
			echo 'color:' . esc_attr( $template_contentcolor ) . ' !important;';
			echo 'border-color:' . esc_attr( $template_contentcolor ) . ' !important;';
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a:hover,
	<?php echo esc_attr( $layout_id ); ?> .wtl-author a:hover{
		<?php
		$template_contentcolor = isset( $wtl_settings['template_contentcolor'] ) ? esc_attr( $wtl_settings['template_contentcolor'] ) : '';
		if ( $template_contentcolor ) {
			echo 'color:' . esc_attr( $template_contentcolor ) . ' !important;';
			echo 'border-color:' . esc_attr( $template_contentcolor ) . ' !important;';
		}
		?>
	}
	<?php echo esc_attr( $layout_id ); ?> .blog_template .social-component a{ color:#fff !important; }
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-blog-img img,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-slitem_nav .wtl-blog-img::after,
	<?php echo esc_attr( $layout_id ); ?> .wtl-border-top,
	<?php echo esc_attr( $layout_id ); ?> .wtl-border-bottom{
		<?php echo isset( $wtl_settings['template_color'] ) ? 'border-color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
	}

	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-ss-right i,
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-ss-left i{
		<?php echo isset( $wtl_settings['template_color'] ) ? 'color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
	}
	/* odd  */
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-slitem_nav:nth-child(odd) .wtl-blog-img:before,
	<?php echo esc_attr( $layout_id ); ?> .wtl-blog-curve-timeline li:nth-child(odd) .wtl-blog-number:before {
		<?php
		if ( isset( $wtl_settings['template_color2'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color2'] ) . ' !important;';
		}
		if ( isset( $wtl_settings['template_color4'] ) ) {
			echo 'color:' . esc_attr( $wtl_settings['template_color4'] ) . ' !important;';
		}
		?>
	}
	/* even */
	<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl_al_nav .wtl-slitem_nav:nth-child(even) .wtl-blog-img:before,
	<?php echo esc_attr( $layout_id ); ?> .wtl-blog-curve-timeline li:nth-child(even) .wtl-blog-number:before {
		<?php
		if ( isset( $wtl_settings['template_color3'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color3'] ) . ' !important;';
		}
		if ( isset( $wtl_settings['template_color5'] ) ) {
			echo 'color:' . esc_attr( $wtl_settings['template_color5'] ) . ' !important;';
		}
		?>
	}
	<?php
}
/*------------------ Template: Advanced Layout --------------- */
if ( 'advanced_layout' === $wp_timeline_theme ) {
	?>
		<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper{
		<?php echo isset( $wtl_settings['template_bgcolor'] ) ? 'background:' . esc_attr( $wtl_settings['template_bgcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_main_title h1,
		<?php echo esc_attr( $layout_id ); ?> .wtl_main_title h2{
			<?php echo isset( $wtl_settings['template_color'] ) ? 'color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-all-post-content{
			<?php
			echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_padding( $wtl_settings ) );
			?>
		}
		/* Title*/
		<?php echo esc_attr( $layout_id ); ?> h2.wtl-post-title{
			<?php echo esc_attr( Wtl_Lite_Template_Advanced_Layout::content_box_border_radious_title( $wtl_settings ) ); ?>
		}
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::dropcap( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_content_color( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_meta_typography( $wtl_settings, $layout_id ) );
		?>
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-footer,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-content
		{
		<?php echo esc_attr( Wtl_Lite_Template_Config::content_box_padding( $wtl_settings ) ); ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-footer
		{
			padding-top: 0 !important;
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap .wtl-post-center-image span i {
		<?php
		if ( isset( $template_titlecolor ) && '' !== $template_titlecolor ) {
			?>
			color: <?php echo esc_attr( $template_titlecolor ); ?> !important;<?php } ?>
			font-size: 22px;
		}
		/* Template Color */
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap:after,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap:before,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-post-content .wtl_year,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-post-content .wtl_year:before,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-post-content .wtl_year span,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-center-image
		{
		<?php echo isset( $wtl_settings['template_color'] ) ? 'background:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_year,
		<?php echo esc_attr( $layout_id ); ?> .wtl_year span,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap::after {
			<?php echo isset( $wtl_settings['timeline_border_color'] ) ? 'background:' . esc_attr( $wtl_settings['timeline_border_color'] ) . ' !important' : ''; ?>
		}

		/* Line */
		<?php echo esc_attr( $layout_id ); ?> .wtl_year,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-center-image
		{
			<?php echo isset( $wtl_settings['template_color'] ) ? 'border-color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-center-image{
			<?php echo isset( $wtl_settings['template_color'] ) ? 'background-color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap::after{
			<?php echo isset( $wtl_settings['timeline_line_width'] ) ? 'width:' . esc_attr( $wtl_settings['timeline_line_width'] ) . 'px !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-post-content .wtl_year::before{
			<?php echo isset( $wtl_settings['timeline_line_width'] ) ? 'height:' . esc_attr( $wtl_settings['timeline_line_width'] ) . 'px !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_year,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-center-image{
			<?php echo isset( $wtl_settings['timeline_line_width'] ) ? 'border-width:' . esc_attr( $wtl_settings['timeline_line_width'] ) . 'px !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap .wtl-schedule-all-post-content .wtl-post-content,
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap .wtl-schedule-all-post-content .wtl-post-footer {
			<?php
				echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
			?>
		}
		<?php
		/**
		 * Style Dependency Start
		 */
		/**
		 * If Horizental selected
		 */
		if ( 1 == $wtl_settings['layout_type'] ) {
			?>
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-ss-right i,
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-ss-left i{
				<?php echo isset( $wtl_settings['template_color'] ) ? 'color:' . esc_attr( $wtl_settings['template_color'] ) . ';' : ''; ?>
				border:2px solid;width: 25px;height: 25px;text-align: center;vertical-align: middle;line-height: 20px;margin-top: -10px;
			}
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .slick-track:before{
				<?php echo isset( $wtl_settings['template_color'] ) ? 'background:' . esc_attr( $wtl_settings['template_color'] ) . '' : ''; ?>
			}
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-slitem{
				<?php echo isset( $wtl_settings['wp_timeline_content_border_radius'] ) ? 'border-radius:' . esc_attr( $wtl_settings['wp_timeline_content_border_radius'] ) . 'px !important;' : ''; ?>
			}
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-slitem{
				<?php
				echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
				echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
				echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
				echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
				?>
			}
			<?php echo esc_attr( $layout_id ); ?>.wtl_is_horizontal .wtl-post-content{
				<?php echo esc_attr( Wtl_Lite_Template_Config::content_box_padding( $wtl_settings ) ); ?>
			}
			<?php
			/* if Default */
		}
		/* fix random issues */
		echo esc_attr( $layout_id );
		?>
		.wtl-post-title{
			<?php echo 0 == $wtl_settings['wp_timeline_post_title_link'] ? 'padding:15px' : ''; ?>
		}
		<?php
		/* --- End Horizental --- */
		echo esc_attr( Wtl_Lite_Template_Config::post_date_typography( $wtl_settings, $layout_id ) );
}
/*------------------ Template: Easy Layout --------------- */
if ( 'easy_layout' === $wp_timeline_theme ) {
	?>
	<?php echo esc_attr( $layout_id ); ?>.wtl_wrapper{
		<?php echo isset( $wtl_settings['template_bgcolor'] ) ? 'background:' . esc_attr( $wtl_settings['template_bgcolor'] ) : '#fff'; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap .wtl_steps_wrap{
		<?php echo isset( $wtl_settings['template_titlecolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_titlecolor'] ) . ' !important;' : ''; ?>
		}
		/* Box */
		<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl_steps .wtl_blog_single_post_wrapp{
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_padding( $wtl_settings ) );
		echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> h2.wtl-post-title{
			<?php echo esc_attr( Wtl_Lite_Template_Advanced_Layout::content_box_border_radious_title( $wtl_settings ) ); ?>
		}
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::dropcap( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_content_color( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_meta_typography( $wtl_settings, $layout_id ) );
		?>
		<?php echo esc_attr( $layout_id ); ?> .wtl_steps_wrap .wtl_steps::before,
		<?php echo esc_attr( $layout_id ); ?> .wtl_steps_wrap .wtl_steps:after
		{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_steps_wrap:before	   
		{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_steps_post_format{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'border-color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl_blog_template .wtl_steps .wtl_blog_single_post_wrapp .wtl_steps_post_format:before{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'color:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?>.hide_timeline_icon .wtl_steps_post_format:after,
		<?php echo esc_attr( $layout_id ); ?>.hide_timeline_icon .wtl_steps_post_format:before{
		<?php
		if ( isset( $wtl_settings['template_color'] ) ) {
			echo 'background:' . esc_attr( $wtl_settings['template_color'] ) . ' !important;';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a{
		<?php
		$template_contentcolor = isset( $wtl_settings['template_contentcolor'] ) ? $wtl_settings['template_contentcolor'] : '';
		if ( $template_contentcolor ) {
			echo 'color:' . esc_attr( $template_contentcolor ) . ';';
		}
		?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover{
			<?php
			$template_contentcolor = isset( $wtl_settings['template_contentcolor'] ) ? $wtl_settings['template_contentcolor'] : '';
			if ( $template_contentcolor ) {
				echo 'color:' . esc_attr( $template_contentcolor ) . ';';
			}
			?>
		}
		<?php echo esc_attr( $layout_id ); ?> .author a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a,
		<?php echo esc_attr( $layout_id ); ?> .comments-link{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .author a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a:hover,
		<?php echo esc_attr( $layout_id ); ?> .comments-link:hover{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>            
		}
		<?php
		$border_width = isset( $wtl_settings['wp_timeline_content_border_width'] ) ? $wtl_settings['wp_timeline_content_border_width'] : '';
		$border_style = isset( $wtl_settings['wp_timeline_content_border_style'] ) ? $wtl_settings['wp_timeline_content_border_style'] : '';
		$border_color = isset( $wtl_settings['wp_timeline_content_border_color'] ) ? $wtl_settings['wp_timeline_content_border_color'] : '';
		?>
		<?php echo esc_attr( $layout_id ); ?> #wtl_steps .wtl_blog_template .wtl_blog_single_post_wrapp:before{
			border-top: <?php echo esc_attr( $border_width ); ?>px <?php echo esc_attr( $border_style ); ?> <?php echo esc_attr( $border_color ); ?>;
			border-right: <?php echo esc_attr( $border_width ); ?>px <?php echo esc_attr( $border_style ); ?> <?php echo esc_attr( $border_color ); ?>;
		<?php echo isset( $wtl_settings['content_box_bg_color'] ) ? 'background:' . esc_attr( $wtl_settings['content_box_bg_color'] ) : '#fff'; ?>
		}
		<?php
}
/* ------------------ Template: Full Width Layout --------------- */
if ( 'fullwidth_layout' === $wp_timeline_theme ) {
	$template_color                     = isset( $wtl_settings['template_color'] ) ? esc_attr( $wtl_settings['template_color'] ) : '#fff';
	?>
	<?php echo esc_attr( $layout_id ); ?>{
		<?php echo isset( $wtl_settings['template_bgcolor'] ) ? 'background:' . esc_attr( $wtl_settings['template_bgcolor'] ) : '#fff'; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-read-more-div{overflow:hidden;}
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-load-more-pre,
		<?php echo esc_attr( $layout_id ); ?> .wp-timeline-load-more{z-index: 3;position: relative}
		<?php echo esc_attr( $layout_id ); ?> #wtl-load-more-hidden{ float:none; }
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::dropcap( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_content_color( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::read_more_style( $wtl_settings, $layout_id ) );
		echo esc_attr( Wtl_Lite_Template_Config::post_meta_typography( $wtl_settings, $layout_id ) );
		?>
		<?php echo esc_attr( $layout_id ); ?> .wtl-author a,
		<?php echo esc_attr( $layout_id ); ?> .post-comment a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a,
		<?php echo esc_attr( $layout_id ); ?> .wtl-meta-comment i,
		<?php echo esc_attr( $layout_id ); ?> a.comments-link
		{
		<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-author a:hover,
		<?php echo esc_attr( $layout_id ); ?> .post-comment a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-category a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-tags a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-meta-comment i:hover,
		<?php echo esc_attr( $layout_id ); ?> a.comments-link:hover
		{
		<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-content{
		<?php echo esc_attr( Wtl_Lite_Template_Config::content_box_padding( $wtl_settings ) ); ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-content{
		<?php
		if ( $content_box_bg_color ) {
			echo 'background:' . esc_attr( $content_box_bg_color ) . ';';
		}
		?>
		}
		/* Box */
		<?php echo esc_attr( $layout_id ); ?> .wtl-schedule-wrap .wtl-schedule-post-content{
			<?php
			echo esc_attr( Wtl_Lite_Template_Config::content_box_bg_color( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_border( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_border_radius( $wtl_settings ) );
			echo esc_attr( Wtl_Lite_Template_Config::content_box_shadow( $wtl_settings ) );
			?>
		}
		/* BG Color -------------- */
		/* .wp-timeline-post-image .wtl-flexslider.flexslider li { width: 100px !important; } */
		.wtl-flexslider.flexslider .slides > li { min-width: 70px;}
		.wp-timeline-post-image figure, .wp-timeline-post-image .wtl-flexslider.flexslider {width: 100px;height: 100px;background: #fff;padding: 12px;border-radius: 50%;}
		.wp-timeline-post-image figure img{max-height: 100%;position: absolute;display: block;width: 70%;height: 60%;top: 50% !important;bottom: 0;margin: auto;transform: translateY(-50%);}
		.wp-timeline-post-image .wtl-flexslider.flexslider { display: inline-flex; align-items: center; overflow: hidden; }
		/* Post Date */
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date:hover,
		<?php echo esc_attr( $layout_id ); ?> .wtl-post-date a:hover{
			<?php echo isset( $wtl_settings['template_contentcolor'] ) ? 'color:' . esc_attr( $wtl_settings['template_contentcolor'] ) . ' !important;' : ''; ?>
		}
		<?php
		echo esc_attr( Wtl_Lite_Template_Config::post_date_typography( $wtl_settings, $layout_id ) );
}
if ( isset( $wtl_settings['custom_css'] ) && ! empty( $wtl_settings['custom_css'] ) ) {
	echo esc_attr( wp_unslash( $wtl_settings['custom_css'] ) );
}
?>

</style>
<?php
/* Dynamic Style End. */
?>
