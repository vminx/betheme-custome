<?php
/**
 * WC Quotes & Order Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

$plugin_key = 'wc_email_inquiry';

// Delete Google Font
delete_option( $plugin_key . '_google_api_key' . '_enable' );
delete_transient( $plugin_key . '_google_api_key' . '_status' );
delete_option( $plugin_key . '_google_font_list' );

if ( get_option( $plugin_key . '_clean_on_deletion' ) == 1 ) {
	delete_option( $plugin_key . '_google_api_key' );
	delete_option( $plugin_key . '_toggle_box_open' );
	delete_option( $plugin_key . '-custom-boxes' );

	delete_metadata( 'user', 0,  $plugin_key . '-' . 'plugin_framework_global_box' . '-' . 'opened', '', true );

	delete_option('wc_email_inquiry_rules_roles_settings');
    delete_option('wc_email_inquiry_global_settings');
    delete_option('wc_email_inquiry_contact_form_settings');
    delete_option('wc_email_inquiry_3rd_contactforms_settings');
    delete_option('wc_email_inquiry_email_options');
    delete_option('wc_email_inquiry_customize_email_button');
    delete_option('wc_email_inquiry_customize_email_popup');
    delete_option('wc_email_inquiry_contact_success');

    delete_option('wc_email_inquiry_fancybox_popup_settings');
    delete_option('wc_email_inquiry_colorbox_popup_settings');

    delete_option('wc_email_inquiry_quote_product_page');
    delete_option('wc_email_inquiry_quote_widget_cart');
    delete_option('wc_email_inquiry_quote_cart_page');
    delete_option('wc_email_inquiry_quote_cart_note');
    delete_option('wc_email_inquiry_quote_checkout_page');
    delete_option('wc_email_inquiry_quote_checkout_top_message');
    delete_option('wc_email_inquiry_quote_checkout_bottom_message');
    delete_option('wc_email_inquiry_quote_order_received_page');
    delete_option('wc_email_inquiry_quote_order_received_top_message');
    delete_option('wc_email_inquiry_quote_order_received_bottom_message');
    delete_option('wc_email_inquiry_quote_new_account_email_settings');
    delete_option('wc_email_inquiry_quote_new_account_email_content');
    delete_option('wc_email_inquiry_quote_send_quote_email_settings');
    delete_option('quote_send_quote_email_description');

    delete_option('wc_email_inquiry_order_product_page');
    delete_option('wc_email_inquiry_order_widget_cart');
    delete_option('wc_email_inquiry_order_cart_page');
    delete_option('wc_email_inquiry_order_cart_note');
    delete_option('wc_email_inquiry_order_checkout_page');
    delete_option('wc_email_inquiry_order_checkout_top_message');
    delete_option('wc_email_inquiry_order_checkout_bottom_message');
    delete_option('wc_email_inquiry_order_order_received_page');
    delete_option('wc_email_inquiry_order_order_received_top_message');
    delete_option('wc_email_inquiry_order_order_received_bottom_message');
    delete_option('wc_email_inquiry_order_new_account_email_settings');
    delete_option('wc_email_inquiry_order_new_account_email_content');

    delete_option( $plugin_key . '_clean_on_deletion' );

    delete_option('wc_email_inquiry_read_more_settings');
    delete_option('wc_ei_read_more_hover_position_style');
    delete_option('wc_ei_read_more_under_image_style');

    delete_post_meta_by_key('_wc_email_inquiry_settings_custom');

    wp_delete_post(get_option('wc_email_inquiry_page_id'), true);
}
