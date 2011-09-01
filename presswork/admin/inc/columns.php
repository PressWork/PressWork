<?php
if(!function_exists('pw_columns')) :
/**
 * Add pw_columns functionality
 *
 * Display posts in a grid layout according to the parameters set in the
 * argument array.
 *
 * @since PressWork 1.0
 */
	function pw_columns($args = '') {
		global $pw_content_width, $paged;
		
		$defaults = array(
			'width' => 'full',
			'columns' => 1,
			'posts' => 1,
			'text' => 'excerpt',
			'readmore' => 1,
			'category' => 0,
			'dates' => 1,
			'authors' => 1,
			'comments' => 1,
			'images' => 1,
			'img_w' => 100,
			'img_h' => 100,
			'img_float' => 'alignright',
			'margin_right' => '',
			'offset' => '',
			'title' => '',
			'id' => '',
			'padding' => 0,
			'colmargin' => 30
		);
	
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
	
		$featuredcat = pw_theme_option('fp_featured');
		$post_query = array(
			"posts_per_page"=>$r['posts'],
			"ignore_sticky_posts" => 1,
			'paged' => $paged
		);
		if($r['category']!=0) 
			$post_query['cat'] = $r['category'];	
		
		if(!empty($r['offset']))
			$post_query['offset'] = $r['offset'];
		
		if($r['width']=="full") { 
			$width = ' style="width:100%;';
			if(!empty($r['margin_right'])) $width .= ' margin-right:'.$r['margin_right'].'px;"'; else $width .= '"';
			if($r['columns']!=1) $col_width = ($pw_content_width - ($colmargin*($columns-1))) / $r['columns']; else $col_width = $pw_content_width;
		} else { 
			$width = ' style="width:'.$r['width'].'px; margin-right:'.$r['margin_right'].'px;"'; 
			if($r['columns']!=1) $col_width = ($r['width'] - ($colmargin*($columns-1))) / $r['columns']; else $col_width = $r['width'];
		}
		$col_width = ' style="width: '.$col_width.'px;';
		if(!empty($padding)) $col_width .= ' padding: '.$padding.'px;';

		$x=1;
		if(!empty($r['id'])) {
			$id = ' id="'.$r['id'].'"';
		} else {
			$id = "";
		}

		$column_query = new WP_Query();
		$column_query->query($post_query);
		
		?>
		<div class="columns"<?php echo $width; echo $id; ?>>
		<?php while ($column_query->have_posts()) : $column_query->the_post(); ?>
			<?php if($x==1) $clear = "clear"; else $clear = ""; ?>
			<?php if($x!=1 && $r['columns']>1)  $final_width = $col_width.' margin-left: '.$colmargin.'px;"'; else $final_width = $col_width.'"'; ?>
			<?php if($x==$r['columns']) $x=0; ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($clear); echo $final_width; ?>>
				<?php pw_actionBlock('pw_columns', $r); ?>
			</article>
		<?php $x++; endwhile; ?>
		</div>
	<?php
	
	}
endif;

