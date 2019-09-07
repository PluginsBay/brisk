//dynamic form selection
jQuery(document).ready(function($) {
	/*Group Status*/
	$('.brisk-script-manager-group-status .brisk-status-select').on('change', function(ev) {
		if($(this).children(':selected').val() == 'enabled') {
			$(this).removeClass('disabled');
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section .brisk-script-manager-assets-disabled').hide();
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section table').show();
		}
		else {
			$(this).addClass('disabled');
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section table').hide();
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section .brisk-script-manager-assets-disabled').show();
		}
	});
	$('.brisk-script-manager-group-status .brisk-status-toggle').on('change', function(ev) {
		if($(this).is(':checked')) {
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section table').hide();
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section .brisk-script-manager-assets-disabled').show();
		}
		else {
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section .brisk-script-manager-assets-disabled').hide();
			$(this).closest('.brisk-script-manager-group').find('.brisk-script-manager-section table').show();
		}
	});

	/*Script Status*/
	$('.brisk-script-manager-status .brisk-status-select').on('change', function(ev) {
		if($(this).children(':selected').val() == 'enabled') {
			$(this).removeClass('disabled');
			$(this).closest('tr').find('.brisk-script-manager-controls').hide();
		}
		else {
			$(this).addClass('disabled');
			$(this).closest('tr').find('.brisk-script-manager-controls').show();
		}
	});
	$('.brisk-script-manager-status .brisk-status-toggle').on('change', function(ev) {
		if($(this).is(':checked')) {
			$(this).closest('tr').find('.brisk-script-manager-controls').show();
		}
		else {
			$(this).closest('tr').find('.brisk-script-manager-controls').hide();
		}
	});

	/*Disable Radio*/
	$('.brisk-disable-select').on('change', function(ev) {
		if($(this).val() == 'everywhere') {
			$(this).closest('.brisk-script-manager-controls').find('.brisk-script-manager-enable').show();
		}
		else {
			$(this).closest('.brisk-script-manager-controls').find('.brisk-script-manager-enable').hide();
		}
		if($(this).val() == 'regex') {
			$(this).closest('.brisk-script-manager-controls').find('.pmsm-disable-regex').show();
		}
		else {
			$(this).closest('.brisk-script-manager-controls').find('.pmsm-disable-regex').hide();
		}
	});

	/*Reset Button*/
	$('.pmsm-reset').click(function(ev) {
		ev.preventDefault();
		$('#pmsm-reset-form').submit();
	});
});