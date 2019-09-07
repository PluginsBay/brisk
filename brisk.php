<?php
/*
Plugin Name: Brisk
Plugin URI: https://pluginsbay.com/
Description: Increase website page speed by removing the unnecessary CSS and JS from WordPress Themes and Plugins on a per-page basis.
Version: 1.4.1
Author: StefanPejcic
Author URI: https://giga.rs/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: brisk
Domain Path: /languages
*/

//add admin menu
if(is_admin()) {
	add_action('admin_menu', 'brisk_menu', 9);
}
global $brisk_settings_page;

//admin menu
function brisk_menu() {
	if(brisk_network_access()) {
		//TODO: change the page name
		global $brisk_settings_page;
		$brisk_settings_page = add_options_page('brisk', 'Brisk', 'manage_options', 'brisk', 'brisk_admin');
		add_action('load-' . $brisk_settings_page, 'brisk_settings_load');
	}
}

//settings page
function brisk_admin() {
	include plugin_dir_path(__FILE__) . '/inc/admin.php';
}

//load hook
function brisk_settings_load() {
	add_action('admin_enqueue_scripts', 'brisk_admin_scripts');
}

//load scripts
function brisk_admin_scripts() {
	if(brisk_network_access()) {
		wp_register_style('brisk-styles', plugins_url('/css/style.css', __FILE__), array());
		wp_enqueue_style('brisk-styles');

		wp_register_script('brisk-js', plugins_url('/js/brisk.js', __FILE__), array());
		wp_enqueue_script('brisk-js');
	}
}

//check multisite
function brisk_network_access() {
	if(is_multisite()) {
		$brisk_network = get_site_option('brisk_network');
		if((!empty($brisk_network['access']) && $brisk_network['access'] == 'super') && !is_super_admin()) {
			return false;
		}
	}
	return true;
}

//messages in plugins table
function brisk_meta_links($links, $file) {
	if(strpos($file, 'brisk.php' ) !== false) {
		//single
		if(is_network_admin()) {
			$settings_url = network_admin_url('settings.php?page=brisk');
		}
		//multisite
		else {
			$settings_url = admin_url('options-general.php?page=brisk');
		}

		$brisk_links = array();

		//support link
		$brisk_links[] = '<a href="https://pluginsbay.com/docs/brisk/" target="_blank">' . __('Support', 'brisk') . '</a>';

		$links = array_merge($links, $brisk_links);
	}
	return $links;
}
add_filter('plugin_row_meta', 'brisk_meta_links', 10, 2);

//settings link in plugins table
function brisk_action_links($actions, $plugin_file) 
{
	if(plugin_basename(__FILE__) == $plugin_file) {
		//single
		if(is_network_admin()) {
			$settings_url = network_admin_url('settings.php?page=brisk');
		}
		//multisite
		else {
			$settings_url = admin_url('options-general.php?page=brisk');
		}

		$settings_link = array('settings' => '<a href="' . $settings_url . '">' . __('Settings', 'brisk') . '</a>');
		$actions = array_merge($settings_link, $actions);
	}
	return $actions;
}
add_filter('plugin_action_links', 'brisk_action_links', 10, 5);
/*
//Notice on the settings page
function brisk_guide_notice() {
    if(get_current_screen()->base == 'settings_page_brisk') {
        echo "<div class='notice notice-info'>";
        	echo "<p>";
        		_e("Check out our <a href='https://pluginsbay.com/brisk-wordpress-optimization-plugin/' title='WordPress Optimization Guide' target='_blank'>complete optimization guide</a> for more ways to speed up WordPress.", 'brisk');
        	echo "</p>";
        echo "</div>";
    }
}
add_action('admin_notices', 'brisk_guide_notice');
*/
//uninstall + delete options
function brisk_uninstall() {
	//plugin options
	$brisk_options = array(
		'brisk_options',
		'brisk_cdn',
		'brisk_ga',
		'brisk_advanced',
		'brisk_script_manager',
		'brisk_script_manager_settings',
	);
	//multisite
	if(is_multisite()) {
		$brisk_network = get_site_option('brisk_network');
		if(!empty($brisk_network['clean_uninstall']) && $brisk_network['clean_uninstall'] == 1) {
			delete_site_option('brisk_network');

			$sites = array_map('get_object_vars', get_sites(array('deleted' => 0)));
			if(is_array($sites) && $sites !== array()) {
				foreach($sites as $site) {
					foreach($brisk_options as $option) {
						delete_blog_option($site['blog_id'], $option);
					}
				}
			}
		}
	}
	else {
		$brisk_advanced = get_option('brisk_advanced');
		if(!empty($brisk_advanced['clean_uninstall']) && $brisk_advanced['clean_uninstall'] == 1) {
			foreach($brisk_options as $option) {
				delete_option($option);
			}
		}
	}
}
register_uninstall_hook(__FILE__, 'brisk_uninstall');

//file includes
include plugin_dir_path(__FILE__) . '/inc/settings.php';
include plugin_dir_path(__FILE__) . '/inc/functions.php';
include plugin_dir_path(__FILE__) . '/inc/network.php';