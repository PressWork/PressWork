<?php
/**
 * This is where the CSS is set up based on the theme options
 *
 * @since PressWork 1.0
 */
 if(pw_theme_option('content_width')) {
	$pw_content_width = pw_theme_option('content_width');
	$pw_first_sidebar = pw_theme_option('first_sidebar_width');
	$pw_second_sidebar = pw_theme_option('second_sidebar_width');
	$pw_body_margins = pw_theme_option('body_margins');
	$pw_margins = pw_theme_option('content_margins');

	$loc2 = strpos(pw_theme_option('layout_option'), "secondsidebar");
	$loc = strpos(pw_theme_option('layout_option'), "firstsidebar");
	$pw_site = $pw_content_width;
	if($pw_first_sidebar>0 && $loc !== false) {
		$pw_site = $pw_site + $pw_first_sidebar + $pw_margins;
	}
	if($pw_second_sidebar>0 && $loc2 !== false) {
		$pw_site = $pw_site + $pw_second_sidebar + $pw_margins;
	}
} else {
	$pw_content_width = 600;
	$pw_first_sidebar = 300;
	$pw_content = 900;
	$pw_margins = 30;
	$pw_site = $pw_content_width + $pw_first_sidebar + $pw_margins;
}
if(!function_exists('pw_header_css')):
	function pw_header_css() {
		global $pw_content_width, $pw_first_sidebar, $pw_second_sidebar, $pw_body_margins, $pw_margins, $pw_site;
		$ipad = 720 / $pw_site;
		$fullsite = $pw_site;
		$mainlineheight = round(pw_theme_option('main_size')*1.4);
		$right_col_padding = get_option('thumbnail_size_w') + 15;
	?>
<!-- PressWork Theme Option CSS -->
<style type="text/css"<?php if(pw_theme_option('toolbox')=="on" && current_user_can( "edit_theme_options" )) echo ' id="pw_style_preview"'; ?>>
body { font-family: <?php echo pw_theme_option("body_font"); ?>; font-size: <?php echo pw_theme_option("body_font_size"); ?>px; }
h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-family: <?php echo pw_theme_option("headers_font"); ?>; }
#body-wrapper { color: <?php echo pw_theme_option('main_text_color'); ?>; width: <?php echo $pw_site; ?>px; padding: <?php echo $pw_body_margins; ?>px; background-color: <?php echo pw_theme_option('page_background_color'); ?>; }
#main-wrapper > li { margin: 0 <?php echo $pw_margins/2; ?>px; }
#main-wrapper .el3 { *margin-left: <?php echo $pw_margins; ?>px; }
#firstsidebar { width: <?php echo $pw_first_sidebar; ?>px; }
#secondsidebar { width: <?php echo $pw_second_sidebar; ?>px; }
#maincontent { width: <?php echo $pw_content_width; ?>px; }
body.fullwidth #maincontent { width: <?php echo $fullsite; ?>px; margin: 0; }
.siteheader a { color: <?php echo pw_theme_option('siteheader_color'); ?>; }
.siteheader a:hover { color: <?php echo pw_theme_option('siteheader_color_hover'); ?>; }
#description { color: <?php echo pw_theme_option('description_color'); ?>; }
a { color: <?php echo pw_theme_option('a_color'); ?>; background: <?php echo pw_theme_option('a_background_color') ; ?> }
a:hover { color: <?php echo pw_theme_option('a_color_hover'); ?>; background: <?php echo pw_theme_option('a_background_color_hover') ; ?> }
#nav nav ul { background: <?php echo pw_theme_option('nav_background_color'); ?>; }
#nav nav a { color: <?php echo pw_theme_option('nav_color'); ?> }
#nav nav a:hover, #nav nav .sub-menu li, #nav nav li:hover { color: <?php echo pw_theme_option('nav_color_hover'); ?>; background: <?php echo pw_theme_option('nav_background_color_hover') ; ?>; }
#subnav nav ul  { background: <?php echo pw_theme_option('subnav_background_color'); ?>; }
#subnav nav a { color: <?php echo pw_theme_option('subnav_color'); ?> }
#subnav nav a:hover, #subnav nav .sub-menu li, #subnav nav li:hover { color: <?php echo pw_theme_option('subnav_color_hover'); ?>; background: <?php echo pw_theme_option('subnav_background_color_hover') ; ?>; }
#footer nav ul  { background: <?php echo pw_theme_option('footernav_background_color'); ?>; }
#footer nav a { color: <?php echo pw_theme_option('footernav_color'); ?> }
#footer nav a:hover, #footer nav .sub-menu li, #footer nav li:hover { color: <?php echo pw_theme_option('footernav_color_hover'); ?>; background: <?php echo pw_theme_option('footernav_background_color_hover') ; ?>; }
h1.catheader { color: <?php echo pw_theme_option('category_header_color'); ?>; }
article .meta { color: <?php echo pw_theme_option('post_meta_color'); ?>; }
article .posttitle, article .posttitle a { color: <?php echo pw_theme_option('post_title_color'); ?>; }
article .posttitle a:hover { color: <?php echo pw_theme_option('post_title_color_hover'); ?>; }
article .content-col { padding-left: <?php echo $right_col_padding; ?>px; }
@media only screen and (max-device-width: 768px), only screen and (max-width: 768px) {
	#body-wrapper {	width: 720px !important; padding: 0 10px; }
	#maincontent { width: <?php echo ($pw_content_width * $ipad) - 10; ?>px !important; }
	#firstsidebar { width: <?php echo $pw_first_sidebar * $ipad; ?>px !important; }
	#secondsidebar { width: <?php echo ($pw_second_sidebar * $ipad) - 15; ?>px !important; }
}
@media only screen and (max-width: 480px), only screen and (max-device-width: 480px) {
	#body-wrapper {	width: 420px !important; padding: 0 10px; }
	#maincontent { width: 420px !important; }
	.home article { width: 100%; }
	#firstsidebar, #secondsidebar { float: none; width: 100% !important; }
	#main-wrapper > li { margin: 0 !important; }
}
</style>
<!-- eof PressWork Theme Option CSS -->
	<?php
	}
endif;