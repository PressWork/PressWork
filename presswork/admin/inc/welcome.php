<?php 
/**
 * PressWork's welcome screen. Displays the first time PressWork has
 * been activated. 
 *
 * @stored in pw_theme_option("welcome_screen")
 * @since PressWork 1.0
 */
function pw_welcome_screen() {
	?>
	<div id="pw_welcome_screen">
        <div id="pw-logo">Welcome to</div>
        <div class="welcome-box">
	        <p class="brain-icon clear"><span></span><strong><?php _e('PressWork Settings', "presswork"); ?></strong> - <?php _e('Turn on the Drag &amp; Drop Editor, Hooks &amp; Functions, or even Reset all options if you mess up.', "presswork"); ?></p>
	        <p class="layout-icon"><span></span><strong><?php _e('Layouts', "presswork"); ?></strong> - <?php _e('This panel allows you to modify widths and margins. You can also add your own logo, sidebars &amp; more.', "presswork"); ?></p>
	        <p class="color-icon clear"><span></span><strong><?php _e('Colors', "presswork"); ?></strong> - <?php _e('This is where you can change the colors for links, main text, menus, post titles, backgrounds &amp; more.', "presswork"); ?></p>
	        <p class="fonts-icon"><span></span><strong><?php _e('Google Fonts', "presswork"); ?></strong> - <?php _e('PressWork comes with the top 20 most popular Google Fonts. You can easily add more if you like.', "presswork"); ?></p>
	        <p class="social-icon clear"><span></span><strong><?php _e('Social Networking', "presswork"); ?></strong> - <?php _e('Enter your Twitter, Facebook &amp; Flickr usernames so people can find you.', "presswork"); ?></p>
	        <p class="save-icon"><span></span><strong><?php _e('Save', "presswork"); ?></strong> - <?php _e('Got everything set up the way you want? Better make sure to click Save or you might lose your settings.', "presswork"); ?></p>
        </div>
        <div id="pw_version"><?php _e('version', "presswork"); ?> <?php echo PW_THEME_VERSION; ?></div>
		<a href="javascript:void(0)" id="close-welcome"><?php _e('Close', "presswork"); ?></a>
		<div class="close-arrow"><?php _e('Close the<br />Welcome Screen', "presswork"); ?></div>
	</div>
	<div id="pw_fadeback">
		<div class="toolbox-arrow"><?php _e('The PressWork<br />Toolbox', "presswork"); ?></div>
		<div class="adminbar-arrow"><?php _e('The PressWork<br />Admin Page', "presswork"); ?></div>
	</div>
	<?php
}


