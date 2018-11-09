<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
class WC_EI_Popup_Form_Style_Settings
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
            	'name' 		=> __( 'Form Background Colour', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_form_bg_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Background Colour', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_form_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF',
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Default Form Fonts and Text', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_form_title_box',
                'is_box'	=> true,
           	),
           	array(
            	'name' 		=> __( 'Form Heading Text', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Heading Text', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( "Leave Empty and the form title will default to Product Inquiry", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_heading',
				'type' 		=> 'text',
				'default'	=> '',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Text Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_heading_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '18px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Product Name', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_hidden',
           	),
			array(
				'name' 		=> __( 'Product Name Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_form_product_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '26px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#29577F' )
			),

			array(
            	'name' 		=> __( 'Product URL', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_hidden',
           	),
			array(
				'name' 		=> __( 'Product URL Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_form_product_url_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#29577F' )
			),

			array(
            	'name' 		=> __( 'Form Content Font', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Content Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_popup_text',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Email Subject Name', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Subject Name Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_form_subject_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Default Form Text Input Fileds', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_form_input_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Background Colour', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FAFAFA',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Font Colour', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_font_colour',
				'type' 		=> 'color',
				'default'	=> '#000000',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Input Field Borders', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_input_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#CCCCCC', 'corner' => 'square' , 'rounded_value' => 0 ),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Default Form SEND Button Style', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'class'		=> 'wc_ei_default_form_container',
                'id'		=> 'wc_ei_form_button_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Send Button Text', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( "Leave empty and button will show SEND", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_text_button',
				'type' 		=> 'text',
				'default'	=> __( 'SEND', 'woocommerce-email-inquiry-cart-options' ),
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Button Font', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' ),
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Background Colour', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Background Colour Gradient From', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#FBCACA',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Background Colour Gradient To', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'Default', 'woocommerce-email-inquiry-cart-options' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B',
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( 'Button Border', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#EE2B2B', 'corner' => 'rounded' , 'rounded_value' => 3 ),
				'free_version'		=> true,
			),
			array(
				'name' => __( 'Button Shadow', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'inquiry_contact_button_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' ),
				'free_version'		=> true,
			),

        );
	}

}

global $wc_ei_popup_form_style_settings;
$wc_ei_popup_form_style_settings = new WC_EI_Popup_Form_Style_Settings();

?>