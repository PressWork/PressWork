<?php
/**
 * Functionality for Flickr widget
 *
 * @since PressWork 1.0
 */
class PW_Flickr_Widget extends WP_Widget {
	function PW_Flickr_Widget() {
		$widget_ops = array('classname' => 'pw_flickr_feed', 'description' => __('Displays your flickr photos', "presswork") );
		$this->WP_Widget('pw_flickr_feed', __('PW - Flickr Feed', "presswork"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$UserID = $instance['UserID'];
		$NumPics = $instance['NumPics'];
		$link = $instance['link'];
		
		echo $before_widget;
	    if(!empty($title)) { echo $before_title . $title . $after_title; };
		
		$feed = "http://www.flickr.com/badge_code_v2.gne?count=" . $NumPics . "&display=latest&size=s&layout=x&source=user&user=" .$UserID;
		
		echo '<div id="flickr_tab">';
		echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $NumPics . '&display=latest&size=s&layout=x&source=user&user=' .$UserID .'"></script>';
		echo '</div>';

		?>
	    <p class="clear flickr-link"><a href="http://flickr.com/photos/<?php echo $UserID; ?>"><?php echo $link; ?></a></p>
	  	<?php  
		
		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Flickr Photos', 'UserID' => '', 'link' => 'Find Me on Flickr', 'NumPics' => '9' ) );
		$title = strip_tags($instance['title']);
		$UserID = strip_tags($instance['UserID']);
		$NumPics = strip_tags($instance['NumPics']);
		$link = strip_tags($instance['link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('UserID'); ?>"><?php _e('UserID', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('UserID'); ?>" name="<?php echo $this->get_field_name('UserID'); ?>" type="text" value="<?php echo esc_attr($UserID); ?>" /></label><br /><a href="http://idgettr.com/" target="_blank"><?php _e('Flickr idGettr', "presswork"); ?></a></p>
		<p><label for="<?php echo $this->get_field_id('NumPics'); ?>"><?php _e('Number of Photos', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('NumPics'); ?>" name="<?php echo $this->get_field_name('NumPics'); ?>" type="text" value="<?php echo esc_attr($NumPics); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link Text', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label></p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['UserID'] = strip_tags($new_instance['UserID']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['NumPics'] = strip_tags($new_instance['NumPics']);
		return $instance;
	}
}
register_widget('PW_Flickr_Widget');