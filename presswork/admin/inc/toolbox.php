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
			<div class="open_toolbox options clear fl" data-pw-toolbox-name="options" title="PressWork Options"></div>
			<div class="open_toolbox layout clear fl" data-pw-toolbox-name="layout" title="Layout Options"></div>
			<div class="open_toolbox color clear fl" data-pw-toolbox-name="color" title="Color Options"></div>
			<div class="open_toolbox fonts clear fl" data-pw-toolbox-name="fonts" title="Font Options"></div>
			<div class="open_toolbox social clear fl" data-pw-toolbox-name="social" title="Social Options"></div>
			<?php do_action('pw_add_toolbox_icon'); ?>
			<div id="savetheme" class="clear fl" title="Save Button"></div>
		</div>	
		<form method="post" name="themeform" id="themeform" autocomplete="off">
			<div id="options" class="pw_toolbox_content"> 
				<div class="pw_toolbox_arrow"></div>
				<h4><?php _e('PressWork Settings', "presswork"); ?></h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<tr><th><?php _e('Drag &amp; Drop Editor', "presswork"); ?></th><td>
						<?php 
						$dragdrop = pw_theme_option('dragdrop');
						$hooks = pw_theme_option('hooks');
						$functions = pw_theme_option('functions'); 
						?>
						<a href="javascript:void(0)" class="save_option green-button<?php if($dragdrop=="on") echo ' active'; ?>" id="dragdrop"><?php if($dragdrop!="on") _e('OFF', "presswork"); else _e('ON', "presswork"); ?></a>
					</td></tr>
					<tr><th><?php _e('Hooks', "presswork");?></th><td><a href="javascript:void(0)" class="save_option green-button<?php if($hooks=="on") echo ' active'; ?>" id="hooks"><?php if($hooks!="on") _e('OFF', "presswork"); else _e('ON', "presswork"); ?></a></td></tr>
					<tr><th><?php _e('Functions', "presswork"); ?></th><td><a href="javascript:void(0)" class="save_option green-button<?php if($functions=="on") echo ' active'; ?>" id="functions"><?php if($functions!="on") _e('OFF', "presswork"); else _e('ON', "presswork"); ?></a></td></tr>
					<tr><th><?php _e('Reset all options', "presswork"); ?></th><td><a href="javascript:void(0)" class="green-button" id="reset_options"><?php _e('Reset', "presswork"); ?></a></td></tr>
					<?php do_action('pw_presswork_options'); ?>
				</table>
			</div>
			
			<div id="layout" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4><?php _e('Layout', "presswork"); ?></h4> 
				<div class="closewindow">X</div>
				<div class="lower_box">
					<?php pw_layout_widths(); ?>
					<div class="styled-select clearfix">
		           		<select id="layoutselect">
							<?php pw_layout_options(); ?>
						</select>
		            </div>
					<div class="pw-items">
						<?php pw_add_all_elements(); ?>
		            </div>
				</div>
			</div>
			
			<div id="color" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4><?php _e('Colors', "presswork"); ?></h4> 
				<div class="closewindow">X</div>
				<div class="lower_box">
		            <div class="styled-select">
			            <select id="colorselect">
							<?php pw_color_select_options(); ?>
						</select>
		            </div>
						<table class="themeoptions">
						<?php pw_add_all_color_options(); ?>
						</table>		
					<div id="picker"></div>
				</div>
			</div>			
			<div id="fonts" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4><?php _e('Fonts', "presswork"); ?></h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<?php pw_font_option('headers', __('Headers', "presswork"), '#body-wrapper h1, #body-wrapper h2, #body-wrapper h3, #body-wrapper h4, #body-wrapper h5, #body-wrapper h6, #body-wrapper h1 a, #body-wrapper h2 a, #body-wrapper h3 a, #body-wrapper h4 a, #body-wrapper h5 a, #body-wrapper h6 a'); ?>
					<?php pw_font_option('body', __('Body', "presswork"), '#body-wrapper'); ?>
					<tr><th><?php _e('Font Size', "presswork"); ?></th><td><input type="text" name="body_font_size" id="body_font_size" value="<?php echo pw_theme_option("body_font_size"); ?>" size="4" /> px</td></tr>
		        </table>
		        <p><?php _e('Fonts by', "presswork"); ?> <a href="http://www.google.com/webfonts?subset=latin&amp;sort=pop" target="_blank">Google</a></p>
			</div>
			
			<div id="social" class="pw_toolbox_content">  
				<div class="pw_toolbox_arrow"></div>
				<h4><?php _e('Social', "presswork"); ?></h4> 
				<div class="closewindow">X</div>
				<table class="themeoptions">
					<?php pw_social_option("twitter", "Twitter", __("Username (without @)", "presswork")); ?>
					<?php pw_social_option("facebook", "Facebook",  __("Username", "presswork")); ?>
					<?php pw_social_option("flickr", "Flickr", __("User ID", "presswork")); ?>
					<?php pw_social_option("googleplus", "Google +", __("User ID", "presswork")); ?>
					<?php pw_social_option("linkedin", "LinkedIn", __("Username", "presswork")); ?>
					<?php pw_social_option("stumbleupon", "StumbleUpon", __("Username", "presswork")); ?>
		        </table>
			</div>			
	
			<input type="hidden" name="layout_option" id="layout_option" value="<?php echo pw_theme_option('layout_option'); ?>" />
			<input type="hidden" name="header_option" id="header_option" value="<?php echo pw_theme_option('header_option'); ?>" />
			<input type="hidden" name="footer_option" id="footer_option" value="<?php echo pw_theme_option('footer_option'); ?>" />
	    	<?php if(function_exists('wp_nonce_field')) wp_nonce_field('presswork_nonce', 'presswork_nonce'); ?>
	    	<?php do_action('pw_add_toolbox_item'); ?>
   	</form>
	</div>  	
   	<div id="ajaxloader"></div>
	<div id="save_message"><?php echo PW_THEME_NAME; echo ' '; _e('Updated', "presswork"); ?></div>
    <?php
}

if(!function_exists('pw_layout_widths')) :
	function pw_layout_widths() {
		?>
		<label><?php _e('Main Content', "presswork"); ?></label><input type="text" class="layout_widths" data-pw-ids="maincontent" name="content_width" size="4" id="content_width" value="<?php echo pw_theme_option('content_width'); ?>" />&nbsp;&nbsp;
		<label><?php _e('First Sidebar', "presswork"); ?></label><input type="text" class="layout_widths" data-pw-ids="firstsidebar" name="first_sidebar_width" size="4" id="first_sidebar_width" value="<?php echo pw_theme_option('first_sidebar_width'); ?>" />&nbsp;&nbsp;
		<label><?php _e('Second Sidebar', "presswork"); ?></label><input type="text" class="layout_widths" name="second_sidebar_width" size="4" id="second_sidebar_width" data-pw-ids="secondsidebar" value="<?php echo pw_theme_option('second_sidebar_width'); ?>" />
		<br />
		<label><?php _e('Body Margins', "presswork"); ?></label><input type="text" class="margins" data-pw-ids="body-wrapper" name="body_margins" size="4" id="body_margins" value="<?php echo pw_theme_option('body_margins'); ?>" />&nbsp;&nbsp;
		<label><?php _e('Content Margins', "presswork"); ?></label><input type="text" class="margins" data-pw-ids="main-wrapper > li" name="content_margins" size="4" id="content_margins" value="<?php echo pw_theme_option('content_margins'); ?>" />
		<?php
	}
endif;

if(!function_exists('pw_layout_options')) :
	function pw_layout_options() {
		?>
		<option value="header"><?php _e('Header', "presswork"); ?></option>
		<option value="layout"><?php _e('Main Content', "presswork"); ?></option>
		<option value="footer"><?php _e('Footer', "presswork"); ?></option>
		<?php
	}
endif;

if(!function_exists('pw_add_all_color_options')) :
	function pw_add_all_color_options() {
		?>
		<?php pw_color_option('siteheader', 'siteheader_color', __('Color', "presswork"), '.siteheader a|color'); ?>
		<?php pw_color_option('siteheader', 'siteheader_color_hover', __('Hover Color', "presswork"), '.siteheader a:hover|color'); ?>
		<?php pw_color_option('description', 'description_color', __('Color', "presswork"), '#description|color'); ?>
		<?php pw_color_option('links', 'a_color', __('Color', "presswork"), 'a|color'); ?>
		<?php pw_color_option('links', 'a_color_hover', __('Hover Color', "presswork"), 'a:hover|color'); ?>
		<?php pw_color_option('text', 'main_text_color', __('Color', "presswork"), '#body-wrapper|color'); ?>
		<?php pw_color_option('nav', 'nav_color', __('Color', "presswork"), '#nav nav a|color'); ?>
		<?php pw_color_option('nav', 'nav_color_hover', __('Hover Color', "presswork"), '#nav nav a:hover|color'); ?>
		<?php pw_color_option('nav', 'nav_background_color', __('BG Color', "presswork"), '#nav nav ul|background-color'); ?>
		<?php pw_color_option('nav', 'nav_background_color_hover', __('BG Hover Color', "presswork"), '#nav nav a:hover, #nav nav .sub-menu li, #nav nav li:hover|background-color'); ?>
		<?php pw_color_option('subnav', 'subnav_color', __('Color', "presswork"), '#subnav nav a|color'); ?>
		<?php pw_color_option('subnav', 'subnav_color_hover', __('Hover Color', "presswork"), '#subnav nav a:hover|color'); ?>
		<?php pw_color_option('subnav', 'subnav_background_color', __('BG Color', "presswork"), '#subnav nav ul|background-color'); ?>
		<?php pw_color_option('subnav', 'subnav_background_color_hover', __('BG Hover Color', "presswork"), '#subnav nav a:hover, #subnav nav .sub-menu li, #subnav nav li:hover|background-color'); ?>
		<?php pw_color_option('footernav', 'footernav_color', __('Color', "presswork"), '#footernav nav a|color'); ?>
		<?php pw_color_option('footernav', 'footernav_color_hover', __('Hover Color', "presswork"), '#footernav nav a:hover|color'); ?>
		<?php pw_color_option('footernav', 'footernav_background_color', __('BG Color', "presswork"), '#footernav nav ul|background-color'); ?>
		<?php pw_color_option('footernav', 'footernav_background_color_hover', __('BG Hover Color', "presswork"), '#footernav nav a:hover, #footernav nav .sub-menu li, #footernav nav li:hover|background-color'); ?>
		<?php pw_color_option('category_header', 'category_header_color', __('Category Header', "presswork"), 'h1.catheader|color'); ?>
		<?php pw_color_option('post_title', 'post_title_color', __('Color', "presswork"), 'article .posttitle, article .posttitle a|color'); ?>
		<?php pw_color_option('post_title', 'post_title_color_hover', __('Hover Color', "presswork"), 'article .posttitle a:hover|color'); ?>
		<?php pw_color_option('post_meta', 'post_meta_color', __('Color', "presswork"), 'article .meta|color'); ?>
		<?php pw_color_option('page_background', 'page_background_color', __('BG Color', "presswork"), '#body-wrapper|background-color'); ?>
		<?php
	}
endif;

if(!function_exists('pw_color_select_options')) :
function pw_color_select_options() {
	?>
	<option value="siteheader"><?php _e('Blog Name', "presswork"); ?></option>
	<option value="description"><?php _e('Description', "presswork"); ?></option>
	<option value="links"><?php _e('Links', "presswork"); ?></option>
	<option value="text"><?php _e('Main Text', "presswork"); ?></option>
	<option value="nav"><?php _e('Primary Menu', "presswork"); ?></option>
	<option value="subnav"><?php _e('Secondary Menu', "presswork"); ?></option>
	<option value="footernav"><?php _e('Footer Menu', "presswork"); ?></option>
	<option value="category_header"><?php _e('Category Header', "presswork"); ?></option>
	<option value="post_title"><?php _e('Post Title', "presswork"); ?></option>
	<option value="post_meta"><?php _e('Post Meta', "presswork"); ?></option>
	<option value="page_background"><?php _e('Page Background', "presswork"); ?></option>
	<?php
}
endif;

if(!function_exists('pw_add_all_elements')) :
function pw_add_all_elements() {
	?>
	<?php pw_add_element_option('header', 'header_logo', __('Logo', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'header_image', __('Header Image', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'blogname', __('Blog Name', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'description', __('Description', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'nav', __('Primary Menu', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'subnav', __('Secondary Menu', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('header', 'headerarea', __('Widgetized Area', "presswork"), 'headerbanner|header'); ?>
	<?php pw_add_element_option('layout', 'firstsidebar', __('First Sidebar', "presswork"), 'main-wrapper|layout'); ?>
	<?php pw_add_element_option('layout', 'secondsidebar', __('Second Sidebar', "presswork"), 'main-wrapper|layout'); ?>
	<?php pw_add_element_option('footer', 'footernav', __('Footer Menu', "presswork"), 'footer|footer'); ?>
	<?php pw_add_element_option('footer', 'extendedfooter', __('Extended Footer', "presswork"), 'footer|footer'); ?>
	<?php pw_add_element_option('footer', 'copyright', __('Copyright', "presswork"), 'footer|footer'); ?>
	<table class="pw-inputs header-inputs">
		<tr><td><label for="the_header_logo"><?php _e('Logo Image URL', "presswork"); ?></label></td><td><input type="text" name="header_logo" id="the_header_logo" class="header-item" value="<?php echo pw_theme_option("header_logo"); ?>" /></td></tr>
		<tr><td><label for="favicon"><?php _e('Favicon URL', "presswork"); ?></label></td><td><input type="text" name="favicon" id="favicon" value="<?php echo pw_theme_option("favicon"); ?>" /></td></tr>
	</table>
	<?php
}
endif;