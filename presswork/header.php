<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } if ( $paged > 1 ) { echo (' | Page '); echo $paged; } ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", theme_option("body_font")); ?>|<?php echo str_replace(" ", "+", theme_option("headers_font")); ?>' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if(theme_option("toolbox")=="on" && current_user_can( "manage_options" )) echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/admin/css/toolbox-styles.css" type="text/css" media="screen" />'; ?>
<?php pw_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/admin/images/favicon.ico" />	

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
    <header> <!-- begin header -->
		<?php actionBlock('pw_header'); ?>
    </header> <!-- end header -->
    <section> <!-- begin section -->
	    <ul id="main-wrapper">
	