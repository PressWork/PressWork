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
		global $pw_content_width;
		$defaults = array(
			'width' => 'full',
			'columns' => 1,
			'posts' => 1,
			'text' => 'excerpt',
			'readmore' => 1,
			'category' => 'all',
			'dates' => 1,
			'authors' => 1,
			'comments' => 1,
			'images' => 1,
			'img_w' => 100,
			'img_h' => 100,
			'margin-right' => '',
			'offset' => '',
			'title' => '',
			'id' => '',
			'padding' => 15,
			'colmargin' => 30
		);
	
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
	
		$featuredcat = pw_theme_option('fp_featured');
		$posts = array(
			"posts_per_page"=>$r['posts'],
		);
		if($r['category']!="all") 
			$posts['cat'] = $r['category'];	
		
		if(isset($r['offset']))
			$posts['offset'] = $r['offset'];
		
		$column = new WP_Query();
		$column->query($posts);
		
		if($r['width']=="full") { 
			$width = ' style="width:100%; margin-right:'.$r['margin-right'].'px;"';  
			if($r['columns']!=1) $col_width = ($pw_content_width - ($padding * 2 * $columns) - ($colmargin*($columns-1))) / $r['columns']; else $col_width = $pw_content_width - ($padding * 2);
			$col_width = ' style="width: '.$col_width.'px;';
		} else { 
			$width = ' style="width:'.$r['width'].'px; margin-right:'.$r['margin-right'].'px;"'; 
			if($r['columns']!=1) $col_width = ($r['width'] - ($padding * 2 * $columns) - ($colmargin*($columns-1))) / $r['columns']; else $col_width = $r['width'] - ($padding * 2);
			$col_width = ' style="width: '.$col_width.'px;';
		}
		$x=1;
		if(!empty($r['id'])) {
			$id = ' id="'.$r['id'].'"';
		} else {
			$id = "";
		}
		?>
		<div class="columns"<?php echo $width; echo $id; ?>>
		<?php if(!empty($r['title'])) echo '<div class="columns-title">'.$r['title'].'</div>'; ?>
		<?php while ($column->have_posts()) : $column->the_post(); ?>
			<?php if($x==1) $clear = "clear"; else $clear = ""; ?>
			<?php if($x!=1 && $r['columns']>1)  $final_width = $col_width.' margin-left: '.$colmargin.'px;"'; else $final_width = $col_width.'"'; ?>
			<?php if($x==$r['columns']) $x=0; ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class($clear); echo $final_width; ?>>
				<?php pw_actionBlock('pw_columns', $r); ?>
			</div>
		<?php $x++; endwhile; ?>
		</div>
	<?php
	}
endif;