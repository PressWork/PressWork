<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Calls pw_get_element() to display elements according to how they have
 * been placed using the drag and drop function.
 *
 * @since PressWork 1.0
 */

get_header(); ?>
	<?php 
    $layout = pw_theme_option('layout_option');
	if(is_singular()) {
		$fullwidth = get_post_meta($post->ID, 'pw_single_layout', true);
    	if($fullwidth==2) $layout = "maincontent";
    }
    $layout = explode(",", $layout);
    $i = 1;
    foreach($layout as $elem) {
    	pw_get_element($elem, "el".$i);
    	$i++;
    }
    ?>
<?php get_footer(); ?>