<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_EI_Global_Settings extends WC_Email_Inquiry_Admin_UI
{

	/**
	 * @var string
	 */
	private $parent_tab = 'email-inquiry';

	/**
	 * @var array
	 */
	private $subtab_data;

	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_global_settings';

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_global_settings';

	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;

	/**
	 * @var array
	 */
	public $form_fields = array();

	/**
	 * @var array
	 */
	public $form_messages = array();

	public function custom_types() {
		$custom_type = array( 'hide_inquiry_button_yellow_message' );

		return $custom_type;
	}

	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		// add custom type
		foreach ( $this->custom_types() as $custom_type ) {
			add_action( $this->plugin_name . '_admin_field_' . $custom_type, array( $this, $custom_type ) );
		}

		add_action( 'plugins_loaded', array( $this, 'init_form_fields' ), 1 );
		$this->subtab_init();

		$this->form_messages = array(
				'success_message'	=> __( 'Email Inquiry Settings successfully saved.', 'woocommerce-email-inquiry-cart-options' ),
				'error_message'		=> __( 'Error: Email Inquiry Settings can not save.', 'woocommerce-email-inquiry-cart-options' ),
				'reset_message'		=> __( 'Email Inquiry Settings successfully reseted.', 'woocommerce-email-inquiry-cart-options' ),
			);

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );

		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );

		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {

		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );

	}

	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_ei_admin_interface;

		$wc_ei_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}

	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_ei_admin_interface;
		
		$wc_ei_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}

	/*-----------------------------------------------------------------------------------*/
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {

	}

	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_ei_admin_interface;

		$wc_ei_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}

	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array (
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {

		$subtab_data = array(
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'woocommerce-email-inquiry-cart-options' ),
			'callback_function'	=> 'wc_ei_global_settings_form',
		);

		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;

	}

	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {

		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();

		return $subtabs_array;
	}

	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_ei_admin_interface;

		$output = '';
		$output .= $wc_ei_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );

		return $output;
	}

	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();

  		// Define settings
     	$this->form_fields = array(

			array(
            	'name' 		=> __( "'Email Inquiry' Rules and Roles", 'woocommerce-email-inquiry-cart-options' ),
            	'desc'		=> sprintf( __( 'Globally set Email Inquiry feature for all Products for not logged in users and users when they log in. Option to independently set these options for each products edit page is available by upgrading to the Premium <a href="%s" target="_blank">WooCommerce Email Inquiry Ultimate</a> plugin.', 'woocommerce-email-inquiry-cart-options' ), $this->ultimate_plugin_page_url ),
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_show_email_inquiry_button_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( "View before log in", 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'show_email_inquiry_button_before_login',
				'desc'		=> __( "ON and users will see Email Inquiry on Products Pages before they login.", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'show_button',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'free_version'		=> true,
			),
			array(
				'name' 		=> __( "View after login", 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'show_email_inquiry_button_after_login',
				'desc'		=> __( "Select user roles that will see Email Inquiry when they log in.", 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> 'show_button_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'free_version'		=> true,
			),
			array(
				'class'		=> 'show_email_inquiry_button_after_login_container',
                'type' 		=> 'heading',
           	),
			array(
				'desc' 		=> '',
				'id' 		=> 'role_apply_show_inquiry_button',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'woocommerce-email-inquiry-cart-options' ),
				'css'		=> 'width:600px; min-height:80px;',
				'options'	=> $roles,
				'free_version'		=> true,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_inquiry_button_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_inquiry_button_yellow_message',
           	),

			array(
				'name'		=> __( 'Product Cards', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_product_cards_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Email Inquiry Feature', 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( "ON to show Email Inquiry feature on your Product Cards on Shop, category and tags pages.", 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'inquiry_single_only',
				'id' 		=> 'inquiry_single_only',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'no',
				'unchecked_value'	=> 'yes',
				'checked_label' 	=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label'	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
				'free_version'		=> true,
			),
        );

		include_once( $this->admin_plugin_dir() . '/settings/email-inquiry/contact-form-global-settings.php' );
		global $wc_ei_contact_form_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_ei_contact_form_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/email-inquiry/popup-form-style-settings.php' );
		global $wc_ei_popup_form_style_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_ei_popup_form_style_settings->form_fields );


		include_once( $this->admin_plugin_dir() . '/settings/email-inquiry/success-message-settings.php' );
		global $wc_ei_success_message_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_ei_success_message_settings->form_fields );

		$this->form_fields = apply_filters( $this->option_name . '_settings_fields', $this->form_fields );
	}

	public function hide_inquiry_button_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_inquiry_button_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <?php
				$hide_inquiry_button_blue_message = '<div><strong>'.__( 'Tip', 'woocommerce-email-inquiry-cart-options' ).':</strong> '.__( "If a product does not have a price set (even 0) it is a function of WooCommmerce that the add to cart function is removed from the product. The Email Inquiry button hooks to that function and if it is not present the button cannot show. Also if a bespoke theme has removed the WooCommerce add to cart template and replaced it with a custom template the button cannot show on any products.", 'woocommerce-email-inquiry-cart-options' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_inquiry_button_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <a class="hide_inquiry_button_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_inquiry_button_blue_message, '600px' );
			?>
<style>
.a3rev_panel_container .hide_inquiry_button_yellow_message_container {
<?php if ( $customized_settings['show_button'] == 'no' && $customized_settings['show_button_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_inquiry_button_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { @session_start(); } if ( isset( $_SESSION['wc_ei_hide_inquiry_button_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_inquiry_button_yellow_message_container").slideDown();
		} else if( $("input.show_email_inquiry_button_before_login").prop( "checked" ) == false ) {
			$(".hide_inquiry_button_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_inquiry_button_yellow_message_container").slideDown();
		} else if( $("input.show_email_inquiry_button_after_login").prop( "checked" ) == false ) {
			$(".hide_inquiry_button_yellow_message_container").slideUp();
		}
	});

	$(document).on( "click", ".hide_inquiry_button_yellow_message_dontshow", function(){
		$(".hide_inquiry_button_yellow_message_tr").slideUp();
		$(".hide_inquiry_button_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_inquiry_button_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});

	$(document).on( "click", ".hide_inquiry_button_yellow_message_dismiss", function(){
		$(".hide_inquiry_button_yellow_message_tr").slideUp();
		$(".hide_inquiry_button_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_inquiry_button_message_dismiss",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dismiss"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
});
})(jQuery);
</script>
			</td>
		</tr>
    <?php

	}

	public function include_script() {
	?>
<style>
.yellow_message_container {
	margin-top: -15px;
}
.yellow_message_container a {
	text-decoration:none;
}
.yellow_message_container th, .yellow_message_container td, .show_email_inquiry_button_after_login_container th, .show_email_inquiry_button_after_login_container td {
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}
</style>
<script>
(function($) {

	$(document).ready(function() {

		if ( $("input.show_email_inquiry_button_after_login:checked").val() != 'yes') {
			$('.show_email_inquiry_button_after_login_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		if ( $("input.show_phone:checked").val() != 'yes') {
			$(".show_phone_yes_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		if ( $("input.acceptance:checked").val() != 'yes') {
			$(".show_acceptance_yes").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.rules_roles_explanation', function( event, value, status ) {
			if ( status == 'true' ) {
				$(".rules_roles_explanation_container").slideDown();
			} else {
				$(".rules_roles_explanation_container").slideUp();
			}
		});

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_after_login', function( event, value, status ) {
			$('.show_email_inquiry_button_after_login_container').attr('style','display:none;');
			if ( status == 'true' ) {
				$(".show_email_inquiry_button_after_login_container").slideDown();
			} else {
				$(".show_email_inquiry_button_after_login_container").slideUp();
			}
		});

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_phone', function( event, value, status ) {
			$(".show_phone_yes_container").attr('style','display:none;');
			if ( value == 'yes' && status == 'true' ) {
				$(".show_phone_yes_container").slideDown();
			}
		});

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.acceptance', function( event, value, status ) {
			$(".show_acceptance_yes").attr('style','display:none;');
			if ( value == 'yes' && status == 'true' ) {
				$(".show_acceptance_yes").slideDown();
			}
		});

	});

})(jQuery);
</script>
    <?php
	}
}

global $wc_ei_global_settings;
$wc_ei_global_settings = new WC_EI_Global_Settings();

/**
 * wc_ei_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_global_settings_form() {
	global $wc_ei_global_settings;
	$wc_ei_global_settings->settings_form();
}

?>
