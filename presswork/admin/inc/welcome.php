<?php 

function pw_welcome_screen() {
	?>
	<div id="pw_welcome_screen">
        <img src="<?php echo get_template_directory_uri(); ?>/admin/images/pw-logo.jpg" width="557" height="125" alt="" class="pw-logo" />
		<a href="javascript:void(0)" id="close-welcome">Close</a>
		<div class="close-arrow"></div>
	</div>
	<div id="pw_fadeback">
		<div class="toolbox-arrow"></div>
		<div class="adminbar-arrow"></div>
	
	
	</div>
	<?php
}


