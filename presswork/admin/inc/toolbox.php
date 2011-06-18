<?php
function pw_toolbox() {
	?>
  	<div id="pw_toolbox">
		<form action="" method="post" name="themeform" id="themeform">
			<div id="options" class="pw_toolbox_content">  
    			<div class="close_toolbox"></div>
 				<table class="themeoptions">
    			<tr><th>Drag &amp; Drop Editor </th><td>
    				<?php $dragdrop = theme_option('dragdrop'); ?>
    				<?php $guides = theme_option('guides'); ?>
					<a href="javascript:void(0)" class="save_option green-button<?php if($dragdrop=="on") echo ' active'; ?>" id="dragdrop"><?php if($dragdrop=="on") echo 'OFF'; else echo "ON" ?></a>
				</td></tr>
 				<tr><th>Framework Guides</th><td><a href="javascript:void(0)" class="save_option green-button<?php if($guides=="on") echo ' active'; ?>" id="guides"><?php if($guides=="on") echo 'OFF'; else echo "ON" ?></a></td></tr>
 				<tr><th>Reset all options</th><td><a href="javascript:void(0)" class="green-button" id="reset_options">Reset</a></td></tr>
 				</table>
 			</div>
			
			<div id="layout" class="pw_toolbox_content">  
   				<div class="close_toolbox"></div>
				<label>Main Content</label><input type="texbox" class="layout_widths" rel="maincontent" name="content_width" size="5" id="content_width" value="<?php echo theme_option('content_width'); ?>" />&nbsp;&nbsp;<label>First Sidebar</label><input type="texbox" class="layout_widths" rel="firstsidebar" name="first_sidebar_width" size="5" id="first_sidebar_width" value="<?php echo theme_option('first_sidebar_width'); ?>" />&nbsp;&nbsp;<label>Second Sidebar</label><input type="texbox" class="layout_widths" name="second_sidebar_width" size="5" id="second_sidebar_width" rel="secondsidebar" value="<?php echo theme_option('second_sidebar_width'); ?>" />
				<br class="clear" />
 				<div class="styled-select">
                <select id="layoutselect">
 					<option value="--">--</option>
 					<option value="header">Header</option>
 					<option value="layout">Main Content</option>
 					<option value="footer">Footer</option>
 				</select>
                </div>
 				<div class="pw-items">
 					<?php pw_add_element_option('header', 'blogname', 'Blog Name', 'headerbanner|header'); ?>
 					<?php pw_add_element_option('header', 'description', 'Description', 'headerbanner|header'); ?>
 					<?php pw_add_element_option('header', 'nav', 'Nav Menu', 'headerbanner|header'); ?>
 					<?php pw_add_element_option('header', 'subnav', 'Sub Nav Menu', 'headerbanner|header'); ?>
 					<?php pw_add_element_option('header', 'headerarea', 'Widgetized Area', 'headerbanner|header'); ?>
 					<?php pw_add_element_option('layout', 'firstsidebar', 'First Sidebar', 'main-wrapper|layout'); ?>
 					<?php pw_add_element_option('layout', 'secondsidebar', 'Second Sidebar', 'main-wrapper|layout'); ?>
 					<?php pw_add_element_option('footer', 'extendedfooter', 'Extended Footer', 'footer|footer'); ?>
 					<?php pw_add_element_option('footer', 'copyright', 'Copyright', 'footer|footer'); ?>
				</div>
    		</div>
			
			<div id="color" class="pw_toolbox_content">  
    			<div class="close_toolbox"></div>
                <div class="styled-select">
                <select id="colorselect">
 					<option value="--">--</option>
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
					<?php pw_color_option('siteheader', 'siteheader_color', 'Color', '.siteheader a|color'); ?>
					<?php pw_color_option('siteheader', 'siteheader_color_hover', 'Hover Color', '.siteheader a:hover|color'); ?>
					<?php pw_color_option('description', 'description_color', 'Color', '#description|color'); ?>
					<?php pw_color_option('links', 'a_color', 'Color', 'a|color'); ?>
					<?php pw_color_option('links', 'a_color_hover', 'Hover Color', 'a:hover|color'); ?>
					<?php pw_color_option('text', 'main_text_color', 'Color', 'body|color'); ?>
					<?php pw_color_option('nav', 'nav_color', 'Color', '#nav nav a|color'); ?>
					<?php pw_color_option('nav', 'nav_color_hover', 'Hover Color', '#nav nav a:hover|color'); ?>
					<?php pw_color_option('nav', 'nav_background_color', 'BG Color', '#nav nav ul, #nav .sf-menu li li|background-color'); ?>
					<?php pw_color_option('nav', 'nav_background_color_hover', 'BG Hover Color', '#nav nav a:hover|background-color'); ?>
					<?php pw_color_option('subnav', 'subnav_color', 'Color', '#subnav nav a|color'); ?>
					<?php pw_color_option('subnav', 'subnav_color_hover', 'Hover Color', '#subnav nav a:hover|color'); ?>
					<?php pw_color_option('subnav', 'subnav_background_color', 'BG Color', '#subnav nav ul, #subnav .sf-menu li li|background-color'); ?>
					<?php pw_color_option('subnav', 'subnav_background_color_hover', 'BG Hover Color', '#subnav nav a:hover|background-color'); ?>
  					<?php pw_color_option('post_title', 'post_title_color', 'Color', '.posttitle, .posttitle a|color'); ?>
  					<?php pw_color_option('post_title', 'post_title_color_hover', 'Hover Color', '.posttitle a:hover|color'); ?>
					<?php pw_color_option('post_meta', 'post_meta_color', 'Color', 'article .meta|color'); ?>
					<?php pw_color_option('page_background', 'page_background_color', 'BG Color', '#body-wrapper|background-color'); ?>
				</table>		
                <a href="javascript:void(0)" class="green-button" id="pw-preview">Preview</a>	
 				<div id="picker"></div>
 			</div>
			
			<div id="fonts" class="pw_toolbox_content">  
    			<div class="close_toolbox"></div>
    			<p>Select a font group</p>
                <a href="javascript:void(0)" class="font-option<?php if(theme_option('font_option')=="font-style-one") echo ' active'; ?>" id="font-style-one"></a>	
                <a href="javascript:void(0)" class="font-option<?php if(theme_option('font_option')=="font-style-two") echo ' active'; ?>" id="font-style-two"></a>	
                <a href="javascript:void(0)" class="font-option<?php if(theme_option('font_option')=="font-style-three") echo ' active'; ?>" id="font-style-three"></a>	
                <a href="javascript:void(0)" class="font-option<?php if(theme_option('font_option')=="font-style-four") echo ' active'; ?>" id="font-style-four"></a>	
                <a href="javascript:void(0)" class="font-option<?php if(theme_option('font_option')=="font-style-five") echo ' active'; ?>" id="font-style-five"></a>	
 			</div>
			
			<div class="open_toolbox options" rel="options"></div>
  			<div class="open_toolbox layout" rel="layout"></div>
  			<div class="open_toolbox color" rel="color"></div>
  			<div class="open_toolbox fonts" rel="fonts"></div>
  			<div id="savetheme"></div>
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