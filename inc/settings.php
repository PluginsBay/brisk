<?php
//settings + options
function brisk_settings() {
	if(get_option('brisk_options') == false) {	
		add_option('brisk_options', apply_filters('brisk_default_options', brisk_default_options()));
	}

    //options
    add_settings_section('brisk_options', __('Options', 'brisk'), 'brisk_options_callback', 'brisk_options');

    //emojis
    add_settings_field(
    	'disable_emojis', 
    	brisk_title(__('Disable Emojis', 'brisk'), 'disable_emojis') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-emojis-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
            'id' => 'disable_emojis',
            'tooltip' => __('Removes WordPress Emojis JavaScript file (wp-emoji-release.min.js).', 'brisk')
        )
    );

    //embeds
    add_settings_field(
    	'disable_embeds', 
    	brisk_title(__('Disable Embeds', 'brisk'), 'disable_embeds') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-embeds-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_embeds',
    		'tooltip' => __('Removes WordPress Embed JavaScript file (wp-embed.min.js).', 'brisk')   		
    	)
    );

    //strings
    add_settings_field(
    	'remove_query_strings', 
    	brisk_title(__('Remove Query Strings', 'brisk'), 'remove_query_strings') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-query-strings-from-static-resources/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_query_strings',
    		'tooltip' => __('Remove query strings from static resources (CSS, JS).', 'brisk')
    	)
    );

	//xml-rpc
    add_settings_field(
    	'disable_xmlrpc', 
    	brisk_title(__('Disable XML-RPC', 'brisk'), 'disable_xmlrpc') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-xml-rpc-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_xmlrpc',
    		'tooltip' => __('Disables WordPress XML-RPC functionality.', 'brisk')
    	)
    );

	//jquery migrate
    add_settings_field(
    	'remove_jquery_migrate', 
    	brisk_title(__('Remove jQuery Migrate', 'brisk'), 'remove_jquery_migrate') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-jquery-migrate-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_jquery_migrate',
    		'tooltip' => __('Removes jQuery Migrate JavaScript file (jquery-migrate.min.js).', 'brisk')
    	)
    );

    //wp version
    add_settings_field(
    	'hide_wp_version', 
    	brisk_title(__('Hide WP Version', 'brisk'), 'hide_wp_version') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-wordpress-version-number/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'hide_wp_version',
    		'tooltip' => __('Removes WordPress version meta tag.', 'brisk')
    	)
    );

    //wlmanifest
    add_settings_field(
    	'remove_wlwmanifest_link', 
    	brisk_title(__('Remove wlwmanifest Link', 'brisk'), 'remove_wlwmanifest_link') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-wlwmanifest-link-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options',
        array(
        	'id' => 'remove_wlwmanifest_link',
        	'tooltip' => __('Remove wlwmanifest (Windows Live Writer) link tag.', 'brisk')
        )
    );

    //rsd
    add_settings_field(
    	'remove_rsd_link', 
    	brisk_title(__('Remove RSD Link', 'brisk'), 'remove_rsd_link') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-rsd-link-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_rsd_link',
    		'tooltip' => __('Remove RSD (Real Simple Discovery) link tag.', 'brisk')
    	)
    );

    //shortlink
    add_settings_field(
    	'remove_shortlink', 
    	brisk_title(__('Remove Shortlink', 'brisk'), 'remove_shortlink') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-shortlink-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_shortlink',
    		'tooltip' => __('Remove Shortlink link tag.', 'brisk')
    	)
    );

    //rss
    add_settings_field(
    	'disable_rss_feeds', 
    	brisk_title(__('Disable RSS Feeds', 'brisk'), 'disable_rss_feeds') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-rss-feeds-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_rss_feeds',
    		'tooltip' => __('Disable WordPress generated RSS feeds and 301 redirect URL to parent.', 'brisk')
    	)
    );

    //feed
    add_settings_field(
    	'remove_feed_links', 
    	brisk_title(__('Remove RSS Feed Links', 'brisk'), 'remove_feed_links') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-rss-feed-links-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_feed_links',
    		'tooltip' => __('Disable WordPress generated RSS feed link tags.', 'brisk')
    	)
    );

    //pingback
    add_settings_field(
    	'disable_self_pingbacks', 
    	brisk_title(__('Disable Self Pingbacks', 'brisk'), 'disable_self_pingbacks') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-self-pingbacks-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_self_pingbacks',
    		'tooltip' => __('Disable Self Pingbacks (generated when linking to an article on your own blog).', 'brisk')
    	)
    );

    //rest api
    add_settings_field(
    	'disable_rest_api', 
    	brisk_title(__('Disable REST API', 'brisk'), 'disable_rest_api') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-wordpress-rest-api/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_rest_api',
    		'input' => 'select',
    		'options' => array(
    			''                   => __('Default (Enabled)', 'brisk'),
    			'disable_non_admins' => __('Disable for Non-Admins', 'brisk'),
    			'disable_logged_out' => __('Disable When Logged Out', 'brisk')
    		),
    		'tooltip' => __('Disables REST API requests and displays an error message if the requester doesn\'t have permission.', 'brisk')
    	)
    );

    //api links
    add_settings_field(
    	'remove_rest_api_links', 
    	brisk_title(__('Remove REST API Links', 'brisk'), 'remove_rest_api_links') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-wordpress-rest-api-links/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'remove_rest_api_links',
    		'tooltip' => __('Removes REST API link tag from the front end and the REST API header link from page requests.', 'brisk')
    	)
    );

    //dashicons
    add_settings_field(
        'disable_dashicons', 
        brisk_title(__('Disable Dashicons', 'brisk'), 'disable_dashicons') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-dashicons-wordpress/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'disable_dashicons',
            'tooltip' => __('Disables dashicons on the front end when not logged in.', 'brisk')
        )
    );

    //g maps
    add_settings_field(
        'disable_google_maps', 
        brisk_title(__('Disable Google Maps', 'brisk'), 'disable_google_maps') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-google-maps-api-wordpress/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'disable_google_maps',
            'tooltip' => __('Removes any instances of Google Maps being loaded across your entire site.', 'brisk')
        )
    );

    //g fonts
    add_settings_field(
        'disable_google_fonts', 
        brisk_title(__('Disable Google Fonts', 'brisk'), 'disable_google_fonts') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-google-fonts/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'disable_google_fonts',
            'tooltip' => __('Removes any instances of Google Fonts being loaded across your entire site.', 'brisk')
        )
    );

    //password meter
    add_settings_field(
        'disable_password_strength_meter', 
        brisk_title(__('Disable Password Strength Meter', 'brisk'), 'disable_password_strength_meter') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-password-meter-strength/'),
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'disable_password_strength_meter',
            'tooltip' => __('Removes WordPress and WooCommerce Password Strength Meter scripts from non essential pages.', 'brisk')
        )
    );

    //comments
    add_settings_field(
        'disable_comments', 
        brisk_title(__('Disable Comments', 'brisk'), 'disable_comments') . brisk_tooltip('https://pluginsbay.com/docs/brisk/wordpress-disable-comments/'),
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'disable_comments',
            'tooltip' => __('Disables WordPress comments across your entire site.', 'brisk')
        )
    );

    //comments url
    add_settings_field(
        'remove_comment_urls', 
        brisk_title(__('Remove Comment URLs', 'brisk'), 'remove_comment_urls') . brisk_tooltip('https://pluginsbay.com/docs/brisk/remove-wordpress-comment-author-link'),
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'remove_comment_urls',
            'tooltip' => __('Removes the WordPress comment author link and website field from blog posts.', 'brisk')
        )
    );

    //heartbeat
    add_settings_field(
    	'disable_heartbeat', 
    	'<label for=\'disable_heartbeat\'>' . __('Disable Heartbeat', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-wordpress-heartbeat-api/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'disable_heartbeat',
    		'input' => 'select',
    		'options' => array(
    			''                   => __('Default', 'brisk'),
    			'disable_everywhere' => __('Disable Everywhere', 'brisk'),
    			'allow_posts'        => __('Only Allow When Editing Posts/Pages', 'brisk')
    		),
    		'tooltip' => __('Disable WordPress Heartbeat everywhere or in certain areas (used for auto saving and revision tracking).', 'brisk')
    	)
    );

    //heartbeat frequency
    add_settings_field(
    	'heartbeat_frequency', 
    	'<label for=\'heartbeat_frequency\'>' . __('Heartbeat Frequency', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/change-heartbeat-frequency-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'heartbeat_frequency',
    		'input' => 'select',
    		'options' => array(
    			''   => sprintf(__('%s Seconds', 'brisk'), '15') . ' (' . __('Default', 'brisk') . ')',
                '30' => sprintf(__('%s Seconds', 'brisk'), '30'),
                '45' => sprintf(__('%s Seconds', 'brisk'), '45'),
                '60' => sprintf(__('%s Seconds', 'brisk'), '60')
    		),
    		'tooltip' => __('Controls how often the WordPress Heartbeat API is allowed to run.', 'brisk')
    	)
    );

    //post revisions
    add_settings_field(
    	'limit_post_revisions', 
    	'<label for=\'limit_post_revisions\'>' . __('Limit Post Revisions', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-limit-post-revisions-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'limit_post_revisions',
    		'input' => 'select',
    		'options' => array(
    			''      => __('Default', 'brisk'),
    			'false' => __('Disable Post Revisions', 'brisk'),
    			'1'     => '1',
    			'2'     => '2',
    			'3'     => '3',
    			'4'     => '4',
    			'5'     => '5',
    			'10'    => '10',
    			'15'    => '15',
    			'20'    => '20',
    			'25'    => '25',
    			'30'    => '30'
    		),
    		'tooltip' => __('Limits the maximum amount of revisions that are allowed for posts and pages.', 'brisk')
    	)
    );

    //autosave
    add_settings_field(
    	'autosave_interval', 
    	'<label for=\'autosave_interval\'>' . __('Autosave Interval', 'brisk') . '</label>' . brisk_tooltip('https://pluginsbay.com/docs/brisk/change-autosave-interval-wordpress/'), 
    	'brisk_print_input', 
    	'brisk_options', 
    	'brisk_options', 
    	array(
    		'id' => 'autosave_interval',
    		'input' => 'select',
    		'options' => array(
    			''    => __('1 Minute', 'brisk') . ' (' . __('Default', 'brisk') . ')',
                '120' => sprintf(__('%s Minutes', 'brisk'), '2'),
                '180' => sprintf(__('%s Minutes', 'brisk'), '3'),
                '240' => sprintf(__('%s Minutes', 'brisk'), '4'),
                '300' => sprintf(__('%s Minutes', 'brisk'), '5')
    		),
    		'tooltip' => __('Controls how often WordPress will auto save posts and pages while editing.', 'brisk')
    	)
    );

    //login url
    add_settings_field(
        'login_url', 
        brisk_title(__('Change Login URL', 'brisk'), 'login_url') . brisk_tooltip('https://pluginsbay.com/docs/brisk/change-wordpress-login-url/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_options', 
        array(
            'id' => 'login_url',
            'input' => 'text',
            'placeholder' => 'hideme',
            'tooltip' => __('When set, this will change your WordPress login URL (slug) to the provided string and will block wp-admin and wp-login endpoints from being directly accessed.', 'brisk')
        )
    );
	
	
/*
 *START WooCommerce Settings
 *TODO: Switch to WC_VERSION constant
 */

/*check if WooCommerce is active*/	
if ( class_exists( 'WooCommerce' ) ) {
    //WooCommerce Options Section
    add_settings_section('brisk_woocommerce', 'WooCommerce', 'brisk_woocommerce_callback', 'brisk_options');

    //wc scripts
    add_settings_field(
        'disable_woocommerce_scripts', 
        brisk_title(__('Disable Scripts', 'brisk'), 'disable_woocommerce_scripts') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-woocommerce-scripts-and-styles/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_woocommerce', 
        array(
            'id' => 'disable_woocommerce_scripts',
            'tooltip' => __('Disables WooCommerce scripts and styles except on product, cart, and checkout pages.', 'brisk')
        )
    );

    //wc cart fragmentation
    add_settings_field(
        'disable_woocommerce_cart_fragmentation', 
        brisk_title(__('Disable Cart Fragmentation', 'brisk'), 'disable_woocommerce_cart_fragmentation') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-woocommerce-cart-fragments-ajax/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_woocommerce', 
        array(
            'id' => 'disable_woocommerce_cart_fragmentation',
            'tooltip' => __('Completely disables WooCommerce cart fragmentation script.', 'brisk')
        )
    );

    //wc status meta box
    add_settings_field(
        'disable_woocommerce_status', 
        brisk_title(__('Disable Status Meta Box', 'brisk'), 'disable_woocommerce_status') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-woocommerce-status-meta-box/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_woocommerce', 
        array(
            'id' => 'disable_woocommerce_status',
            'tooltip' => __('Disables WooCommerce status meta box from the WP Admin Dashboard.', 'brisk')
        )
    );

    //wc widgets
    add_settings_field(
        'disable_woocommerce_widgets', 
        brisk_title(__('Disable Widgets', 'brisk'), 'disable_woocommerce_widgets') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-woocommerce-widgets/'), 
        'brisk_print_input', 
        'brisk_options', 
        'brisk_woocommerce', 
        array(
            'id' => 'disable_woocommerce_widgets',
            'tooltip' => __('Disables all WooCommerce widgets.', 'brisk')
        )
    );
} else {
/*END WooCommerce Settings*/


}
    register_setting('brisk_options', 'brisk_options');

    //CDN Options
    if(get_option('brisk_cdn') == false) {    
        add_option('brisk_cdn', apply_filters('brisk_default_cdn', brisk_default_cdn()));
    }

    //CDN Section
    add_settings_section('brisk_cdn', 'CDN', 'brisk_cdn_callback', 'brisk_cdn');

    //CDN URL
    add_settings_field(
        'enable_cdn', 
        brisk_title(__('Enable CDN Rewrite', 'brisk'), 'enable_cdn') . brisk_tooltip('https://pluginsbay.com/docs/brisk/cdn-rewrite/'), 
        'brisk_print_input', 
        'brisk_cdn', 
        'brisk_cdn', 
        array(
            'id' => 'enable_cdn',
            'option' => 'brisk_cdn',
            'tooltip' => __('Enables rewriting of your site URLs with your CDN URLs which can be configured below.', 'brisk')
        )
    );

    //CDN URL
    add_settings_field(
        'cdn_url', 
        brisk_title(__('CDN URL', 'brisk'), 'cdn_url') . brisk_tooltip('https://pluginsbay.com/docs/brisk/cdn-url/'), 
        'brisk_print_input', 
        'brisk_cdn', 
        'brisk_cdn', 
        array(
            'id' => 'cdn_url',
            'option' => 'brisk_cdn',
            'input' => 'text',
            'placeholder' => 'https://cdn.example.com',
            'tooltip' => __('Enter your CDN URL without the trailing backslash. Example: https://cdn.example.com', 'brisk')
        )
    );

    //CDN included directories
    add_settings_field(
        'cdn_directories', 
        brisk_title(__('Included Directories', 'brisk'), 'cdn_directories') . brisk_tooltip('https://pluginsbay.com/docs/brisk/cdn-included-directories/'), 
        'brisk_print_input', 
        'brisk_cdn', 
        'brisk_cdn', 
        array(
            'id' => 'cdn_directories',
            'option' => 'brisk_cdn',
            'input' => 'text',
            'placeholder' => 'wp-content,wp-includes',
            'tooltip' => __('Enter any directories you would like to be included in CDN rewriting, separated by commas (,). Default: wp-content,wp-includes', 'brisk')
        )
    );

    //CDN exclusions
    add_settings_field(
        'cdn_exclusions', 
        brisk_title(__('CDN Exclusions', 'brisk'), 'cdn_exclusions') . brisk_tooltip('https://pluginsbay.com/docs/brisk/cdn-exclusions/'), 
        'brisk_print_input', 
        'brisk_cdn', 
        'brisk_cdn', 
        array(
            'id' => 'cdn_exclusions',
            'option' => 'brisk_cdn',
            'input' => 'text',
            'placeholder' => '.php',
            'tooltip' => __('Enter any directories or file extensions you would like to be excluded from CDN rewriting, separated by commas (,). Default: .php', 'brisk')
        )
    );

    register_setting('brisk_cdn', 'brisk_cdn');

    //GA options
    if(get_option('brisk_ga') == false) {    
        add_option('brisk_ga', apply_filters('brisk_default_ga', brisk_default_ga()));
    }

    //GA Section
    add_settings_section('brisk_ga', __('Google Analytics', 'brisk'), 'brisk_ga_callback', 'brisk_ga');

    //GA local
    add_settings_field(
        'enable_local_ga', 
        brisk_title(__('Enable Local Analytics', 'brisk'), 'enable_local_ga') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/'),
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'enable_local_ga',
            'option' => 'brisk_ga',
            'tooltip' => __('Enable syncing of the Google Analytics script to your own server.', 'brisk')
        )
    );

    //GA ID
    add_settings_field(
        'tracking_id', 
        brisk_title(__('Tracking ID', 'brisk'), 'tracking_id') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#trackingid'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'tracking_id',
            'option' => 'brisk_ga',
            'input' => 'text',
            'tooltip' => __('Input your Google Analytics tracking ID.', 'brisk')
        )
    );

    //GA position
    add_settings_field(
        'tracking_code_position', 
        brisk_title(__('Tracking Code Position', 'brisk'), 'tracking_code_position') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#trackingcodeposition'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'tracking_code_position',
            'option' => 'brisk_ga',
            'input' => 'select',
            'options' => array(
            	"" => __('Header', 'brisk') . ' (' . __('Default', 'brisk') . ')',
            	"footer" => __('Footer', 'brisk')
            	),
            'tooltip' => __('Load your analytics script in the header (default) or footer of your site. Default: Header', 'brisk')
        )
    );

    //GA display features
    add_settings_field(
        'disable_display_features', 
        brisk_title(__('Disable Display Features', 'brisk'), 'disable_display_features') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#disabledisplayfeatures'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'disable_display_features',
            'option' => 'brisk_ga',
            'tooltip' => __('Disable remarketing and advertising which generates a 2nd HTTP request.', 'brisk')
        )
    );

    //GA IP
    add_settings_field(
        'anonymize_ip', 
        brisk_title(__('Anonymize IP', 'brisk'), 'anonymize_ip') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#anonymize-ip'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'anonymize_ip',
            'option' => 'brisk_ga',
            'tooltip' => __('Shorten visitor IP to comply with privacy restrictions in some countries.', 'brisk')
        )
    );

    //GA admins
    add_settings_field(
        'track_admins', 
        brisk_title(__('Track Logged In Admins', 'brisk'), 'track_admins') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#track-logged-in-admins'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'track_admins',
            'option' => 'brisk_ga',
            'tooltip' => __('Include logged-in WordPress admins in your Google Analytics reports.', 'brisk')
        )
    );

    //GA bounce rate
    add_settings_field(
        'adjusted_bounce_rate', 
        brisk_title(__('Adjusted Bounce Rate', 'brisk'), 'adjusted_bounce_rate') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#adjusted-bounce-rate'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'adjusted_bounce_rate',
            'option' => 'brisk_ga',
            'input' => 'text',
            'tooltip' => __('Set a timeout limit in seconds to better evaluate the quality of your traffic. (1-100)', 'brisk')
        )
    );

    //GA MonsterInsights
    add_settings_field(
        'use_monster_insights', 
        brisk_title(__('Use MonsterInsights', 'brisk'), 'use_monster_insights') . brisk_tooltip('https://pluginsbay.com/docs/brisk/local-analytics/#monster-insights'), 
        'brisk_print_input', 
        'brisk_ga', 
        'brisk_ga', 
        array(
            'id' => 'use_monster_insights',
            'option' => 'brisk_ga',
            'tooltip' => __('Allows MonsterInsights to manage your Google Analaytics while still using the locally hosted analytics.js file generated by Brisk.', 'brisk')
        )
    );

    register_setting('brisk_ga', 'brisk_ga');

    if(get_option('brisk_advanced') == false) {    
        add_option('brisk_advanced', apply_filters('brisk_default_advanced', brisk_default_advanced()));
    }
    add_settings_section('brisk_advanced', __('Advanced', 'brisk'), 'brisk_advanced_callback', 'brisk_advanced');

    //Frontend
    add_settings_field(
        'script_manager', 
        brisk_title(__('Front-end', 'brisk'), 'script_manager') . brisk_tooltip('https://pluginsbay.com/docs/brisk/disable-scripts-per-post-page/'), 
        'brisk_print_input', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
        	'id' => 'script_manager',
        	'option' => 'brisk_advanced',
        	'tooltip' => __('Enables Brisk on the front-end to disable CSS and JS files on a page by page basis.', 'brisk')
        )
    );

    //DNS Prefetch
    add_settings_field(
        'dns_prefetch', 
        brisk_title(__('DNS Prefetch', 'brisk'), 'dns_prefetch') . brisk_tooltip('https://pluginsbay.com/docs/brisk/dns-prefetching/'), 
        'brisk_print_dns_prefetch', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
            'id' => 'dns_prefetch',
            'option' => 'brisk_advanced',
            'tooltip' => __('Resolve domain names before a user clicks. Format: //domain.tld (one per line)', 'brisk')
        )
    );

    //Preconnect
    add_settings_field(
        'preconnect', 
        brisk_title(__('Preconnect', 'brisk'), 'preconnect') . brisk_tooltip('https://pluginsbay.com/docs/brisk/preconnect/'), 
        'brisk_print_preconnect', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
            'id' => 'preconnect',
            'option' => 'brisk_advanced',
            'tooltip' => __('Preconnect allows the browser to set up early connections before an HTTP request, eliminating roundtrip latency and saving time for users. Format: scheme://domain.tld', 'brisk')
        )
    );

    //Blank Favicon
    add_settings_field(
        'blank_favicon', 
        brisk_title(__('Add Blank Favicon', 'brisk'), 'blank_favicon') . brisk_tooltip('https://pluginsbay.com/docs/brisk/blank-favicon/'), 
        'brisk_print_input', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
            'id' => 'blank_favicon',
            'option' => 'brisk_advanced',
            'tooltip' => __('Adds a blank favicon to your WordPress header which will prevent a Missing Favicon or 404 error from showing up on certain website speed testing tools.', 'brisk')
        )
    );

    //Header Code
    add_settings_field(
        'header_code', 
        brisk_title(__('Add Header Code', 'brisk'), 'header_code') . brisk_tooltip('https://pluginsbay.com/docs/brisk/wordpress-add-code-to-header-footer/'), 
        'brisk_print_input', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
            'id' => 'header_code',
            'option' => 'brisk_advanced',
            'input' => 'textarea',
            'tooltip' => __('Code added here will be printed in the head section on every page of your website.', 'brisk')
        )
    );

    //Footer Code
    add_settings_field(
        'footer_code', 
        brisk_title(__('Add Footer Code', 'brisk'), 'footer_code') . brisk_tooltip('https://pluginsbay.com/docs/brisk/wordpress-add-code-to-header-footer/'), 
        'brisk_print_input', 
        'brisk_advanced', 
        'brisk_advanced', 
        array(
            'id' => 'footer_code',
            'option' => 'brisk_advanced',
            'input' => 'textarea',
            'tooltip' => __('Code added here will be printed above the closing body tag on every page of your website.', 'brisk')
        )
    );

    if(!is_multisite()) {

        //Clean Uninstall
        add_settings_field(
            'clean_uninstall', 
            brisk_title(__('Clean Uninstall', 'brisk'), 'clean_uninstall') . brisk_tooltip('https://pluginsbay.com/docs/brisk/clean-uninstall/'), 
            'brisk_print_input', 
            'brisk_advanced', 
            'brisk_advanced', 
            array(
                'id' => 'clean_uninstall',
                'option' => 'brisk_advanced',
                'tooltip' => __('When enabled, this will cause all Brisk options data to be removed from your database when the plugin is uninstalled.', 'brisk')
            )
        );

    }

    //Accessibility Mode
    add_settings_field(
        'accessibility_mode', 
        brisk_title(__('Accessibility Mode', 'brisk'), 'accessibility_mode', true), 
        'brisk_print_input',
        'brisk_advanced', 
        'brisk_advanced', 
        array(
        	'id' => 'accessibility_mode',
        	'input' => 'checkbox',
        	'option' => 'brisk_advanced',
        	'tooltip' => __('Disable the use of visual UI elements in the plugin settings such as checkbox toggles and hovering tooltips.', 'brisk')
        )
    );

    register_setting('brisk_advanced', 'brisk_advanced', 'brisk_sanitize_advanced');
}
add_action('admin_init', 'brisk_settings');

//options default values
function brisk_default_options() {
	$defaults = array(
		'disable_emojis' => "0",
		'disable_embeds' => "0",
		'remove_query_strings' => "0",
		'disable_xmlrpc' => "0",
		'remove_jquery_migrate' => "0",
		'hide_wp_version' => "0",
		'remove_wlwmanifest_link' => "0",
		'remove_rsd_link' => "0",
		'remove_shortlink' => "0",
		'disable_rss_feeds' => "0",
		'remove_feed_links' => "0",
		'disable_self_pingbacks' => "0",
		'disable_rest_api' => "",
		'remove_rest_api_links' => "0",
        'disable_dashicons' => "0",
        'disable_google_maps' => "0",
        'disable_password_strength_meter' => "0",
        'disable_comments' => "0",
        'remove_comment_urls' => "0",
		'disable_heartbeat' => "",
		'heartbeat_frequency' => "",
		'limit_post_revisions' => "",
		'autosave_interval' => "",
        'login_url' => "",
        'disable_woocommerce_scripts' => "0",
        'disable_woocommerce_cart_fragmentation' => "0",
        'disable_woocommerce_status' => "0",
        'disable_woocommerce_widgets' => "0"
	);
    brisk_network_defaults($defaults, 'brisk_options');
	return apply_filters('brisk_default_options', $defaults);
}

//CDN default values
function brisk_default_cdn() {
    $defaults = array(
        'enable_cdn' => "0",
        'cdn_url' => "0",
        'cdn_directories' => "wp-content,wp-includes",
        'cdn_exclusions' => ".php"
    );
    brisk_network_defaults($defaults, 'brisk_cdn');
    return apply_filters( 'brisk_default_cdn', $defaults );
}

//GA default values
function brisk_default_ga() {
    $defaults = array(
    	'enable_local_ga' => "0",
        'tracking_id' => "",
        'tracking_code_position' => "",
        'disable_display_features' => "0",
        'anonymize_ip' => "0",
        'track_admins' => "0",
        'adjusted_bounce_rate' => "",
        'use_monster_insights' => "0"
    );
    brisk_network_defaults($defaults, 'brisk_ga');
    return apply_filters('brisk_default_ga', $defaults);
}

//advanced default values
function brisk_default_advanced() {
    $defaults = array(
        'script_manager' => "1",
        'dns_prefetch' => "",
        'preconnect' => "",
        'blank_favicon' => "0",
        'header_code' => "",
        'footer_code' => "",
        'accessibility_mode' => "0"
    );
    brisk_network_defaults($defaults, 'brisk_advanced');
    return apply_filters( 'brisk_default_advanced', $defaults );
}

function brisk_network_defaults(&$defaults, $option) {
    if(is_multisite() && is_plugin_active_for_network('brisk/brisk.php')) {
        $brisk_network = get_site_option('brisk_network');
        if(!empty($brisk_network['default'])) {
            $networkDefaultOptions = get_blog_option($brisk_network['default'], $option);
            if($option == 'brisk_cdn') {
                unset($networkDefaultOptions['cdn_url']);
            }
            if(!empty($networkDefaultOptions)) {
                foreach($networkDefaultOptions as $key => $val) {
                    $defaults[$key] = $val;
                }
            }
        }
    }
}

//main options group callback
function brisk_options_callback() {
	echo '<p class="brisk-subheading">' . __('Select which briskormance options you would like to enable.', 'brisk') . '</p>';
}

//woocommerce options group callback
function brisk_woocommerce_callback() {
    echo '<p class="brisk-subheading">' . __('Disable specific elements of WooCommerce.', 'brisk') . '</p>';
}

//cdn group callback
function brisk_cdn_callback() {
    echo '<p class="brisk-subheading">' . __('CDN options that allow you to rewrite your site URLs with your CDN URLs.', 'brisk') . '</p>';
}

//google analytics group callback
function brisk_ga_callback() {
    echo '<p class="brisk-subheading">' . __('Optimization options for Google Analytics.', 'brisk') . '</p>';
}

//advanced group callback
function brisk_advanced_callback() {
    echo '<p class="brisk-subheading">' . __('Extra options that pertain to Brisk plugin functionality.', 'brisk') . '</p>';
}

//print form inputs
function brisk_print_input($args) {
    if(!empty($args['option'])) {
        $option = $args['option'];
        if($args['option'] == 'brisk_network') {
            $options = get_site_option($args['option']);
        }
        else {
            $options = get_option($args['option']);
        }
    }
    else {
        $option = 'brisk_options';
        $options = get_option('brisk_options');
    }
    if(!empty($args['option']) && $args['option'] == 'brisk_advanced') {
        $advanced = $options;
    }
    else {
        $advanced = get_option('brisk_advanced');
    }

    echo "<div style='display: table; width: 100%;'>";
        echo "<div class='brisk-input-wrapper'>";

            //Text
            if(!empty($args['input']) && ($args['input'] == 'text' || $args['input'] == 'color')) {
                echo "<input type='text' id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]' value='" . (!empty($options[$args['id']]) ? $options[$args['id']] : '') . "' placeholder='" . (!empty($args['placeholder']) ? $args['placeholder'] : '') . "' />";
            }

            //Select
            elseif(!empty($args['input']) && $args['input'] == 'select') {
                echo "<select id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]'>";
                    foreach($args['options'] as $value => $title) {
                        echo "<option value='" . $value . "' "; 
                        if(!empty($options[$args['id']]) && $options[$args['id']] == $value) {
                            echo "selected";
                        } 
                        echo ">" . $title . "</option>";
                    }
                echo "</select>";
            }

            //Text Area
            elseif(!empty($args['input']) && $args['input'] == 'textarea') {
                echo "<textarea id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]'>";
                    echo (!empty($options[$args['id']]) ? $options[$args['id']] : '');
                echo "</textarea>";
            }

            //Checkbox + Toggle
            else {
                if((empty($advanced['accessibility_mode']) || $advanced['accessibility_mode'] != "1") && (empty($args['input']) || $args['input'] != 'checkbox')) {
                    echo "<label for='" . $args['id'] . "' class='switch'>";
                }
                    echo "<input type='checkbox' id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]' value='1' style='display: block; margin: 0px;' ";
                    if(!empty($options[$args['id']]) && $options[$args['id']] == "1") {
                        echo "checked";
                    }
                    echo ">";
                if((empty($advanced['accessibility_mode']) || $advanced['accessibility_mode'] != "1") && (empty($args['input']) || $args['input'] != 'checkbox')) {
                       echo "<div class='slider'></div>";
                   echo "</label>";
                }
            }
            
        echo "</div>";

        if(!empty($args['tooltip'])) {
            if((empty($advanced['accessibility_mode']) || $advanced['accessibility_mode'] != "1") && $args['id'] != 'accessibility_mode') {
                echo "<div class='brisk-tooltip-text-wrapper'>";
                    echo "<div class='brisk-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='brisk-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//print DNS Prefetch
function brisk_print_dns_prefetch($args) {
    $advanced = get_option('brisk_advanced');
     echo "<div style='display: table; width: 100%;'>";
        echo "<div class='brisk-input-wrapper'>";
            echo "<textarea id='" . $args['id'] . "' name='brisk_advanced[" . $args['id'] . "]' placeholder='//example.com'>";
                if(!empty($advanced['dns_prefetch'])) {
                    foreach($advanced['dns_prefetch'] as $line) {
                        echo $line . "\n";
                    }
                }
            echo "</textarea>";
        echo "</div>";
        if(!empty($args['tooltip'])) {
            if(empty($advanced['accessibility_mode']) || $advanced['accessibility_mode'] != "1") {
                echo "<div class='brisk-tooltip-text-wrapper'>";
                    echo "<div class='brisk-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='brisk-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//print Preconnect
function brisk_print_preconnect($args) {
    $advanced = get_option('brisk_advanced');
    echo "<div style='display: table; width: 100%;'>";

        echo "<div id='brisk-preconnect-wrapper' class='brisk-input-wrapper'>";

            $rowCount = 0;

            if(!empty($advanced['preconnect'])) {

                foreach($advanced['preconnect'] as $line) {

                    //check for previous vs new format
                    if(is_array($line)) {
                        $url = $line['url'];
                        $crossorigin = $line['crossorigin'];
                    }
                    else {
                        $url = $line;
                        $crossorigin = 1;
                    }

                    //print row
                    echo "<div class='brisk-preconnect-row'>";
                        echo "<input type='text' id='" . $args['id'] . "-" . $rowCount . "-url' name='brisk_advanced[" . $args['id'] . "][" . $rowCount . "][url]' value='" . $url . "' placeholder='https://example.com' />";
                        echo "<label for='" . $args['id'] . "-" . $rowCount . "-crossorigin'>";
                            echo "<input type='checkbox' id='" . $args['id'] . "-" . $rowCount . "-crossorigin' name='brisk_advanced[" . $args['id'] . "][" . $rowCount . "][crossorigin]' " . ($crossorigin == 1 ? "checked" : "") . " value='1' /> CrossOrigin";
                        echo "</label>";
                        echo "<a href='#' class='brisk-delete-preconnect' title='" . __('Remove', 'brisk') . "'><span class='dashicons dashicons-no'></span></a>";
                    echo "</div>";

                    $rowCount++;
                }
            }

            //print empty row at the end
            echo "<div class='brisk-preconnect-row'>";
                echo "<input type='text' id='preconnect-" . $rowCount . "-url' name='brisk_advanced[preconnect][" . $rowCount . "][url]' value='' placeholder='https://example.com' />";
                echo "<label for='" . $args['id'] . "-" . $rowCount . "-crossorigin'>";
                    echo "<input type='checkbox' id='preconnect-" . $rowCount . "-crossorigin' name='brisk_advanced[preconnect][" . $rowCount . "][crossorigin]' value='1' /> CrossOrigin";
                echo "</label>";
                echo "<a href='#' class='brisk-delete-preconnect' title='" . __('Remove', 'brisk') . "'><span class='dashicons dashicons-no'></span></a>";
            echo "</div>";

        echo "</div>";

        //add new row
        echo "<a href='#' id='brisk-add-preconnect' rel='" . $rowCount . "'>" . __('Add New', 'brisk') . "</a>";

        if(!empty($args['tooltip'])) {
            if(empty($advanced['accessibility_mode']) || $advanced['accessibility_mode'] != "1") {
                echo "<div class='brisk-tooltip-text-wrapper'>";
                    echo "<div class='brisk-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='brisk-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//sanitize advanced
function brisk_sanitize_advanced($values) {
    if(!empty($values['dns_prefetch'])) {
        $text = trim($values['dns_prefetch']);
        $text_array = explode("\n", $text);
        $text_array = array_filter($text_array, 'trim');
        $values['dns_prefetch'] = $text_array;
    }
    if(!empty($values['preconnect'])) {
        foreach($values['preconnect'] as $key => $line) {
            if(empty(trim($line['url']))) {
                unset($values['preconnect'][$key]);
            }
        }
        $values['preconnect'] = array_values($values['preconnect']);
    }
    return $values;
}

//print tooltip
function brisk_tooltip($link) {
	$var = "<a ";
        if(!empty($link)) {
            $var.= "href='" . $link . "' title='" . __('View Documentation', 'brisk') . "' ";
        }
        $var.= "class='brisk-tooltip' target='_blank'>?";
    $var.= "</a>";
    return $var;
}

//print title
function brisk_title($title, $id, $checkbox = false) {
    if(!empty($title)) {
        $var = $title;
        if(!empty($id)) {
            $advanced = get_option('brisk_advanced');
            if((!empty($advanced['accessibility_mode']) && $advanced['accessibility_mode'] == "1") || $checkbox == true) {
                $var = "<label for='" . $id . "'>" . $var . "</label>";
            }
        }
        return $var;
    }
}