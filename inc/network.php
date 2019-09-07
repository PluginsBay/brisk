<?php
function brisk_network_admin_menu() {
	//Add network menu
    add_submenu_page('settings.php', 'Brisk Network Settings', 'Brisk', 'manage_network_options', 'brisk', 'brisk_network_page_callback');

    //create if none
    if(get_site_option('brisk_network') == false) {    
        add_site_option('brisk_network', true);
    }
 
 	//Add settings
    add_settings_section('brisk_network', 'Network Setup', 'brisk_network_callback', 'brisk_network');
   
   	//Access options
	add_settings_field(
		'access', 
		'<label for=\'access\'>' . __('Network Access', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/wordpress-multisite/'),
		'brisk_network_access_callback', 
		'brisk_network', 
		'brisk_network'
	);
	//Default options
	add_settings_field(
		'default', 
		'<label for=\'default\'>' . __('Network Default', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/wordpress-multisite/'),
		'brisk_network_default_callback', 
		'brisk_network', 
		'brisk_network'
	);

	//Uninstall
    add_settings_field(
        'clean_uninstall', 
        brisk_title(__('Clean Uninstall', 'brisk'), 'clean_uninstall') . brisk_tooltip('https://pluginsbay.com/docs/brisk/clean-uninstall/'), 
        'brisk_print_input', 
        'brisk_network', 
        'brisk_network', 
        array(
            'id' => 'clean_uninstall',
            'option' => 'brisk_network',
            'tooltip' => __('When enabled, this will cause all Brisk options data to be removed from your database when the plugin is uninstalled.', 'brisk')
        )
    );

	//Register setting
	register_setting('brisk_network', 'brisk_network');
}
add_filter('network_admin_menu', 'brisk_network_admin_menu');

//callback
function brisk_network_callback() {
	echo '<p class="brisk-subheading">' . __('Manage network access control and setup a network default site.', 'brisk') . '</p>';
}
 
//access
function brisk_network_access_callback() {
	$brisk_network = get_site_option('brisk_network');
	echo "<div style='display: table; width: 100%;'>";
		echo "<div class='brisk-input-wrapper'>";
			echo "<select name='brisk_network[access]' id='access'>";
				echo "<option value=''>" . __('Site Admins (Default)', 'brisk') . "</option>";
				echo "<option value='super' " . ((!empty($brisk_network['access']) && $brisk_network['access'] == 'super') ? "selected" : "") . ">" . __('Super Admins Only', 'brisk') . "</option>";
			echo "<select>";
		echo "</div>";
		echo "<div class='brisk-tooltip-text-wrapper'>";
			echo "<div class='brisk-tooltip-text-container' style='display: none;'>";
				echo "<div style='display: table; height: 100%; width: 100%;'>";
					echo "<div style='display: table-cell; vertical-align: middle;'>";
						echo "<span class='brisk-tooltip-text'>" . __('Choose who has access to manage Brisk plugin settings.', 'brisk') . "</span>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}

//default
function brisk_network_default_callback() {
	$brisk_network = get_site_option('brisk_network');
	echo "<div style='display: table; width: 100%;'>";
		echo "<div class='brisk-input-wrapper'>";
			echo "<select name='brisk_network[default]' id='default'>";
				$sites = array_map('get_object_vars', get_sites(array('deleted' => 0)));
				if(is_array($sites) && $sites !== array()) {
					echo "<option value=''>" . __('None', 'brisk') . "</option>";
					foreach($sites as $site) {
						echo "<option value='" . $site['blog_id'] . "' " . ((!empty($brisk_network['default']) && $brisk_network['default'] == $site['blog_id']) ? "selected" : "") . ">" . $site['blog_id'] . ": " . $site['domain'] . $site['path'] . "</option>";
					}
				}
			echo "<select>";
		echo "</div>";
		echo "<div class='brisk-tooltip-text-wrapper'>";
			echo "<div class='brisk-tooltip-text-container' style='display: none;'>";
				echo "<div style='display: table; height: 100%; width: 100%;'>";
					echo "<div style='display: table-cell; vertical-align: middle;'>";
						echo "<span class='brisk-tooltip-text'>" . __('Choose a subsite that you want to pull default settings from.', 'brisk') . "</span>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}
 
//settings page
function brisk_network_page_callback() {
	if(isset($_POST['brisk_apply_defaults'])) {
		check_admin_referer('brisk-network-apply');
		if(isset($_POST['brisk_network_apply_blog']) && is_numeric($_POST['brisk_network_apply_blog'])) {
			$blog = get_blog_details($_POST['brisk_network_apply_blog']);
			if($blog) {
				//apply default settings
				if(is_multisite()) {
					$brisk_network = get_site_option('brisk_network');

					if(!empty($brisk_network['default'])) {

						if($blog->blog_id != $brisk_network['default']) {

							$option_names = array(
								'brisk_options',
								'brisk_cdn',
								'brisk_advanced'
							);

							foreach($option_names as $option_name) {
								//clear previous
								delete_blog_option($blog->blog_id, $option_name);
								//grab new
								$new_option = get_blog_option($brisk_network['default'], $option_name);
								//remove options
								if($option_name == 'brisk_cdn') {
									unset($new_option['cdn_url']);
								}
								//update options
								update_blog_option($blog->blog_id, $option_name, $new_option);

							}

							//updated notice
							echo "<div class='notice updated is-dismissible'><p>" . __('Default settings applied!', 'brisk') . "</p></div>";
						}
						else {
							//error if select default
							echo "<div class='notice error is-dismissible'><p>" . __('Select a site that is not already the Network Default.', 'brisk') . "</p></div>";
						}
					}
					else {
						//error if no default
						echo "<div class='notice error is-dismissible'><p>" . __('Network Default not set.', 'brisk') . "</p></div>";
					}
				}
			}
			else {
				//error if no blog
				echo "<div class='notice error is-dismissible'><p>" . __('Error: Blog Not Found.', 'brisk') . "</p></div>";
			}
		}
	}

	//updated
	if(isset($_GET['updated'])) {
		echo "<div class='notice updated is-dismissible'><p>" . __('Options saved.', 'brisk') . "</p></div>";
	}

	//default tab
	if(empty($_GET['tab'])) {
		$_GET['tab'] = 'network';
	} 

	echo "<div class='wrap brisk-admin'>";

		//title
  		echo "<h1>" . __('Brisk Network Settings', 'brisk') . "</h1>";

  		//tabs
		echo "<h2 class='nav-tab-wrapper'>";
			echo "<a href='?page=brisk&tab=network' class='nav-tab " . ($_GET['tab'] == 'network' ? 'nav-tab-active' : '') . "'>" . __('Network', 'brisk') . "</a>";
			echo "<a href='?page=brisk&tab=support' class='nav-tab " . ($_GET['tab'] == 'support' ? 'nav-tab-active' : '') . "'>" . __('Support', 'brisk') . "</a>";
		echo "</h2>";

		//content
		if($_GET['tab'] == 'network') {

	  		echo "<form method='POST' action='edit.php?action=brisk_update_network_options' style='overflow: hidden;'>";
			    settings_fields('brisk_network');
			    do_settings_sections('brisk_network');
			    submit_button();
	  		echo "</form>";

	  		echo "<form method='POST'>";
	 
	  			echo "<h2>" . __('Apply Default Settings', 'brisk') . "</h2>";
	  			echo '<p class="brisk-subheading">' . __('Choose a site to apply the settings from your network default site.', 'brisk') . '</p>';

				wp_nonce_field('brisk-network-apply', '_wpnonce', true, true);
				echo "<p>" . __('Select a site from the dropdown and click to apply the settings from your network default (above).', 'brisk') . "</p>";

				echo "<select name='brisk_network_apply_blog'>";
					$sites = array_map('get_object_vars', get_sites(array('deleted' => 0)));
					if(is_array($sites) && $sites !== array()) {
						echo "<option value=''>" . __('Select a Site', 'brisk') . "</option>";
						foreach($sites as $site) {
							echo "<option value='" . $site['blog_id'] . "'>" . $site['blog_id'] . ": " . $site['domain'] . $site['path'] . "</option>";
						}
					}
				echo "<select>";

				echo "<input type='submit' name='brisk_apply_defaults' value='" . __('Apply Default Settings', 'brisk') . "' class='button' />";
			echo "</form>";
		}

		//support tab
		elseif($_GET['tab'] == 'support') {
			echo "<h2>" . __('Support', 'brisk') . "</h2>";
			echo "<p>" . __("For plugin support and documentation, please visit <a href='https://pluginsbay.com/' title='brisk' target='_blank'>pluginsbay.com</a>.", 'brisk') . "</p>";
		}

		//tooltips
		if($_GET['tab'] != 'support') {
			echo "<div id='brisk-legend'>";
				echo "<div id='brisk-tooltip-legend'>";
					echo "<span>?</span>" . __('Click on tooltip icons to view full documentation.', 'brisk');
				echo "</div>";
			echo "</div>";
		}

		//tooltips JS
		echo "<script>
			(function ($) {
				$('.brisk-tooltip').hover(function(){
				    $(this).closest('tr').find('.brisk-tooltip-text-container').show();
				},function(){
				    $(this).closest('tr').find('.brisk-tooltip-text-container').hide();
				});
			}(jQuery));
		</script>";

	echo "</div>";
}
 
//Update options
function brisk_update_network_options() {

	//Verify referring
  	check_admin_referer('brisk_network-options');
 
	//Get options
	global $new_whitelist_options;
	$options = $new_whitelist_options['brisk_network'];

	//Loop options
	foreach($options as $option) {
		if(isset($_POST[$option])) {

			//Update Site Uption
			update_site_option($option, $_POST[$option]);
		}
	}

	//Redirect to settings
	wp_redirect(add_query_arg(array('page' => 'brisk', 'updated' => 'true'), network_admin_url('settings.php')));

	exit;
}
add_action('network_admin_edit_brisk_update_network_options',  'brisk_update_network_options');