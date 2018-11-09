(function($) {
	$(document).ready(function() {

		setTimeout( function(){
			$('.wc_email_inquiry_modal').appendTo('body');
		}, 1000 );

		$(window).on('wc-ei-modal-scrolltop', function(e) {
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				$('.wc_email_inquiry_modal,body,html').animate({ scrollTop: 0 }, 'slow');
			}
		});

		$('#wc_email_inquiry_modal').on( 'hide.bs.modal', function (event) {
			var modal = $(this);

			modal.removeClass('loading');
		});

		$('#wc_email_inquiry_modal').on( 'show.bs.modal', function (event) {
			var button     = $(event.relatedTarget);
			var product_id = button.data('product_id');
			var form_type  = button.data('form_type');

			var modal = $(this);

			if ( 'party' == form_type ) {

				var iframe_obj = modal.find( '#wc_email_inquiry_party_form' );
				var iframe_src = button.data('iframe_src');

				modal.addClass('loading');
				modal.find('.modal-content').hide();

				iframe_obj.load(function(){
				    modal.find('.modal-content').show();
				    modal.removeClass('loading');

				    $(document).trigger('calculate_modal_iframe_height');
				});

				iframe_obj.attr( 'src', iframe_src );

			} else {

				var inquiry_form_content              = modal.find( '.wc_email_inquiry_content' );
				var inquiry_form_notification_message = modal.find( '.wc_email_inquiry_notification_message' );

				var product_name = button.data('product_name');

				inquiry_form_content.show();
				inquiry_form_notification_message.hide();

				inquiry_form_content.find('input[type="text"]').each(function(){
					$(this).val('');
				});
				inquiry_form_content.find('.your_message').val('');
				inquiry_form_content.find('#send_copy').prop( 'checked', false );
				inquiry_form_content.find('.agree_terms').prop( 'checked', false );

				modal.find('.wc_email_inquiry_form_button').data( 'product_id' , product_id );
				modal.find('.wc_email_inquiry_subject').html( product_name );
			}

			$(window).trigger( 'wc-ei-modal-scrolltop' );
		});

		$(document).on( 'calculate_modal_iframe_height', function(){

			if ( ei_getWidth() <= 768 ) {

				document.getElementById('wc_email_inquiry_party_form').height = $( window ).height() - $('#wc_email_inquiry_party_form').outerHeight() - 50 - 40;
			} else {
				var iframe_height = document.getElementById('wc_email_inquiry_party_form').contentWindow.document.body.scrollHeight;

				//change the height of the iframe
				document.getElementById('wc_email_inquiry_party_form').height = iframe_height;
			}

		});

		function ei_getWidth() {
			xWidth = null;

			if(window.screen != null)
				xWidth = window.screen.availWidth;

			if(window.innerWidth != null)
				xWidth = window.innerWidth;

			if(document.body != null)
				xWidth = document.body.clientWidth;

			return xWidth;
		}

	});

})(jQuery);