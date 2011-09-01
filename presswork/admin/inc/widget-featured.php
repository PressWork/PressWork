<?php
/**
 * Functionality for Featured Post widget
 *
 * @since PressWork 1.0
 */
class PW_Featured_Posts_Widget extends WP_Widget {
	function PW_Featured_Posts_Widget() {
		$widget_ops = array('classname' => 'pw_featured_posts', 'description' => __('Displays featured posts from one category', "presswork") );
		$this->WP_Widget('pw_featured_posts', __('PW - Featured Posts', "presswork"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$sticky = get_option( 'sticky_posts' );
	
		$par = array(
			"posts_per_page" => $instance['number'],
			"cat" => $instance['category'],
			"post__not_in" => $sticky
		);

		echo $before_widget;
	    if(!empty($title)) { echo $before_title . $title . $after_title; };
		
		$featuredPosts = new WP_Query();
	    $featuredPosts->query($par);
		?>
		<?php $i = 1; ?>
	    <?php while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class('side-featured'); ?>>
			<?php
			if(function_exists('has_post_format') && (has_post_format('aside') || has_post_format('link') || has_post_format('gallery'))) { // new aside || link post format
				// do nothing
			} else {
				$rightcon = '';
				if(function_exists('has_post_format') && !has_post_format('image')) {
					if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
						echo '<a href="'.get_permalink().'">';
						the_post_thumbnail('fifty', array('class'=>'alignleft'));
						echo '</a>';
						$rightcon = ' class="content-col"';
					}
				}
				?>
				<div<?php echo $rightcon; ?>>
				<header>
					<h1 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="meta">
						<?php the_time(get_option('date_format')); ?>
					</div>
				</header>
				<?php
			}
			?>
			<div class="storycontent">
				<?php 
				if(function_exists('has_post_format') && 
					(has_post_format('aside') || has_post_format('link') || has_post_format('video') || has_post_format('image') || has_post_format('audio'))) { 
					// new aside || link || audio || video || image post format
					echo '<div class="pformat clear">';
					if(function_exists('has_post_format') && has_post_format('image')) {
						if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
							echo '<a href="'.get_permalink().'">';
							the_post_thumbnail('medium', array('class'=>'alignleft'));
							echo '</a>';
						} else {
							the_content('');
						}
					} else {
						the_content('');						
					}
					echo '</div>';
				} elseif(function_exists('has_post_format') && has_post_format('gallery')) { // new gallery post format
					global $post;
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'full' );
					?>
					<a class="gallery-thumb" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
					<p class="gallery-text clear fl"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>.', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>.', $total_images, "presswork" ),
							'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
							number_format_i18n( $total_images )
						); ?></em>
					</p>
					<?php endif; ?>
					<?php 
				} else {
					pw_excerpt(15);
					?>
				<?php } ?>
			</div> 
			<?php
			if(function_exists('has_post_format') && (has_post_format('aside') || has_post_format('link') || has_post_format('gallery'))) { // new aside || link post format
				// do nothing
			} else {
				echo '</div>';
			}
			?>
		</article>
	    <?php
		endwhile; 
		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Featured Posts', 'category' => '0', 'number' => '1' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$number = strip_tags($instance['number']);
		$selectname = $this->get_field_name('category');
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', "presswork"); ?>: <?php wp_dropdown_categories('hide_empty=0&name='.$selectname.'&selected='.$category); ?></label></p>	
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}

}
register_widget('PW_Featured_Posts_Widget');