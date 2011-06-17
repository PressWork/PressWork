    	</ul><!-- end wrapper ul -->
    </section><!-- end section -->
	<footer class="clear fl"> <!-- begin footer -->
	    <ul id="footer" class="fl clear">
	       	<?php 
		    $layout = theme_option('footer_option');
		    $layout = explode(",", $layout);
		    foreach($layout as $elem) {
		    	pw_get_element($elem);
		    }
		    ?>
	    </ul> <!-- end #footer -->
	</footer> <!-- end footer -->
	<br class="clear" />
</div> <!-- end #body-wrapper -->
<?php actionCall('pw_wrapper_bottom'); ?>
<?php actionCall('pw_body_bottom'); ?>
<?php wp_footer(); ?>
<!-- PressWork Framework created by c.bavota & Brendan Sera-Shriar - http://presswork.me -->
</body>
</html>