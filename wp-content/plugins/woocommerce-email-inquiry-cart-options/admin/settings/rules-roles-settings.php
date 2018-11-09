<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Cart & Price Settings

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

class WC_EI_Rules_Roles_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'rules-roles';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_rules_roles_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_rules_roles_settings';
	
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
		$custom_type = array( 'hide_addtocart_yellow_message', 'hide_price_yellow_message' );
		
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
		//$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Cart & Price Settings successfully saved.', 'woocommerce-email-inquiry-cart-options' ),
				'error_message'		=> __( 'Error: Cart & Price Settings can not save.', 'woocommerce-email-inquiry-cart-options' ),
				'reset_message'		=> __( 'Cart & Price Settings successfully reseted.', 'woocommerce-email-inquiry-cart-options' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . trim( $this->form_key ) . '_settings_init', array( $this, 'after_settings_save' ) );
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
	/* after_settings_save()
	/* Process after settings is saved */
	/*-----------------------------------------------------------------------------------*/
	public function after_settings_save() {
		if ( get_option( $this->plugin_name . '_clean_on_deletion' ) == 0  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[ $this->plugin_path ]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
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
			'name'				=> 'rules-roles',
			'label'				=> __( 'Settings', 'woocommerce-email-inquiry-cart-options' ),
			'callback_function'	=> 'wc_ei_rules_roles_settings_form',
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
		unset( $roles['manual_quote'] );
		unset( $roles['auto_quote'] );
		$roles_hide_price = $roles_hide_cart = $roles;

		$roles_hide_cart  = apply_filters( 'wc_ei_roles_hide_cart', $roles_hide_cart, 0 );
		$roles_hide_price = apply_filters( 'wc_ei_roles_hide_price', $roles_hide_price, 0 );
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
            	'name' 		=> __( 'Plugin Framework Global Settings', 'woocommerce-email-inquiry-cart-options' ),
            	'id'		=> 'plugin_framework_global_box',
                'type' 		=> 'heading',
                'first_open'=> true,
                'is_box'	=> true,
           	),
           	array(
           		'name'		=> __( 'Customize Admin Setting Box Display', 'woocommerce-email-inquiry-cart-options' ),
           		'desc'		=> __( 'By default each admin panel will open with all Setting Boxes in the CLOSED position.', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
           	array(
				'type' 		=> 'onoff_toggle_box',
			),
           	array(
           		'name'		=> __( 'Google Fonts', 'woocommerce-email-inquiry-cart-options' ),
           		'desc'		=> __( 'By Default Google Fonts are pulled from a static JSON file in this plugin. This file is updated but does not have the latest font releases from Google.', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
           	),
           	array(
                'type' 		=> 'google_api_key',
           	),
           	array(
            	'name' 		=> __( 'House Keeping', 'woocommerce-email-inquiry-cart-options' ),
                'type' 		=> 'heading',
            ),
			array(
				'name' 		=> __( 'Clean up on Deletion', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> __( 'On deletion (not deactivate) the plugin will completely remove all tables and data it created, leaving no trace it was ever here.', 'woocommerce-email-inquiry-cart-options' ),
				'id' 		=> $this->plugin_name . '_clean_on_deletion',
				'type' 		=> 'onoff_checkbox',
				'default'	=> '0',
				'separate_option'	=> true,
				'free_version'		=> true,
				'checked_value'		=> '1',
				'unchecked_value'	=> '0',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
			),

			array(
            	'name' 		=> __( "Hide 'Add to Cart ' Rules and Roles", 'woocommerce-email-inquiry-cart-options' ),
            	'desc'		=> sprintf( __( 'This Rule hides the add to cart button on all products. Hide or show add to cart can be set independently of these global settings from each product edit page with the Premium <a href="%s" target="_blank">WooCommerce Email Inquiry Ultimate</a> upgrade.', 'woocommerce-email-inquiry-cart-options' ), $this->ultimate_plugin_page_url ),
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_hide_add_to_cart_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "View before log in", 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'ON and your stores add to cart button will be hidden from all users before they log in.', 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'hide_addcartbt_before_login',
				'id' 		=> 'hide_addcartbt',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
			),
			array(  
				'name' 		=> __( "View after login", 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'Select user roles that you do not want to see add to cart when they log in.', 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'hide_addcartbt_after_login',
				'id' 		=> 'hide_addcartbt_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
			),
			array(
				'class'		=> 'hide_addcartbt_after_login_container',
                'type' 		=> 'heading',
           	),
			array(  
				'class' 	=> 'chzn-select role_apply_hide_cart',
				'id' 		=> 'role_apply_hide_cart',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'woocommerce-email-inquiry-cart-options' ),
				'css'		=> 'width:600px; min-height:80px;',
				'options'	=> $roles_hide_cart,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_addtocart_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_addtocart_yellow_message',
           	),
			
			array(
				'name' 		=> __( "Hide 'Product Price' Rules and Roles", 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> sprintf( __( 'This Rule hides product prices on all products. Hide or show price can be set independently of these global settings from each product edit page with the Premium <a href="%s" target="_blank">WooCommerce Email Inquiry Ultimate</a> upgrade.', 'woocommerce-email-inquiry-cart-options' ), $this->ultimate_plugin_page_url ),
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_hide_price_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "View before log in", 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'ON all product prices will be hidden from all users before they log in.', 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'email_inquiry_hide_price_before_login',
				'id' 		=> 'hide_price',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
			),
			array(  
				'name' 		=> __( "View after login", 'woocommerce-email-inquiry-cart-options' ),
				'desc'		=> __( 'Select user roles that you do not want to product prices when they log in.', 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'email_inquiry_hide_price_after_login',
				'id' 		=> 'hide_price_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-email-inquiry-cart-options' ),
			),
			array(
				'class'		=> 'email_inquiry_hide_price_after_login_container',
                'type' 		=> 'heading',
           	),
			array(  
				'class' 	=> 'chzn-select role_apply_hide_price',
				'id' 		=> 'role_apply_hide_price',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'woocommerce-email-inquiry-cart-options' ),
				'css'		=> 'width:600px; min-height:80px;',
				'options'	=> $roles_hide_price,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_price_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_price_yellow_message',
           	),

			array(
            	'name' 		=> __( 'Help Notes', 'woocommerce-email-inquiry-cart-options' ),
            	'class'		=> 'help_notes_container',
                'type' 		=> 'heading',
                'id'		=> 'wc_ei_help_notes_box',
                'is_box'	=> true,
            ),
			array(
				'name' 		=> __( "Rules & Roles Help Notes", 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'rules_roles_explanation',
				'id' 		=> 'rules_roles_explanation',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'hide',
				'checked_value'		=> 'show',
				'unchecked_value' 	=> 'hide',
				'checked_label'		=> __( 'SHOW', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'HIDE', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> '</span></td></tr><tr><td colspan="2"><div class="rules_roles_explanation_container">
<div>' . sprintf( __( 'Product Page Rules apply a single action Rule to all product pages which can be filtered on a per User Role basis. Rules can also be varied on a product by product basis from each product edit page by upgrading to the Premium <a href="%s" target="_blank">WooCommerce Email Inquiry Ultimate</a> plugin', 'woocommerce-email-inquiry-cart-options' ), $this->ultimate_plugin_page_url ) . '</div>
<ul style="padding-left: 40px;">
	<li>* ' . __( "Set Rules that apply to Product Pages or your entire store.", 'woocommerce-email-inquiry-cart-options' ) . '</li>
	<li>* ' . __( "The Rules are applied to users who are NOT Logged in and Rules for when they login in.", 'woocommerce-email-inquiry-cart-options' ) . '</li>
	<li>* ' . __( "Different Rules can be applied to logged in users based upon their user Role e.g. what users with the Customer Role see verses what users with the Subscriber role see.", 'woocommerce-email-inquiry-cart-options' ) . '</li>
</ul>
<div style="margin-bottom: 20px;">' . __( "<strong>Important!</strong> When an admin sets a Rule for NOT logged in users if they then check the front end to see the new Rule they will not see it, because they are logged in as administrator and have not applied that Rule to their role (this catches a lot of first time users who think the plugin is not working because they can't see the rule applied while they are logged in but can when they log out).", 'woocommerce-email-inquiry-cart-options' ) . '</div>
				</div><span>',
			),
			array(
				'name' 		=> __( "Troubleshooting", 'woocommerce-email-inquiry-cart-options' ),
				'class'		=> 'troubleshooting_explanation',
				'id' 		=> 'troubleshooting_explanation',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'hide',
				'checked_value'		=> 'show',
				'unchecked_value' 	=> 'hide',
				'checked_label'		=> __( 'SHOW', 'woocommerce-email-inquiry-cart-options' ),
				'unchecked_label' 	=> __( 'HIDE', 'woocommerce-email-inquiry-cart-options' ),
				'desc' 		=> '</span></td></tr><tr><td colspan="2"><div class="troubleshooting_explanation_container">
<div>' . __( "Below is a list of common issues we see", 'woocommerce-email-inquiry-cart-options' ) . '</div>
<div style="margin-top: 20px;">' . __( "<strong>Don't See Rules Applied on front end.</strong>", 'woocommerce-email-inquiry-cart-options' ) . '
<ul style="padding-left: 40px;">
	<li>* ' . __( "This is because you have not applied the Rule to your logged in user role (administrator). Either apply your role to the rule or check it in another browser where you are not logged in.", 'woocommerce-email-inquiry-cart-options' ) . '</li>
</ul>
</div>
				</div><span>',
			),

        ));
	}
	
	public function hide_addtocart_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_addtocart_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <?php 
				$hide_addtocart_blue_message = '<div><strong>'.__( 'Note', 'woocommerce-email-inquiry-cart-options' ).':</strong> '.__( "If you do not apply Rules to your role i.e. 'administrator' you will need to either log out or open the site in another browser where you are not logged in to see the Rule feature is activated.", 'woocommerce-email-inquiry-cart-options' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_addtocart_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <a class="hide_addtocart_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_addtocart_blue_message, '600px' ); 
			?>
<style>
.a3rev_panel_container .hide_addtocart_yellow_message_container {
<?php if ( $customized_settings['hide_addcartbt'] == 'no' && $customized_settings['hide_addcartbt_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_addtocart_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { @session_start(); } if ( isset( $_SESSION['wc_ei_hide_addtocart_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_addtocart_yellow_message_container").slideDown();
		} else if( $("input.hide_addcartbt_before_login").prop( "checked" ) == false ) {
			$(".hide_addtocart_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_addtocart_yellow_message_container").slideDown();
		} else if( $("input.hide_addcartbt_after_login").prop( "checked" ) == false ) {
			$(".hide_addtocart_yellow_message_container").slideUp();
		}
	});
	
	$(document).on( "click", ".hide_addtocart_yellow_message_dontshow", function(){
		$(".hide_addtocart_yellow_message_tr").slideUp();
		$(".hide_addtocart_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_addtocart_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".hide_addtocart_yellow_message_dismiss", function(){
		$(".hide_addtocart_yellow_message_tr").slideUp();
		$(".hide_addtocart_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_addtocart_message_dismiss",
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
		
	public function hide_price_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_price_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <?php 
				$hide_inquiry_button_blue_message = '<div><strong>'.__( 'Note', 'woocommerce-email-inquiry-cart-options' ).':</strong> '.__( "If you do not apply Rules to your role i.e. 'administrator' you will need to either log out or open the site in another browser where you are not logged in to see the Rule feature is activated.", 'woocommerce-email-inquiry-cart-options' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_price_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <a class="hide_price_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_inquiry_button_blue_message, '600px' ); 
			?>
<style>
.a3rev_panel_container .hide_price_yellow_message_container {
<?php if ( $customized_settings['hide_price'] == 'no' && $customized_settings['hide_price_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_price_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { @session_start(); } if ( isset( $_SESSION['wc_ei_hide_price_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_price_yellow_message_container").slideDown();
		} else if( $("input.email_inquiry_hide_price_before_login").prop( "checked" ) == false ) {
			$(".hide_price_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_price_yellow_message_container").slideDown();
		} else if( $("input.email_inquiry_hide_price_after_login").prop( "checked" ) == false ) {
			$(".hide_price_yellow_message_container").slideUp();
		}
	});
	
	$(document).on( "click", ".hide_price_yellow_message_dontshow", function(){
		$(".hide_price_yellow_message_tr").slideUp();
		$(".hide_price_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_price_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".hide_price_yellow_message_dismiss", function(){
		$(".hide_price_yellow_message_tr").slideUp();
		$(".hide_price_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_price_message_dismiss",
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
	
	public function manual_quote_yellow_message( $value ) {
	?>
    	<tr valign="top" class="manual_quote_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <?php 
				$manual_quote_blue_message = '<div><strong>'.__( 'Tip', 'woocommerce-email-inquiry-cart-options' ).':</strong> '.__( "When you assign the Administrator Role to Manual Quotes and create a test Manual Quote Request you will get 2 Quote Request Received emails - the site admins copy and the customers copy", 'woocommerce-email-inquiry-cart-options' ).'. <strong>'.__( 'Note', 'woocommerce-email-inquiry-cart-options' ).':</strong> '.__( "The admin email shows the order sub total amount. This is not a bug. Check the customers copy and you will see it shows no prices for each product and no sub total amount.", 'woocommerce-email-inquiry-cart-options' ).'</div>
				<div style="clear:both"></div>
                <a class="manual_quote_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <a class="manual_quote_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $manual_quote_blue_message, '600px' ); 
			?>
<style>
.a3rev_panel_container .manual_quote_yellow_message_container {
<?php if ( get_option( 'wc_ei_manual_quote_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { @session_start(); } if ( isset( $_SESSION['wc_ei_manual_quote_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	
	$(document).on( "click", ".manual_quote_yellow_message_dontshow", function(){
		$(".manual_quote_yellow_message_tr").slideUp();
		$(".manual_quote_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_manual_quote_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".manual_quote_yellow_message_dismiss", function(){
		$(".manual_quote_yellow_message_tr").slideUp();
		$(".manual_quote_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_manual_quote_message_dismiss",
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
	
	public function use_woocommerce_css_yellow_message( $value ) {
	?>
    	<tr valign="top" class="use_woocommerce_css_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <?php 
				$use_woocommerce_css_yellow_message = '<div><div><strong>'.__( 'Tip', 'woocommerce-email-inquiry-cart-options' ).':</strong></div><div>'.__( "This only applies if you are using a Bespoke theme and the Theme developer has removed the woocommerce.css and replaced it with a custom template that uses a different HTML structure. This is very bad practise but there are plenty of Bespoke Theme developers who do it. You will know if you have such a theme because in Quotes or Orders mode on the Cart page, Checkout page and Order received pages layout and style will be broken.", 'woocommerce-email-inquiry-cart-options' ).'</div><div>'.__( "If you have this issue and after activating this feature you still have issues with the WooCommerce page layouts and style it will be because the custom HTML structure of the theme is over riding the woocommerce.css. If using WooCommerce Quotes and Orders is important to your stores functionality you should do one of 2 things.", 'woocommerce-email-inquiry-cart-options' ).'</div><div>'.__( "1. Contact the theme developer and ask them to fix their code.", 'woocommerce-email-inquiry-cart-options' ).'</div><div>'.__( "2. Ask for a refund and choose a theme that is 100% WooCommerce Compatible (It is not hard the Default WordPress themes are all 100% compatible).", 'woocommerce-email-inquiry-cart-options' ).'</div></div>
				<div style="clear:both"></div>
                <a class="use_woocommerce_css_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <a class="use_woocommerce_css_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'woocommerce-email-inquiry-cart-options' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $use_woocommerce_css_yellow_message, '600px' ); 
			?>
<style>
.a3rev_panel_container .use_woocommerce_css_yellow_message_container {
<?php if ( get_option( 'wc_ei_use_woocommerce_css_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { @session_start(); } if ( isset( $_SESSION['wc_ei_use_woocommerce_css_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	
	$(document).on( "click", ".use_woocommerce_css_yellow_message_dontshow", function(){
		$(".use_woocommerce_css_yellow_message_tr").slideUp();
		$(".use_woocommerce_css_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_use_woocommerce_css_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".use_woocommerce_css_yellow_message_dismiss", function(){
		$(".use_woocommerce_css_yellow_message_tr").slideUp();
		$(".use_woocommerce_css_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_use_woocommerce_css_message_dismiss",
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
.help_notes_container table th {
	padding-top:12px;
	padding-bottom:12px;
}
.help_notes_container table td {
	padding-top:8px;
	padding-bottom:8px;
}
.yellow_message_container {
	margin-top: -15px;	
}
.yellow_message_container a {
	text-decoration:none;	
}
.yellow_message_container th, .yellow_message_container td, .hide_addcartbt_after_login_container th, .hide_addcartbt_after_login_container td,  .email_inquiry_hide_price_after_login_container th, .email_inquiry_hide_price_after_login_container td, .role_apply_activate_order_logged_in_container th, .role_apply_activate_order_logged_in_container td {
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}
</style>
<script>
(function($) {
	
	a3revEIRulesRoles = {
		
		initRulesRoles: function () {
			// Disabled Manual Quote role for Manual Quote rule to admin can't remove this role for Manual Quote rule
			$("select.role_apply_manual_quote option:first").attr('disabled', 'disabled');
			
			// Disabled Auto Quote role for Auto Quote rule to admin can't remove this role for Auto Quote rule
			$("select.role_apply_auto_quote option:first").attr('disabled', 'disabled');
			
			if ( $("input.rules_roles_explanation").is(':checked') == false ) {
				$(".rules_roles_explanation_container").hide();
			}

			if ( $("input.troubleshooting_explanation").is(':checked') == false ) {
				$(".troubleshooting_explanation_container").hide();
			}

			if ( $("input.quotes_orders_upgrade").is(':checked') == false ) {
				$(".quotes_orders_upgrade_container").hide();
			}

			/*
			 * Condition logic for activate apply rule to logged in users
			 * Show Roles dropdown for : Hide Add to Cart, Show Email Inquiry Button, Hide Price, Add to Order rules
			 * Apply when page is loaded
			 */
			if ( $("input.hide_addcartbt_after_login:checked").val() == 'yes' ) {
				$('.hide_addcartbt_after_login_container').css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			} else {
				$('.hide_addcartbt_after_login_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
			}
			if ( $("input.email_inquiry_hide_price_after_login:checked").val() == 'yes') {
				$('.email_inquiry_hide_price_after_login_container').css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			} else {
				$('.email_inquiry_hide_price_after_login_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
			}
			
		},
		
		conditionLogicEvent: function () {
			
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.rules_roles_explanation', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".rules_roles_explanation_container").slideDown();
				} else {
					$(".rules_roles_explanation_container").slideUp();
				}
			});

			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.troubleshooting_explanation', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".troubleshooting_explanation_container").slideDown();
				} else {
					$(".troubleshooting_explanation_container").slideUp();
				}
			});

			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.quotes_orders_upgrade', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".quotes_orders_upgrade_container").slideDown();
				} else {
					$(".quotes_orders_upgrade_container").slideUp();
				}
			});

			
			/* 
			 * Condition logic for activate apply rule to logged in users
			 * Show Roles dropdown for : Hide Add to Cart, Show Email Inquiry Button, Hide Price, Add to Order rules
			 */
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_after_login', function( event, value, status ) {
				$('.hide_addcartbt_after_login_container').hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
				if ( status == 'true' ) {
					$(".hide_addcartbt_after_login_container").slideDown();
				} else {
					$(".hide_addcartbt_after_login_container").slideUp();
				}
			});
			
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_after_login', function( event, value, status ) {
				$('.email_inquiry_hide_price_after_login_container').hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
				if ( status == 'true' ) {
					$(".email_inquiry_hide_price_after_login_container").slideDown();
				} else {
					$(".email_inquiry_hide_price_after_login_container").slideUp();
				}
			});
		}
	}
	
	$(document).ready(function() {
		
		a3revEIRulesRoles.initRulesRoles();
		a3revEIRulesRoles.conditionLogicEvent();
	});
	
})(jQuery);
</script>
    <?php	
	}
}

global $wc_ei_rules_roles_settings;
$wc_ei_rules_roles_settings = new WC_EI_Rules_Roles_Settings();

/** 
 * wc_ei_rules_roles_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_rules_roles_settings_form() {
	global $wc_ei_rules_roles_settings;
	$wc_ei_rules_roles_settings->settings_form();
}

?>
