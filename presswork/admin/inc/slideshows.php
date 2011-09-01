<?php
if(!function_exists('pw_slideshow')) :
/**
 * Add slideshow functionality
 *
 * Displays a slideshow according to the parameters set in the argument array.
 *
 * @since PressWork 1.0
 */
	function pw_slideshow($args = '') { 
		global $wp_scripts;
		$defaults = array(
			'type' => 'scrollerota',
			'cat' => '',
			'postnum' => 4,
			'width' => pw_theme_option('content_width'),
			'height' => 260,
			'excerpt' => 35
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
		$name = $r['type'];

		$wp_scripts->in_footer[] = 'pw_'.$name.'_js';

		if(!empty($r['cat'])) {
			$featuredcat = $r['cat'];
			$posts = array(
				"posts_per_page"=>$r['postnum'],
				"cat"=>$featuredcat,
				"ignore_sticky_posts" => 1	
			);
		} else {
			$posts = array(
				"posts_per_page"=>$r['postnum'],
				"ignore_sticky_posts" => 1	
			);
		}

		$featured = new WP_Query();
		$featured->query($posts);
	?>
	<div id="<?php echo $r['type']; ?>" class="pw-slideshow" style="height: <?php echo $r['height']; ?>px;">
		<div class="slideshow-content" style="height: <?php echo $r['height']; ?>px;">
			<ul class="images">
			<?php while ($featured->have_posts()) : $featured->the_post(); ?> 
				<li>
				<?php
				if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
					echo '<a href="'.get_permalink().'">';
					the_post_thumbnail('full');
					echo '</a>';
				}	
				?>
				</li>
			<?php endwhile; ?>
			</ul>
			<ul class="text">
			<?php while ($featured->have_posts()) : $featured->the_post(); ?> 
				<li>
				<?php 
				if($r['type']=="faderota") {
					echo '<header><h4><a href="'.get_permalink().'">'.esc_attr(get_the_title()).'</a></h4></header>';
				} else {
					echo '<header><h4><a href="'.get_permalink().'">'.esc_attr(get_the_title()).'</a></h4></header>';
					echo pw_excerpt($r['excerpt']); 
					?>
					<footer><a href="<?php the_permalink(); ?>" class="readmore"><?php _e('Read more', "presswork"); ?></a></footer>
				<?php } ?>
				</li>
			<?php endwhile; ?>
			</ul>
		</div><!-- end .slideshow-content -->
	</div><!-- end #slideshow -->
	<?php
	}	
endif;