//admin JS
jQuery(document).ready(function($) {
	
	$('#brisk-add-preconnect').on('click', function(ev) {
		ev.preventDefault();

		var rowCount = $(this).prop('rel');

		rowCount++;
		
		$('#brisk-preconnect-wrapper').append("<div class='brisk-preconnect-row'><input type='text' id='preconnect-" + rowCount + "-url' name='brisk_advanced[preconnect][" + rowCount + "][url]' value='' placeholder='https://example.com' /><label for='preconnect-" + rowCount + "-crossorigin'><input type='checkbox' id='preconnect-" + rowCount + "-crossorigin' name='brisk_advanced[preconnect][" + rowCount + "][crossorigin]' value='1' /> CrossOrigin</label><a href='#' class='brisk-delete-preconnect' title='Remove'><span class='dashicons dashicons-no'></span></a></div>");

		$(this).prop('rel', rowCount);

	});

	$('#brisk-preconnect-wrapper').on('click', '.brisk-delete-preconnect', function(ev) {
		console.log('clicked');
		ev.preventDefault();

		var siblings = $(this).closest('div').siblings();
		
		$(this).closest('div').remove();

		siblings.each(function(i){

			var url = $(this).find('input:text');

			url.attr('id', 'preconnect-' + i + '-url');
			url.attr('name', 'brisk_advanced[preconnect][' + i + '][url]');

			var crossorigin = $(this).find('input:checkbox');

			crossorigin.attr('id', 'preconnect-' + i + '-crossorigin');
			crossorigin.attr('name', 'brisk_advanced[preconnect][' + i + '][crossorigin]');

		})

		var rowCount = $('#brisk-add-preconnect').prop('rel');
		$('#brisk-add-preconnect').prop('rel', rowCount - 1);

	});

});