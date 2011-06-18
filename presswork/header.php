<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } if ( $paged > 1 ) { echo (' | Page '); echo $paged; } ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href='http://fonts.googleapis.com/css?family=Quattrocento|Metrophobic|Special+Elite' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/admin/css/<?php echo theme_option("font_option"); ?>.css" type="text/css" media="screen" />
<?php pw_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
<?php wp_enqueue_script('effects_js'); ?>
<?php
if(current_user_can('manage_options')) {
	wp_enqueue_style( 'farbtastic' );
}
?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php actionCall('pw_body_top'); ?>
<div id="body-wrapper">
	<?php actionCall('pw_wrapper_top'); ?>
    <header> <!-- begin header -->
        <ul id="headerbanner" class="fl clear">
           	<?php 
		    $layout = theme_option('header_option');
		    $layout = explode(",", $layout);
		    foreach($layout as $elem) {
		    	pw_get_element($elem);
		    }
		    ?>
        </ul> <!-- end headerbanner -->
    </header> <!-- end header -->
    <section> <!-- begin section -->
	    <ul id="main-wrapper">
	