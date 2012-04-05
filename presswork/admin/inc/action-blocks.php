<?php
/**
 * Adds action blocks
 *
 * @since PressWork 1.0
 */
function pw_actionBlock($id, $r = null) {
	$blocks = array('_top', '_middle', '_bottom');
	foreach($blocks as $block) {
		if(pw_theme_option('toolbox')=="on" && pw_theme_option('hooks')=="on" && current_user_can('edit_theme_options')) echo '<div class="hooks clear fl"><p class="hooks-title">'.$id.$block.'</p>';
		do_action($id.$block, $r);
		if(pw_theme_option('toolbox')=="on" && pw_theme_option('hooks')=="on" && current_user_can('edit_theme_options')) echo  '</div>';
	}
}

/**
 * Adds action calls
 *
 * @since PressWork 1.0
 */
 function pw_actionCall($id) {
	if(pw_theme_option('toolbox')=="on" && pw_theme_option('hooks')=="on" && current_user_can('edit_theme_options')) echo '<div class="hooks clear fl"><p class="hooks-title">'.$id.'</p>';
	do_action($id);
	if(pw_theme_option('toolbox')=="on" && pw_theme_option('hooks')=="on" && current_user_can('edit_theme_options')) echo  '</div>';
}