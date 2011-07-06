<?php
/**
 * Functionality for PressWork's toolbox editor
 *
 * @since PressWork 1.0
 */
function pw_toolbox() {
	?>
  	<div id="pw_toolbox">
		<div id="pw_toolbox_controls">
			<div class="open_toolbox options clear fl" rel="options"></div>
			<div class="open_toolbox layout clear fl" rel="layout"></div>
			<div class="open_toolbox color clear fl" rel="color"></div>
			<div class="open_toolbox fonts clear fl" rel="fonts"></div>
			<div class="open_toolbox social clear fl" rel="social"></div>
			<div id="savetheme" class="clear fl"></div>
		</div>	
		<form action="" method="post" name="themeform" id="themeform">
			<div id="options" class="pw_toolbox_content"> 
				<div class="pw_toolbox_arrow"></div>
				<h4>PressWork Settings</h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<tr><th>Drag &amp; Drop Editor </th><td>
						<?php 
						$dragdrop = theme_option('dragdrop');
						$guides = theme_option('guides');
						$functions = theme_option('functions'); 
						?>
						<a href="javascript:void(0)" class="save_option green-button<?php if($dragdrop=="on") echo ' active'; ?>" id="dragdrop"><?php if($dragdrop!="on") echo 'OFF'; else echo "ON" ?></a>
					</td></tr>
					<tr><th>Guides</th><td><a href="javascript:void(0)" class="save_option green-button<?php if($guides=="on") echo ' active'; ?>" id="guides"><?php if($guides!="on") echo 'OFF'; else echo "ON" ?></a></td></tr>
					<tr><th>Functions</th><td><a href="javascript:void(0)" class="save_option green-button<?php if($functions=="on") echo ' active'; ?>" id="functions"><?php if($functions!="on") echo 'OFF'; else echo "ON" ?></a></td></tr>
					<tr><th>Reset all options</th><td><a href="javascript:void(0)" class="green-button" id="reset_options">Reset</a></td></tr>
				</table>
			</div>
			
			<div id="layout" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4>Layout</h4> 
				<div class="closewindow">X</div>
				<div class="lower_box">
					<label>Main Content</label><input type="texbox" class="layout_widths" rel="maincontent" name="content_width" size="4" id="content_width" value="<?php echo theme_option('content_width'); ?>" />&nbsp;&nbsp;<label>First Sidebar</label><input type="texbox" class="layout_widths" rel="firstsidebar" name="first_sidebar_width" size="4" id="first_sidebar_width" value="<?php echo theme_option('first_sidebar_width'); ?>" />&nbsp;&nbsp;<label>Second Sidebar</label><input type="texbox" class="layout_widths" name="second_sidebar_width" size="4" id="second_sidebar_width" rel="secondsidebar" value="<?php echo theme_option('second_sidebar_width'); ?>" /><br />
					<label>Body Margins</label><input type="texbox" class="margins" rel="body-wrapper" name="body_margins" size="4" id="body_margins" value="<?php echo theme_option('body_margins'); ?>" />&nbsp;&nbsp;<label>Content Margins</label><input type="texbox" class="margins" rel="main-wrapper > li" name="content_margins" size="4" id="content_margins" value="<?php echo theme_option('content_margins'); ?>" />
					<br class="clear" />
					<div class="styled-select">
		            <select id="layoutselect">
							<option value="header">Header</option>
							<option value="layout">Main Content</option>
							<option value="footer">Footer</option>
						</select>
		            </div>
						<div class="pw-items">
							<?php pw_add_all_elements(); ?>
						<div class="logo-input clear"><label for="header_logo">Logo Image URL</label><input size="50" type="text" name="header_logo" id="the_header_logo" class="header-item" value="<?php echo theme_option("header_logo"); ?>" /></div>
		            </div>
				</div>
			</div>
			
			<div id="color" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4>Colors</h4> 
				<div class="closewindow">X</div>
				<div class="lower_box">
		            <div class="styled-select">
		            <select id="colorselect">
							<option value="siteheader">Blog Name</option>
							<option value="description">Description</option>
							<option value="links">Links</option>
							<option value="text">Main Text</option>
							<option value="nav">Navigation Menu</option>
							<option value="subnav">Sub-Navigation Menu</option>
							<option value="post_title">Post Title</option>
							<option value="post_meta">Post Meta</option>
							<option value="page_background">Page Background</option>
						</select>
		            </div>
						<table class="themeoptions">
						<?php pw_add_all_color_options(); ?>
						</table>		
		            <a href="javascript:void(0)" class="green-button" id="pw-preview">Preview</a>	
					<div id="closepicker">&larr;</div>
					<div id="picker"></div>
				</div>
			</div>			
			<div id="fonts" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4>Fonts</h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<?php pw_font_option('headers', 'Headers', 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a'); ?>
					<?php pw_font_option('body', 'Body', '#body-wrapper'); ?>
					<tr><th>Font Size</th><td><input type="text" name="body_font_size" id="body_font_size" value="<?php echo theme_option("body_font_size"); ?>" size="4" /> px</td></tr>
		        </table>
		        <p>Fonts by <a href="http://www.google.com/webfonts?subset=latin&sort=pop" target="_blank">Google</a></p>
			</div>
			
			<div id="social" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4>Social</h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<?php pw_social_option("twitter", "Twitter"); ?>
					<?php pw_social_option("facebook", "Facebook"); ?>
					<?php pw_social_option("flickr", "Flickr"); ?>
		        </table>
			</div>			
	
			<input type="hidden" name="font_option" id="font_option" value="<?php echo theme_option('font_option'); ?>" />
			<input type="hidden" name="layout_option" id="layout_option" value="<?php echo theme_option('layout_option'); ?>" />
			<input type="hidden" name="header_option" id="header_option" value="<?php echo theme_option('header_option'); ?>" />
			<input type="hidden" name="footer_option" id="footer_option" value="<?php echo theme_option('footer_option'); ?>" />
	    	<?php if(function_exists('wp_nonce_field')) wp_nonce_field('bavotasan_nonce', 'bavotasan_nonce'); ?>
   	</form>
	</div>  	
   	<div id="ajaxloader"></div>
	<div id="save_message">PressWork Updated</div>
    <?php
}

if(!function_exists('pw_add_all_color_options')) :
	function pw_add_all_color_options() {
		?>
		<?php pw_color_option('siteheader', 'siteheader_color', 'Color', '.siteheader a|color'); ?>
		<?php pw_color_option('siteheader', 'siteheader_color_hover', 'Hover Color', '.siteheader a:hover|color'); ?>
		<?php pw_color_option('description', 'description_color', 'Color', '#description|color'); ?>
		<?php pw_color_option('links', 'a_color', 'Color', 'a|color'); ?>
		<?php pw_color_option('links', 'a_color_hover', 'Hover Color', 'a:hover|color'); ?>
		<?php pw_color_option('text', 'main_text_color', 'Color', 'body|color'); ?>
		<?php pw_color_option('nav', 'nav_color', 'Color', '#nav nav a|color'); ?>
		<?php pw_color_option('nav', 'nav_color_hover', 'Hover Color', '#nav nav a:hover|color'); ?>
		<?php pw_color_option('nav', 'nav_background_color', 'BG Color', '#nav nav ul|background-color'); ?>
		<?php pw_color_option('nav', 'nav_background_color_hover', 'BG Hover Color', '#nav nav a:hover, #nav .sub-menu li, #nav .sfHover|background-color'); ?>
		<?php pw_color_option('subnav', 'subnav_color', 'Color', '#subnav nav a|color'); ?>
		<?php pw_color_option('subnav', 'subnav_color_hover', 'Hover Color', '#subnav nav a:hover|color'); ?>
		<?php pw_color_option('subnav', 'subnav_background_color', 'BG Color', '#subnav nav ul|background-color'); ?>
		<?php pw_color_option('subnav', 'subnav_background_color_hover', 'BG Hover Color', '#subnav nav a:hover, #subnav .sub-menu li, #subnav .sfHover|background-color'); ?>
		<?php pw_color_option('footernav', 'footernav_color', 'Color', '#footernav nav a|color'); ?>
		<?php pw_color_option('footernav', 'footernav_color_hover', 'Hover Color', '#footernav nav a:hover|color'); ?>
		<?php pw_color_option('footernav', 'footernav_background_color', 'BG Color', '#footernav nav ul|background-color'); ?>
		<?php pw_color_option('footernav', 'footernav_background_color_hover', 'BG Hover Color', '#subnav nav a:hover, #footernav .sub-menu li, #subnav .sfHover|background-color'); ?>
		<?php pw_color_option('post_title', 'post_title_color', 'Color', 'article .posttitle, article .posttitle a|color'); ?>
		<?php pw_color_option('post_title', 'post_title_color_hover', 'Hover Color', 'article .posttitle a:hover|color'); ?>
		<?php pw_color_option('post_meta', 'post_meta_color', 'Color', 'article .meta|color'); ?>
		<?php pw_color_option('page_background', 'page_background_color', 'BG Color', '#body-wrapper|background-color'); ?>
		<?php
	}
endif;

if(!function_exists('pw_add_all_elements')) :
function pw_add_all_elements() {
	?>
	<?php pw_add_element_option('header', 'header_logo', 'Logo', 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'blogname', 'Blog Name', 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'description', 'Description', 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'nav', 'Nav Menu', 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'subnav', 'Sub Nav Menu', 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'headerarea', 'Widgetized Area', 'headerbanner|header'); ?>
	<?php pw_add_element_option('layout', 'firstsidebar', 'First Sidebar', 'main-wrapper|layout'); ?>
	<?php pw_add_element_option('layout', 'secondsidebar', 'Second Sidebar', 'main-wrapper|layout'); ?>
	<?php pw_add_element_option('footer', 'footernav', 'Footer Nav Menu', 'footer|footer'); ?>
	<?php pw_add_element_option('footer', 'extendedfooter', 'Extended Footer', 'footer|footer'); ?>
	<?php pw_add_element_option('footer', 'copyright', 'Copyright', 'footer|footer'); ?>
	<?php
}
endif;