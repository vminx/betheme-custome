<?php
/**
 * WC Email Inquiry Functions
 *
 * Table Of Contents
 *
 * check_hide_add_cart_button()
 * check_add_email_inquiry_button()
 * check_add_email_inquiry_button_on_shoppage()
 * reset_products_to_global_settings()
 * email_inquiry()
 * get_from_address()
 * get_from_name()
 * get_content_type()
 * plugin_extension()
 * wc_ei_yellow_message_dontshow()
 * wc_ei_yellow_message_dismiss()
 */
class WC_Email_Inquiry_Functions 
{	
	
	/** 
	 * Set global variable when plugin loaded
	 */
	
	public static function check_hide_add_cart_button ($product_id) {

		$force_value = apply_filters( 'wc_ei_force_value_hide_add_cart_button', null, $product_id );
		if ( null !== $force_value ) {
			return $force_value;
		}

		global $wc_email_inquiry_rules_roles_settings;
			
		$wc_email_inquiry_hide_addcartbt = $wc_email_inquiry_rules_roles_settings['hide_addcartbt'] ;
		
		// dont hide add to cart button if setting is not checked and not logged in users
		if ($wc_email_inquiry_hide_addcartbt == 'no' && !is_user_logged_in() ) return false;
		
		// hide add to cart button if setting is checked and not logged in users
		if ($wc_email_inquiry_hide_addcartbt != 'no' &&  !is_user_logged_in()) return true;
		
		$wc_email_inquiry_hide_addcartbt_after_login = $wc_email_inquiry_rules_roles_settings['hide_addcartbt_after_login'] ;

		// don't hide add to cart if for logged in users is deacticated
		if ( $wc_email_inquiry_hide_addcartbt_after_login != 'yes' ) return false;
		
		$role_apply_hide_cart = (array) $wc_email_inquiry_rules_roles_settings['role_apply_hide_cart'];
		
		$user_login = wp_get_current_user();
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$role_existed = array_intersect( $user_login->roles, $role_apply_hide_cart );
			
			// hide add to cart button if current user role in list apply role
			if ( is_array( $role_existed ) && count( $role_existed ) > 0 ) return true;
		}
		return false;
		
	}
	
	public static function check_hide_price ($product_id) {

		$force_value = apply_filters( 'wc_ei_force_value_hide_price', null, $product_id );
		if ( null !== $force_value ) {
			return $force_value;
		}

		global $wc_email_inquiry_rules_roles_settings;
			
		$wc_email_inquiry_hide_price = $wc_email_inquiry_rules_roles_settings['hide_price'];
		
		// dont hide price if setting is not checked and not logged in users
		if ($wc_email_inquiry_hide_price == 'no' && !is_user_logged_in() ) return false;
		
		// alway hide price if setting is checked and not logged in users
		if ($wc_email_inquiry_hide_price != 'no' && !is_user_logged_in()) return true;
		
		$wc_email_inquiry_hide_price_after_login = $wc_email_inquiry_rules_roles_settings['hide_price_after_login'] ;

		// don't hide price if for logged in users is deacticated
		if ( $wc_email_inquiry_hide_price_after_login != 'yes' ) return false;
		
		$role_apply_hide_price = (array) $wc_email_inquiry_rules_roles_settings['role_apply_hide_price'];
		
		$user_login = wp_get_current_user();		
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$role_existed = array_intersect( $user_login->roles, $role_apply_hide_price );
			
			// hide price if current user role in list apply role
			if ( is_array( $role_existed ) && count( $role_existed ) > 0 ) return true;
		}
		
		return false;
	}
	
	public static function check_add_email_inquiry_button ($product_id) {
		global $wc_email_inquiry_global_settings;
			
		$wc_email_inquiry_show_button = $wc_email_inquiry_global_settings['show_button'];
		
		// dont show email inquiry button if setting is not checked and not logged in users
		if ($wc_email_inquiry_show_button == 'no' && !is_user_logged_in() ) return false;
		
		// alway show email inquiry button if setting is checked and not logged in users
		if ($wc_email_inquiry_show_button != 'no' && !is_user_logged_in()) return true;
		
		$wc_email_inquiry_show_button_after_login = $wc_email_inquiry_global_settings['show_button_after_login'] ;

		// don't show email inquiry button if for logged in users is deacticated
		if ( $wc_email_inquiry_show_button_after_login != 'yes' ) return false;
		
		$role_apply_show_inquiry_button = (array) $wc_email_inquiry_global_settings['role_apply_show_inquiry_button'];		
		
		$user_login = wp_get_current_user();		
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$role_existed = array_intersect( $user_login->roles, $role_apply_show_inquiry_button );
			
			// show email inquiry button if current user role in list apply role
			if ( is_array( $role_existed ) && count( $role_existed ) > 0 ) return true;
		}
		
		return false;
		
	}
	
	public static function check_add_email_inquiry_button_on_shoppage ($product_id=0) {
		global $wc_email_inquiry_global_settings;
			
		$wc_email_inquiry_single_only = $wc_email_inquiry_global_settings['inquiry_single_only'];
		
		if ($wc_email_inquiry_single_only == 'yes') return false;
		
		return WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id);
		
	}

	public static function enqueue_modal_scripts() {

		wp_register_script( 'wc-ei-modal-popup', WC_EMAIL_INQUIRY_JS_URL . '/modal-popup.js', array( 'jquery' ), WC_EMAIL_INQUIRY_VERSION, true );

		wp_localize_script( 'wc-ei-modal-popup',
			'wc_ei_vars',
			apply_filters( 'wc_ei_vars', array(
				'ajax_url'       => admin_url( 'admin-ajax.php', 'relative' ),
				'security_nonce' => wp_create_nonce( 'wc-ei-event' )
			) )
		);

		if ( ! wp_script_is( 'bootstrap-modal', 'registered' ) 
			&& ! wp_script_is( 'bootstrap-modal', 'enqueued' ) ) {
			global $wc_ei_admin_interface;
			$wc_ei_admin_interface->register_modal_scripts();
		}

		wp_enqueue_style( 'bootstrap-modal' );

		// Don't include modal script if bootstrap is loaded by theme or plugins
		if ( wp_script_is( 'bootstrap', 'registered' ) 
			|| wp_script_is( 'bootstrap', 'enqueued' ) ) {
			
			wp_enqueue_script( 'bootstrap' );
			wp_enqueue_script( 'wc-ei-modal-popup' );
			
			return;
		}

		if ( wp_script_is( 'wpsm_tabs_r_bootstrap-js-front', 'enqueued' ) || wp_script_is( 'wpsm_ac_bootstrap-js-front', 'enqueued' ) ) {

			wp_enqueue_script( 'wc-ei-modal-popup' );
			return;
		}

		wp_enqueue_script( 'bootstrap-modal' );
		wp_enqueue_script( 'wc-ei-modal-popup' );
	}


	public static function enqueue_default_form_scripts() {

		if ( wp_script_is( 'wc-ei-default-form', 'enqueued' ) ) {
			return;
		}

		wp_enqueue_script( 'wc-ei-default-form', WC_EMAIL_INQUIRY_JS_URL . '/default-form.js', array( 'jquery' ), WC_EMAIL_INQUIRY_VERSION, true );

		wp_localize_script( 'wc-ei-default-form',
			'wc_ei_default_vars',
			apply_filters( 'wc_ei_default_vars', array(
				'ajax_url'          => admin_url( 'admin-ajax.php', 'relative' ),
				'email_valid_error' => __( 'Please enter valid Email address', 'woocommerce-email-inquiry-cart-options' ),
				'required_error'    => __( 'is required', 'woocommerce-email-inquiry-cart-options' ),
				'agree_terms_error' => __( 'You need to agree to the website terms and conditions if want to submit this inquiry', 'woocommerce-email-inquiry-cart-options' ),
				'security_nonce'    => wp_create_nonce( 'wc-ei-default-form' )
			) )
		);
	}

	public static function reset_products_to_global_settings() {
		global $wpdb;
		$wpdb->query( "DELETE FROM ".$wpdb->postmeta." WHERE meta_key='_wc_email_inquiry_settings_custom' " );
	}
	
	public static function email_inquiry( $product_id, $your_name, $your_email, $your_phone, $your_message, $send_copy_yourself = 1 ) {
		global $wc_email_inquiry_contact_form_settings;
		$wc_email_inquiry_contact_success = stripslashes( get_option( 'wc_email_inquiry_contact_success', '' ) );
		
		if ( WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			
			if ( trim( $wc_email_inquiry_contact_success ) != '') $wc_email_inquiry_contact_success = wpautop(wptexturize( $wc_email_inquiry_contact_success ));
			else $wc_email_inquiry_contact_success = __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", 'woocommerce-email-inquiry-cart-options' );
		
			$to_email = $wc_email_inquiry_contact_form_settings['inquiry_email_to'];
			if (trim($to_email) == '') $to_email = get_option('admin_email');
			
			if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'] == '' )
				$from_email = get_option('admin_email');
			else
				$from_email = $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'];
				
			if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'] == '' )
				$from_name = get_option('blogname');
			else
				$from_name = $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'];
			
			$cc_emails = $wc_email_inquiry_contact_form_settings['inquiry_email_cc'];
			if (trim($cc_emails) == '') $cc_emails = '';
			
			$headers = array();
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset='. get_option('blog_charset');
			$headers[] = 'From: '.$from_name.' <'.$from_email.'>';
			$headers_yourself = $headers;
			$headers[] = 'Reply-To: '.$your_name.' <'.$your_email.'>';
			$headers_yourself[] = 'Reply-To: '.$from_name.' <'.$from_email.'>';
			
			if (trim($cc_emails) != '') {
				$cc_emails_a = explode("," , $cc_emails);
				if (is_array($cc_emails_a) && count($cc_emails_a) > 0) {
					foreach ($cc_emails_a as $cc_email) {
						$headers[] = 'Cc: '.$cc_email;
					}
				} else {
					$headers[] = 'Cc: '.$cc_emails;
				}
			}
			
			$product_name = html_entity_decode( get_the_title($product_id) );
			$product_url = get_permalink($product_id);
			$subject = __('Email inquiry for', 'woocommerce-email-inquiry-cart-options' ).' '.$product_name;
			$subject_yourself = __('[Copy]: Email inquiry for', 'woocommerce-email-inquiry-cart-options' ).' '.$product_name;
			
			ob_start();
			wc_ei_email_notification_tpl();
			$content = ob_get_clean();
		  
			$content = str_replace('[your_name]', $your_name, $content);
			$content = str_replace('[your_email]', $your_email, $content);
			$content = str_replace('[your_phone]', $your_phone, $content);
			$content = str_replace('[product_name]', $product_name, $content);
			$content = str_replace('[product_url]', $product_url, $content);
			$your_message = str_replace( '://', ':&#173;­//', $your_message );
			$your_message = str_replace( '.com', '&#173;.com', $your_message );
			$your_message = str_replace( '.net', '&#173;.net', $your_message );
			$your_message = str_replace( '.info', '&#173;.info', $your_message );
			$your_message = str_replace( '.org', '&#173;.org', $your_message );
			$your_message = str_replace( '.au', '&#173;.au', $your_message );
			$content = str_replace('[your_message]', wpautop( $your_message ), $content);
			
			$content = apply_filters('wc_email_inquiry_inquiry_content', $content);
			
			// Filters for the email
			add_filter( 'wp_mail_from', array( 'WC_Email_Inquiry_Functions', 'get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( 'WC_Email_Inquiry_Functions', 'get_from_name' ) );
			add_filter( 'wp_mail_content_type', array( 'WC_Email_Inquiry_Functions', 'get_content_type' ) );
			
			wp_mail( $to_email, $subject, $content, $headers, '' );
			
			if ($send_copy_yourself == 1) {
				wp_mail( $your_email, $subject_yourself, $content, $headers_yourself, '' );
			}
			
			// Unhook filters
			remove_filter( 'wp_mail_from', array( 'WC_Email_Inquiry_Functions', 'get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( 'WC_Email_Inquiry_Functions', 'get_from_name' ) );
			remove_filter( 'wp_mail_content_type', array( 'WC_Email_Inquiry_Functions', 'get_content_type' ) );
			
			return $wc_email_inquiry_contact_success;
		} else {
			return false;
		}
	}
	
	public static function get_from_address() {
		global $wc_email_inquiry_contact_form_settings;
		if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'] == '' )
			$from_email = get_option('admin_email');
		else
			$from_email = $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'];
			
		return $from_email;
	}
	
	public static function get_from_name() {
		global $wc_email_inquiry_contact_form_settings;
		if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'] == '' )
			$from_name = get_option('blogname');
		else
			$from_name = $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'];
			
		return $from_name;
	}
	
	public static function get_content_type() {
		return 'text/html';
	}
	
	
	public static function wc_ei_yellow_message_dontshow() {
		check_ajax_referer( 'wc_ei_yellow_message_dontshow', 'security' );
		$option_name   = $_REQUEST['option_name'];
		update_option( $option_name, 1 );
		die();
	}
	
	public static function wc_ei_yellow_message_dismiss() {
		check_ajax_referer( 'wc_ei_yellow_message_dismiss', 'security' );
		$session_name   = $_REQUEST['session_name'];
		if ( !isset($_SESSION) ) { @session_start(); } 
		$_SESSION[$session_name] = 1 ;
		die();
	}
}
?>
