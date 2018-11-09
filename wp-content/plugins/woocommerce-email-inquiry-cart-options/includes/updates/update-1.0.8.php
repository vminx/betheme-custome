<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$wc_email_inquiry_rules_roles_settings = get_option( 'wc_email_inquiry_rules_roles_settings', array() );
$wc_email_inquiry_global_settings = get_option( 'wc_email_inquiry_global_settings', array() );
$wc_email_inquiry_email_options = get_option( 'wc_email_inquiry_email_options', array() );
$wc_email_inquiry_3rd_contactforms_settings = get_option( 'wc_email_inquiry_3rd_contactforms_settings', array() );
$wc_email_inquiry_customize_email_popup = get_option( 'wc_email_inquiry_customize_email_popup', array() );
$wc_email_inquiry_customize_email_button = get_option( 'wc_email_inquiry_customize_email_button', array() );

$wc_email_inquiry_contact_form_settings = array(
	
	'inquiry_email_from_name'			=> $wc_email_inquiry_email_options['inquiry_email_from_name'],
	'inquiry_email_from_address'		=> $wc_email_inquiry_email_options['inquiry_email_from_address'],
	'inquiry_send_copy'					=> $wc_email_inquiry_email_options['inquiry_send_copy'],
	'inquiry_email_to'					=> $wc_email_inquiry_email_options['inquiry_email_to'],
	'inquiry_email_cc'					=> $wc_email_inquiry_email_options['inquiry_email_cc'],
	
);
update_option( 'wc_email_inquiry_contact_form_settings', $wc_email_inquiry_contact_form_settings );

$wc_email_inquiry_global_settings = array(
	'inquiry_popup_type'				=> $wc_email_inquiry_customize_email_popup['inquiry_popup_type'],
);
update_option( 'wc_email_inquiry_global_settings', $wc_email_inquiry_global_settings );

$wc_email_inquiry_customize_email_button_new = array_merge( $wc_email_inquiry_customize_email_button, array( 
	'inquiry_button_type'				=> $wc_email_inquiry_global_settings['inquiry_button_type'],
	'inquiry_button_position'			=> $wc_email_inquiry_global_settings['inquiry_button_position'],
	'inquiry_button_margin_top'			=> $wc_email_inquiry_global_settings['inquiry_button_padding_top'],
	'inquiry_button_margin_bottom'		=> $wc_email_inquiry_global_settings['inquiry_button_padding_bottom'],
	'inquiry_single_only'				=> $wc_email_inquiry_global_settings['inquiry_single_only'],
	
) );
update_option( 'wc_email_inquiry_customize_email_button', $wc_email_inquiry_customize_email_button_new );

$wc_email_inquiry_customize_email_popup_new = array_merge( $wc_email_inquiry_customize_email_popup, array( 
	'inquiry_contact_popup_text_font'	=> array(
				'size'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_size'],
				'face'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font'],
				'style'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_style'],
				'color'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_colour'],
	),
	
) );
update_option( 'wc_email_inquiry_customize_email_popup', $wc_email_inquiry_customize_email_popup_new );