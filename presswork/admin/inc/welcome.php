<?php 
/**
 * PressWork's welcome screen. Displays the first time PressWork has
 * been activated. 
 *
 * @stored in theme_option("welcome_screen")
 * @since PressWork 1.0
 */
function pw_welcome_screen() {
	?>
	<div id="pw_welcome_screen">
        <div id="pw-logo">Welcome to</div>
        <div class="welcome-box">
	        <p class="brain-icon clear"><span></span><strong>PressWork Settings</strong> - Turn on the Drag &amp; Drop Editor, Guides &amp; Functions or even Reset all options if you mess up.</p>
	        <p class="layout-icon"><span></span><strong>Layouts</strong> - This panel allows you to modify widths and margins. You can also add your own logo, sidebars &amp; more.</p>
	        <p class="color-icon clear"><span></span><strong>Colors</strong> - Here is where you to change the colors for all your links, main text, menus, post titles, backgrounds &amp; more.</p>
	        <p class="fonts-icon"><span></span><strong>Google Fonts</strong> - PressWork takes the top 20 most popular Google Fonts and puts them at your fingertips.</p>
	        <p class="save-icon clear"><span></span><strong>Save</strong> - Got things looking the way you want? Better make sure to click save.</p>
        </div>
        <div id="pw_version">version <?php echo THEME_VERSION; ?></div>
		<a href="javascript:void(0)" id="close-welcome">Close</a>
		<div class="close-arrow"></div>
	</div>
	<div id="pw_fadeback">
		<div class="toolbox-arrow"></div>
		<div class="adminbar-arrow"></div>
	
	
	</div>
	<?php
}


