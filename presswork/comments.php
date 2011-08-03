<?php
/**
 * The comments template action calls.
 *
 * @since PressWork 1.0
 */
 ?>
<div id="comments"> <!-- beging comments -->
	<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', "presswork" ); ?></div>
		</div> <!-- end nopassword -->
	<?php
		return;
	endif; 
	if ( have_comments() ) : 
		pw_actionCall('pw_comments_top');
		pw_actionCall('pw_comments_nav_top');
		pw_actionCall('pw_comments_middle');
		pw_actionCall('pw_comments_nav_bottom');
	else : // this is displayed if there are no comments so far
   		pw_actionCall('pw_comments_bottom');
	endif; 
	pw_actionCall('pw_comments_reply');
	?>
</div> <!-- end comments -->