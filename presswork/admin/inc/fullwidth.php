<?php
if(!function_exists('pw_layout_option')) :
/**
 * This adds a panel on the post/page edit screen to select
 * a full width (no sidebar) layout for the specific post/page
 *
 * @since PressWork 1.0
 */	
	function pw_layout_option() {
		global $post;
		$layout = get_post_meta($post->ID, 'pw_single_layout', true);
		
		if(function_exists('wp_nonce_field')) wp_nonce_field('presswork_nonce', 'presswork_nonce');
		
		echo '<table border="0" cellpadding="0" cellspacing="5">';
		echo '<tr><td><input name="pw_single_layout" type="radio" value="1"'; if($layout == 1 || !$layout) echo ' checked="checked"'; echo ' /></td><td>'.__('Default', "presswork").'</td></tr>';
		echo '<tr><td><input name="pw_single_layout" type="radio" value="2"'; checked($layout, 2); echo ' /></td><td>'.__('Full width', "presswork").'</td></tr>';
		echo '</table>';
	}
endif;

if(!function_exists('pw_create_meta_box')) :
/**
 * This initializes the full width meta box
 *
 * @since PressWork 1.0
 */	
	function pw_create_meta_box() {
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'presswork-layout-options', __('Layout', "presswork"), 'pw_layout_option', 'post', 'side', 'low' );
			add_meta_box( 'presswork-layout-options', __('Layout', "presswork"), 'pw_layout_option', 'page', 'side', 'low' );
		}
	}
endif;

if(!function_exists('pw_save_postdata')) :
/**
 * This saves the full width meta box option
 *
 * @since PressWork 1.0
 */	
	function pw_save_postdata($post_id) {
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
      		return;

		if(!empty($_POST['presswork_nonce']) && !wp_verify_nonce($_POST['presswork_nonce'], "presswork_nonce"))
  			return;
		
		if(!empty($_POST['post_type'])) {
			if('page'==$_POST['post_type']) {
				if(!current_user_can('edit_page', $post_id))
					return;
			} else {
				if(!current_user_can('edit_post', $post_id))
					return;
			}
		}

		if(!empty($_POST['pw_single_layout'])) {
			$pw_single_layout = (int) $_POST['pw_single_layout'];
			update_post_meta($post_id, 'pw_single_layout', $pw_single_layout);
		}
	}
endif;
add_action('add_meta_boxes', 'pw_create_meta_box');
add_action('save_post', 'pw_save_postdata');

if(!function_exists('pw_fullWidth')) :
/**
 * Adds the fullwidth class to the body tag
 *
 * @since PressWork 1.0
 */	
 	function pw_fullWidth($classes = '') {
		global $post;
		$added = '';
		if(!empty($post)) {
			$full = get_post_meta($post->ID, 'pw_single_layout', true);
			if($full==2 && is_singular()) { 
				$classes[] = 'fullwidth'; 
				$added = true; 
			}
		}
		if(pw_theme_option('layout_option')=="maincontent" && empty($added)) $classes[] = 'fullwidth';
		return $classes;
	}
endif;
add_filter('body_class','pw_fullWidth');