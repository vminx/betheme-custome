<?php
/**
 *
 * Override this template by copying it to yourtheme/woocommerce/email-inquiry/default-form.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wc_email_inquiry_contact_form_settings;
global $wc_email_inquiry_global_settings;

$product_name                         = '';
$name_required                        = false;
$show_phone                           = false;
$phone_required                       = false;
$message_required                     = false;
$send_copy                            = false;
$show_acceptance                      = true;
$wc_email_inquiry_contact_text_button = __( 'SEND', 'woocommerce-email-inquiry-cart-options' );
$wc_email_inquiry_form_class          = 'wc_email_inquiry_form';

$name_label      = __( 'Name', 'woocommerce-email-inquiry-cart-options' );
$email_label     = __( 'Email', 'woocommerce-email-inquiry-cart-options' );
$phone_label     = __( 'Phone', 'woocommerce-email-inquiry-cart-options' );
$subject_label   = __( 'Subject', 'woocommerce-email-inquiry-cart-options' );
$message_label   = __( 'Message', 'woocommerce-email-inquiry-cart-options' );
$send_copy_label = __( 'Send a copy of this email to myself.', 'woocommerce-email-inquiry-cart-options' );

if ( isset( $wc_email_inquiry_contact_form_settings['name_required'] ) 
	&& 'no' !== $wc_email_inquiry_contact_form_settings['name_required'] ) {
	$name_required = true;
}

if ( isset( $wc_email_inquiry_contact_form_settings['show_phone'] ) 
	&& 'no' !== $wc_email_inquiry_contact_form_settings['show_phone'] ) {
	$show_phone = true;
}

if ( isset( $wc_email_inquiry_contact_form_settings['phone_required'] ) 
	&& 'no' !== $wc_email_inquiry_contact_form_settings['phone_required'] ) {
	$phone_required = true;
}

if ( isset( $wc_email_inquiry_contact_form_settings['message_required'] ) 
	&& 'no' !== $wc_email_inquiry_contact_form_settings['message_required'] ) {
	$message_required = true;
}

if ( 'no' !== $wc_email_inquiry_contact_form_settings['inquiry_send_copy'] ) {
	$send_copy = true;
}

if ( isset( $wc_email_inquiry_contact_form_settings['acceptance'] ) 
	&& 'no' === $wc_email_inquiry_contact_form_settings['acceptance'] ) {
	$show_acceptance = false;
}

if ( ! empty( $wc_email_inquiry_global_settings['inquiry_contact_text_button'] ) ) {
	$wc_email_inquiry_contact_text_button = $wc_email_inquiry_global_settings['inquiry_contact_text_button'];
}

if ( 'inner_page' === $open_type ) {
	$wc_email_inquiry_form_class = 'wc_email_inquiry_form_inner';
}

if ( ! empty( $product_id ) ) {
	$product_name = get_the_title( strip_tags( $product_id ) );
} else {
	$product_id = 0;
}

?>	
<div class="wc_email_inquiry_default_form_container <?php echo $wc_email_inquiry_form_class; ?>">
	<div style="padding:10px;">

		<div class="wc_email_inquiry_content">
			<div class="wc_email_inquiry_field">
	        	<label class="wc_email_inquiry_label" for="your_name">
	        		<?php echo $name_label; ?> 

	        		<?php if ( $name_required ) { ?>
	        		<span class="wc_email_inquiry_required">*</span>
	        		<?php } ?>

	        	</label> 
				<input type="text" class="your_name" name="your_name" id="your_name" value="" title="<?php echo esc_attr( $name_label ); ?>" />
			</div>
			<div class="wc_email_inquiry_field">
	        	<label class="wc_email_inquiry_label" for="your_email">
	        		<?php echo $email_label; ?> 
	        		<span class="wc_email_inquiry_required">*</span>
	        	</label>
				<input type="text" class="your_email" name="your_email" id="your_email" value="" title="<?php echo esc_attr( $email_label ); ?>" />
			</div>

			<?php if ( $show_phone ) { ?>

			<div class="wc_email_inquiry_field">
	        	<label class="wc_email_inquiry_label" for="your_phone">
	        		<?php echo $phone_label; ?> 

	        		<?php if ( $phone_required ) { ?>
	        		<span class="wc_email_inquiry_required">*</span>
	        		<?php } ?>

	        	</label> 
				<input type="text" class="your_phone" name="your_phone" id="your_phone" value="" title="<?php echo esc_attr( $phone_label ); ?>" />
			</div>

			<?php } ?>

			<div class="wc_email_inquiry_field">
	        	<label class="wc_email_inquiry_label">
	        		<?php echo $subject_label; ?> 
	        	</label> 
				<span class="wc_email_inquiry_subject"><?php echo $product_name; ?></span>
			</div>

			<div class="wc_email_inquiry_field">
	        	<label class="wc_email_inquiry_label" for="your_message">
	        		<?php echo $message_label; ?> 
	        		
	        		<?php if ( $message_required ) { ?>
	        		<span class="wc_email_inquiry_required">*</span>
	        		<?php } ?>

	        	</label> 
				<textarea class="your_message" name="your_message" id="your_message" title="<?php echo esc_attr( $message_label ); ?>"></textarea>
			</div>

			<?php if ( $send_copy ) { ?>

			<div class="wc_email_inquiry_field">
	            <label class="wc_email_inquiry_label">&nbsp;</label>
	            <label class="wc_email_inquiry_send_copy"><input type="checkbox" name="send_copy" id="send_copy" value="1" /> <?php echo $send_copy_label; ?></label>
	        </div>

	        <?php } ?>

	        <?php if ( $show_acceptance ) { ?>

			<div class="wc_email_inquiry_field">&nbsp;</div>

			<?php $information_text = get_option( 'wc_email_inquiry_contact_form_information_text', '' ); ?>
			<?php if ( ! empty( $information_text ) ) { ?>
			<div class="wc_email_inquiry_field">
				<?php echo stripslashes( $information_text ); ?>
			</div>

			<?php } ?>

			<?php
			$condition_text = get_option( 'wc_email_inquiry_contact_form_condition_text', '' );
			if ( empty( $condition_text ) ) {
				$condition_text = __( 'I have read and agree to the website terms and conditions', 'woocommerce-email-inquiry-cart-options' );
			}
			?>
			<div class="wc_email_inquiry_field">
				<label class="wc_email_inquiry_send_copy"><input type="checkbox" name="agree_terms" class="agree_terms" value="1"> <?php echo stripslashes( $condition_text ); ?></label>
			</div>
			<div class="wc_email_inquiry_field">&nbsp;</div>
			<?php } ?>

	        <div class="wc_email_inquiry_field">
	            <a class="wc_email_inquiry_form_button"
	            	data-product_id="<?php echo $product_id; ?>"
	            	data-name_required="<?php echo ( $name_required ? 1 : 0 ); ?>"
	            	data-show_phone="<?php echo ( $show_phone ? 1 : 0 ); ?>"
	            	data-phone_required="<?php echo ( $phone_required ? 1 : 0 ); ?>"
	            	data-message_required="<?php echo ( $message_required ? 1 : 0 ); ?>"
	            	data-show_acceptance="<?php echo ( $show_acceptance ? 1 : 0 ); ?>"
	            	><?php echo $wc_email_inquiry_contact_text_button; ?></a> 

	            <span class="wc_email_inquiry_loading"><img src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/loading.gif" /></span>
	        </div>
	        
	        <div style="clear:both"></div>

		</div>

		<div class="wc_email_inquiry_notification_message wc_email_inquiry_success_message"></div>
		<div class="wc_email_inquiry_notification_message wc_email_inquiry_error_message"></div>

	    <div style="clear:both"></div>

	</div>

</div>