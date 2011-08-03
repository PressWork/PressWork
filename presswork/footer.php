<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #main-wrapper ul and the #body-wrapper div.
 * Includes all the action blocks for the footer.
 *
 * @since PressWork 1.0
 */
 ?>
   	</ul><!-- end #main-wrapper ul -->
	<footer id="footer-main" class="clear fl" role="contentinfo"> <!-- begin footer -->
		<?php pw_actionBlock('pw_footer'); ?>
	</footer> <!-- end footer -->
	<br class="clear" />
</div> <!-- end #body-wrapper -->
<?php pw_actionCall('pw_body_bottom'); ?>
<?php wp_footer(); ?>
<!-- PressWork framework created by c.bavota & Brendan Sera-Shriar - http://presswork.me -->
</body>
</html>