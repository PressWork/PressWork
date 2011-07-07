<?php
/**
 * This is where the CSS is set up based on the theme options
 *
 * @since PressWork 1.0
 */
 if(theme_option('content_width')) {
	$pw_content_width = theme_option('content_width');
	$pw_first_sidebar = theme_option('first_sidebar_width');
	$pw_second_sidebar = theme_option('second_sidebar_width');
	$pw_body_margins = theme_option('body_margins');
	$pw_margins = theme_option('content_margins');

	$loc2 = strpos(theme_option('layout_option'), "secondsidebar");
	$loc = strpos(theme_option('layout_option'), "firstsidebar");
	$pw_site = $pw_content_width;
	if($pw_first_sidebar>0 && $loc !== false) {
		$pw_site = $pw_site + $pw_first_sidebar + $pw_margins + ($pw_body_margins*2);
	}
	if($pw_second_sidebar>0 && $loc2 !== false) {
		$pw_site = $pw_site + $pw_second_sidebar + $pw_margins + ($pw_body_margins*2);
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
		$fullsite = $pw_site;
		$loc2 = strpos(theme_option('layout_option'), "secondsidebar");
		$loc = strpos(theme_option('layout_option'), "firstsidebar");
		$mainlineheight = round(theme_option('main_size')*1.4);
		$right_col_padding = get_option('thumbnail_size_w') + 15;
	?>
	<!-- PressWork Theme Option CSS -->
	<style type="text/css"<?php if(theme_option('toolbox')=="on" && current_user_can( "manage_options" )) echo ' id="pw_style_preview"'; ?>>
	body { font-family: <?php echo theme_option("body_font"); ?>; font-size: <?php echo theme_option("body_font_size"); ?>px; }
	h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-family: <?php echo theme_option("headers_font"); ?>; }
	#body-wrapper { color: <?php echo theme_option('main_text_color'); ?>; width: <?php echo $pw_site; ?>px; padding: <?php echo $pw_body_margins; ?>px; background-color: <?php echo theme_option('page_background_color'); ?>; }
	#main-wrapper > li { margin: 0 <?php echo $pw_margins/2; ?>px; }
	#firstsidebar { width: <?php echo $pw_first_sidebar; ?>px; }
	#secondsidebar { width: <?php echo $pw_second_sidebar; ?>px; }
	#maincontent { width: <?php echo $pw_content_width; ?>px; }
	body.fullwidth #maincontent { width: <?php echo $fullsite; ?>px; margin: 0; }
	.siteheader a { color: <?php echo theme_option('siteheader_color'); ?>; }
	.siteheader a:hover { color: <?php echo theme_option('siteheader_color_hover'); ?>; }
	#description { color: <?php echo theme_option('description_color'); ?>; }
	a { color: <?php echo theme_option('a_color'); ?>; background: <?php echo theme_option('a_background_color') ; ?> }
	a:hover { color: <?php echo theme_option('a_color_hover'); ?>; background: <?php echo theme_option('a_background_color_hover') ; ?> }
	#nav nav ul { background: <?php echo theme_option('nav_background_color'); ?>; }
	#nav nav a { color: <?php echo theme_option('nav_color'); ?> }
	#nav nav a:hover, #nav .sub-menu li, #nav .sfHover { color: <?php echo theme_option('nav_color_hover'); ?>; background: <?php echo theme_option('nav_background_color_hover') ; ?>; }
	#subnav nav ul  { background: <?php echo theme_option('subnav_background_color'); ?>; }
	#subnav nav a { color: <?php echo theme_option('subnav_color'); ?> }
	#subnav nav a:hover, #subnav .sub-menu li, #subnav .sfHover { color: <?php echo theme_option('subnav_color_hover'); ?>; background: <?php echo theme_option('subnav_background_color_hover') ; ?>; }
	#footer nav ul  { background: <?php echo theme_option('footernav_background_color'); ?>; }
	#footer nav a { color: <?php echo theme_option('footernav_color'); ?> }
	#footer nav a:hover, #footer .sub-menu li, #footer .sfHover { color: <?php echo theme_option('footernav_color_hover'); ?>; background: <?php echo theme_option('footernav_background_color_hover') ; ?>; }
	h1.catheader { color: <?php echo theme_option('category_header_color'); ?>; }
	article .meta { color: <?php echo theme_option('post_meta_color'); ?>; }
	article .posttitle, article .posttitle a { color: <?php echo theme_option('post_title_color'); ?>; }
	article .posttitle a:hover { color: <?php echo theme_option('post_title_color_hover'); ?>; }
	article .content-col { padding-left: <?php echo $right_col_padding; ?>px; }
	.authortext { width: <?php echo $pw_content_width-100; ?>px; }
	</style>
	<!-- eof PressWork Theme Option CSS -->
	<?php
	}
endif;