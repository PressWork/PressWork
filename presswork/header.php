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
<!--[if IE]><![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); if(is_front_page()) { echo ' | '; bloginfo('description'); } if ( $paged > 1 ) { echo (' | Page '); echo $paged; } ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php 
global $pw_google_fonts; 
if(pw_theme_option("toolbox")=="on" && current_user_can( "edit_theme_options" )) { ?>
<link href="http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", implode("|", $pw_google_fonts)); ?>" rel="stylesheet" type="text/css" /> 
<?php } else { ?>
<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", pw_theme_option("body_font")); ?>|<?php echo str_replace(" ", "+", pw_theme_option("headers_font")); ?>' rel='stylesheet' type='text/css' />
<?php } ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if(pw_theme_option("toolbox")=="on" && current_user_can( "edit_theme_options" )) echo '<link rel="stylesheet" href="'.PW_THEME_URL.'/admin/css/toolbox-styles.css" type="text/css" media="screen" />'; ?>
<?php pw_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php $favicon = pw_theme_option('favicon'); if(!empty($favicon)) echo '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'" />'."\n"; ?>
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width" />

<?php if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
<?php wp_enqueue_script( 'jquery' ); ?>
<?php if(pw_theme_option('toolbox')=="on" && current_user_can( "edit_theme_options" )) wp_enqueue_script( 'jquery-ui-sortable' ); ?>
<?php if(current_user_can('edit_theme_options')) wp_enqueue_style( 'farbtastic' ); ?>
<?php wp_head(); ?>
</head>

<!--[if lt IE 7 ]> <body <?php body_class("ie6"); ?>> <![endif]-->
<!--[if IE 7 ]>    <body <?php body_class("ie7"); ?>> <![endif]-->
<!--[if IE 8 ]>    <body <?php body_class("ie8"); ?>> <![endif]-->
<!--[if IE 9 ]>    <body <?php body_class("ie9"); ?>> <![endif<]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body <?php body_class(); ?>> <!--<![endif]-->

<?php pw_actionCall('pw_body_top'); ?>
<div id="body-wrapper" class="clearfix">
    <header id="header-main" role="banner"> <!-- begin header -->
		<?php pw_actionBlock('pw_header'); ?>
    </header> <!-- end header -->
    <ul id="main-wrapper">
	