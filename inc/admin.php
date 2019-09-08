<?php 
//default tab
if(empty($_GET['tab'])) {
	$_GET['tab'] = 'options';
} 
?>
<div class="wrap brisk-admin">
	<!-- Page Title -->
	<h2><?php _e('Brisk Settings', 'brisk'); ?></h2>

    <!-- Tabs -->
	<h2 class="nav-tab-wrapper">
		<a href="?page=brisk&tab=options" class="nav-tab <?php echo $_GET['tab'] == 'options' || '' ? 'nav-tab-active' : ''; ?>"><?php _e('Options', 'brisk'); ?></a>
		<a href="?page=brisk&tab=cdn" class="nav-tab <?php echo $_GET['tab'] == 'cdn' ? 'nav-tab-active' : ''; ?>"><?php _e('CDN', 'brisk'); ?></a>
		<a href="?page=brisk&tab=ga" class="nav-tab <?php echo $_GET['tab'] == 'ga' ? 'nav-tab-active' : ''; ?>"><?php _e('Google Analytics', 'brisk'); ?></a>
		<a href="?page=brisk&tab=advanced" class="nav-tab <?php echo $_GET['tab'] == 'advanced' ? 'nav-tab-active' : ''; ?>"><?php _e('Advanced', 'brisk'); ?></a>
		<a href="?page=brisk&tab=support" class="nav-tab <?php echo $_GET['tab'] == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', 'brisk'); ?></a>
	</h2>

	<!-- Options Form -->
	<form method="post" action="options.php">

		<!-- Main Tab -->
		<?php if($_GET['tab'] == 'options') { ?>
		    <?php settings_fields('brisk_options'); ?>
		    <?php do_settings_sections('brisk_options'); ?>
			<?php submit_button(); ?>

		<!-- CDN Tab -->
		<?php } elseif($_GET['tab'] == 'cdn') { ?>

			<?php settings_fields('brisk_cdn'); ?>
		    <?php do_settings_sections('brisk_cdn'); ?>
			<?php submit_button(); ?>

		<!-- Google Analytics Tab -->
		<?php } elseif($_GET['tab'] == 'ga') { ?>

			<?php settings_fields('brisk_ga'); ?>
		    <?php do_settings_sections('brisk_ga'); ?>
			<?php submit_button(); ?>

		<!-- Advanced Tab -->
		<?php } elseif($_GET['tab'] == 'advanced') { ?>

			<?php settings_fields('brisk_advanced'); ?>
		    <?php do_settings_sections('brisk_advanced'); ?>
			<?php submit_button(); ?>


		<!-- Support Tab -->
		<?php } elseif($_GET['tab'] == 'support') { ?>

			<h2><?php _e('Support', 'brisk'); ?></h2>
			<p><?php _e("For plugin support and documentation, please visit <a href='https://pluginsbay.com/' title='brisk' target='_blank'>pluginsbay.com</a>.", 'brisk'); ?></p>

		<?php } ?>
	</form>
	<!-- Tooltips JS -->
	<script>
		(function ($) {
			$(".brisk-tooltip").hover(function(){
			    $(this).closest("tr").find(".brisk-tooltip-text-container").show();
			},function(){
			    $(this).closest("tr").find(".brisk-tooltip-text-container").hide();
			});
		}(jQuery));
	</script>
	
</div>