<?php
/**
 * Admin Import Form.
 *
 * @link       https://www.solwininfotech.com/
 * @since      1.0.0
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/wp_timeline_templates
 */

/**
 * To Import Layout.
 *
 * @package    Wp_Timeline
 * @subpackage Wp_Timeline/admin
 * @author     Solwin Infotech <info@solwininfotech.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $import_success, $import_error;
?>
<div class="wrap">
	<h2><?php esc_html_e( 'Import Timeline Layouts', 'timeline-designer' ); ?></h2>
	<?php
	if ( isset( $import_error ) ) {
		?>
		<div class="error notice"><p><?php echo esc_html( $import_error ); ?></p></div>
		<?php
	}
	if ( isset( $import_success ) ) {
		?>
		<div class="updated notice">
			<p><?php echo esc_html( $import_success ); ?></p>
		</div>
		<?php
	}
	?>
	<div class="narrow">
		<p>
			<?php esc_html_e( 'Select import type and Choose a .txt file to upload, then click Upload file and import', 'timeline-designer' ); ?>
		</p>
		<form method="post" id="wp-timeline-import-upload-form" class="wp-timeline-upload-form" enctype="multipart/form-data" name="wp-timeline-import-upload-form">
			<p>
				<?php wp_nonce_field( 'wtl_import', 'wtl_import_nonce' ); ?>
				<label><?php esc_html_e( 'Import Type', 'timeline-designer' ); ?> : </label>
				<select id="wtl_layout_import_types" name="wtl_layout_import_types">
					<option value=""><?php esc_html_e( 'Please Select', 'timeline-designer' ); ?></option>
					<option value="wp_timeline_blog_layouts"><?php esc_html_e( 'Timeline Layouts', 'timeline-designer' ); ?></option>
					<option value="wp_timeline_cpt"><?php esc_html_e( 'Timeline Custom Post Type', 'timeline-designer' ); ?></option>
				</select>
			</p>
			<p>
				<label for="wtl_import_layout"><?php esc_html_e( 'Choose a file from your computer', 'timeline-designer' ); ?> : </label>
				<input type="file" id="wtl_import_layout" name="wtl_import">
			</p>
			<p>
				<strong><?php esc_html_e( 'Note', 'timeline-designer' ); ?>:</strong> <?php esc_html_e( 'If you have an query or face any issue while importing layout, please refer', 'timeline-designer' ); ?> <a href="<?php echo esc_url( 'https://wptimeline.solwininfotech.com/docs-category/export-and-import/' ); ?>" target="_blank"><?php esc_html_e( 'WP Timeline Document', 'timeline-designer' ); ?></a>
			</p>
			<p class="submit">
				<input id="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Upload file and import', 'timeline-designer' ); ?>" name="submit">
			</p>

		</form>
	</div>
</div>
