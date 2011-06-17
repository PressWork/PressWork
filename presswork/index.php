<?php get_header(); ?>
	<?php 
    $layout = theme_option('layout_option');
    $layout = explode(",", $layout);
    foreach($layout as $elem) {
    	pw_get_element($elem);
    }
    ?>
<?php get_footer(); ?>