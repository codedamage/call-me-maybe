(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery( 'form[name="callback_form"]' ).on( 'submit', function() {
		var form_data = jQuery( this ).serializeArray();

		form_data.push( { "name" : "security", "value" : ajax_nonce } );

		jQuery.ajax({
			url : ajax_url,
			type : 'post',
			data : form_data,
			success : function( response ) {
				console.log(response);
				jQuery( 'form[name="callback_form"]' ).append('<div class="success">' + response.data + '</div>');
				jQuery(':input','form[name="callback_form"]')
					.not(':button, :submit, :reset, :hidden')
					.val('')
					.prop('checked', false)
					.prop('selected', false);
			},
			fail : function( err ) {
				console.log(response);
				jQuery( 'form[name="callback_form"]' ).append('<div class="error">' + response.data + '</div>');
			}
		});

		return false;
	});
})( jQuery );
