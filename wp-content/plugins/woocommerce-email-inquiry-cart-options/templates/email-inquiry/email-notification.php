<?php
/**
 *
 * Override this template by copying it to yourtheme/woocommerce/email-inquiry/email-notification.php
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wc_email_inquiry_contact_form_settings;
$show_phone = false;
if ( isset( $wc_email_inquiry_contact_form_settings['show_phone'] ) 
	&& 'no' !== $wc_email_inquiry_contact_form_settings['show_phone'] ) {
	$show_phone = true;
}
?><table width="99%" cellspacing="0" cellpadding="1" border="0" bgcolor="#eaeaea"><tbody>
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="5" border="0" bgcolor="#ffffff"><tbody>
				<tr bgcolor="#eaf2fa">
					<td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong><?php echo __('Name', 'woocommerce-email-inquiry-cart-options' ); ?></strong></font> 
					</td></tr>
				<tr bgcolor="#ffffff">
					<td width="20">&nbsp;</td>
					<td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_name]</font> </td></tr>
				<tr bgcolor="#eaf2fa">
					<td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong><?php echo __('Email', 'woocommerce-email-inquiry-cart-options' ); ?></strong></font> </td></tr>
				<tr bgcolor="#ffffff">
					<td width="20">&nbsp;</td>
					<td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="mailto:[your_email]">[your_email]</a></font> </td></tr>

				<?php if ( $show_phone ) { ?>
				<tr bgcolor="#eaf2fa">
					<td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong><?php echo __('Phone', 'woocommerce-email-inquiry-cart-options' ); ?></strong></font> </td></tr>
				<tr bgcolor="#ffffff">
					<td width="20">&nbsp;</td>
					<td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_phone]</font> </td></tr>
				<?php } ?>

				<tr bgcolor="#eaf2fa">
					<td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong><?php echo __('Product Name', 'woocommerce-email-inquiry-cart-options' ); ?></strong></font> </td></tr>
				<tr bgcolor="#ffffff">
					<td width="20">&nbsp;</td>
					<td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="[product_url]">[product_name]</a></font> </td></tr>
				<tr bgcolor="#eaf2fa">
					<td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong><?php echo __('Message', 'woocommerce-email-inquiry-cart-options' ); ?></strong></font> </td></tr>
				<tr bgcolor="#ffffff">
					<td width="20">&nbsp;</td>
					<td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_message]</font> 
					</td></tr></tbody></table></td></tr></tbody></table>