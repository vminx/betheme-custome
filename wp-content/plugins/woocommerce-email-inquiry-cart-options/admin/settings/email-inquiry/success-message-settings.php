<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
class WC_EI_Success_Message_Settings
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

  		// Define settings
     	$this->form_fields = array(

			array(
            	'name' 		=> __( 'Default Form Success Message', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_success_message_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Success Message', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Message that user will see after their Inquiry is sent.', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'wc_email_inquiry_contact_success',
				'type' 		=> 'wp_editor',
				'textarea_rows'		=> 30,
				'default'	=> __( "Thanks for your inquiry - we'll be in touch with you as soon as possible!", 'woocommerce-email-inquiry-cart-options' ),
				'separate_option'	=> true,
				'free_version'		=> true,
			),

        );
	}

}

global $wc_ei_success_message_settings;
$wc_ei_success_message_settings = new WC_EI_Success_Message_Settings();

?>