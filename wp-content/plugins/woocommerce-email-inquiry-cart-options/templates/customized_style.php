<style>
.wc_email_inquiry_expand_text {
	min-width:20px;
	display:inline-block;	
}
.wc_email_inquiry_custom_form_container {
	position:relative !important;	
}
<?php
global $wc_ei_admin_interface, $wc_ei_fonts_face;

// Email Inquiry Button Style
global $wc_email_inquiry_customize_email_button;
extract($wc_email_inquiry_customize_email_button);
?>
@charset "UTF-8";
/* CSS Document */

/* Email Inquiry Button Style */
.wc_email_inquiry_button_container { 
	margin-bottom: <?php echo $inquiry_button_margin_bottom; ?>px !important;
	margin-top: <?php echo $inquiry_button_margin_top; ?>px !important;
	margin-left: <?php echo $inquiry_button_margin_left; ?>px !important;
	margin-right: <?php echo $inquiry_button_margin_right; ?>px !important;
}
body .wc_email_inquiry_button_container .wc_email_inquiry_button {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
body .wc_email_inquiry_button_container .wc_email_inquiry_email_button {
	padding: <?php echo $inquiry_button_padding_tb; ?>px <?php echo $inquiry_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $inquiry_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $inquiry_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $inquiry_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $inquiry_button_bg_colour_from; ?> 20%,
					<?php echo $inquiry_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wc_ei_admin_interface->generate_border_css( $inquiry_button_border ); ?>
	
	/* Shadow */
	<?php echo $wc_ei_admin_interface->generate_shadow_css( $inquiry_button_shadow ); ?>
	
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_button_font ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

body .wc_email_inquiry_button_container .wc_email_inquiry_hyperlink_text {
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_hyperlink_font ); ?>
}

body .wc_email_inquiry_button_container .wc_email_inquiry_hyperlink_text:hover {
	color: <?php echo $inquiry_hyperlink_hover_color ; ?> !important;	
}

<?php
// Email Inquiry Form Button Style
global $wc_email_inquiry_global_settings;
extract($wc_email_inquiry_global_settings);
?>

/* Email Inquiry Form Style */
.wc_email_inquiry_form * {
	box-sizing:content-box !important;
	-moz-box-sizing:content-box !important;
	-webkit-box-sizing:content-box !important;	
}
.wc_email_inquiry_form, .wc_email_inquiry_modal.default .modal-content {
	background-color: <?php echo $inquiry_form_bg_colour; ?> !important;	
}
body .wc_email_inquiry_form, .wc_email_inquiry_form, .wc_email_inquiry_form .wc_email_inquiry_field, body .wc_email_inquiry_field {
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_contact_popup_text ); ?>
}
.wc_email_inquiry_custom_form_product_heading {
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_form_product_name_font ); ?>
	
	clear:none !important;
	margin-top:5px !important;
	padding-top:0 !important;	
}
a.wc_email_inquiry_custom_form_product_url {
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_form_product_url_font ); ?>
}
.wc_email_inquiry_subject {
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_form_subject_font ); ?>
}

.wc_email_inquiry_field input, .wc_email_inquiry_field textarea{
	box-sizing: border-box !important;
	/*Border*/
	<?php echo $wc_ei_admin_interface->generate_border_css( $inquiry_input_border ); ?>
	
	/*Background*/
	background-color: <?php echo $inquiry_input_bg_colour; ?> !important;
	
	/* Font */
	color: <?php echo $inquiry_input_font_colour; ?> !important;
}

/* Email Inquiry Form Button Style */
body .wc_email_inquiry_form_button, .wc_email_inquiry_form_button {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
}
body .wc_email_inquiry_form_button, .wc_email_inquiry_form_button {
	padding: 7px 10px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $inquiry_contact_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $inquiry_contact_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $inquiry_contact_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $inquiry_contact_button_bg_colour_from; ?> 20%,
					<?php echo $inquiry_contact_button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $wc_ei_admin_interface->generate_border_css( $inquiry_contact_button_border ); ?>
	
	/* Shadow */
	<?php echo $wc_ei_admin_interface->generate_shadow_css( $inquiry_contact_button_shadow ); ?>
	
	/* Font */
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_contact_button_font ); ?>
		
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

/* Contact Form Heading */
.wc_email_inquiry_result_heading {
	<?php echo $wc_ei_fonts_face->generate_font_css( $inquiry_contact_heading_font ); ?>
}

</style>
