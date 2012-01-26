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
   	</ul> <!-- end #main-wrapper ul -->
	<footer id="footer-main" class="clearfix fl" role="contentinfo"> <!-- begin footer -->
		<?php pw_actionBlock('pw_footer'); ?>
	</footer> <!-- end footer -->
</div> <!-- end #body-wrapper -->
<?php pw_actionCall('pw_body_bottom'); ?>
<?php wp_footer(); ?>
<!-- PressWork framework created by c.bavota & Brendan Sera-Shriar - http://presswork.me -->
<script type="text/javascript">
/* <![CDATA[ */
(function($) {
	$("object, embed, .format-video iframe").each(function() {
		var origVideo = $(this),
			aspectRatio = origVideo.attr("height") / origVideo.attr("width"),
			wrapWidth = origVideo.parents().find("p:last").width();
		if(origVideo.attr("width") > wrapWidth) {
			origVideo
				.attr("width", wrapWidth)
				.attr("height", (wrapWidth * aspectRatio));
		}
	});
})(jQuery);
/* ]]> */
</script>
</body>
</html>