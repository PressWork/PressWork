<?php
/**
 * The template for displaying the header.
 *
 * Displays all of the <head> section and everything up till <ul id="main-wrapper">
 * Includes all the action blocks for the header.
 *
 * @since PressWork 1.0
 */
 ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } if ( $paged > 1 ) { echo (' | Page '); echo $paged; } ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", pw_theme_option("body_font")); ?>|<?php echo str_replace(" ", "+", pw_theme_option("headers_font")); ?>' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if(pw_theme_option("toolbox")=="on" && current_user_can( "edit_theme_options" )) echo '<link rel="stylesheet" href="'.PW_THEME_URL.'/admin/css/toolbox-styles.css" type="text/css" media="screen" />'; ?>
<?php pw_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php $favicon = pw_theme_option('favicon'); if(!empty($favicon)) echo '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'" />'."\n"; ?>
<meta name="viewport" content="width=device-width" />

<?php if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
<?php wp_enqueue_script('pw_effects_js'); ?>
<?php
if(current_user_can('edit_theme_options')) {
	wp_enqueue_style( 'farbtastic' );
}
?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php pw_actionCall('pw_body_top'); ?>
<div id="body-wrapper">
    <header id="header-main" role="banner"> <!-- begin header -->
		<?php pw_actionBlock('pw_header'); ?>
    </header> <!-- end header -->
    <ul id="main-wrapper">
	