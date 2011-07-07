<?php
/**
 * Functionality for Twitter widget
 *
 * @since PressWork 1.0
 */
class PW_Twitter_Widget extends WP_Widget {
	function PW_Twitter_Widget() {
		$widget_ops = array('classname' => 'pw_twitter_feed', 'description' => __('Displays your tweets', "presswork") );
		$this->WP_Widget('pw_twitter_feed', __('PW - Twitter Feed', "presswork"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$username = $instance['username'];
		$limit = $instance['number'];
		$link = $instance['link'];
		
		echo $before_widget;
	    if(!empty($title)) { echo $before_title . $title . $after_title; };
		
		$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=" . $limit;
		
		$twitterFeed = wp_remote_fopen($feed);
		$this->pw_parse_feed($twitterFeed);
		?>
	    <p class="clear"><a href="http://twitter.com/<?php echo $username; ?>"><?php echo $link; ?></a></p>
	  	<?php  
		
		echo $after_widget; 
	}
	
	function pw_parse_feed($feed) {
		$feed = str_replace("&lt;", "<", $feed);
		$feed = str_replace("&gt;", ">", $feed);
		$feed = str_replace("&quot;", '"', $feed);
		$clean = explode("<content type=\"html\">", $feed);
		
		$amount = count($clean) - 1;
		
		echo "<ul class='mytweets'>";
		
		for ($i = 1; $i <= $amount; $i++) {
		$cleaner = explode("</content>", $clean[$i]);
		echo "<li>";
		echo str_replace("&amp;", "&", $cleaner[0]);
		echo "</li>";
		}
		
		echo "</ul>";
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Latest Tweets', 'username' => 'pressworkwp', 'link' => 'Follow Us', 'number' => '3' ) );
		$title = strip_tags($instance['title']);
		$username = strip_tags($instance['username']);
		$number = strip_tags($instance['number']);
		$link = strip_tags($instance['link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Tweets', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Text Link', "presswork"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label></p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}
}
register_widget('PW_Twitter_Widget');