<?php
/*
Plugin Name: WooCommerce Email Inquiry & Cart Options LITE
Description: Transform your entire WooCommerce products catalog or any individual product into an online brochure with Product Email Inquiry button and pop-up email form. Add product email inquiry functionality to any product either with WooCommerce functionality or hide that functionality and the page becomes a brochure.
Version: 2.2.0
Requires at least: 4.5
Tested up to: 4.9.7
Author: a3rev Software
Author URI: https://a3rev.com/
Text Domain: woocommerce-email-inquiry-cart-options
Domain Path: /languages
WC requires at least: 3.0.0
WC tested up to: 3.4.3
License: This software is under commercial license and copyright to A3 Revolution Software Development team

	WooCommerce Email Inquiry & Cart Options. Plugin for the WooCommerce shopping Cart.
	Copyright© 2011 A3 Revolution Software Development team

	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('WC_EMAIL_INQUIRY_FILE_PATH', dirname(__FILE__));
define('WC_EMAIL_INQUIRY_DIR_NAME', basename(WC_EMAIL_INQUIRY_FILE_PATH));
define('WC_EMAIL_INQUIRY_FOLDER', dirname(plugin_basename(__FILE__)));
define('WC_EMAIL_INQUIRY_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WC_EMAIL_INQUIRY_DIR', WP_PLUGIN_DIR . '/' . WC_EMAIL_INQUIRY_FOLDER);
define('WC_EMAIL_INQUIRY_NAME', plugin_basename(__FILE__));
define('WC_EMAIL_INQUIRY_TEMPLATE_PATH', WC_EMAIL_INQUIRY_FILE_PATH . '/templates');
define('WC_EMAIL_INQUIRY_IMAGES_URL', WC_EMAIL_INQUIRY_URL . '/assets/images');
define('WC_EMAIL_INQUIRY_JS_URL', WC_EMAIL_INQUIRY_URL . '/assets/js');
define('WC_EMAIL_INQUIRY_CSS_URL', WC_EMAIL_INQUIRY_URL . '/assets/css');

if (!defined("WC_EMAIL_ULTIMATE_URI")) define("WC_EMAIL_ULTIMATE_URI", "https://a3rev.com/shop/woocommerce-email-inquiry-ultimate/");

define( 'WC_EMAIL_INQUIRY_KEY', 'wc_email_inquiry' );
define( 'WC_EMAIL_INQUIRY_VERSION',  '2.2.0' );

/**
 * Load Localisation files.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 * 		- WP_LANG_DIR/woocommerce-email-inquiry-cart-options/woocommerce-email-inquiry-cart-options-LOCALE.mo
 * 		- WP_LANG_DIR/plugins/woocommerce-email-inquiry-cart-options-LOCALE.mo
 * 	 	- /wp-content/plugins/woocommerce-email-inquiry-cart-options/languages/woocommerce-email-inquiry-cart-options-LOCALE.mo (which if not found falls back to)
 */
function wc_email_inquiry_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-email-inquiry-cart-options' );

	load_textdomain( 'woocommerce-email-inquiry-cart-options', WP_LANG_DIR . '/woocommerce-email-inquiry-cart-options/woocommerce-email-inquiry-cart-options-' . $locale . '.mo' );
	load_plugin_textdomain( 'woocommerce-email-inquiry-cart-options', false, WC_EMAIL_INQUIRY_FOLDER . '/languages/' );
}

include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-settings-page.php');

include ('admin/admin-init.php');
include ('admin/less/sass.php');

include ('includes/wc-email-inquiry-template-functions.php');
include ('classes/class-wc-email-inquiry-ajax.php');

include ('classes/class-wc-email-inquiry-functions.php');
include ('classes/class-wc-email-inquiry-hook.php');

include ('admin/wc-email-inquiry-init.php');

/**
 * Call when the plugin is activated
 */
register_activation_hook(__FILE__, 'wc_email_inquiry_install');

?>