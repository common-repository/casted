jQuery(document).ready(function ($) {
	/**
	 * Disconnect Casted Account Button Click
	 */
	$('#casted-disconnect').click(function () {
		let form = $(this).closest('form');

		// Clear casted settings fields
		form.find('input[type="text"]').val('');
		
		// Turn diagnostics off
		form.find('input[name="send_diagnostics"]').val('false');

		// Submit form to save new field values
		form.submit();
	});
});
