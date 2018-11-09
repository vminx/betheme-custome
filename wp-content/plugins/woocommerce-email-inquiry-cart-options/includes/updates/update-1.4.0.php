<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

@set_time_limit(86400);
@ini_set("memory_limit","640M");

$wc_email_inquiry_global_settings = get_option('wc_email_inquiry_global_settings', array() );

$wc_email_inquiry_customize_email_popup = get_option('wc_email_inquiry_customize_email_popup', array() );
$wc_email_inquiry_global_settings = array_merge( $wc_email_inquiry_customize_email_popup, $wc_email_inquiry_global_settings );

update_option('wc_email_inquiry_global_settings', $wc_email_inquiry_global_settings);