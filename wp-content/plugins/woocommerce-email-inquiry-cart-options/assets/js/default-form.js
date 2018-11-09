(function($) {
	$(document).ready(function() {

		$(document).on( 'click', '.wc_email_inquiry_form_button', function(){

			var button = $(this);

			if ( button.hasClass( 'wc_email_inquiry_sending' ) ) {
				return false;
			}

			button.addClass( 'wc_email_inquiry_sending' );

			var inquiry_form_container       = button.parents( '.wc_email_inquiry_default_form_container' );
			var inquiry_form_content         = inquiry_form_container.find( '.wc_email_inquiry_content' );
			var inquiry_form_success_message = inquiry_form_container.find( '.wc_email_inquiry_success_message' );
			var inquiry_form_error_message   = inquiry_form_container.find( '.wc_email_inquiry_error_message' );
			var inquiry_submit_loading       = inquiry_form_container.find( '.wc_email_inquiry_loading' );
			
			var product_id       = button.data( 'product_id' );
			var name_required    = button.data( 'name_required' );
			var show_phone       = button.data( 'show_phone' );
			var phone_required   = button.data( 'phone_required' );
			var message_required = button.data( 'message_required' );
			var show_acceptance  = button.data( 'show_acceptance' );

			var your_name_obj    = inquiry_form_content.find( '#your_name' );
			var your_email_obj   = inquiry_form_content.find( '#your_email' );
			var your_phone_obj   = inquiry_form_content.find( '#your_phone' );
			var your_message_obj = inquiry_form_content.find( '#your_message' );
			var send_copy_obj    = inquiry_form_content.find( '#send_copy' );
			var agree_terms_obj  = inquiry_form_content.find( '.agree_terms' );

			var your_name       = your_name_obj.val();
			var your_email      = your_email_obj.val();
			var your_phone      = '';
			var your_message    = your_message_obj.val();
			var send_copy       = 0;
			var is_agree_terms  = 1;

			if ( send_copy_obj.is( ':checked' ) ) {
				send_copy = 1;
			}

			if ( 1 == show_acceptance ) {
				var is_agree_terms = 0;
				if ( agree_terms_obj.is( ':checked' ) ) {
					is_agree_terms = 1;
				}
			}
			
			var wc_email_inquiry_error      = '';
			var wc_email_inquiry_have_error = false;

			var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			if ( 1 == name_required ) {
				if ( your_name.replace(/^\s+|\s+$/g, '') == '' ) {
					wc_email_inquiry_error += your_name_obj.attr( 'title' ) + ' ' + wc_ei_default_vars.required_error + "\n";
					wc_email_inquiry_have_error = true;
				}
			}

			if ( your_email.replace(/^\s+|\s+$/g, '') == '' ) {
				wc_email_inquiry_error += your_email_obj.attr( 'title' ) + ' ' + wc_ei_default_vars.required_error + "\n";
				wc_email_inquiry_have_error = true;

			} else if ( !filter.test( your_email ) ) {
				wc_email_inquiry_error      += wc_ei_default_vars.email_valid_error + "\n";
				wc_email_inquiry_have_error = true;
			}

			if ( 1 == show_phone ) {
				your_phone = your_phone_obj.val();

				if ( 1 == phone_required ) {
					if ( your_phone.replace(/^\s+|\s+$/g, '') == '') {
						wc_email_inquiry_error      += your_phone_obj.attr( 'title' ) + ' ' + wc_ei_default_vars.required_error + "\n";
						wc_email_inquiry_have_error = true;
					}
				}
			}

			if ( 1 == message_required ) {
				if ( your_message.replace(/^\s+|\s+$/g, '') == '' ) {
					wc_email_inquiry_error += your_message_obj.attr( 'title' ) + ' ' + wc_ei_default_vars.required_error + "\n";
					wc_email_inquiry_have_error = true;
				}
			}

			if ( 0 === is_agree_terms ) {
				wc_email_inquiry_error      += wc_ei_default_vars.agree_terms_error + "\n";
				wc_email_inquiry_have_error = true;
			}

			if ( wc_email_inquiry_have_error ) {
				button.removeClass( 'wc_email_inquiry_sending' );
				alert( wc_email_inquiry_error );
				return false;
			}

			inquiry_submit_loading.show();

			var submit_data = {
				action: 		'wc_email_inquiry_submit_form',
				product_id: 	product_id,
				your_name: 		your_name,
				your_email: 	your_email,
				your_phone: 	your_phone,
				your_message: 	your_message,
				send_copy:		send_copy,
				security: 		wc_ei_default_vars.security_nonce
			};

			$.ajax({
				type: 	'POST',
				url: 	wc_ei_default_vars.ajax_url,
				data: 	submit_data,
				success: function ( response ) {

					if ( 'success' == response.status ) {
						// Success
						button.removeClass( 'wc_email_inquiry_sending' );
						inquiry_submit_loading.hide();
						inquiry_form_content.hide();
						inquiry_form_success_message.html( response.message ).show();

					} else {
						// Error
						button.removeClass( 'wc_email_inquiry_sending' );
						inquiry_submit_loading.hide();
						inquiry_form_content.hide();
						inquiry_form_error_message.html( response.message ).show();
					}
				},
				error: function( e ) {
					// Error
					button.removeClass( 'wc_email_inquiry_sending' );
					inquiry_submit_loading.hide();
					inquiry_form_content.hide();
					inquiry_form_error_message.html( e ).show();
				}
			});
		});

	});

})(jQuery);