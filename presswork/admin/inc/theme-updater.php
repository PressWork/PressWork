<?php
/**
 * Functionality to hook in the WordPress theme updater. Included in 
 * PressWork but only really needed for child themes.
 *
 * @since PressWork 1.0
 */
function check_for_update() {
	$contents = wp_remote_fopen('http://themes.bavotasan.com/?themeversion=wpt-'.THEME_CODE);
	if(version_compare($contents, THEME_VERSION, '>'))
		return $contents;
}
add_filter('pre_set_site_transient_update_themes', 'theme_updater');

function theme_updater($checked_data) {
	global $wp_version;
	
	$bavotasan_version_check = check_for_update();

	if (empty($checked_data->checked) && !empty($bavotasan_version_check)) {
		$response = array(
			'new_version' => $bavotasan_version_check,
			'url' => THEME_HOMEPAGE,
			'package' => 'http://themes.bavotasan.com/fvTHfe/wpt-'.THEME_CODE.'.zip'
			);
		$checked_data->checked[THEME_FILE] = $bavotasan_version_check;
		$checked_data->response[THEME_FILE] = $response;
	
		return $checked_data;
	}

	if(!empty($bavotasan_version_check)) {
		$response = array(
			'new_version' => $bavotasan_version_check,
			'url' => THEME_HOMEPAGE,
			'package' => 'http://themes.bavotasan.com/fvTHfe/wpt-'.THEME_CODE.'.zip'
			);
		$checked_data->response[THEME_FILE] = $response;
	}		
	return $checked_data;
}

if (is_admin())
	$current = get_transient('update_themes');