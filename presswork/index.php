<?php get_header(); ?>
	<?php 
    $layout = theme_option('layout_option');
	$fullwidth = get_post_meta($post->ID, 'pw_single_layout', true);
    if($fullwidth==2) $layout = "maincontent";
    $layout = explode(",", $layout);
    foreach($layout as $elem) {
    	pw_get_element($elem);
    }
    ?>
<?php get_footer(); ?>