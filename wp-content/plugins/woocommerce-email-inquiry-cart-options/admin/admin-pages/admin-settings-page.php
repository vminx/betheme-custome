<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Admin Email Inquiry Cart Page

TABLE OF CONTENTS

- var menu_slug
- var page_data

- __construct()
- page_init()
- page_data()
- add_admin_menu()
- tabs_include()
- admin_settings_page()

-----------------------------------------------------------------------------------*/

class WC_EI_Settings_Page extends WC_Email_Inquiry_Admin_UI
{	
	/**
	 * @var string
	 */
	private $menu_slug = 'email-cart-options';
	
	/**
	 * @var array
	 */
	private $page_data;
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->page_init();
		$this->tabs_include();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_init() */
	/* Page Init */
	/*-----------------------------------------------------------------------------------*/
	public function page_init() {
		
		add_filter( $this->plugin_name . '_add_admin_menu', array( $this, 'add_admin_menu' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_data() */
	/* Get Page Data */
	/*-----------------------------------------------------------------------------------*/
	public function page_data() {
		
		$page_data = array( 
			'type'				=> 'submenu',
			'parent_slug'		=> 'woocommerce',
			'page_title'		=> __( 'Email & Cart', 'woocommerce-email-inquiry-cart-options' ),
			'menu_title'		=> __( 'Email & Cart', 'woocommerce-email-inquiry-cart-options' ),
			'capability'		=> 'manage_options',
			'menu_slug'			=> $this->menu_slug,
			'function'			=> 'wc_ei_settings_page_show',
			'admin_url'			=> 'admin.php',
			'callback_function' => '',
			'script_function' 	=> '',
			'view_doc'			=> '',
		);

		if ( isset( $_GET['page'] ) &&  in_array( $_GET['page'], array( 'email-cart-options' ) ) ) {
			if ( ! isset( $_SESSION ) ) {
				@session_start();
			}
		}
		
		if ( $this->page_data ) return $this->page_data;
		return $this->page_data = $page_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_admin_menu() */
	/* Add This page to menu on left sidebar */
	/*-----------------------------------------------------------------------------------*/
	public function add_admin_menu( $admin_menu ) {
		
		if ( ! is_array( $admin_menu ) ) $admin_menu = array();
		$admin_menu[] = $this->page_data();
		
		return $admin_menu;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tabs_include() */
	/* Include all tabs into this page
	/*-----------------------------------------------------------------------------------*/
	public function tabs_include() {
		
		include_once( $this->admin_plugin_dir() . '/tabs/rules-roles-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/email-inquiry-tab.php' );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* admin_settings_page() */
	/* Show Settings Page */
	/*-----------------------------------------------------------------------------------*/
	public function admin_settings_page() {
		global $wc_ei_admin_init;
		$wc_ei_admin_init->admin_settings_page( $this->page_data() );
	}
	
}

global $wc_ei_settings_page;
$wc_ei_settings_page = new WC_EI_Settings_Page();

/** 
 * wc_ei_settings_page_show()
 * Define the callback function to show page content
 */
function wc_ei_settings_page_show() {
	global $wc_ei_settings_page;
	$wc_ei_settings_page->admin_settings_page();
}

?>
