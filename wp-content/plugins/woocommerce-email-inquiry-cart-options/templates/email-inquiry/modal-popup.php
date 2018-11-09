<?php
/**
 *
 * Override this template by copying it to yourtheme/woocommerce/email-inquiry/modal-popup.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wc_email_inquiry_global_settings;

if ( '' != trim( $wc_email_inquiry_global_settings['inquiry_contact_heading'] ) ) {
	$wc_email_inquiry_contact_heading = $wc_email_inquiry_global_settings['inquiry_contact_heading'];
} else {
	$wc_email_inquiry_contact_heading = __('Product Inquiry', 'woocommerce-email-inquiry-cart-options' );
}
?>

<div class="wc_email_inquiry_modal modal fade default" id="wc_email_inquiry_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title wc_email_inquiry_result_heading" id="exampleModalLabel"><?php echo $wc_email_inquiry_contact_heading; ?></h5>
				<span class="close" data-dismiss="modal" aria-label="<?php echo __( 'Close', 'woocommerce-email-inquiry-cart-options' ); ?>">
					<span aria-hidden="true">&times;</span>
				</span>
			</div>
			<div class="modal-body">
				<?php
					$data = array(
						'product_id'        => 0,
						'show_product_info' => 1,
						'open_type'         => 'popup',
					);

					wc_ei_default_form_tpl( $data );
				?>
			</div>
		</div>
	</div>
</div>