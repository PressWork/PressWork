<?php
/**
 * Functionality for Slideshow widget
 *
 * @since PressWork 1.0
 */
class PW_Slideshow_Widget extends WP_Widget {
	function PW_Slideshow_Widget() {
		$widget_ops = array('classname' => 'pw_slideshow', 'description' => __('Add a featured slideshow', "presswork") );
		$this->WP_Widget('pw_slideshow', __('PW - Slideshows', "presswork"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);	
		
		$settings = array(
			'type' => $instance['type'],
			'cat' => $instance['cat'],
			'postnum' => $instance['postnum'],
			'width' => $instance['width'],
			'height' => $instance['height'],
			'excerpt' => $instance['excerpt']
		);
		echo $before_widget;
	    if(!empty($title)) echo $before_title . $title . $after_title; else echo '<h1 class="assistive-text">Featured slideshow</h1>';
		pw_slideshow($settings);  	
		echo $after_widget; 
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'type' => 'scrollerota', 'postnum' => '4', 'width' => pw_theme_option('content_width'), 'height' => 260, 'cat' => '', 'excerpt' => 35 ) );
		$title = strip_tags($instance['title']);
		$type = strip_tags($instance['type']);
		$postnum = strip_tags($instance['postnum']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$cat = strip_tags($instance['cat']);
		$excerpt = strip_tags($instance['excerpt']);
		$selectname = $this->get_field_name('cat');
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type', "presswork"); ?>: 
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option class="level-0" value="faderota" <?php selected($type, "faderota"); ?>>Fade</option>
				<option class="level-0" value="scrollerota" <?php selected($type, "scrollerota"); ?>>Scroll</option>
				<option class="level-0" value="sliderota" <?php selected($type, "sliderota"); ?>>Slide</option>
			</select>
			</label></p>
		<p><label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of posts', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" type="text" value="<?php echo esc_attr($postnum); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Excerpt length', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo esc_attr($excerpt); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Category', "presswork"); ?>: <?php wp_dropdown_categories('show_option_all=All&hide_empty=0&name='.$selectname.'&selected='.$cat); ?></label></p>	
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['postnum'] = strip_tags($new_instance['postnum']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['excerpt'] = strip_tags($new_instance['excerpt']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		return $instance;
	}
}
register_widget('PW_Slideshow_Widget');