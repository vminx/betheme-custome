<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wc_ei_admin_init;
$wc_ei_admin_init->set_default_settings();

// Build sass
global $wc_email_inquiry_less;
$wc_email_inquiry_less->plugin_build_sass();