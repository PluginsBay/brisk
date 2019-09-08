<?php
$brisk_options = get_option('brisk_options');
$brisk_cdn = get_option('brisk_cdn');
$brisk_ga = get_option('brisk_ga');
$brisk_advanced = get_option('brisk_advanced');

/* options actions + filters */
if(!empty($brisk_options['disable_emojis']) && $brisk_options['disable_emojis'] == "1") {
	add_action('init', 'brisk_disable_emojis');
}
if(!empty($brisk_options['disable_embeds']) && $brisk_options['disable_embeds'] == "1") {
	add_action('init', 'brisk_disable_embeds', 9999);
}
if(!empty($brisk_options['remove_query_strings']) && $brisk_options['remove_query_strings'] == "1") {
	add_action('init', 'brisk_remove_query_strings');
}

/* Disable XML-RPC */
if(!empty($brisk_options['disable_xmlrpc']) && $brisk_options['disable_xmlrpc'] == "1") {
	add_filter('xmlrpc_enabled', '__return_false');
	add_filter('wp_headers', 'brisk_remove_x_pingback');
	add_filter('pings_open', '__return_false', 9999);
}

function brisk_remove_x_pingback($headers) {
    unset($headers['X-Pingback'], $headers['x-pingback']);
    return $headers;
}

if(!empty($brisk_options['remove_jquery_migrate']) && $brisk_options['remove_jquery_migrate'] == "1") {
	add_filter('wp_default_scripts', 'brisk_remove_jquery_migrate');
}
if(!empty($brisk_options['hide_wp_version']) && $brisk_options['hide_wp_version'] == "1") {
	remove_action('wp_head', 'wp_generator');
	add_filter('the_generator', 'brisk_hide_wp_version');
}
if(!empty($brisk_options['remove_wlwmanifest_link']) && $brisk_options['remove_wlwmanifest_link'] == "1") {
	remove_action('wp_head', 'wlwmanifest_link');
}
if(!empty($brisk_options['remove_rsd_link']) && $brisk_options['remove_rsd_link'] == "1") {
	remove_action('wp_head', 'rsd_link');
}

/* Remove Shortlink */
if(!empty($brisk_options['remove_shortlink']) && $brisk_options['remove_shortlink'] == "1") {
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action ('template_redirect', 'wp_shortlink_header', 11, 0);
}

/* Disable RSS Feeds */
if(!empty($brisk_options['disable_rss_feeds']) && $brisk_options['disable_rss_feeds'] == "1") {
	add_action('template_redirect', 'brisk_disable_rss_feeds', 1);
}

function brisk_disable_rss_feeds() {
	if(!is_feed() || is_404()) {
		return;
	}
	
	global $wp_rewrite;
	global $wp_query;

	//check for GET feed query variable firet and redirect
	if(isset($_GET['feed'])) {
		wp_redirect(esc_url_raw(remove_query_arg('feed')), 301);
		exit;
	}

	//unset wp_query feed variable
	if(get_query_var('feed') !== 'old') {
		set_query_var('feed', '');
	}
		
	//let Wordpress redirect to the proper URL
	redirect_canonical();

	//redirect failed, display error message
	wp_die(sprintf(__("No feed available, please visit the <a href='%s'>homepage</a>!"), esc_url(home_url('/'))));
}

/* Remove RSS Feed Links */
if(!empty($brisk_options['remove_feed_links']) && $brisk_options['remove_feed_links'] == "1") {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
}

/* Disable Self Pingbacks */
if(!empty($brisk_options['disable_self_pingbacks']) && $brisk_options['disable_self_pingbacks'] == "1") {
	add_action('pre_ping', 'brisk_disable_self_pingbacks');
}

function brisk_disable_self_pingbacks(&$links) {
	$home = get_option('home');
	foreach($links as $l => $link) {
		if(strpos($link, $home) === 0) {
			unset($links[$l]);
		}
	}
}

/* Disable REST API */
if(!empty($brisk_options['disable_rest_api'])) {
	add_filter('rest_authentication_errors', 'brisk_rest_authentication_errors', 20);
}

function brisk_rest_authentication_errors($result) {
	if(!empty($result)) {
		return $result;
	}
	else{
		global $brisk_options;
		$disabled = false;

		if($brisk_options['disable_rest_api'] == 'disable_non_admins' && !current_user_can('manage_options')) {
			$disabled = true;
		}
		elseif($brisk_options['disable_rest_api'] == 'disable_logged_out' && !is_user_logged_in()) {
			$disabled = true;
		}
	}
	if($disabled) {
		return new WP_Error('rest_authentication_error', __('Sorry, you do not have permission to make REST API requests.', 'brisk'), array('status' => 401));
	}
	return $result;
}

/* Remove REST API Links */
if(!empty($brisk_options['remove_rest_api_links']) && $brisk_options['remove_rest_api_links'] == "1") {
	remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

/* Disable Google Maps */
if(!empty($brisk_options['disable_google_maps']) && $brisk_options['disable_google_maps'] == "1") {
	add_action('wp_loaded', 'brisk_disable_google_maps');
}

function brisk_disable_google_maps() {
	ob_start('brisk_disable_google_maps_regex');
}

function brisk_disable_google_maps_regex($html) {
	$html = preg_replace('/<script[^<>]*\/\/maps.(googleapis|google|gstatic).com\/[^<>]*><\/script>/i', '', $html);
	return $html;
}

/* Disable Google Fonts */
if(!empty($brisk_options['disable_google_fonts']) && $brisk_options['disable_google_fonts'] == "1") {
	add_action('wp_loaded', 'brisk_disable_google_fonts');
}

function brisk_disable_google_fonts() {
	ob_start('brisk_disable_google_fonts_regex');
}

function brisk_disable_google_fonts_regex($html) {
	$html = preg_replace('/<link[^<>]*\/\/fonts\.(googleapis|google|gstatic)\.com[^<>]*>/i', '', $html);
	return $html;
}

/* Disable Password Strength Meter */
if(!empty($brisk_options['disable_password_strength_meter']) && $brisk_options['disable_password_strength_meter'] == "1") {
	add_action('wp_print_scripts', 'brisk_disable_password_strength_meter', 100);
}

function brisk_disable_password_strength_meter() {
	global $wp;

	$wp_check = isset($wp->query_vars['lost-password']) || (isset($_GET['action']) && $_GET['action'] === 'lostpassword') || is_page('lost_password');

	$wc_check = (class_exists('WooCommerce') && (is_account_page() || is_checkout()));

	if(!$wp_check && !$wc_check) {
		if(wp_script_is('zxcvbn-async', 'enqueued')) {
			wp_dequeue_script('zxcvbn-async');
		}

		if(wp_script_is('password-strength-meter', 'enqueued')) {
			wp_dequeue_script('password-strength-meter');
		}

		if(wp_script_is('wc-password-strength-meter', 'enqueued')) {
			wp_dequeue_script('wc-password-strength-meter');
		}
	}
}

/* Disable Comments */
if(!empty($brisk_options['disable_comments']) && $brisk_options['disable_comments'] == "1") {

	//Disable Built-in Recent Comments Widget
	add_action('widgets_init', 'brisk_disable_recent_comments_widget');

	//Check for XML-RPC
	if(empty($brisk_options['disable_xmlrpc'])) {
		add_filter('wp_headers', 'brisk_remove_x_pingback');
	}

	//Check for Feed Links
	if(empty($brisk_options['remove_feed_links'])) {
		remove_action('wp_head', 'feed_links_extra', 3);
	}
	
	//Disable Comment Feed Requests
	add_action('template_redirect', 'brisk_disable_comment_feed_requests', 9);

	//Remove Comment Links from the Admin Bar
	add_action('template_redirect', 'brisk_remove_admin_bar_comment_links'); //front end
	add_action('admin_init', 'brisk_remove_admin_bar_comment_links'); //admin

	//Finish Disabling Comments
	add_action('wp_loaded', 'brisk_wp_loaded_disable_comments');
}

//Disable Recent Comments Widget
function brisk_disable_recent_comments_widget() {
	unregister_widget('WP_Widget_Recent_Comments');
	add_filter('show_recent_comments_widget_style', '__return_false');
}

//Disable Comment Feed Requests
function brisk_disable_comment_feed_requests() {
	if(is_comment_feed()) {
		wp_die(__('Comments are disabled.', 'brisk'), '', array('response' => 403));
	}
}

//Remove Comment Links from the Admin Bar
function brisk_remove_admin_bar_comment_links() {
	if(is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		if(is_multisite()) {
			add_action('admin_bar_menu', 'brisk_remove_network_admin_bar_comment_links', 500);
		}
	}
}

//Remove Comment Links from the Network Admin Bar
function brisk_remove_network_admin_bar_comment_links($wp_admin_bar) {
	if(!function_exists('is_plugin_active_for_network')) {
	    require_once(ABSPATH . '/wp-admin/includes/plugin.php');
	}
	if(is_plugin_active_for_network('brisk/brisk.php') && is_user_logged_in()) {

		//Remove for All Sites
		foreach($wp_admin_bar->user->blogs as $blog) {
			$wp_admin_bar->remove_menu('blog-' . $blog->userblog_id . '-c');
		}
	}
	else {
		
		//Remove for Current Site
		$wp_admin_bar->remove_menu('blog-' . get_current_blog_id() . '-c');
	}
}

//Finish Disabling Comments
function brisk_wp_loaded_disable_comments() {

	//Remove Comment Support from All Post Types
	$post_types = get_post_types(array('public' => true), 'names');
	if(!empty($post_types)) {
		foreach($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}

	//Close Comment Filters
	add_filter('comments_array', function() { return array(); }, 20, 2);
	add_filter('comments_open', function() { return false; }, 20, 2);
	add_filter('pings_open', function() { return false; }, 20, 2);

	if(is_admin()) {

		//Remove Menu Links + Disable Admin Pages 
		add_action('admin_menu', 'brisk_admin_menu_remove_comments', 9999);
		
		//Hide Comments from Dashboard
		add_action('admin_print_styles-index.php', 'brisk_hide_dashboard_comments_css');

		//Hide Comments from Profile
		add_action('admin_print_styles-profile.php', 'brisk_hide_profile_comments_css');
		
		//Remove Recent Comments Meta
		add_action('wp_dashboard_setup', 'brisk_remove_recent_comments_meta');
		
		//Disable Pingback Flag
		add_filter('pre_option_default_pingback_flag', '__return_zero');
	}
	else {

		//Replace Comments Template with a Blank One
		add_filter('comments_template', 'brisk_blank_comments_template', 20);
		
		//Remove Comment Reply Script
		wp_deregister_script('comment-reply');
		
		//Disable the Comments Feed Link
		add_filter('feed_links_show_comments_feed', '__return_false');
	}
}

//Remove Menu Links + Disable Admin Pages 
function brisk_admin_menu_remove_comments() {

	global $pagenow;

	//Remove Comment + Discussion Menu Links
	remove_menu_page('edit-comments.php');
	remove_submenu_page('options-general.php', 'options-discussion.php');

	//Disable Comments Pages
	if($pagenow == 'comment.php' || $pagenow == 'edit-comments.php') {
		wp_die(__('Comments are disabled.', 'brisk'), '', array('response' => 403));
	}

	//Disable Discussion Page
	if($pagenow == 'options-discussion.php') {
		wp_die(__('Comments are disabled.', 'brisk'), '', array('response' => 403));
	}
}

//Hide Comments from Dashboard
function brisk_hide_dashboard_comments_css(){
	echo "<style>
		#dashboard_right_now .comment-count, #dashboard_right_now .comment-mod-count, #latest-comments, #welcome-panel .welcome-comments {
			display: none !important;
		}
	</style>";
}

//Hide Comments from Profile
function brisk_hide_profile_comments_css(){
	echo "<style>
		.user-comment-shortcuts-wrap {
			display: none !important;
		}
	</style>";
}

//Remove Recent Comments Meta Box
function brisk_remove_recent_comments_meta(){
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}

//Return Blank Comments Template
function brisk_blank_comments_template() {
	return dirname(__FILE__) . '/comments-template.php';
}

/* Remove Comment URLs */
if(!empty($brisk_options['remove_comment_urls']) && $brisk_options['remove_comment_urls'] == "1") {
	add_filter('get_comment_author_link', 'brisk_remove_comment_author_link', 10, 3);
	add_filter('get_comment_author_url', 'brisk_remove_comment_author_url');
	add_filter('comment_form_default_fields', 'brisk_remove_website_field', 9999);
}

function brisk_remove_comment_author_link($return, $author, $comment_ID) {
    return $author;
}

function brisk_remove_comment_author_url() {
    return false;
}

function brisk_remove_website_field($fields) {
   unset($fields['url']);
   return $fields;
}

/* Disable Dashicons
/***********************************************************************/
if(!empty($brisk_options['disable_dashicons']) && $brisk_options['disable_dashicons'] == "1") {
	add_action('wp_enqueue_scripts', 'brisk_disable_dashicons');
}

function brisk_disable_dashicons() {
	if(!is_user_logged_in()) {
		wp_dequeue_style('dashicons');
	    wp_deregister_style('dashicons');
	}
}

/* Disable WooCommerce Scripts */
if(!empty($brisk_options['disable_woocommerce_scripts']) && $brisk_options['disable_woocommerce_scripts'] == "1") {
	add_action('wp_enqueue_scripts', 'brisk_disable_woocommerce_scripts', 99);
}

function brisk_disable_woocommerce_scripts() {
	if(function_exists('is_woocommerce')) {
		if(!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_product() && !is_product_category() && !is_shop()) {
			global $brisk_options;
			
			//Dequeue WooCommerce Styles
			wp_dequeue_style('woocommerce-general');
			wp_dequeue_style('woocommerce-layout');
			wp_dequeue_style('woocommerce-smallscreen');
			wp_dequeue_style('woocommerce_frontend_styles');
			wp_dequeue_style('woocommerce_fancybox_styles');
			wp_dequeue_style('woocommerce_chosen_styles');
			wp_dequeue_style('woocommerce_prettyPhoto_css');
			//Dequeue WooCommerce Scripts
			wp_dequeue_script('wc_price_slider');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-add-to-cart');
			wp_dequeue_script('wc-checkout');
			wp_dequeue_script('wc-add-to-cart-variation');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-cart');
			wp_dequeue_script('wc-chosen');
			wp_dequeue_script('woocommerce');
			wp_dequeue_script('prettyPhoto');
			wp_dequeue_script('prettyPhoto-init');
			wp_dequeue_script('jquery-blockui');
			wp_dequeue_script('jquery-placeholder');
			wp_dequeue_script('fancybox');
			wp_dequeue_script('jqueryui');

			if(empty($brisk_options['disable_woocommerce_cart_fragmentation']) || $brisk_options['disable_woocommerce_cart_fragmentation'] == "0") {
				wp_dequeue_script('wc-cart-fragments');
			}
		}
	}
}

/* Disable WooCommerce Cart Fragmentation */
if(!empty($brisk_options['disable_woocommerce_cart_fragmentation']) && $brisk_options['disable_woocommerce_cart_fragmentation'] == "1") {
	add_action('wp_enqueue_scripts', 'brisk_disable_woocommerce_cart_fragmentation', 99);
}

function brisk_disable_woocommerce_cart_fragmentation() {
	if(function_exists('is_woocommerce')) {
		wp_dequeue_script('wc-cart-fragments');
	}
}

/* Disable WooCommerce Status Meta Box */
if(!empty($brisk_options['disable_woocommerce_status']) && $brisk_options['disable_woocommerce_status'] == "1") {
	add_action('wp_dashboard_setup', 'brisk_disable_woocommerce_status');
}

function brisk_disable_woocommerce_status() {
	remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
}

/* Disable WooCommerce Widgets */
if(!empty($brisk_options['disable_woocommerce_widgets']) && $brisk_options['disable_woocommerce_widgets'] == "1") {
	add_action('widgets_init', 'brisk_disable_woocommerce_widgets', 99);
}
function brisk_disable_woocommerce_widgets() {
	global $brisk_options;

	unregister_widget('WC_Widget_Products');
	unregister_widget('WC_Widget_Product_Categories');
	unregister_widget('WC_Widget_Product_Tag_Cloud');
	unregister_widget('WC_Widget_Cart');
	unregister_widget('WC_Widget_Layered_Nav');
	unregister_widget('WC_Widget_Layered_Nav_Filters');
	unregister_widget('WC_Widget_Price_Filter');
	unregister_widget('WC_Widget_Product_Search');
	unregister_widget('WC_Widget_Recently_Viewed');

	if(empty($brisk_options['disable_woocommerce_reviews']) || $brisk_options['disable_woocommerce_reviews'] == "0") {
		unregister_widget('WC_Widget_Recent_Reviews');
		unregister_widget('WC_Widget_Top_Rated_Products');
		unregister_widget('WC_Widget_Rating_Filter');
	}
}

if(!empty($brisk_options['disable_heartbeat'])) {
	add_action('init', 'brisk_disable_heartbeat', 1);
}
if(!empty($brisk_options['heartbeat_frequency'])) {
	add_filter('heartbeat_settings', 'brisk_heartbeat_frequency');
}

/* Limit Post Revisions */
if(!empty($brisk_options['limit_post_revisions'])) {
	if(defined('WP_POST_REVISIONS')) {
		add_action('admin_notices', 'brisk_admin_notice_post_revisions');
	}
	define('WP_POST_REVISIONS', $brisk_options['limit_post_revisions']);
}

function brisk_admin_notice_post_revisions() {
	echo "<div class='notice notice-error'>";
		echo "<p>";
			echo "<strong>" . __('Brisk Warning', 'brisk') . ":</strong> ";
			echo __('WP_POST_REVISIONS is already enabled somewhere else on your site. We suggest only enabling this feature in one place.', 'brisk');
		echo "</p>";
	echo "</div>";
}

/* Autosave Interval */
if(!empty($brisk_options['autosave_interval'])) {
	if(defined('AUTOSAVE_INTERVAL')) {
		add_action('admin_notices', 'brisk_admin_notice_autosave_interval');
	}
	define('AUTOSAVE_INTERVAL', $brisk_options['autosave_interval']);
}

function brisk_admin_notice_autosave_interval() {
	echo "<div class='notice notice-error'>";
		echo "<p>";
			echo "<strong>" . __('Brisk Warning', 'brisk') . ":</strong> ";
			echo __('AUTOSAVE_INTERVAL is already enabled somewhere else on your site. We suggest only enabling this feature in one place.', 'brisk');
		echo "</p>";
	echo "</div>";
}

if(!empty($brisk_advanced['script_manager']) && $brisk_advanced['script_manager'] == "1") {
	add_action('admin_bar_menu', 'brisk_script_manager_admin_bar', 1000);
	add_filter('post_row_actions', 'brisk_script_manager_row_actions', 10, 2);
	add_filter('page_row_actions', 'brisk_script_manager_row_actions', 10, 2);
	add_action('wp_footer', 'brisk_script_manager', 1000);
	add_action('script_loader_src', 'brisk_dequeue_scripts', 1000, 2);
	add_action('style_loader_src', 'brisk_dequeue_scripts', 1000, 2);
	add_action('template_redirect', 'brisk_script_manager_update', 10, 2);
	add_action('update_option_brisk_script_manager', 'brisk_script_manager_update_option', 10, 3);
	add_action('update_option_brisk_script_manager_settings', 'brisk_script_manager_update_option', 10, 3);
	add_action('wp_enqueue_scripts', 'brisk_script_manager_scripts');
	add_action('init', 'brisk_script_manager_force_admin_bar');
}

if(!empty($brisk_advanced['dns_prefetch'])) {
	add_action('wp_head', 'brisk_dns_prefetch', 1);
}

/* Disable Emojis */
function brisk_disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');	
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');	
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'brisk_disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'brisk_disable_emojis_dns_prefetch', 10, 2);
	add_filter('emoji_svg_url', '__return_false');
}

function brisk_disable_emojis_tinymce($plugins) {
	if(is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

function brisk_disable_emojis_dns_prefetch( $urls, $relation_type ) {
	if('dns-prefetch' == $relation_type) {
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));
	}
	return $urls;
}

/* Disable Embeds */
function brisk_disable_embeds() {
	global $wp;
	$wp->public_query_vars = array_diff($wp->public_query_vars, array('embed',));
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	add_filter( 'embed_oembed_discover', '__return_false' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'tiny_mce_plugins', 'brisk_disable_embeds_tiny_mce_plugin' );
	add_filter( 'rewrite_rules_array', 'brisk_disable_embeds_rewrites' );
	remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

function brisk_disable_embeds_tiny_mce_plugin($plugins) {
	return array_diff($plugins, array('wpembed'));
}

function brisk_disable_embeds_rewrites($rules) {
	foreach($rules as $rule => $rewrite) {
		if(false !== strpos($rewrite, 'embed=true')) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}

/* Remove Query Strings */
function brisk_remove_query_strings() {
	if(!is_admin()) {
		add_filter('script_loader_src', 'brisk_remove_query_strings_split', 15);
		add_filter('style_loader_src', 'brisk_remove_query_strings_split', 15);
	}
}

function brisk_remove_query_strings_split($src){
	$output = preg_split("/(&ver|\?ver)/", $src);
	return $output[0];
}

/* Remove jQuery Migrate */
function brisk_remove_jquery_migrate(&$scripts) {
    if(!is_admin()) {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, array( 'jquery-core' ), '1.12.4');
    }
}

/* Hide WP Version */
function brisk_hide_wp_version() {
	return '';
}

/* Disable Heartbeat */
function brisk_disable_heartbeat() {
	global $brisk_options;
	if(!empty($brisk_options['disable_heartbeat'])) {
		if($brisk_options['disable_heartbeat'] == 'disable_everywhere') {
			wp_deregister_script('heartbeat');
			/*wp_dequeue_script('heartbeat');
			if(is_admin()) {
				wp_register_script('hearbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
				wp_enqueue_script('heartbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
			}*/
		}
		elseif($brisk_options['disable_heartbeat'] == 'allow_posts') {
			global $pagenow;
			if($pagenow != 'post.php' && $pagenow != 'post-new.php') {
				wp_deregister_script('heartbeat');
				/*wp_dequeue_script('heartbeat');
				if(is_admin()) {
					wp_register_script('hearbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
					wp_enqueue_script('heartbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
				}*/
			}
		}
	}
}

/* Heartbeat Frequency */
function brisk_heartbeat_frequency($settings) {
	global $brisk_options;
	if(!empty($brisk_options['heartbeat_frequency'])) {
		$settings['interval'] = $brisk_options['heartbeat_frequency'];
	}
	return $settings;
}

/* Change Login URL */
$brisk_wp_login = false;

if(!empty($brisk_options['login_url']) && !defined('WP_CLI')) {
	add_action('plugins_loaded', 'brisk_plugins_loaded', 2);
	add_action('wp_loaded', 'brisk_wp_loaded');
	add_action('setup_theme', 'brisk_disable_customize_php', 1);
	add_filter('site_url', 'brisk_site_url', 10, 4);
	add_filter('network_site_url', 'brisk_network_site_url', 10, 3);
	add_filter('wp_redirect', 'brisk_wp_redirect', 10, 2);
	add_filter('site_option_welcome_email', 'brisk_welcome_email');
	add_filter('admin_url', 'brisk_admin_url');
	remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
}

function brisk_site_url($url, $path, $scheme, $blog_id) {
	return brisk_filter_wp_login($url, $scheme);
}

function brisk_network_site_url($url, $path, $scheme) {
	return brisk_filter_wp_login($url, $scheme);
}

function brisk_wp_redirect($location, $status) {
	return brisk_filter_wp_login($location);
}

function brisk_filter_wp_login($url, $scheme = null) {

	//wp-login.php Being Requested
	if(strpos($url, 'wp-login.php') !== false) {

		//Set HTTPS Scheme if SSL
		if(is_ssl()) {
			$scheme = 'https';
		}

		//Check for Query String and Craft New Login URL
		$query_string = explode('?', $url);
		if(isset($query_string[1])) {
			parse_str($query_string[1], $query_string);
			$url = add_query_arg($query_string, brisk_login_url($scheme));
		} 
		else {
			$url = brisk_login_url($scheme);
		}
	}

	//Return Finished Login URL
	return $url;
}

function brisk_login_url($scheme = null) {

	//Return Full New Login URL Based on Permalink Structure
	if(get_option('permalink_structure')) {
		return brisk_trailingslashit(home_url('/', $scheme) . brisk_login_slug());
	} 
	else {
		return home_url('/', $scheme) . '?' . brisk_login_slug();
	}
}

function brisk_trailingslashit($string) {

	//Check for Permalink Trailing Slash and Add to String
	if((substr(get_option('permalink_structure'), -1, 1)) === '/') {
		return trailingslashit($string);
	}
	else {
		return untrailingslashit($string);
	}
}

function brisk_login_slug() {

	//Declare Global Variable
	global $brisk_options;

	//Return Login URL Slug if Available
	if(!empty($brisk_options['login_url'])) {
		return $brisk_options['login_url'];
	} 
}

function brisk_plugins_loaded() {

	//Declare Global Variables
	global $pagenow;
	global $brisk_wp_login;

	//Parse Requested URI
	$URI = parse_url($_SERVER['REQUEST_URI']);
	$path = untrailingslashit($URI['path']);
	$slug = brisk_login_slug();

	//Non Admin wp-login.php URL
	if(!is_admin() && (strpos(rawurldecode($_SERVER['REQUEST_URI']), 'wp-login.php') !== false || $path === site_url('wp-login', 'relative'))) {

		//Set Flag
		$brisk_wp_login = true;

		//Prevent Redirect to Hidden Login
		$_SERVER['REQUEST_URI'] = brisk_trailingslashit('/' . str_repeat('-/', 10));
		$pagenow = 'index.php';
	} 
	//Hidden Login URL
	elseif($path === home_url($slug, 'relative') || (!get_option('permalink_structure') && isset($_GET[$slug]) && empty($_GET[$slug]))) {
		
		//Override Current Page w/ wp-login.php
		$pagenow = 'wp-login.php';
	}
}

function brisk_wp_loaded() {

	//Declare Global Variables
	global $pagenow;
	global $brisk_wp_login;

	//Parse Requested URI
	$URI = parse_url($_SERVER['REQUEST_URI']);

	//Disable Normal WP-Admin
	if(is_admin() && !is_user_logged_in() && !defined('DOING_AJAX') && $pagenow !== 'admin-post.php' && (isset($_GET) && empty($_GET['adminhash']) && empty($_GET['newuseremail']))) {
        wp_die(__('This has been disabled.', 'brisk'), 403);
	}

	//Requesting Hidden Login Form - Path Mismatch
	if($pagenow === 'wp-login.php' && $URI['path'] !== brisk_trailingslashit($URI['path']) && get_option('permalink_structure')) {

		//Local Redirect to Hidden Login URL
		$URL = brisk_trailingslashit(brisk_login_url()) . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
		wp_safe_redirect($URL);
		die();
	}
	//Requesting wp-login.php Directly, Disabled
	elseif($brisk_wp_login) {
		wp_die(__('This has been disabled.', 'brisk'), 403);
	} 
	//Requesting Hidden Login Form
	elseif($pagenow === 'wp-login.php') {

		//Declare Global Variables
		global $error, $interim_login, $action, $user_login;
		
		//User Already Logged In
		if(is_user_logged_in() && !isset($_REQUEST['action'])) {
			wp_safe_redirect(admin_url());
			die();
		}

		//Include Login Form
		@require_once ABSPATH . 'wp-login.php';
		die();
	}
}

function brisk_disable_customize_php() {

	//Declare Global Variable
	global $pagenow;

	//Disable customize.php from Redirecting to Login URL
	if(!is_user_logged_in() && $pagenow === 'customize.php') {
		wp_die(__('This has been disabled.', 'brisk'), 403);
	}
}

function brisk_welcome_email($value) {

	//Declare Global Variable
	global $brisk_options;

	//Check for Custom Login URL and Replace
	if(!empty($brisk_options['login_url'])) {
		$value = str_replace(array('wp-login.php', 'wp-admin'), trailingslashit($brisk_options['login_url']), $value);
	}

	return $value;
}

function brisk_admin_url($url) {

	//Check for Multisite Admin
	if(is_multisite() && ms_is_switched() && is_admin()) {

		global $current_blog;

		//Get Current Switched Blog
		$switched_blog_id = get_current_blog_id();

		if($switched_blog_id != $current_blog->blog_id) {

			$brisk_blog_options = get_blog_option($switched_blog_id, 'brisk_options');

			//Swap Custom Login URL Only with Base /wp-admin/ Links
			if(!empty($brisk_blog_options['login_url'])) {
				$url = preg_replace('/\/wp-admin\/$/', '/' . $brisk_blog_options['login_url'] . '/', $url);
			} 
		}
	}

	return $url;
}

/* CDN Rewrite URLs */
if(!empty($brisk_cdn['enable_cdn']) && $brisk_cdn['enable_cdn'] == "1" && !empty($brisk_cdn['cdn_url'])) {
	add_action('template_redirect', 'brisk_cdn_rewrite');
}

function brisk_cdn_rewrite() {
	ob_start('brisk_cdn_rewriter');
}

function brisk_cdn_rewriter($html) {
	global $brisk_cdn;

	//Prep Site URL
    $escapedSiteURL = quotemeta(get_option('home'));
	$regExURL = '(https?:|)' . substr($escapedSiteURL, strpos($escapedSiteURL, '//'));

	//Prep Included Directories
	$directories = 'wp\-content|wp\-includes';
	if(!empty($brisk_cdn['cdn_directories'])) {
		$directoriesArray = array_map('trim', explode(',', $brisk_cdn['cdn_directories']));
		if(count($directoriesArray) > 0) {
			$directories = implode('|', array_map('quotemeta', array_filter($directoriesArray)));
		}
	}
  
  	//Rewrite URLs + Return
	$regEx = '#(?<=[(\"\'])(?:' . $regExURL . ')?/(?:((?:' . $directories . ')[^\"\')]+)|([^/\"\']+\.[^/\"\')]+))(?=[\"\')])#';
	$cdnHTML = preg_replace_callback($regEx, 'brisk_cdn_rewrite_url', $html);
	return $cdnHTML;
}

function brisk_cdn_rewrite_url($url) {
	global $brisk_cdn;

	//Make Sure CDN URL is Set
	if(!empty($brisk_cdn['cdn_url'])) {

		//Don't Rewrite if Excluded
		if(!empty($brisk_cdn['cdn_exclusions'])) {
			$exclusions = array_map('trim', explode(',', $brisk_cdn['cdn_exclusions']));
			foreach($exclusions as $exclusion) {
	            if(!empty($exclusion) && stristr($url[0], $exclusion) != false) {
	                return $url[0];
	            }
	        }
		} 

	    //Don't Rewrite if Previewing
	    if(is_admin_bar_showing() && isset($_GET['preview']) && $_GET['preview'] == 'true') {
	        return $url[0];
	    }

	    //Prep Site URL
	    $siteURL = get_option('home');
	    $siteURL = substr($siteURL, strpos($siteURL, '//'));

	    //Replace URL w/ No HTTP/S Prefix
	    if(strpos($url[0], '//') === 0) {
	        return str_replace($siteURL, $brisk_cdn['cdn_url'], $url[0]);
	    }

	    //Found Site URL, Replace Non Relative URL w/ HTTP/S Prefix
	    if(strstr($url[0], $siteURL)) {
	        return str_replace(array('http:' . $siteURL, 'https:' . $siteURL), $brisk_cdn['cdn_url'], $url[0]);
	    }

	    //Replace Relative URL
    	return $brisk_cdn['cdn_url'] . $url[0];
    }

    //Return Original URL
    return $url[0];
}

/* Google Analytics */

//enable/disable local analytics scheduled event
if(!empty($brisk_ga['enable_local_ga']) && $brisk_ga['enable_local_ga'] == "1") {
	if(!wp_next_scheduled('brisk_update_ga')) {
		wp_schedule_event(time(), 'daily', 'brisk_update_ga');
	}

	if(!empty($brisk_ga['use_monster_insights']) && $brisk_ga['use_monster_insights'] == "1") {
		add_filter('monsterinsights_frontend_output_analytics_src', 'brisk_monster_ga', 1000);
	}
	else {
		if(!empty($brisk_ga['tracking_code_position']) && $brisk_ga['tracking_code_position'] == 'footer') {
			$tracking_code_position = 'wp_footer';
		}
		else {
			$tracking_code_position = 'wp_head';
		}
		add_action($tracking_code_position, 'brisk_print_ga', 0);
	}
}
else {
	if(wp_next_scheduled('brisk_update_ga')) {
		wp_clear_scheduled_hook('brisk_update_ga');
	}
}

//update analytics.js
function brisk_update_ga() {
	//paths
	$local_file = dirname(dirname(__FILE__)) . '/js/analytics.js';
	$host = 'www.google-analytics.com';
	$path = '/analytics.js';

	//open connection
	$fp = @fsockopen($host, '80', $errno, $errstr, 10);

	if($fp){	
		//send headers
		$header = "GET $path HTTP/1.0\r\n";
		$header.= "Host: $host\r\n";
		$header.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6\r\n";
		$header.= "Accept: */*\r\n";
		$header.= "Accept-Language: en-us,en;q=0.5\r\n";
		$header.= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
		$header.= "Keep-Alive: 300\r\n";
		$header.= "Connection: keep-alive\r\n";
		$header.= "Referer: https://$host\r\n\r\n";
		fwrite($fp, $header);
		$response = '';
		
		//get response
		while($line = fread($fp, 4096)) {
			$response.= $line;
		}

		//close connection
		fclose($fp);

		//remove headers
		$position = strpos($response, "\r\n\r\n");
		$response = substr($response, $position + 4);

		//create file if needed
		if(!file_exists($local_file)) {
			fopen($local_file, 'w');
		}

		//write response to file
		if(is_writable($local_file)) {
			if($fp = fopen($local_file, 'w')) {
				fwrite($fp, $response);
				fclose($fp);
			}
		}
	}
}
add_action('brisk_update_ga', 'brisk_update_ga');

//print analytics script
function brisk_print_ga() {
	global $brisk_ga;

	//dont print for logged in admins
	if(current_user_can('manage_options') && empty($brisk_ga['track_admins'])) {
		return;
	}

	if(!empty($brisk_ga['tracking_id'])) {
		echo "<!-- Local Analytics generated with brisk. -->";
		echo "<script>";
		    echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','" . plugins_url() . "/brisk/js/analytics.js','ga');";
		    echo "ga('create', '" . $brisk_ga['tracking_id'] . "', 'auto');";

		    //disable display features
		    if(!empty($brisk_ga['disable_display_features']) && $brisk_ga['disable_display_features'] == "1") {
		    	echo "ga('set', 'allowAdFeatures', false);";
		    }

		    //anonymize ip
		   	if(!empty($brisk_ga['anonymize_ip']) && $brisk_ga['anonymize_ip'] == "1") {
		   		echo "ga('set', 'anonymizeIp', true);";
		   	}

		    echo "ga('send', 'pageview');";

		    //adjusted bounce rate
		    if(!empty($brisk_ga['adjusted_bounce_rate'])) {
		    	echo 'setTimeout("ga(' . "'send','event','adjusted bounce rate','" . $brisk_ga['adjusted_bounce_rate'] . " seconds')" . '"' . "," . $brisk_ga['adjusted_bounce_rate'] * 1000 . ");";
		    }
	    echo "</script>";
	}
}

//return local anlytics url for Monster Insights
function brisk_monster_ga($url) {
	return plugins_url() . "/brisk/js/analytics.js";
}

/* Script Manager */

//Script Manager Admin Bar Link
function brisk_script_manager_admin_bar($wp_admin_bar) {

	//check for proper access
	if(!current_user_can('manage_options') || !brisk_network_access()) {
		return;
	}

	if(is_admin()) {
		if(function_exists('get_current_screen')) {
			$current_screen = get_current_screen();
			$permalink = get_permalink();
			if($current_screen->base == 'post' && $current_screen->action != 'add' && !empty($permalink)) {
				$href = add_query_arg('brisk', '', $permalink);
				$menu_text = __('Script Manager', 'brisk');
			}
			else {
				return;
			}
		}
		else {
			return;
		}
	}
	else {
		global $wp;

		$href = add_query_arg(str_replace(array('&brisk', 'brisk'), '', $_SERVER['QUERY_STRING']), '', home_url($wp->request));

		if(!isset($_GET['brisk'])) {
			$href.= !empty($_SERVER['QUERY_STRING']) ? '&brisk' : '?brisk';
			$menu_text = __('Brisk', 'brisk');
		}
		else {
			$menu_text = __('Close Brisk', 'brisk');
		}
	}

	//build node and add to admin bar
	if(!empty($menu_text) && !empty($href)) {
		$args = array(
			'id'    => 'brisk_script_manager',
			'title' => $menu_text,
			'href'  => $href
		);
		$wp_admin_bar->add_node($args);
	}
}
 
function brisk_script_manager_row_actions($actions, $post) {

	//check for proper access
	if(!current_user_can('manage_options') || !brisk_network_access()) {
		return $actions;
	}

	//get post permalink
	$permalink = get_permalink($post->ID);

	if(!empty($permalink)) {

		//add brisk query arg
    	$script_manager_link = add_query_arg('brisk', '', $permalink);

    	//merge link array with existing row actions
	    $actions = array_merge($actions, array(
	        'script_manager' => sprintf('<a href="%1$s">%2$s</a>', esc_url($script_manager_link), __('Brisk', 'brisk'))
	    ));
	}
 
    return $actions;
}

//Script Manager Front End
function brisk_script_manager() {
	require_once('script_manager.php');
}

//Script Manager Scripts
function brisk_script_manager_scripts() {
	if(!current_user_can('manage_options') || is_admin() || !isset($_GET['brisk']) || !brisk_network_access()) {
		return;
	}
	wp_register_script('brisk-script-manager-js', plugins_url('js/script-manager.js', dirname(__FILE__)), array('jquery-core'));
	wp_enqueue_script('brisk-script-manager-js');
}

//Script Manager Force Admin Bar
function brisk_script_manager_force_admin_bar() {
	if(!current_user_can('manage_options') || is_admin() || !isset($_GET['brisk']) || !brisk_network_access() || is_admin_bar_showing()) {
		return;
	}
	add_filter('show_admin_bar', '__return_true' , 9999);
}

function brisk_script_manager_load_master_array() {

	if(!function_exists('get_plugins')) {
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	}

	global $wp_scripts;
	global $wp_styles;

	$master_array = array('plugins' => array(), 'themes' => array(), 'WordPress Core' => array());

	$brisk_filters = array(
		"js" => array (
			"title" => "JS",
			"scripts" => $wp_scripts
		),
		"css" => array(
			"title" => "CSS",
			"scripts" => $wp_styles
		)
	);

	$loaded_plugins = array();
	$loaded_themes = array();

	foreach($brisk_filters as $type => $data) {

		if(!empty($data["scripts"]->done)) {
			$plug_org_scripts = array_unique($data["scripts"]->done);

			uasort($plug_org_scripts, function($a, $b) use ($type) {
				global $brisk_filters;
			    if($brisk_filters[$type]['scripts']->registered[$a]->src == $brisk_filters[$type]['scripts']->registered[$b]->src) {
			        return 0;
			    }
			    return ($brisk_filters[$type]['scripts']->registered[$a]->src < $brisk_filters[$type]['scripts']->registered[$b]->src) ? -1 : 1;
			});

			foreach($plug_org_scripts as $key => $val) {
				$src = $brisk_filters[$type]['scripts']->registered[$val]->src;

				if(strpos($src, "/wp-content/plugins/") !== false) {
					$explode = explode("/wp-content/plugins/", $src);
					$explode = explode('/', $explode[1]);
					if(!array_key_exists($explode[0], $loaded_plugins)) {
						$file_plugin = get_plugins('/' . $explode[0]);
						$loaded_plugins[$explode[0]] = $file_plugin;
						$master_array['plugins'][$explode[0]] = array('name' => $file_plugin[key($file_plugin)]['Name']);
					}
					else {
						$file_plugin = $loaded_plugins[$explode[0]];
					}
			    	$master_array['plugins'][$explode[0]]['assets'][] = array('type' => $type, 'handle' => $val);
			    }
			    elseif(strpos($src, "/wp-content/themes/") !== false) {
					$explode = explode("/wp-content/themes/", $src);
					$explode = explode('/', $explode[1]);
					if(!array_key_exists($explode[0], $loaded_themes)) {
						$file_theme = wp_get_theme('/' . $explode[0]);
						$loaded_themes[$explode[0]] = $file_theme;
						$master_array['themes'][$explode[0]] = array('name' => $file_theme->get('Name'));
					}
					else {
						$file_theme = $loaded_themes[$explode[0]];
					}
					
			    	$master_array['themes'][$explode[0]]['assets'][] = array('type' => $type, 'handle' => $val);
			    }
			    else {
			    	$master_array['WordPress Core'][] = array('type' => $type, 'handle' => $val);
			    }
			}
		}
	}
	if(isset($master_array['plugins']['brisk'])) {
		unset($master_array['plugins']['brisk']);
	}
	return $master_array;
}

function brisk_script_manager_print_section($category, $group, $scripts) {
	global $brisk_script_manager_options;
	global $currentID;

	$options = $brisk_script_manager_options;

	$statusDisabled = false;
	if(isset($options['disabled'][$category][$group]['everywhere']) || (isset($options['disabled'][$category][$group]['current']) && in_array($currentID, $options['disabled'][$category][$group]['current'], TRUE)) || !empty($options['disabled'][$category][$group]['regex'])) {
		$statusDisabled = true;
	}

	echo "<div class='brisk-script-manager-section'>";
		echo "<table " . ($statusDisabled ? "style='display: none;'" : "") . ">";
			echo "<thead>";
				echo "<tr>";
					echo "<th style='width: 85px;'>" . __('Status', 'brisk') . "</th>";
					echo "<th style=''>" . __('Script', 'brisk') . "</th>";
					echo "<th style='width: 50px; text-align: center;'>" . __('Type', 'brisk') . "</th>";
					echo "<th style='width: 65px; text-align: center;'>" . __('Size', 'brisk') . "</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach($scripts as $key => $details) {
					brisk_script_manager_print_script($category, $group, $details['handle'], $details['type']);
				}
			echo "</tbody>";
		echo "</table>";

		if($category != "WordPress Core") {
			
			echo "<div class='brisk-script-manager-assets-disabled' " . (!$statusDisabled ? "style='display: none;'" : "") . ">";

				echo "<div class='brisk-script-manager-controls'>";

					//Disable
					brisk_script_manager_print_disable($category, $group);

					//Enable
					brisk_script_manager_print_enable($category, $group);

				echo "</div>";

			echo "</div>";
		}
	echo "</div>";
}


function brisk_script_manager_print_script($category, $group, $script, $type) {

	global $brisk_advanced;
	global $brisk_script_manager_settings;
	global $brisk_filters;
	global $brisk_disables;
	global $brisk_script_manager_options;
	global $currentID;
	global $statusDisabled;
	global $pmsm_jquery_disabled;

	$options = $brisk_script_manager_options;

	$data = $brisk_filters[$type];

	if(!empty($data["scripts"]->registered[$script]->src)) {

		//Check for disables already set
		if(!empty($brisk_disables)) {
			foreach($brisk_disables as $key => $val) {
				if(strpos($data["scripts"]->registered[$script]->src, $val) !== false) {
					//continue 2;
					return;
				}
			}
		}

		$handle = $data["scripts"]->registered[$script]->handle;
		echo "<tr>";	

			//Status
			echo "<td class='brisk-script-manager-status'>";

				brisk_script_manager_print_status($type, $handle);

			echo "</td>";

			//Script Cell
			echo "<td class='brisk-script-manager-script'>";

				//Script Handle
				echo "<span>" . $handle . "</span>";

				//Script Path
				echo "<a href='" . $data["scripts"]->registered[$script]->src . "' target='_blank'>" . str_replace(get_home_url(), '', $data["scripts"]->registered[$script]->src) . "</a>";

				echo "<div class='brisk-script-manager-controls' " . (!$statusDisabled ? "style='display: none;'" : "") . ">";

					//Disable
					brisk_script_manager_print_disable($type, $handle);

					//Enable
					brisk_script_manager_print_enable($type, $handle);

				echo "</div>";

				if($category != "core") {
					echo "<input type='hidden' name='relations[" . $type . "][" . $handle . "][category]' value='" . $category . "' />";
					echo "<input type='hidden' name='relations[" . $type . "][" . $handle . "][group]' value='" . $group . "' />";
				}

				//jquery override message
				if($type == 'js' && $handle == 'jquery-core' && $pmsm_jquery_disabled) {
					echo "<div id='jquery-message'>jQuery has been temporarily enabled in order for the Script Manager to function properly.</div>";
				}
				
			echo "</td>";

			//Type
			echo "<td class='brisk-script-manager-type'>";
				if(!empty($type)) {
					echo $type;
				}
			echo "</td>";

			//Size					
			echo "<td class='brisk-script-manager-size'>";
				if(file_exists(ABSPATH . str_replace(get_home_url(), '', $data["scripts"]->registered[$script]->src))) {
					echo round(filesize(ABSPATH . str_replace(get_home_url(), '', $data["scripts"]->registered[$script]->src)) / 1024, 1 ) . ' KB';
				}
			echo "</td>";

		echo "</tr>";

	}
}

function brisk_script_manager_print_status($type, $handle) {
	global $brisk_advanced;
	global $brisk_script_manager_options;
	global $currentID;
	$options = $brisk_script_manager_options;

	global $statusDisabled;

	$statusDisabled = false;
	if(isset($options['disabled'][$type][$handle]['everywhere']) || (isset($options['disabled'][$type][$handle]['current']) && in_array($currentID, $options['disabled'][$type][$handle]['current'], TRUE)) || !empty($options['disabled'][$type][$handle]['regex'])) {
		$statusDisabled = true;
	}
	if(!empty($brisk_advanced['accessibility_mode']) && $brisk_advanced['accessibility_mode'] == "1") {
		echo "<select name='status[" . $type . "][" . $handle . "]' class='brisk-status-select " . ($statusDisabled ? "disabled" : "") . "'>";
			echo "<option value='enabled' class='brisk-option-enabled'>" . __('ON', 'brisk') . "</option>";
			echo "<option value='disabled' class='brisk-option-everywhere' " . ($statusDisabled ? "selected" : "") . ">" . __('OFF', 'brisk') . "</option>";
		echo "</select>";
	}
	else {
		echo "<input type='hidden' name='status[" . $type . "][" . $handle . "]' value='enabled' />";
        echo "<label for='status_" . $type . "_" . $handle . "' class='brisk-script-manager-switch'>";
        	echo "<input type='checkbox' id='status_" . $type . "_" . $handle . "' name='status[" . $type . "][" . $handle . "]' value='disabled' " . ($statusDisabled ? "checked" : "") . " class='brisk-status-toggle'>";
        	echo "<div class='brisk-script-manager-slider'></div>";
       	echo "</label>";
	}
}

function brisk_script_manager_print_disable($type, $handle) {
	global $brisk_script_manager_settings;
	global $brisk_script_manager_options;
	global $currentID;
	$options = $brisk_script_manager_options;

	echo "<div class='brisk-script-manager-disable'>";
		echo "<div style='/* font-size: 16px; */display:  inline-block;padding-right: 10px;padding-left: 10px;'>" . __('Disable', 'brisk') . "</div>";
		echo "<label for='disabled-" . $type . "-" . $handle . "-current'>";
			echo "<input type='radio' name='disabled[" . $type . "][" . $handle . "]' id='disabled-" . $type . "-" . $handle . "-current' class='brisk-disable-select' value='current' ";
			echo (isset($options['disabled'][$type][$handle]['current']) && in_array($currentID, $options['disabled'][$type][$handle]['current'], TRUE) ? "checked" : "");
			echo " />";
			echo __('On This Page', 'brisk');
		echo "</label>";
		
		echo "<label for='disabled-" . $type . "-" . $handle . "-everywhere'>";
			echo "<input type='radio' name='disabled[" . $type . "][" . $handle . "]' id='disabled-" . $type . "-" . $handle . "-everywhere' class='brisk-disable-select' value='everywhere' ";
			echo (!empty($options['disabled'][$type][$handle]['everywhere']) ? "checked" : "");
			echo " />";
			echo __('On All Pages', 'brisk');
		echo "</label>";

		

		//if(!empty($brisk_script_manager_settings['pattern_matching']) && $brisk_script_manager_settings['pattern_matching'] == "1") {
			echo "<label for='disabled-" . $type . "-" . $handle . "-regex'>";
				echo "<input type='radio' name='disabled[" . $type . "][" . $handle . "]' id='disabled-" . $type . "-" . $handle . "-regex' class='brisk-disable-select' value='regex' ";
				echo (!empty($options['disabled'][$type][$handle]['regex']) ? "checked" : "");
				echo " />";
				echo __('Regex', 'brisk');
			echo "</label>";

			echo "<div class='pmsm-disable-regex'" . (empty($options['disabled'][$type][$handle]['regex']) ? " style='display: none;'" : "") . ">";
				echo "<label for='disabled-" . $type . "-" . $handle . "-regex-value'>";
					echo "<span style='display: block; font-size: 10px; font-weight: bold; margin: 5px 0px 0px 15px;'>" . __('Regex', 'brisk') . "</span>";
					echo "<input type='text' name='regex[disabled][" . $type . "][" . $handle . "]' id='disabled-" . $type . "-" . $handle . "-regex-value' class='brisk-disable-select' value='" . (!empty($options['disabled'][$type][$handle]['regex']) ? esc_attr($options['disabled'][$type][$handle]['regex']) : "") . "' />";
				echo "</label>";
			echo "</div>";
		//}
	echo "</div>";
}

function brisk_script_manager_print_enable($type, $handle) {
	global $brisk_script_manager_settings;
	global $brisk_script_manager_options;
	global $currentID;

	$options = $brisk_script_manager_options;

	echo "<div class='brisk-script-manager-enable'"; if(empty($options['disabled'][$type][$handle]['everywhere'])) { echo " style='display: none;'"; } echo">";

		echo "<div style='font-size: 16px;'>" . __('Exceptions', 'brisk') . "</div>";

		//Current URL
		echo "<input type='hidden' name='enabled[" . $type . "][" . $handle . "][current]' value='' />";
		echo "<label for='" . $type . "-" . $handle . "-enable-current'>";
			echo "<input type='checkbox' name='enabled[" . $type . "][" . $handle . "][current]' id='" . $type . "-" . $handle . "-enable-current' value='" . $currentID ."' ";
				if(isset($options['enabled'][$type][$handle]['current'])) {
					if(in_array($currentID, $options['enabled'][$type][$handle]['current'])) {
						echo "checked";
					}
				}
			echo " />" . __('Current URL', 'brisk');
		echo "</label>";

		//Post Types
		echo "<span style='display: block; font-size: 10px; font-weight: bold; margin: 0px;'>Post Types:</span>";
		$post_types = get_post_types(array('public' => true), 'objects', 'and');
		if(!empty($post_types)) {
			if(isset($post_types['attachment'])) {
				unset($post_types['attachment']);
			}
			echo "<input type='hidden' name='enabled[" . $type . "][" . $handle . "][post_types]' value='' />";
			foreach($post_types as $key => $value) {
				echo "<label for='" . $type . "-" . $handle . "-enable-" . $key . "'>";
					echo "<input type='checkbox' name='enabled[" . $type . "][" . $handle . "][post_types][]' id='" . $type . "-" . $handle . "-enable-" . $key . "' value='" . $key ."' ";
						if(isset($options['enabled'][$type][$handle]['post_types'])) {
							if(in_array($key, $options['enabled'][$type][$handle]['post_types'])) {
								echo "checked";
							}
						}
					echo " />" . $value->label;
				echo "</label>";
			}
		}

		//Archives
		if(!empty($brisk_script_manager_settings['separate_archives']) && $brisk_script_manager_settings['separate_archives'] == "1") {
			echo "<span style='display: block; font-size: 10px; font-weight: bold; margin: 0px;'>Archives:</span>";
			echo "<input type='hidden' name='enabled[" . $type . "][" . $handle . "][archives]' value='' />";

			//Built-In Tax Archives
			//$wp_archives = array('category' => 'Categories', 'post_tag' => 'Tags', 'author' => 'Authors', 'date' => 'Dates');
			$wp_archives = array('category' => 'Categories', 'post_tag' => 'Tags', 'author' => 'Authors');
			foreach($wp_archives as $key => $value) {
				echo "<label for='" . $type . "-" . $handle . "-enable-archive-" . $key . "' title='" . $key . " (WordPress Taxonomy Archive)'>";
					echo "<input type='checkbox' name='enabled[" . $type . "][" . $handle . "][archives][]' id='" . $type . "-" . $handle . "-enable-archive-" . $key . "' value='" . $key ."' ";
						if(isset($options['enabled'][$type][$handle]['archives'])) {
							if(in_array($key, $options['enabled'][$type][$handle]['archives'])) {
								echo "checked";
							}
						}
					echo " />" . $value;
				echo "</label>";
			}

			//Custom Tax Archives
			$taxonomies = get_taxonomies(array('public' => true, '_builtin' => false), 'objects', 'and');
			if(!empty($taxonomies)) {
				foreach($taxonomies as $key => $value) {
					echo "<label for='" . $type . "-" . $handle . "-enable-archive-" . $key . "' title='" . $key . " (Custom Taxonomy Archive)'>";
						echo "<input type='checkbox' name='enabled[" . $type . "][" . $handle . "][archives][]' id='" . $type . "-" . $handle . "-enable-archive-" . $key . "' value='" . $key ."' ";
							if(isset($options['enabled'][$type][$handle]['archives'])) {
								if(in_array($key, $options['enabled'][$type][$handle]['archives'])) {
									echo "checked";
								}
							}
						echo " />" . $value->label;
					echo "</label>";
				}
			}

			//Post Type Archives
			$archive_post_types = get_post_types(array('public' => true, 'has_archive' => true), 'objects', 'and');
			if(!empty($archive_post_types)) {
				foreach($archive_post_types as $key => $value) {
					echo "<label for='" . $type . "-" . $handle . "-enable-archive-" . $key . "' title='" . $key . " (Post Type Archive)'>";
						echo "<input type='checkbox' name='enabled[" . $type . "][" . $handle . "][archives][]' id='" . $type . "-" . $handle . "-enable-archive-" . $key . "' value='" . $key ."' ";
							if(isset($options['enabled'][$type][$handle]['archives'])) {
								if(in_array($key, $options['enabled'][$type][$handle]['archives'])) {
									echo "checked";
								}
							}
						echo " />" . $value->label;
					echo "</label>";
				}
			}
		}

		//Regex
		echo "<div class='pmsm-enable-regex'>";
			echo "<label for='" . $type . "-" . $handle . "-enable-regex-value'>";
				echo "<span style='display: block; font-size: 10px; font-weight: bold; margin: 0px;'>" . __('Regex', 'brisk') . "</span>";
				echo "<input type='text' name='regex[enabled][" . $type . "][" . $handle . "]' id='" . $type . "-" . $handle . "enable-regex-value' value='" . (!empty($options['enabled'][$type][$handle]['regex']) ? esc_attr($options['enabled'][$type][$handle]['regex']) : "") . "' />";
			echo "</label>";
		echo "</div>";

	echo "</div>";
}


function brisk_script_manager_update() {

	if(isset($_GET['brisk']) && !empty($_POST['brisk_script_manager'])) {

		$currentID = brisk_get_current_ID();

		$brisk_filters = array("js", "css", "plugins", "themes");

		$options = get_option('brisk_script_manager');
		$settings = get_option('brisk_script_manager_settings');

		foreach($brisk_filters as $type) {

			if(isset($_POST['disabled'][$type])) {

				foreach($_POST['disabled'][$type] as $handle => $value) {

					$groupDisabled = false;
					if(isset($_POST['relations'][$type][$handle])) {
						$relationInfo = $_POST['relations'][$type][$handle];
						if($_POST['status'][$relationInfo['category']][$relationInfo['group']] == "disabled" && isset($_POST['disabled'][$relationInfo['category']][$relationInfo['group']])) {
							$groupDisabled = true;
						}
					}

					if(!$groupDisabled && $_POST['status'][$type][$handle] == 'disabled' && !empty($value)) {
						if($value == "everywhere") {
							$options['disabled'][$type][$handle]['everywhere'] = 1;
							if(!empty($options['disabled'][$type][$handle]['current'])) {
								unset($options['disabled'][$type][$handle]['current']);
							}
							if(isset($options['disabled'][$type][$handle]['regex'])) {
								unset($options['disabled'][$type][$handle]['regex']);
							}
						}
						elseif($value == "current") {
							if(isset($options['disabled'][$type][$handle]['everywhere'])) {
								unset($options['disabled'][$type][$handle]['everywhere']);
							}
							if(isset($options['disabled'][$type][$handle]['regex'])) {
								unset($options['disabled'][$type][$handle]['regex']);
							}
							if(!is_array($options['disabled'][$type][$handle]['current'])) {
								$options['disabled'][$type][$handle]['current'] = array();
							}
							if(!in_array($currentID, $options['disabled'][$type][$handle]['current'], TRUE)) {
								array_push($options['disabled'][$type][$handle]['current'], $currentID);
							}
						}
						elseif($value == "regex") {
							if(!empty($_POST['regex']['disabled'][$type][$handle])) {
								if(isset($options['disabled'][$type][$handle]['everywhere'])) {
									unset($options['disabled'][$type][$handle]['everywhere']);
								}
								if(!empty($options['disabled'][$type][$handle]['current'])) {
									unset($options['disabled'][$type][$handle]['current']);
								}
								$options['disabled'][$type][$handle]['regex'] = stripslashes($_POST['regex']['disabled'][$type][$handle]);
							}
							else {
								if(isset($options['disabled'][$type][$handle]['regex'])) {
									unset($options['disabled'][$type][$handle]['regex']);
								}
							}
						}
					}
					else {
						unset($options['disabled'][$type][$handle]['everywhere']);
						if(isset($options['disabled'][$type][$handle]['current'])) {
							$current_key = array_search($currentID, $options['disabled'][$type][$handle]['current']);
							if($current_key !== false) {
								unset($options['disabled'][$type][$handle]['current'][$current_key]);
								if(empty($options['disabled'][$type][$handle]['current'])) {
									unset($options['disabled'][$type][$handle]['current']);
								}
							}
						}
						if(isset($options['disabled'][$type][$handle]['regex'])) {
							unset($options['disabled'][$type][$handle]['regex']);
						}
					}

					if(empty($options['disabled'][$type][$handle])) {
						unset($options['disabled'][$type][$handle]);
						if(empty($options['disabled'][$type])) {
							unset($options['disabled'][$type]);
							if(empty($options['disabled'])) {
								unset($options['disabled']);
							}
						}
					}
				}
			}

			if(isset($_POST['enabled'][$type])) {

				foreach($_POST['enabled'][$type] as $handle => $value) {

					$groupDisabled = false;
					if(isset($_POST['relations'][$type][$handle])) {
						$relationInfo = $_POST['relations'][$type][$handle];
						if($_POST['status'][$relationInfo['category']][$relationInfo['group']] == "disabled" && isset($_POST['disabled'][$relationInfo['category']][$relationInfo['group']])) {
							$groupDisabled = true;
						}
					}

					if(!$groupDisabled && $_POST['status'][$type][$handle] == 'disabled' && (!empty($value['current']) || $value['current'] === "0")) {
						if(!is_array($options['enabled'][$type][$handle]['current'])) {
							$options['enabled'][$type][$handle]['current'] = array();
						}
						if(!in_array($value['current'], $options['enabled'][$type][$handle]['current'], TRUE)) {
							array_push($options['enabled'][$type][$handle]['current'], $value['current']);
						}
					}
					else {
						if(isset($options['enabled'][$type][$handle]['current'])) {
							$current_key = array_search($currentID, $options['enabled'][$type][$handle]['current']);
							if($current_key !== false) {
								unset($options['enabled'][$type][$handle]['current'][$current_key]);
								if(empty($options['enabled'][$type][$handle]['current'])) {
									unset($options['enabled'][$type][$handle]['current']);
								}
							}
						}
					}

					if(!$groupDisabled && $_POST['status'][$type][$handle] == 'disabled' && !empty($value['post_types'])) {
						$options['enabled'][$type][$handle]['post_types'] = array();
						foreach($value['post_types'] as $key => $post_type) {
							if(isset($options['enabled'][$type][$handle]['post_types'])) {
								if(!in_array($post_type, $options['enabled'][$type][$handle]['post_types'])) {
									array_push($options['enabled'][$type][$handle]['post_types'], $post_type);
								}
							}
						}
					}
					else {
						unset($options['enabled'][$type][$handle]['post_types']);
					}

					if(!empty($settings['separate_archives']) && $settings['separate_archives'] == "1") {
						if(is_array($value['archives'])) {
							$value['archives'] = array_filter($value['archives']);
						}
						if(!$groupDisabled && $_POST['status'][$type][$handle] == 'disabled' && !empty($value['archives'])) {
							$options['enabled'][$type][$handle]['archives'] = array();
							foreach($value['archives'] as $key => $archive) {
								if(!in_array($archive, $options['enabled'][$type][$handle]['archives'])) {
									array_push($options['enabled'][$type][$handle]['archives'], $archive);
								}
							}
						}
						else {
							unset($options['enabled'][$type][$handle]['archives']);
						}
					}

					if(!$groupDisabled && $_POST['status'][$type][$handle] == 'disabled' && !empty($_POST['regex']['enabled'][$type][$handle])) {
						$options['enabled'][$type][$handle]['regex'] = stripslashes($_POST['regex']['enabled'][$type][$handle]);
					}
					else {
						unset($options['enabled'][$type][$handle]['regex']);
					}

					//filter out empty child arrays
					if(empty($options['enabled'][$type][$handle])) {
						unset($options['enabled'][$type][$handle]);
						if(empty($options['enabled'][$type])) {
							unset($options['enabled'][$type]);
							if(empty($options['enabled'])) {
								unset($options['enabled']);
							}
						}
					}
				}
			}
		}
		update_option('brisk_script_manager', $options);
	}
}

function brisk_script_manager_update_option($old_value, $value, $option) {
	add_action('wp_footer', function(){
		echo "<script>
        	var currentMessage = jQuery('.brisk-script-manager-message').html();
			jQuery('.brisk-script-manager-message').html('<span style=\"color: #27ae60;\">" . __('Settings Saved!', 'brisk') . "</span>').delay(1000).animate({'opacity': 0}, 500, function () {
			    jQuery(this).html(currentMessage);
			}).animate({'opacity': 1}, 500);
        </script>";    
	}, 9999);
}

function brisk_dequeue_scripts($src, $handle) {
	if(is_admin()) {
		return $src;
	}

	//get script type
	$type = current_filter() == 'script_loader_src' ? "js" : "css";

	//load options
	$options = get_option('brisk_script_manager');
	$settings = get_option('brisk_script_manager_settings');
	$currentID = brisk_get_current_ID();

	//get category + group from src
	preg_match('/\/wp-content\/(.*?\/.*?)\//', $src, $match);
	if(!empty($match[1])) {
		$match = explode("/", $match[1]);
		$category = $match[0];
		$group = $match[1];
	}

	//check for group disable settings and override
	if(!empty($category) && !empty($group) && isset($options['disabled'][$category][$group])) {
		$type = $category;
		$handle = $group;
	}

	//disable is set, check options
	if((!empty($options['disabled'][$type][$handle]['everywhere']) && $options['disabled'][$type][$handle]['everywhere'] == 1) || (!empty($options['disabled'][$type][$handle]['current']) && in_array($currentID, $options['disabled'][$type][$handle]['current'])) || !empty($options['disabled'][$type][$handle]['regex'])) {

		//jquery override
		if($handle == 'jquery-core' && $type == 'js' && isset($_GET['brisk']) && current_user_can('manage_options')) {
			global $pmsm_jquery_disabled;
			$pmsm_jquery_disabled = true;
			return $src;
		}
	
		//current url check
		if(!empty($options['enabled'][$type][$handle]['current']) && in_array($currentID, $options['enabled'][$type][$handle]['current'])) {
			return $src;
		}

		//regex check
		if(!empty($options['disabled'][$type][$handle]['regex'])) {
			global $wp;
  			$current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));
			if(!preg_match($options['disabled'][$type][$handle]['regex'], $current_url)) {
				return $src;
			}
			else {
				return false;
			}
		}

		if(!empty($options['enabled'][$type][$handle]['regex'])) {
			global $wp;
  			$current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));
  			if(preg_match($options['enabled'][$type][$handle]['regex'], $current_url)) {
				return $src;
			}
		}

		if(!empty($settings['separate_archives']) && $settings['separate_archives'] == "1") {
			if(is_archive()) {
				$object = get_queried_object();
				if(!empty($object)) {
					$objectClass = get_class($object);
					if($objectClass == "WP_Post_Type") {
						if(!empty($options['enabled'][$type][$handle]['archives']) && in_array($object->name, $options['enabled'][$type][$handle]['archives'])) {
							return $src;
						}
						else {
							return false;
						}
					}
					elseif($objectClass == "WP_User")
					{
						if(!empty($options['enabled'][$type][$handle]['archives']) && in_array("author", $options['enabled'][$type][$handle]['archives'])) {
							return $src;
						}
						else {
							return false;
						}
					}
					else {
						if(!empty($options['enabled'][$type][$handle]['archives']) && in_array($object->taxonomy, $options['enabled'][$type][$handle]['archives'])) {
							return $src;
						}
						else {
							return false;
						}
					}
				}
			}
		}

		if(is_front_page() || is_home()) {
			if(get_option('show_on_front') == 'page' && !empty($options['enabled'][$type][$handle]['post_types']) && in_array('page', $options['enabled'][$type][$handle]['post_types'])) {
				return $src;
			}
		}
		else {
			if(!empty($options['enabled'][$type][$handle]['post_types']) && in_array(get_post_type(), $options['enabled'][$type][$handle]['post_types'])) {
				return $src;
			}
		}

		return false;
	}

	//original script src
	return $src;
}

//Get current ID
function brisk_get_current_ID() {
	$currentID = get_queried_object_id();
	if($currentID === 0) {
		if(!is_front_page()) {
			if(is_404()) {
				$currentID = 'pmsm-404';
			} 
			else {
				$postID = get_the_ID();
				if($postID !== 0) {
					$currentID = $postID;
				}
			}
		}
	}
	return $currentID;
}

/* DNS Prefetch */
function brisk_dns_prefetch() {
	global $brisk_advanced;
	if(!empty($brisk_advanced['dns_prefetch']) && is_array($brisk_advanced['dns_prefetch'])) {
		foreach($brisk_advanced['dns_prefetch'] as $url) {
			echo "<link rel='dns-prefetch' href='" . $url . "'>" . "\n";
		}
	}
}

/* Preconnect */
if(!empty($brisk_advanced['preconnect'])) {
	add_action('wp_head', 'brisk_preconnect', 1);
}

function brisk_preconnect() {
	global $brisk_advanced;
	if(!empty($brisk_advanced['preconnect']) && is_array($brisk_advanced['preconnect'])) {
		foreach($brisk_advanced['preconnect'] as $line) {
			if(is_array($line)) {
				echo "<link rel='preconnect' href='" . $line['url'] . "' " . ($line['crossorigin'] ? "crossorigin" : "") . ">" . "\n";
			}
			else {
				echo "<link rel='preconnect' href='" . $line . "' crossorigin>" . "\n";
			}
			
		}
	}
}

/* Blank Favicon */
if(!empty($brisk_advanced['blank_favicon'])) {
	add_action('wp_head', 'brisk_blank_favicon');
}
//Source: https://davidwalsh.name/blank-favicon
function brisk_blank_favicon() {
	echo '<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon" />';
}

/* Header Code */
if(!empty($brisk_advanced['header_code'])) {
	add_action('wp_head', 'brisk_insert_header_code');
}

function brisk_insert_header_code() {
	global $brisk_advanced;
	if(!empty($brisk_advanced['header_code'])) {
		echo $brisk_advanced['header_code'];
	}
}

/* Footer Code */
if(!empty($brisk_advanced['footer_code'])) {
	add_action('wp_footer', 'brisk_insert_footer_code');
}

function brisk_insert_footer_code() {
	global $brisk_advanced;
	if(!empty($brisk_advanced['footer_code'])) {
		echo $brisk_advanced['footer_code'];
	}
}
