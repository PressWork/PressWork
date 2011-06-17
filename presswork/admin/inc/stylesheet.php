<?php
// Setting up the theme options CSS
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

function pw_header_css() {
	global $pw_content_width, $pw_first_sidebar, $pw_second_sidebar, $pw_body_margins, $pw_margins, $pw_site;
	$fullsite = $pw_site;
	$loc2 = strpos(theme_option('layout_option'), "secondsidebar");
	$loc = strpos(theme_option('layout_option'), "firstsidebar");
	$mainlineheight = round(theme_option('main_size')*1.4);
	$right_col_width = $pw_content_width - get_option('thumbnail_size_w') - 15;
	$first_sidebar_right_col_width = $pw_first_sidebar - 70;
	$second_sidebar_right_col_width = $pw_second_sidebar - 70;
?>
<!-- PressWork Theme Option CSS -->
<style type="text/css"<?php if(theme_option('toolbox')=="on") echo ' id="pw_style_preview"'; ?>>
#body-wrapper { width: <?php echo $pw_site; ?>px; padding-left: <?php echo $pw_body_margins; ?>px; padding-right: <?php echo $pw_body_margins; ?>px; background-color: <?php echo theme_option('page_background_color'); ?>; }
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
#nav nav ul, #nav .sf-menu li li  { background: <?php echo theme_option('nav_background_color'); ?>; }
#nav nav a { color: <?php echo theme_option('nav_color'); ?> }
#nav nav a:hover { color: <?php echo theme_option('nav_color_hover'); ?>; background: <?php echo theme_option('nav_background_color_hover') ; ?> !important; }
#subnav nav ul, #subnav .sf-menu li li  { background: <?php echo theme_option('subnav_background_color'); ?>; }
#subnav nav a { color: <?php echo theme_option('subnav_color'); ?> }
#subnav nav a:hover { color: <?php echo theme_option('subnav_color_hover'); ?>; background: <?php echo theme_option('subnav_background_color_hover') ; ?> !important; }
article .meta { color: <?php echo theme_option('post_meta_color'); ?>; }
article .posttitle, article .posttitle a { color: <?php echo theme_option('post_title_color'); ?>; }
article .posttitle a:hover { color: <?php echo theme_option('post_title_color_hover'); ?>; }
article .content-col { width: <?php echo $right_col_width; ?>px; }
#firstsidebar article.side-featured .content-col { width: <?php echo $first_sidebar_right_col_width; ?>px; }
#secondsidebar article.side-featured .content-col { width: <?php echo $second_sidebar_right_col_width; ?>px; }
<?php if(current_user_can('manage_options') && theme_option('toolbox')=="on") { ?>
body { padding: 0 50px; }
<?php } ?>
</style>
<!-- eof PressWork Theme Option CSS -->
<?php
}