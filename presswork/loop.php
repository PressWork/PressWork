<?php 
global $paged, $pw;
$pw = 1;
if(is_home()) {
	$sticky = get_option( 'sticky_posts' );
	$notin = notin();
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
				<?php actionBlock('pw_index_sticky_post'); ?>
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
				<?php actionBlock('pw_index_featured_post'); ?>
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
			actionBlock('pw_category_post');
		elseif(is_author()) :
			actionBlock('pw_author_post');
		elseif(is_archive()) :
			actionBlock('pw_archive_post');
		elseif(is_search()) :
			actionBlock('pw_search_post');
		elseif(is_page()) :
			actionBlock('pw_page_post');
		elseif(is_single()) :
			actionBlock('pw_single_post');
		else :	 
			actionBlock('pw_index_post');
		endif; 
		?>
    </article>
<?php endwhile; ?>
<?php if(is_home()) echo '</div>'; ?>