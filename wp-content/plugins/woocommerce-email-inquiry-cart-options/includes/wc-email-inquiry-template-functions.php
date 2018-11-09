<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get templates passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @return void
 */
function wc_ei_get_template( $template_name, $args = array() ) {
	
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$template_file_path = wc_ei_get_template_file_path( $template_name );

	if ( empty( $template_file_path ) ) {
		return;
	}

	include( $template_file_path );
}

/**
 *
 * @access public
 * @param $file string filename
 * @return PATH to the file
 */
function wc_ei_get_template_file_path( $file = '' ) {
	// If we're not looking for a file, do not proceed
	if ( empty( $file ) )
		return;

	// Look for file in stylesheet
	if ( file_exists( get_stylesheet_directory() . '/woocommerce/' . $file ) ) {
		$file_path = get_stylesheet_directory() . '/woocommerce/' . $file;

	// Look for file in template
	} elseif ( file_exists( get_template_directory() . '/woocommerce/' . $file ) ) {
		$file_path = get_template_directory() . '/woocommerce/' . $file;

	// Backwards compatibility
	} else {
		$file_path = WC_EMAIL_INQUIRY_TEMPLATE_PATH . '/' . $file;
	}

	// Return filtered result
	return apply_filters( 'wc_email_inquiry_get_template_file_path' , $file_path, $file );
}

function wc_ei_load_modal_popup() {

	$file_name = 'email-inquiry/modal-popup.php';

	wc_ei_get_template( $file_name );
}

function wc_ei_default_form_tpl( $data = array() ) {

	$file_name = 'email-inquiry/default-form.php';

	wc_ei_get_template( $file_name, $data );
}

function wc_ei_email_notification_tpl( $data = array() ) {
	$file_name = 'email-inquiry/email-notification.php';

	wc_ei_get_template( $file_name, $data );
}

?>