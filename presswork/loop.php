<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * Includes all the action blocks for archives, pages and posts.
 *
 * @since PressWork 1.0
 */
?>

<?php 
global $paged, $pw;
$pw = 1;
if(is_home()) {
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
	echo '<div id="indexposts">';
}
?>
<?php while(have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php  
		if(is_category()) :
			pw_actionBlock('pw_category_post');
		elseif(is_author()) :
			pw_actionBlock('pw_author_post');
		elseif(is_archive()) :
			pw_actionBlock('pw_archive_post');
		elseif(is_search()) :
			pw_actionBlock('pw_search_post');
		elseif(is_page()) :
			pw_actionBlock('pw_page_post');
		elseif(is_single()) :
			pw_actionBlock('pw_single_post');
		else :	 
			pw_actionBlock('pw_index_post');
		endif; 
		?>
    </article>
<?php endwhile; ?>
<?php if(is_home()) echo '</div>'; ?>