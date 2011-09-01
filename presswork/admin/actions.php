<?php
/**
 * The action hooks. This is where functions are hooked into certain
 * action calls.
 *
 * @since PressWork 1.0
 */
 ?>
<?php
/*
 * The Header
 */
function pw_header_content() {
	?>
    <ul id="headerbanner" class="fl clear">
       	<?php 
	    $layout = pw_theme_option('header_option');
	    $layout = explode(",", $layout);
	    foreach($layout as $elem) {
	    	pw_get_element($elem);
	    }
	    ?>
    </ul> <!-- end headerbanner -->
	<?php
}
add_action('pw_header_middle', 'pw_header_content');

/*
 * Social Icons
 */
function pw_social_content() {
	$twitter = pw_theme_option('twitter');
	$facebook = pw_theme_option('facebook');
	$flickr = pw_theme_option('flickr');
	$linkedin = pw_theme_option('linkedin');
	$googleplus = pw_theme_option('googleplus');
	$stumbleupon = pw_theme_option('stumbleupon');
	
	echo '<div id="social-icons">';
	if(!empty($twitter))
		echo '<a href="http://twitter.com/'.$twitter.'" class="twitter-icon"></a>';
	if(!empty($facebook))
		echo '<a href="http://facebook.com/'.$facebook.'" class="facebook-icon"></a>';
	if(!empty($flickr))
		echo '<a href="http://www.flickr.com/photos/'.$flickr.'" class="flickr-icon"></a>';		
	if(!empty($googleplus))
		echo '<a href="https://plus.google.com/'.$googleplus.'" class="googleplus-icon"></a>';	
	if(!empty($linkedin))
		echo '<a href="http://www.linkedin.com/in/'.$linkedin.'" class="linkedin-icon"></a>';	
	if(!empty($stumbleupon))
		echo '<a href="http://www.stumbleupon.com/stumbler/'.$stumbleupon.'" class="stumbleupon-icon"></a>';	
	echo '</div>';
}
add_action('pw_header_top', 'pw_social_content');

/*
 * The Footer
 */
function pw_footer_content() {
	?>
    <ul id="footer" class="fl clear">
       	<?php 
	    $layout = pw_theme_option('footer_option');
	    $layout = explode(",", $layout);
	    foreach($layout as $elem) {
	    	pw_get_element($elem);
	    }
	    ?>
    </ul> <!-- end #footer -->
	<?php
}
add_action('pw_footer_middle', 'pw_footer_content');

/*
 * The first sidebar
 */
function pw_sidebar() {
	echo pw_function_handle(__FUNCTION__);
	if(!dynamic_sidebar("first-sidebar")) :	
		echo '<aside class="side-widget default">';
		get_search_form();
		echo '</aside>';

		$args = array(
			'before_widget' => '<aside class="side-widget default">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h3>',
			'after_title' => '</h3></header>',
		);

		$featured = new PW_Featured_Posts_Widget;
		$instance = array( 'title' => 'Featured Posts', 'category' => '0', 'number' => '2' );
		$featured->widget($args, $instance);

		$tweet = new PW_Twitter_Widget;
		$instance = array( 'title' => 'Latest Tweets', 'username' => '', 'link' => 'Follow Us', 'number' => '3' );
		$tweet->widget($args, $instance);

		if(current_user_can('edit_theme_options')) {
			echo '<aside class="warning clear fl"><p>';
			printf(__("Add your own widgets to the First Sidebar %shere%s", "presswork"), '<a href="'.admin_url('widgets.php').'">', '</a>');
			echo '</p></aside>';
		}
    endif;
}
add_action('pw_sidebar_middle', 'pw_sidebar');

/*
 * The second sidebar
 */
function pw_second_sidebar() {
	echo pw_function_handle(__FUNCTION__);
	if(!dynamic_sidebar("second-sidebar" ) && current_user_can('edit_theme_options')) :
		echo '<aside class="warning clear fl"><p>';
		printf(__("Add widgets to the Second Sidebar %shere%s", "presswork"), '<a href="'.admin_url('widgets.php').'">', '</a>');
		echo '</p></aside>';    endif;
}
add_action('pw_second_sidebar_middle', 'pw_second_sidebar');

/*
 * Top Content Widgetized Area
 */
function pw_top_content_widgetized_area() {
	global $paged;
	if($paged < 2) {
		echo pw_function_handle(__FUNCTION__);
		dynamic_sidebar("top-index-area" );
	}
}
add_action('pw_index_top', 'pw_top_content_widgetized_area');

/*
 * Basic Loop
 */
function pw_loop() {
	get_template_part( 'loop');
}
add_action('pw_index_middle','pw_loop');
add_action('pw_single_middle', 'pw_loop');
add_action('pw_page_middle', 'pw_loop');
add_action('pw_archive_middle', 'pw_loop');
add_action('pw_category_middle', 'pw_loop');
add_action('pw_author_middle', 'pw_loop');
add_action('pw_search_middle', 'pw_loop');

/*
 * Pagination
 */
function pw_pagination() {
	echo pw_function_handle(__FUNCTION__);
	pw_paginate();
}
add_action('pw_index_bottom', 'pw_pagination');
add_action('pw_archive_bottom', 'pw_pagination');
add_action('pw_author_bottom', 'pw_pagination');
add_action('pw_category_bottom', 'pw_pagination');
add_action('pw_search_bottom', 'pw_pagination');

/* 
 * This is the 404 page
 */
function pw_404() {
	echo pw_function_handle(__FUNCTION__);
	?>
	<article id="post-0" class="post error404 not-found">
    	<header>
    	   	<h1 class="posttitle"><?php _e("Not found", "presswork"); ?></h1>
        </header>
        <div class="entry">
            <p><?php _e("No results were found for your request.", "presswork"); ?></p>
        </div>
    </article>
	<?php
}
add_action('pw_404_middle', 'pw_404');

/*
 * Archive header
 */
function pw_archive_title() { 
	echo pw_function_handle(__FUNCTION__);
	if (have_posts()) { 
		?>
		<header>
	    	<h1 class="catheader">
	        <?php
	        if( is_tag() ) { ?>
	            <?php printf(__("Posts Tagged &#8216;%s&#8217;", "presswork"), single_tag_title('',false)); ?>
	        	<?php 
			} elseif (is_day()) { ?>
	            <?php _e("Archive for", "presswork"); echo " "; the_time('F jS, Y'); ?>
	        	<?php 
			} elseif (is_month()) { ?>
	            <?php _e("Archive for", "presswork"); echo " "; the_time('F, Y'); ?>
	        	<?php
			} elseif (is_year()) { ?>
	            <?php _e("Archive for", "presswork"); echo " "; the_time('Y'); ?>
	        	<?php
			} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	            <?php _e("Blog Archives", "presswork"); ?>
	        <?php
			}
			?>
	        </h1>
        </header>
        <?php
	} else {
		echo "<header><h1 class='posttitle'>".__("No posts found.", "presswork")."</h1></header>";
	}
}
add_action('pw_archive_top', 'pw_archive_title');

/*
 * Category header
 */
function pw_category_title() {
	echo pw_function_handle(__FUNCTION__);
	if (have_posts()) { ?>
        <header>
        <h1 class="catheader"><?php single_cat_title(); ?></h1>
        <?php $catdesc = category_description(); if(stristr($catdesc,'<p>')) echo '<div class="catdesc clear">'.$catdesc.'</div>'; ?>
        </header>
        <?php
	} else {
		echo "<header><h1 class='posttitle'>".__("No posts found.", "presswork")."</h1></header>";
	}		
}
add_action('pw_category_top', 'pw_category_title');

/*
 * Author header
 */
function pw_author_title() {
	echo pw_function_handle(__FUNCTION__);
	if (have_posts()) {
        pw_authorbox();        
	} else {
		echo "<header><h1 class='posttitle'>".__("No posts found.", "presswork")."</h1></header>";
	}		
}
add_action('pw_author_top', 'pw_author_title');

/*
 * Top of comments section
 */
function pw_comment_section_title() {
	echo pw_function_handle(__FUNCTION__);
	echo '<h3 id="comments-title">';
	printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), "presswork" ), number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
	echo '</h3>';
}
add_action('pw_comments_top', 'pw_comment_section_title');

/*
 * Comment middle section
 */
function pw_comment_section() {
	echo pw_function_handle(__FUNCTION__);
	?>
    <ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'pw_comment_template', 'reply_text' => __('Reply', "presswork") ) ); ?>
    </ol>
    <?php
}
add_action('pw_comments_middle', 'pw_comment_section');

/*
 * Comment navigation
 */
function pw_comment_navigation() {
	echo pw_function_handle(__FUNCTION__);
    if ( get_comment_pages_count() > 1 ) { ?>
        <nav class="navigation">
 			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'presswork' ); ?></h1>
           	<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', "presswork" ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', "presswork" ) ); ?></div>
        </nav>
    <?php 
	}
}
add_action('pw_comments_nav_top', 'pw_comment_navigation');
add_action('pw_comments_nav_bottom', 'pw_comment_navigation');

/*
 * Comment reply section
 */
function pw_comment_section_reply() {
	echo pw_function_handle(__FUNCTION__);
	$args = array(
		'comment_notes_after' => '',
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" required cols="45" rows="8" placeholder="'.__("Your comment", "presswork").' *" aria-required="true"></textarea></p>'
	);
	comment_form($args); 
}
add_action('pw_comments_reply', 'pw_comment_section_reply');

/*
 * Search page title
 */
function pw_search_title() {
	echo pw_function_handle(__FUNCTION__);
	global $wp_query;
	$total_results = $wp_query->found_posts;
    echo '<h1 class="catheader">'.$total_results.' '.__('search results for', "presswork").' "'; the_search_query(); echo '"</h1>';

}
add_action('pw_search_top', 'pw_search_title');

/*
 * Home page featured query
 *
 * @since PressWork 1.0.3
 */
function pw_home_page_featured_query() {
	global $post, $notin, $paged, $pw;
	$pw = 1;
	$sticky = get_option( 'sticky_posts' );
	$notin = pw_notin();
	if(!empty($sticky)) {
		if(!empty($notin)) $notin = array_merge($notin, $sticky); else $notin = $sticky;
		if($paged < 2) {
			$args = array(
				'post__in'  => $sticky,
				'ignore_sticky_posts' => 1
			);
			$the_query = new WP_Query( $args );
			while ( $the_query->have_posts() ) : $the_query->the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class("pw pw".$pw); ?>>
				<?php pw_actionBlock('pw_index_sticky_post'); ?>
			</article>
			<?php
			$pw++;	
			endwhile;
			wp_reset_query();
		}
	} else {
		$args = array(
			'post__not_in'  => $notin,
			'posts_per_page' => 2
		);
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) : $the_query->the_post();
		if($paged < 2) {
			$notin[] = $post->ID;
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class("pw pw".$pw); ?>>
				<?php pw_actionBlock('pw_index_featured_post'); ?>
			</article>
			<?php
			$pw++;	
		} else {
			$notin[] = $post->ID;
		}
		endwhile;
		wp_reset_query();
	}
	query_posts( array( 'post__not_in' => $notin, "paged" => $paged  ) );
}
add_action('pw_home_page', 'pw_home_page_featured_query');

/*
 * Featured posts
 */
function pw_posts_featured() {
	echo pw_function_handle(__FUNCTION__);
	global $pw;
	$rightcon = '';
	if(function_exists('has_post_thumbnail') && has_post_thumbnail() && (function_exists('has_post_format') && !has_post_format('gallery') && !has_post_format('video'))) { 
		echo '<a href="'.get_permalink().'">';
		if($pw==1) { $thumb = 'sticky'; $class = 'alignnone'; } else { $thumb = 'thumbnail'; $class = 'alignleft'; }
		the_post_thumbnail($thumb, array('class'=>$class));
		echo '</a>';
		$rightcon = ' class="content-col"';
	}
	?>
    <div<?php echo $rightcon; ?>>
		<header>
			<hgroup>
			<h1 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	        <h2 class="meta">
	            <?php 
	            _e("by", "presswork"); echo " "; the_author_posts_link(); 
	            echo '&nbsp;&bull;&nbsp;';
	            the_time(get_option('date_format'));
	            if(comments_open()) { echo '&nbsp;&bull;&nbsp;'; comments_popup_link(__('0 Comments', "presswork"),__('1 Comment', "presswork"),__('% Comments', "presswork")); }
	            ?>
	        </h2>
	        </hgroup>
		</header>
	    <div class="storycontent">
	        <?php 
			if(function_exists('has_post_format') && 
				(has_post_format('aside') || has_post_format('link') || has_post_format('video') || has_post_format('image') || has_post_format('audio'))) { 
				// new aside || link || audio || video || image post format
	           	echo '<div class="pformat clear">';
				the_content('');
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
				<p class="gallery-text clear fl"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>', $total_images, "presswork" ),
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></em>
				</p>
				<?php endif; ?>
				<?php 
			} else {
				the_excerpt();
				echo '<a href="'.get_permalink().'" class="more-link">'.__("Read more &rarr;", "presswork").'</a>';
				?>
			<?php } ?>
	    </div> 
	</div> 
<?php
}
add_action('pw_index_sticky_post_middle', 'pw_posts_featured');
add_action('pw_index_featured_post_middle', 'pw_posts_featured');

/*
 * Posts
 */
function pw_posts() {
	echo pw_function_handle(__FUNCTION__);
	?>
	<header>
		<hgroup>
			<h1 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<h2 class="meta">
				<?php 
				_e("by", "presswork"); echo " "; the_author_posts_link(); 
				echo '&nbsp;&bull;&nbsp;';
				the_time(get_option('date_format'));
				if(!is_home()) {
					echo '&nbsp;&bull;&nbsp;';
					the_category(', ');
				}
				if(comments_open()) { echo '&nbsp;&bull;&nbsp;'; comments_popup_link(__('0 Comments', "presswork"),__('1 Comment', "presswork"),__('% Comments', "presswork")); }
				
				?>
			</h2>
		</hgroup>
	</header>
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
			<p class="gallery-text clear fl"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>', $total_images, "presswork" ),
					'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
					number_format_i18n( $total_images )
				); ?></em>
			</p>
			<?php endif; ?>
			<?php 
		} else {
			if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
				echo '<a href="'.get_permalink().'">';
				if(is_home()) $thumb = 'fifty'; else $thumb = 'thumbnail';
				the_post_thumbnail($thumb, array('class'=>'alignleft'));
				echo '</a>';
			}
			the_excerpt();
		}
		if(function_exists('has_post_format') && (has_post_format('aside') || has_post_format('link') || has_post_format('gallery'))) { // new aside || link post format
			// do nothing
		} else {
			echo '<a href="'.get_permalink().'" class="more-link">'.__("Read more &rarr;", "presswork").'</a>';
		}
		?>
    </div> 
	<?php
}
add_action('pw_archive_post_middle', 'pw_posts');
add_action('pw_author_post_middle', 'pw_posts');
add_action('pw_category_post_middle', 'pw_posts');
add_action('pw_search_post_middle', 'pw_posts');
add_action('pw_index_post_middle', 'pw_posts');


/*
 * Single post
 */
function pw_single_post() {
	echo pw_function_handle(__FUNCTION__);
	?>
 	<header>
		<?php if(is_single()) echo '<hgroup>'; ?>
	 		<h1 class="posttitle"><?php the_title(); ?></h1>
			<?php if(is_single()) { ?>
			<h2 class="meta">
				<?php 
				_e("by", "presswork"); echo " "; the_author_posts_link(); 
				echo '&nbsp;&bull;&nbsp;';
				the_time(get_option('date_format'));
				echo '&nbsp;&bull;&nbsp;';
				the_category(', ');
				if(comments_open()) { echo '&nbsp;&bull;&nbsp;'; comments_popup_link(__('0 Comments', "presswork"),__('1 Comment', "presswork"),__('% Comments', "presswork")); }
				?>
			</h2>
			<?php } ?>
		<?php if(is_single()) echo '</hgroup>'; ?>
    </header>
    <div class="storycontent">
        <?php the_content( __( 'Read more &rarr;', "presswork" ) ); ?>
    </div>
    <footer>
	    <?php
	   	the_tags('<p class="tags"><small>'.__('Tags', "presswork").': ', ', ', '</small></p>');
		wp_link_pages(array('before' => '<p><strong>'.__('Pages', "presswork").':</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
		edit_post_link(__('(edit)', "presswork"), '<p class="clear">', '</p>');
		?>
	</footer>
	<?php
}
add_action('pw_single_post_middle', 'pw_single_post');
add_action('pw_page_post_middle', 'pw_single_post');

/*
 * Author box
 */
function pw_authorbox() {
	echo pw_function_handle(__FUNCTION__);
	global $author;
	?>
    <div id="authorbox" class="clear fl">
        <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email', $author), '80' ); }?>
        <div class="authortext">
           <header>
           		<h4><?php _e('About', "presswork"); ?> <?php if(is_author()) the_author_meta('display_name', $author); else the_author_posts_link(); ?></h4>
           </header>
           <p><?php the_author_meta('description', $author); ?></p>
           <p><a href="<?php the_author_meta('url', $author); ?>"><?php the_author_meta('url', $author); ?></a></p>
        </div>
    </div>
<?php
}
add_action('pw_single_bottom', 'pw_authorbox');

/*
 * Columns top
 */
function pw_columns_post_title($r) {
	if(function_exists('has_post_format') && (has_post_format('aside') || has_post_format('link'))) { // new aside || link post format
		// do nothing
	} else {
		?>
	<header>
		<hgroup>
			<h1 class="posttitle"><a href="<?php the_permalink() ?>" title="<?php printf(__("Permanent Link to %s", "presswork"), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
	        <h2 class="meta">
	        	<?php
	        	if(isset($r['authors'])) { _e("by", "presswork"); echo " "; the_author_posts_link(); } 
	            if(isset($r['dates'])) { echo '&nbsp;&bull;&nbsp;'; the_time(get_option('date_format')); }
	            if(isset($r['comments']) && comments_open()) { echo '&nbsp;&bull;&nbsp;'; comments_popup_link(__('0 Comments', "presswork"),__('1 Comment', "presswork"),__('% Comments', "presswork")); }
	        	?>
	        </h2>
        </hgroup>
    </header>
        <?php
	}
}
add_action('pw_columns_top', 'pw_columns_post_title', 1, 1);

function pw_columns_post_content($r) {
	?>
    <div class="storycontent">
		<?php 
        if(function_exists('has_post_format') && 
			(has_post_format('aside') || has_post_format('link') || has_post_format('video') || has_post_format('image') || has_post_format('audio'))) { 
			// new aside || link || audio || video || image post format
           	echo '<div class="pformat clear">';
			the_content('');
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
			<p class="gallery-text clear fl"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>', $total_images, "presswork" ),
					'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', "presswork" ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
					number_format_i18n( $total_images )
				); ?></em>
			</p>
			<?php endif; ?>
			<?php 
		} else {
			if($r['text']=="content") { 
				if($r['readmore']==1) {
					the_content(__( 'Read more &rarr;', "presswork" ));
				} else {
					the_content('');
				}
			} else {
				if($r['images']==1) { 
					if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
						echo '<a href="'.get_permalink().'">';
						the_post_thumbnail(array($r['img_w'], $r['img_h']), array('class'=>$r['img_float']));
						echo '</a>';
					}
				}
				the_excerpt();
 			    if($r['readmore']==1) echo '<a href="'.get_permalink().'" class="more-link">'.__( 'Read more &rarr;', "presswork" ).'</a>';
			}	
		}
        ?>
    </div>
	<?php
}
add_action('pw_columns_middle', 'pw_columns_post_content', 1, 1);

// Including child theme action file
if(!defined('CHILD_ACTION_FILE'))
	define('CHILD_ACTION_FILE', STYLESHEETPATH.'/actions.php');
if(file_exists(CHILD_ACTION_FILE))
	include(CHILD_ACTION_FILE);
?>