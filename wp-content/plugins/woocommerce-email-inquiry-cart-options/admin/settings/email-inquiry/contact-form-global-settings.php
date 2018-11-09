<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Contact Form Settings

-----------------------------------------------------------------------------------*/

class WC_EI_Contact_Form_Settings
{
	/**
	 * @var array
	 */
	public $form_fields = array();

	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
	}

	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {

		global $wc_ei_admin_init;

		$privacy_policy_url = '#';

  		// Define settings
     	$this->form_fields = array(

			// Default Form Settings
			array(
            	'name' 		=> __( 'Default Form Settings', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'desc'		=> sprintf( __( 'The plugins default form applies to all products. For the ability to add custom forms created with Contact Form 7 or Gravity Forms, globally or for individual or groups of products upgrade to the Premium <a href="%s" target="_blank">WooCommerce Email Inquiry Ultimate</a> plugin.', 'woocommerce-email-inquiry-cart-options' ), $wc_ei_admin_init->ultimate_plugin_page_url ),
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_default_form_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( "Email 'From' Settings", 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_hidden',
           	),
			array(
				'name' 		=> __( '"From" Name', 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'Leave empty and your site title will be use', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[inquiry_email_from_name]',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('blogname'),
				'separate_option'	=> true,
			),
			array(
				'name' 		=> __( '"From" Email Address', 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'Leave empty and your WordPress admin email address will be used', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[inquiry_email_from_address]',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
				'separate_option'	=> true,
			),

			array(
				'name' 		=> __( 'Email Delivery', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Inquiry Email goes to', 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'Leave empty and your WordPress admin email address will be used', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[inquiry_email_to]',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
				'separate_option'	=> true,
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'CC', 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( "Leave empty and 'no copy sent'", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[inquiry_email_cc]',
				'type' 		=> 'text',
				'default'	=> '',
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'name' 		=> __( 'Form Field Options', 'woocommerce-email-inquiry-cart-options' ),
				'type' 		=> 'heading',
				'class'		=> 'wc_ei_default_form_container',
				'id'		=> 'wc_ei_form_field_options_box',
				'is_box'	=> true,
           	),

           	array(
				'name' 		=> __( 'Name Field', 'woocommerce-email-inquiry-cart-options' ),
				'type' 		=> 'heading',
			),
			array(  
				'name' 		=> __( 'Required', 'woocommerce-email-inquiry-cart-options' ) . ' <span style="color:red">*</span>',
				'id' 		=> 'wc_email_inquiry_contact_form_settings[name_required]',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'name' 		=> __( 'Phone Field', 'woocommerce-email-inquiry-cart-options' ),
				'type' 		=> 'heading',
			),
			array(  
				'name' 		=> __( 'Show', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[show_phone]',
				'class'		=> 'show_phone',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'class'		=> 'show_phone_yes_container',
				'type' 		=> 'heading',
			),
			array(  
				'name' 		=> __( 'Required', 'woocommerce-email-inquiry-cart-options' ) . ' <span style="color:red">*</span>',
				'id' 		=> 'wc_email_inquiry_contact_form_settings[phone_required]',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'name' 		=> __( 'Message Field', 'woocommerce-email-inquiry-cart-options' ),
				'type' 		=> 'heading',
			),
			array(  
				'name' 		=> __( 'Required', 'woocommerce-email-inquiry-cart-options' ) . ' <span style="color:red">*</span>',
				'id' 		=> 'wc_email_inquiry_contact_form_settings[message_required]',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'name' 		=> __( "Sender 'Request A Copy'", 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Send Copy to Sender', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( "Gives users a checkbox option to send a copy of the Inquiry email to themselves", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[inquiry_send_copy]',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'GDPR Compliance', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_form_gdpr_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Show acceptance checkbox', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( "Gives users a checkbox to agree terms and conditions, this field is required if you turn it ON.", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_settings[acceptance]',
				'class'		=> 'acceptance',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

			array(
				'class'		=> 'show_acceptance_yes',
				'type' 		=> 'heading',
			),
			array(  
				'name' 		=> __( 'Information Text', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Enter informational text and a link to your privacy policy (Optional). Leave blank and nothing will show.', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_information_text',
				'type' 		=> 'wp_editor',
				'textarea_rows'		=> 15,
				'default'	=> sprintf( __( 'The information you enter here will be sent directly to the recipient. It is not stored on this sites database. Read more in our <a href="%s" target="_blank">Privacy Policy</a>', 'woocommerce-email-inquiry-cart-options' ), $privacy_policy_url ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Acceptance Text', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Text will show on the right of the acceptance checkbox. (Required)', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_form_condition_text',
				'type' 		=> 'wp_editor',
				'textarea_rows'		=> 10,
				'default'	=> __( 'I have read and agree to the website terms and conditions', 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

        );
	}

}

global $wc_ei_contact_form_settings;
$wc_ei_contact_form_settings = new WC_EI_Contact_Form_Settings();

?>