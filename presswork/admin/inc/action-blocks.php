<?php
/**
 * Adds action blocks
 *
 * @since PressWork 1.0
 */
function actionBlock($id, $r = null) {
	$blocks = array('_top', '_middle', '_bottom');
	foreach($blocks as $block) {
		if(theme_option('guides')=="on" && current_user_can('manage_options')) echo '<div class="guides clear fl"><p class="guide-title">'.$id.$block.'</p>';
		do_action($id.$block, $r);
		if(theme_option('guides')=="on" && current_user_can('manage_options')) echo  '</div>';
	}
}

/**
 * Adds action calls
 *
 * @since PressWork 1.0
 */
 function actionCall($id) {
	if(theme_option('guides')=="on" && current_user_can('manage_options')) echo '<div class="guides clear fl"><p class="guide-title">'.$id.'</p>';
	do_action($id);
	if(theme_option('guides')=="on" && current_user_can('manage_options')) echo  '</div>';
}