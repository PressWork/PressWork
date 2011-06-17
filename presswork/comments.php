<div id="comments"> <!-- beging comments -->
	<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', "presswork" ); ?></div>
		</div> <!-- end nopassword -->
	<?php
		return;
	endif; 
	if ( have_comments() ) : 
		actionCall('pw_comments_top');
		actionCall('pw_comments_nav_top');
		actionCall('pw_comments_middle');
		actionCall('pw_comments_nav_bottom');
	else : // this is displayed if there are no comments so far
   		actionCall('pw_comments_bottom');
	endif; 
	actionCall('pw_comments_reply');
	?>
</div> <!-- end comments -->