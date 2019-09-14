<?php
//security check
if(!current_user_can('manage_options') || is_admin() || !isset($_GET['brisk']) || !brisk_network_access()) {
	return;
}

//variables
global $brisk_advanced;
global $wp;
global $wp_scripts;
global $wp_styles;
global $brisk_options;
global $currentID;
$currentID = brisk_get_current_ID();

//process form
if(isset($_POST['brisk_script_manager_settings'])) {

	//validate
	if(!isset($_POST['brisk_script_manager_settings_nonce']) || !wp_verify_nonce($_POST['brisk_script_manager_settings_nonce'], 'briskmatter_script_manager_save_settings')) {
		print 'Sorry, your nonce did not verify.';
	    exit;
	} else {

		//update
		update_option('brisk_script_manager_settings', $_POST['brisk_script_manager_settings']);
	}
}

//reset rorm
if(isset($_POST['brisk_script_manager_settings_reset'])) {
	delete_option('brisk_script_manager');
	delete_option('brisk_script_manager_settings');
}

//load settings
global $brisk_script_manager_settings;
$brisk_script_manager_settings = get_option('brisk_script_manager_settings');

//array of existing
global $brisk_disables;
$brisk_disables = array();
if(!empty($brisk_options['disable_google_maps']) && $brisk_options['disable_google_maps'] == "1") {
	$brisk_disables[] = 'maps.google.com';
	$brisk_disables[] = 'maps.googleapis.com';
	$brisk_disables[] = 'maps.gstatic.com';
}
if(!empty($brisk_options['disable_google_fonts']) && $brisk_options['disable_google_fonts'] == "1") {
	$brisk_disables[] = 'fonts.googleapis.com';
}

//filters array
global $brisk_filters;
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

//load options
global $brisk_script_manager_options;
$brisk_script_manager_options = get_option('brisk_script_manager');

//load style
require_once('script_manager_css.php');

//wrapper
echo "<div id='brisk-script-manager-wrapper' " . (isset($_GET['brisk']) ? "style='display: block;'" : "") . ">";

	echo "<div id='brisk-script-manager'>";

		$master_array = brisk_script_manager_load_master_array();
		//header
		echo "<div id='brisk-script-manager-header'>";

		
			//navigation
			echo "<form method='POST'>";
				echo "<div id='brisk-script-manager-tabs'>";
					echo "<button name='tab' value='' class='"; if(empty($_POST['tab'])){echo "active";} echo "' title='" . __('This Page', 'brisk') . "'>" . __('This Page', 'brisk') . "</button>";
					echo "<button name='tab' value='global' class='"; if(!empty($_POST['tab']) && $_POST['tab'] == "global"){echo "active";} echo "' title='" . __('All Pages', 'brisk') . "'>" . __('All Pages', 'brisk') . "</button>";
					echo "<button name='tab' value='settings' class='"; if(!empty($_POST['tab']) && $_POST['tab'] == "settings"){echo "active";} echo "' title='" . __('Settings', 'brisk') . "'>" . __('Settings', 'brisk') . "</button>";
				echo "</div>";
			echo "</form>";

		echo "</div>";

		//upgrade notice
		if(empty($brisk_script_manager_settings['hide_disclaimer']) || $brisk_script_manager_settings['hide_disclaimer'] != "1") {
			echo "<div id='brisk-script-manager-disclaimer'>";
				echo "<p>";
					_e("Upgrade Notice!", 'brisk');
				echo "</p>";
			echo "</div>";
		}

		echo "<div id='brisk-script-manager-container'>";

			//default tab
			if(empty($_POST['tab'])) {

				echo "<div class='brisk-script-manager-title-bar'>";
					echo "<h1>" . __('Script Manager', 'brisk') . "</h1>";
					echo "<p>" . __('Manage scripts loading on the current page.', 'brisk') . "</p>";
				echo "</div>";

				//form
				echo "<form method='POST'>";

					foreach($master_array as $category => $groups) {
						if(!empty($groups)) {
							echo "<h3>" . $category . "</h3>";
							if($category != "WordPress Core") {
								echo "<div style='background: #ffffff; padding: 0px;'>";
								foreach($groups as $group => $details) {
									if(!empty($details['assets'])) {
										echo "<div class='brisk-script-manager-group'>";
											echo "<h4>" . $details['name'];
												//status
												echo "<div class='brisk-script-manager-group-status' style='float: right;'>";
												    brisk_script_manager_print_status($category, $group);
												echo "</div>";

											echo "</h4>";

											brisk_script_manager_print_section($category, $group, $details['assets']);
										echo "</div>";
									}
								}
								echo "</div>";
							}
							else {
								if(!empty($groups)) {
									brisk_script_manager_print_section($category, $category, $groups);
								}
							}
						}
					}

					echo "<div class='brisk-script-manager-toolbar'>";

						echo "<div class='brisk-script-manager-toolbar-container'>";

							//button
							echo "<input type='submit' name='brisk_script_manager' value='" . __('Save', 'brisk') . "' />";

							//message
							echo "<div class='brisk-script-manager-message'>" . $message . "</div>";

						echo "</div>";

					echo "</div>";

				echo "</form>";

			}
			//all tab
			elseif(!empty($_POST['tab']) && $_POST['tab'] == "global") {

				echo "<div class='brisk-script-manager-title-bar'>";
					echo "<h1>" . __('All Pages', 'brisk') . "</h1>";
					echo "<p>" . __('This is a visual representation of all the scripts disabled across your entire site.', 'brisk') . "</p>";
				echo "</div>";
				
				if(!empty($brisk_script_manager_options)) {
					foreach($brisk_script_manager_options as $category => $types) {
						echo "<h3>" . $category . "</h3>";
						if(!empty($types)) {
							echo "<table>";
								echo "<thead>";
									echo "<tr>";
										echo "<th>" . __('Type', 'brisk') . "</th>";
										echo "<th>" . __('Script', 'brisk') . "</th>";
										echo "<th>" . __('Setting', 'brisk') . "</th>";
									echo "</tr>";
								echo "</thead>";
								echo "<tbody>";
									foreach($types as $type => $scripts) {
										if(!empty($scripts)) {
											foreach($scripts as $script => $details) {
												if(!empty($details)) {
													foreach($details as $detail => $values) {
														echo "<tr>";
															echo "<td><span style='font-weight: bold;'>" . $type . "</span></td>";
															echo "<td><span style='font-weight: bold;'>" . $script . "</span></td>";
															echo "<td>";
																echo "<span style='font-weight: bold;'>" . $detail . "</span>";
																if($detail == "current" || $detail == "post_types") {
																	if(!empty($values)) {
																		echo " (";
																		$valueString = "";
																		foreach($values as $key => $value) {
																			if($detail == "current") {
																				if($value !== 0) {
																					if($value == 'pmsm-404') {
																						$valueString.= '404, ';
																					}
																					else {
																						$valueString.= "<a href='" . htmlspecialchars(get_page_link($value), ENT_COMPAT, 'utf-8') . "' target='_blank'>" . $value . "</a>, ";
																					}
																				}
																				else {
																					$valueString.= "<a href='" . htmlspecialchars(get_home_url(), ENT_COMPAT, 'utf-8') . "' target='_blank'>homepage</a>, ";
																				}
																			}
																			elseif($detail == "post_types") {
																				$valueString.= $value . ", ";
																			}
																		}
																		echo rtrim($valueString, ", ");
																		echo ")";
																	}
																}
															echo "</td>";
														echo "</tr>";
													}
												}
											}
										}
									}
								echo "</tbody>";
							echo "</table>";
						}
					}
				}
				else {
					echo "<div class='brisk-script-manager-section'>";
						echo "<p style='margin: 20px; text-align: center;'>" . __("You don't have any scripts disabled yet.") . "</p>";
					echo "</div>";
				}

				echo "<div class='brisk-script-manager-toolbar'>";

					echo "<div class='brisk-script-manager-toolbar-container'>";

						//spacer
						echo "<div></div>";

						//message
						echo "<div class='brisk-script-manager-message'>" . $message . "</div>";

					echo "</div>";

				echo "</div>";
			}
			//settings tab
			elseif(!empty($_POST['tab']) && $_POST['tab'] == "settings") {

				echo "<div class='brisk-script-manager-title-bar'>";
					echo "<h1>" . __('Settings', 'brisk') . "</h1>";
					echo "<p>" . __('View and manage all of your configrations for the front-end  settings.', 'brisk') . "</p>";
				echo "</div>";

				echo "<div class='brisk-script-manager-section'>";
					
					//form
					echo "<form method='POST' id='script-manager-settings'>";
					
						echo "<input type='hidden' name='tab' value='settings' />";

						echo "<table>";
							echo "<tbody>";
								echo "<tr>";
									echo "<th>" . brisk_title(__('Upgrade Notice', 'brisk'), 'hide_disclaimer') . "</th>";
									echo "<td>";
										echo "<input type='hidden' name='brisk_script_manager_settings[hide_disclaimer]' value='0' />";
										$args = array(
								            'id' => 'hide_disclaimer',
								            'option' => 'brisk_script_manager_settings',
								            'tooltip' => __('Hide the upgrade box on top of the page.', 'brisk')
								        );
										brisk_print_input($args);
									echo "</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>" . brisk_title(__('Display Archives', 'brisk'), 'separate_archives') . "</th>";
									echo "<td>";
									$args = array(
							            'id' => 'separate_archives',
							            'option' => 'brisk_script_manager_settings',
							            'tooltip' => __('Add WordPress archives to your selection options. Archive posts will no longer be grouped with their post type.', 'brisk')
							        );
									brisk_print_input($args);
									echo "</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>" . brisk_title(__('Reset Settings', 'brisk'), 'reset_script_manager') . "</th>";
									echo "<td>";
										//Reset Form
										echo "<div>";
											echo "<input type='submit' name='pmsm-reset' class='pmsm-reset' value='" . __('Reset Settings', 'brisk') . "' />";
										echo "</div>";
										echo "<div>";
											echo "<span class='brisk-tooltip-text'>" . __('Remove and reset all of your existing settings.', 'brisk') . "</span>";
										echo "</div>";
									echo "</td>";
								echo "</tr>";
							echo "</tbody>";
						echo "</table>";

						//nonce
						wp_nonce_field('briskmatter_script_manager_save_settings', 'brisk_script_manager_settings_nonce');

						echo "<div class='brisk-script-manager-toolbar'>";

							echo "<div class='brisk-script-manager-toolbar-container'>";

								//button
								echo "<input type='submit' name='brisk_script_manager_settings_submit' value='" . __('Save', 'brisk') . "' />";

								//message
								echo "<div class='brisk-script-manager-message'>" . $message . "</div>";

							echo "</div>";

						echo "</div>";

					echo "</form>";	

				echo "<div>";

				//reset form
				echo "<form method='POST' id='pmsm-reset-form' onSubmit=\"return confirm('" . __('Are you sure? This will remove and reset all of your existing Script Manager settings and cannot be undone!') . "');\">";
					echo "<input type='hidden' name='tab' value='settings' />";
					echo "<input type='hidden' name='brisk_script_manager_settings_reset' class='pmsm-reset' value='submit' />";
				echo "</form>";
			}
		echo "</div>";
	echo "</div>";
echo "</div>";