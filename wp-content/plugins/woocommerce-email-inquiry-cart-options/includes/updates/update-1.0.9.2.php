<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$wc_email_inquiry_rules_roles_settings = get_option( 'wc_email_inquiry_rules_roles_settings', array() );
$wc_email_inquiry_global_settings = get_option( 'wc_email_inquiry_global_settings', array() );
$wc_email_inquiry_customize_email_button = get_option( 'wc_email_inquiry_customize_email_button', array('inquiry_single_only' => 'no') );

$wc_email_inquiry_global_settings['show_button'] = $wc_email_inquiry_rules_roles_settings['show_button'];
$wc_email_inquiry_global_settings['show_button_after_login'] = $wc_email_inquiry_rules_roles_settings['show_button_after_login'];
$wc_email_inquiry_global_settings['role_apply_show_inquiry_button'] = $wc_email_inquiry_rules_roles_settings['role_apply_show_inquiry_button'];
$wc_email_inquiry_global_settings['inquiry_single_only'] = $wc_email_inquiry_customize_email_button['inquiry_single_only'];

update_option( 'wc_email_inquiry_global_settings', $wc_email_inquiry_global_settings );