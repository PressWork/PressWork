<?php
// Set up PressWork Framework information
if(!function_exists('pw_init')):
	function pw_init() {
		$bavotasan_theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
		define('THEME_NAME', $bavotasan_theme_data['Name']);
		define('THEME_AUTHOR', $bavotasan_theme_data['Author']);
		define('THEME_HOMEPAGE', $bavotasan_theme_data['URI']);
		define('THEME_VERSION', trim($bavotasan_theme_data['Version']));
		define('THEME_URL', get_template_directory_uri());
		define('THEME_FILE', 'presswork');
		define('THEME_CODE', 'pwk');
	}
endif;
pw_init();

/**
 * Redirect to theme page upon theme activation
 *
 * @since PressWork 1.0
 */	
if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {
	header( 'Location: '.admin_url().'themes.php?page=presswork' ) ;
}

/**
 * This is where the default themes options are set for PressWork.
 *
 * var $pw_default_options
 *
 * @since PressWork 1.0
 */	
$pw_default_options = array(
	"layout_option" => "maincontent,firstsidebar",
	"header_option" => "header_logo,nav",
	"footer_option" => "extendedfooter,copyright",
	"content_width" => "600",
	"first_sidebar_width" => "300",
	"second_sidebar_width" => "180",
	"body_margins" => "0",
	"content_margins" => "30",
	"toolbox" => "on",
	"dragdrop" => "off",
	"guides" => "off",
	"functions" => "off",
	"header_logo" => get_template_directory_uri()."/admin/images/logo_front.png",
	"siteheader_color" => "#2B904E",
	"siteheader_color_hover" => "#444444",
	"description_color" => "#444444",
	"main_text_color" => "#444444",
	"a_color" => "#2b904e",
	"a_color_hover" => "#4fb859",
	"nav_color" => "#222222",
	"nav_color_hover" => "#444444",
	"nav_background_color" => "#FFFFFF",
	"nav_background_color_hover" => "#EEEEEE",
	"subnav_color" => "#222222",
	"subnav_color_hover" => "#222222",
	"subnav_background_color" => "#FFFFFF",
	"subnav_background_color_hover" => "#EEEEEE",
	"post_title_color" => "#222222",
	"post_title_color_hover" => "#222222",
	"post_meta_color" => "#888888",
	"page_background_color" => "#FFFFFF",
	"body_font" => "Open Sans",
	"headers_font" => "Quattrocento",
	"body_font_size" => "12"
);

// all the includes
$pw_welcome = theme_option("welcome_screen");
if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($pw_welcome)) 
	include(TEMPLATEPATH.'/admin/inc/welcome.php');
include(TEMPLATEPATH."/admin/inc/stylesheet.php");
include(TEMPLATEPATH.'/admin/actions.php');
include(TEMPLATEPATH.'/admin/inc/toolbox.php');
include(TEMPLATEPATH.'/admin/inc/footer-scripts.php');
include(TEMPLATEPATH.'/admin/inc/action-blocks.php');
//include(TEMPLATEPATH.'/admin/inc/theme-updater.php');
include(TEMPLATEPATH.'/admin/inc/slideshows.php');
include(TEMPLATEPATH.'/admin/inc/fullwidth.php');
include(TEMPLATEPATH.'/admin/inc/columns.php');
include(TEMPLATEPATH.'/admin/inc/google-fonts.php');
include(TEMPLATEPATH.'/admin/inc/widget-twitter.php');
include(TEMPLATEPATH.'/admin/inc/widget-featured.php');

/**
 * Load custom-actions.php file if it exists in the uploads folder
 *
 * @since PressWork 1.0
 */
$upload_dir = wp_upload_dir();
if(!defined('ACTION_FILE'))
	define('ACTION_FILE', $upload_dir['basedir'].'/custom-actions.php');
if(file_exists(ACTION_FILE))
	include(ACTION_FILE);

/**
 * Load custom.css file if it exists in the uploads folder
 *
 * @since PressWork 1.0
 */
define('CSS_FILE', $upload_dir['basedir'].'/custom.css');
define('CSS_DISPLAY', $upload_dir['baseurl'].'/custom.css');
if(file_exists(CSS_FILE))
	add_action("wp_head", "add_custom_css_file");

function add_custom_css_file() {
	echo '<link rel="stylesheet" href="'.CSS_DISPLAY.'" type="text/css" media="screen" />'."\n";
}
	
/** Tell WordPress to run presswork_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'presswork_setup' );

if(!function_exists('presswork_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override presswork_setup() in a child theme, add your own presswork_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 *
 * @since PressWork 1.0
 */
function presswork_setup() {
	global $pw_site;
	// This theme allows users to set a custom background
	if(function_exists('add_custom_background')) 
		add_custom_background();
		
	// This theme uses wp_nav_menu()
	if(function_exists('register_nav_menu')) {
		register_nav_menu('main', 'Main Navigation Menu');
		register_nav_menu('sub', 'Sub Navigation Menu');
		register_nav_menu('footer', 'Footer Navigation Menu');
	}
	// The default message if no menu is set in the wp-admin
	function menu_default() {
		echo '<div class="warning clear fl"><p>Create your navigation menu <a href="'.admin_url('nav-menus.php').'">here</a>.</p></div>';
	}

	// The default message if no sub-menu is set in the wp-admin
	function sub_menu_default() {
		echo '<div class="warning clear fl"><p>Create your sub-navigation menu <a href="'.admin_url('nav-menus.php').'">here</a>.</p></div>';
	}

	// The default message if no sub-menu is set in the wp-admin
	function footer_menu_default() {
		echo '<div class="warning clear fl"><p>Create your footer navigation menu <a href="'.admin_url('nav-menus.php').'">here</a>.</p></div>';
	}
	
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain(THEME_FILE, TEMPLATEPATH . '/admin/languages');
	
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/admin/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See pw_admin_header_style(), below.
	add_custom_image_header('pw_header_style', 'pw_admin_header_style');
	
	define('NO_HEADER_TEXT', true );
	define('HEADER_TEXTCOLOR', '');
	define('HEADER_IMAGE_WIDTH', $pw_site); // use width and height appropriate for your theme
	if(!defined('HEADER_IMAGE_HEIGHT')) 
		define('HEADER_IMAGE_HEIGHT', 160);
		
	if(function_exists('add_theme_support')) {
		// Add functionality for post thumbnails/featured image
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'fifty', 50, 50, true );
		add_image_size( 'sticky', theme_option('content_width'), 240, true );
		
		//Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		//Add functionality for post formats
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'gallery', 'image', 'link', 'video' ) );
	}		
}
endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if(!isset($content_width))
	$content_width = (theme_option('content_width'));

// Add the theme admin
add_action('admin_menu', 'pw_add_admin'); 

if(!function_exists('pw_add_admin')) :
/**
 * This is where we initialize the theme using the admin_menu hook.
 *
 * Adds the PressWork admin page into the Appearance panel.
 */
	function pw_add_admin() {
		wp_register_script('admin_effects_js', THEME_URL.'/admin/js/admin-effects.js', array( 'jquery' ),'',true);
		
		$themelayout = add_theme_page(THEME_FILE, THEME_NAME, 'manage_options', THEME_FILE, 'pw_admin_page');
		add_action( "admin_print_scripts-$themelayout", 'pw_admin_css' );
	}
endif;

if(!function_exists('pw_admin_css')) :
// load the js and css on theme options page
	function pw_admin_css() {
		echo '<link rel="stylesheet" href="'.THEME_URL.'/admin/css/admin-style.css" />'."\n";
		wp_enqueue_script('admin_effects_js');
	}
endif;

if(!function_exists('pw_admin_page')) :
/**
 * This is the admin page for PressWork.
 *
 * @since PressWork 1.0
 */	
	function pw_admin_page() { 
		?>
	<div id="presswork" class="wrap">
	  	<div id="ajaxloader"></div>
        <img src="<?php echo get_template_directory_uri(); ?>/admin/images/logo_pw.jpg" width="260" height="114" alt="" class="pw-logo" />
	    <?php echo '<div id="message" class="updated fade" style="display: none;"><p><strong>'.__("PressWork Deactivated.", "presswork").'</strong></p></div>'."\n"; ?>
	    <?php
	    printf(__("<p><strong>%s</strong> is an easy to use framework built for WordPress. There are many theme options available to get your site up and running, but to really take advantage of <strong>%s</strong>, you need to start to understand how custom actions work.</p><p> Take a look at the <strong>%s</strong> section in the %s to get you started.</p>", "presswork"), THEME_NAME, THEME_NAME, THEME_NAME, '<a href="http://themes.bavotasan.com/support/categories/presswork-tutorials">Support Forum</a>');
	    $toolbox = theme_option('toolbox'); 
		if($toolbox=="on") { $class = "deactivate"; }
		?>
        <a href="javascript:void(0)" class="active <?php echo $class; ?>"></a>
        <input type="hidden" name="frontURL" id="frontURL" value="<?php echo home_url("/"); ?>" />
        <p class="pw-briefcase">Want more functionality get</p>
        <p class="pw-twitter">@PressWorkWP</p>
		<?php
		/*$bavotasan_version_check = check_for_update();
		if(!empty($bavotasan_version_check)) {
			set_site_transient('update_themes', null);
			echo '<p class="pw-newversion">';
			printf(__('Version %1$s of %2$s is now available. Go to %3$s page.', "presswork"), $bavotasan_version_check, '<strong>'.THEME_NAME.'</strong>', '<a href="'.admin_url('update-core.php').'">Updates</a>');
			echo '</p>';
		}*/
		echo '</div><!-- end of #wrap -->';	
	}
endif;

// The get_index function
function get_index($array, $index) {
  return isset($array[$index]) ? $array[$index] : null;
}

// Reset theme option function
function reset_options() {
	global $pw_default_options;
	update_option(THEME_FILE, $pw_default_options);
}

// Call theme options
function theme_option($var) {
	$pw_values = get_option(THEME_FILE);
	if(!$pw_values) reset_options();
	$val = get_index($pw_values, $var);
	return $val;
}

// Reset theme ajax function
function reset_theme_options() {
	reset_options();
	die();
}
add_action('wp_ajax_reset_theme_options', 'reset_theme_options');

// Ajax save option function
function save_option() {
	$option = $_POST['option'];
	$id = $_POST['id'];
	pw_single_save($id, $option);
	die();
}
add_action('wp_ajax_save_option', 'save_option');

// Turn on toolbox function
function turn_on_toolbox() {
	$option = $_POST['option'];
	pw_single_save('toolbox', $option);
	pw_single_save('welcome_screen', false);
	die();
}
add_action('wp_ajax_turn_on_toolbox', 'turn_on_toolbox');

// Save single options function
function pw_single_save($option, $value) {
	$savevalues = get_option(THEME_FILE);
	$savevalues[$option] = $value;
	update_option(THEME_FILE, $savevalues);
}

// Ajax save function
function save_theme_callback() {
	if (!wp_verify_nonce($_POST['nonce'], 'bavotasan_nonce'))
		exit();

	$savevalues = get_option(THEME_FILE);
	
	$items = explode("&", $_POST['option']);
	foreach ($items as $value) {
		$key_value = explode("=",$value);
		$key = urldecode($key_value[0]);
		$value = urldecode($key_value[1]);
		$savevalues[ $key ] = $value; 
	}
	
	update_option(THEME_FILE, $savevalues);
	die();
}
add_action('wp_ajax_save_theme_options', 'save_theme_callback');

// Remove welcome screen function
function remove_welcome_screen() {
	if (!wp_verify_nonce($_POST['nonce'], 'bavotasan_nonce'))
		exit();

	pw_single_save("welcome_screen", true);
	die();
}
add_action('wp_ajax_remove_welcome_screen', 'remove_welcome_screen');

if(!function_exists('pw_widgets_init')) :
/**
 * This is where the widgetized areas and the scripts are initialized and 
 * registered
 *
 * @since PressWork 1.0
 */	
	function pw_widgets_init() {
		if(theme_option('toolbox')=="on" && current_user_can( "manage_options" )) 
			wp_register_script('effects_js', THEME_URL.'/admin/js/effects.js', array( 'jquery', 'jquery-ui-sortable' ),'',true);
		else
			wp_register_script('effects_js', THEME_URL.'/admin/js/effects.js', array( 'jquery' ),'',true);
		wp_register_script('sliderota_js', THEME_URL.'/admin/js/sliderota.js', array( 'jquery' ),'',true);
		wp_register_script('scrollerota_js', THEME_URL.'/admin/js/scrollerota.js', array( 'jquery' ),'',true);
		wp_register_script('faderota_js', THEME_URL.'/admin/js/faderota.js', array( 'jquery' ),'',true);
		
		// Initiating the sidebars
		register_sidebar(array(
			'name' => __('First Sidebar', "presswork"),
			'id' => 'first-sidebar',
			'description' => __( "The first sidebar appears on every page of your site, unless you have selected full width for a post or page.", "presswork" ),
			'before_widget' => '<div id="%1$s" class="side-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
		
		register_sidebar(array(
			'name' => __('Second Sidebar', "presswork"),
			'id' => 'second-sidebar',
			'description' => __( "The second sidebar appears on every page of your site, unless you have selected full width for a post or page.", "presswork" ),
			'before_widget' => '<div id="%1$s" class="side-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));

		register_sidebar(array(
			'name' => __('Header Area', "presswork"),
			'id' => 'header-area',
			'description' => __( "The header area appears above the blogname on every page of your site", "presswork" ),
			'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
		
		register_sidebar(array(
			'name' => __('Extended Footer', "presswork"),
			'id' => 'extended-footer',
			'description' => __( "The extended footer appears at the bottom of your site, above your footer content.", "presswork" ),
			'before_widget' => '<div id="%1$s" class="bottom-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}
endif;
add_action( 'init', 'pw_widgets_init' );

if(!function_exists('pw_comment_template')) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own pw_comment_template(), and that function will be used 
 * instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since PressWork 1.0
 */
	function pw_comment_template($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 60 ); ?>
			</div>     
			<div class="comment-author">
				<?php echo get_comment_author_link()." ";
				printf(__('on %1$s at %2$s', "presswork"), get_comment_date(),get_comment_time()); 
				edit_comment_link(__('(Edit)', "presswork"),'  ','');
				?>
			</div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') { _e('<em>Your comment is awaiting moderation.</em>', "presswork"); } ?>
				<?php comment_text() ?>
			</div>
			<?php if($args['max_depth']!=$depth && comments_open() && $comment->comment_type!="pingback") { ?>
			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<?php } ?>
		</div>
		<?php
	}
endif;

if(!function_exists('pw_paginate')) :
/**
 * Creates pagination.
 *
 * @since PressWork 1.0
 */
	function pw_paginate() {
		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		
		$pagination = array(
			'base' => @add_query_arg('page','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => true,
			'type' => 'list',
			'next_text' => '&raquo;',
			'prev_text' => '&laquo;'
			);
		
		if( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		
		if( !empty($wp_query->query_vars['s']) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		
		echo paginate_links( $pagination );
	}
endif;

if(!function_exists('pw_header_style')) :
/**
 * Styles the header image.
 *
 * Referenced via add_custom_image_header()
 *
 * @since PressWork 1.0
 */
	function pw_header_style() {
		$headerimage = get_header_image();
		if(!empty($headerimage)) {
		?>
<style type="text/css">
#headerbanner { background: url(<?php header_image(); ?>); }
</style>
		<?php
		}
	}
endif;

if(!function_exists('pw_admin_header_style')) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header()
 *
 * @since PressWork 1.0
 */
	function pw_admin_header_style() {
		?>
<style type="text/css">
#headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px;	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; }
</style>
		<?php
	}
endif;

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in PressWork's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since PressWork 1.0
 */
 add_filter( 'use_default_gallery_style', '__return_false' );



if(!function_exists('pw_excerpt')) :
/**
 * Function to trim the excerpt
 *
 * @since PressWork 1.0
 */
	function pw_excerpt($limit = 55) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} else {
			$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
	}
endif;

/**
 * Adds links into the new WordPress 3.1 admin bar
 *
 * @since PressWork 1.0
 */
function add_menu_admin_bar() {
    global $wp_admin_bar, $wpdb;

    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;

    /* Add the main siteadmin menu item */
    $wp_admin_bar->add_menu( array( 'id' => 'presswork-options', 'title' => THEME_NAME, 'href' => admin_url('themes.php')."?page=".THEME_FILE ) );
}
add_action( 'admin_bar_menu', 'add_menu_admin_bar', 1000 );

function pw_get_sidebar($id, $name, $action) {
	echo '<li id="'.$id.'"> <!-- begin '.$id.' -->'."\n"; 
	echo '<aside>';
	$handle = pw_handles($name);
	if(!empty($handle)) echo pw_handles($name,$id,true);
	actionBlock($action); // calling the Sidebar
	echo '</aside>';
	echo '</li> <!-- end '.$id.' -->'."\n"; 
	
}

function pw_handles($name, $id = null, $delete = null, $parent = 'layout') {
	$handle_on = theme_option('dragdrop');
	if(current_user_can('manage_options') && $handle_on=="on" && theme_option('toolbox')=="on") {
		if(!empty($delete)) $anchor = '<a href="javascript:void(0)" class="delete_element" key="'.$id.'" rel="'.$parent.'_option"></a>'; else $anchor = '';
		if($handle_on=="on") $handle = '<div class="handle"><span></span>'.$name.$anchor.'</div>'; else $handle = '';
		return $handle;
	}
}

function pw_function_handle($function) {
	if(theme_option('functions')=="on" && current_user_can('manage_options')) 
		return '<div class="handle clear">'.$function.'</div>';
	else
		return;
}

if(current_user_can('manage_options') && theme_option('toolbox')=="on") {
	add_action('pw_body_bottom', 'pw_toolbox');
	if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($welcome)) 
		add_action('wp_footer', 'pw_welcome_screen', 1);
	add_action('wp_footer', 'footer_scripts');

}

function add_element() {
	if (!wp_verify_nonce($_POST['nonce'], 'bavotasan_nonce'))
		exit();
	
	$element = $_POST['element'];
	$option = $_POST['option'];
	pw_get_element($element);
	die();	
}
add_action('wp_ajax_add_element', 'add_element');

function delete_element() {
	$element = $_POST['element'];
	$option = $_POST['option'];
	if (!wp_verify_nonce($_POST['nonce'], 'bavotasan_nonce'))
		exit();

	$all_options = get_option(THEME_FILE);
	$three = explode(',', $all_options[$option]);
	$i = 0;
	foreach($three as $one) {
		if($one==$element) { unset($three[$i]); }
		$i++;
	}
	$all_options[$option] = implode(",", $three);
	die(0);	
}
add_action('wp_ajax_delete_element', 'delete_element');

function pw_get_element($name) {
	if($name=="maincontent") {
		$handle = pw_handles('Main Content'); ?>
	    <li id="maincontent"> <!-- begin maincontent -->
    	<?php 
    	echo $handle; 
    	if(!have_posts()) : 
       		actionBlock('pw_404');
    	elseif(is_category()) :
        	actionBlock('pw_category');	
   		elseif(is_author()) :
        	actionBlock('pw_author');	
    	elseif(is_archive()) :
        	actionBlock('pw_archive');
    	elseif(is_search()) :
        	actionBlock('pw_search');
    	elseif(is_page()) :
        	actionBlock('pw_page');
			comments_template( '', true );
		elseif(is_single()) :
        	actionBlock('pw_single');
			comments_template( '', true );
		else :	 
        	actionBlock('pw_index');
    	endif; 
    	?>
    	</li> <!-- end #maincontent -->
    	<?php
	}
	if($name=="firstsidebar") {
		pw_get_sidebar('firstsidebar', 'First Sidebar', 'pw_sidebar');
	}
	if($name=="secondsidebar") {
    	pw_get_sidebar('secondsidebar', 'Second Sidebar', 'pw_second_sidebar');
	}
	if($name=="headerarea") {
    	echo '<li id="headerarea" class="mainl">'."\n"; 
		$handle = pw_handles('Widgetized Area', 'headerarea', true, 'header');
		echo $handle;
	   	if(!dynamic_sidebar("header-area")) :
			echo '<div class="warning clear fl"><p>Add widgets to the Header Area <a href="'.admin_url('widgets.php').'">here</a>.</p></div>';
    	endif;
		echo '</li>'."\n"; 
	}
	if($name=="blogname") {
		$handle = pw_handles('Blog Name', 'blogname', true, 'header'); 
	   	?>
	   	<li id="blogname" class="mainl">
            <?php echo $handle; ?>
            <?php if(is_home()) $header = "h1"; else $header = "div"; ?>
            <?php echo "<".$header; ?> class="siteheader"><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></<?php echo $header; ?>>
        </li>
		<?php
	}
	if($name=="header_logo") {
		$handle = pw_handles('Header Logo', 'header_logo', true, 'header'); 
	   	?>
	   	<li id="header_logo" class="mainl">
            <?php echo $handle; ?>
            <div class="siteheader"><a href="<?php echo home_url(); ?>/"><img src="<?php echo theme_option("header_logo"); ?>" alt="<?php bloginfo("name"); ?>" /></a></div>
        </li>
		<?php
	}	
	if($name=="description") {
		$handle = pw_handles('Description', 'description', true, 'header');
	   	?>
	   	<li id="description" class="mainl">
            <?php echo $handle; ?>
	   		<?php bloginfo('description'); ?>
    	</li>
		<?php
	}
	if($name=="nav") {
		$handle = pw_handles('Nav Menu', 'nav', true, 'header'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="nav" class="mainl">';
    		echo $handle;
			 wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'sf-menu','sort_column' => 'menu_order', 'container' => 'nav', 'container_class' => 'clear fl', 'fallback_cb' => 'menu_default' ) ); 
			echo '</li>';
		}	
	}
	if($name=="subnav") {
		$handle = pw_handles('Sub Nav Menu', 'subnav', true, 'header'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="subnav" class="mainl">';
    		echo $handle;
			 wp_nav_menu( array( 'theme_location' => 'sub', 'menu_class' => 'sf-menu','sort_column' => 'menu_order', 'container' => 'nav', 'container_class' => 'clear fl sub', 'fallback_cb' => 'sub_menu_default' ) ); 
			echo '</li>';
		}	
	}
	if($name=="footernav") {
		$handle = pw_handles('Footer Nav Menu', 'footernav', true, 'footer'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="footernav" class="foot">';
    		echo $handle;
			 wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'sf-menu','sort_column' => 'menu_order', 'container' => 'nav', 'container_class' => 'clear fl sub', 'fallback_cb' => 'footer_menu_default' ) ); 
			echo '</li>';
		}	
	}
	if($name=="extendedfooter") {
		$handle = pw_handles('Extended Footer', 'extendedfooter', true, 'footer');
		echo '<li id="extendedfooter" class="foot">';
    	echo $handle;
		if(!dynamic_sidebar("extended-footer")) :
			echo '<div class="warning clear fl"><p>Add widgets to the Extended Footer <a href="'.admin_url('widgets.php').'">here</a>.</p></div>';
    	endif;
		echo '</li>';
	}
	if($name=="copyright") {
		$handle = pw_handles('Copyright', 'copyright', true, 'footer');
		echo '<li id="copyright" class="foot">';
    	echo $handle;
		$link = '<a href="'.home_url().'">'.get_bloginfo('name').'</a>';
		printf(__('&copy; %1$d %2$s. All Rights Reserved.', "presswork"), date('Y'), $link);
		echo ' ';
		printf(__('Built using %s.', "presswork"), '<a href="http://presswork.me">'.THEME_NAME.'</a>'); 
		echo '</li>';
	}
}

/**
 * Trims the excerpt length
 *
 * @since PressWork 1.0
 */
 function theme_excerpt($limit = 55, $readmore = false) {
	if($readmore) {
		$link = '<br /><a href="'.get_permalink().'" class="more-link">'.theme_option('more_link_text').'</a>';
	} else {
		$link = "";
	}
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...'.$link;
	} else {
		$excerpt = implode(" ",$excerpt).$link;
	}	
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	echo '<p class="excerpt">'.$excerpt.'</p>';
}

/**
 * Gathers the posts displayed in the featured posts widget
 *
 * @since PressWork 1.0
 */
function notin() {
    if(is_active_widget('', '','pw_featured_posts')) {
		global $post;
		$options = get_option("widget_pw_featured_posts");
		$sticky = get_option( 'sticky_posts' );
		foreach($options as $option) {
			if(!empty($option['number'])) {
				$args = array(
					"posts_per_page" => $option['number'],
					"cat" => $option['category'],
					"post__not_in" => $sticky
				);
		        $featuredPosts = new WP_Query();
		        $featuredPosts->query($args);
		        while($featuredPosts->have_posts()) : $featuredPosts->the_post(); 
		            $notin[] = $post->ID;
		        endwhile;			
			}
		}
    } else {
        $notin = '';
    }
	return $notin;
}

/**
 * Displays the toolbox add element button options
 *
 * @since PressWork 1.0
 */
function pw_add_element_option($name, $id, $text, $rel) {
	$loc = strpos(theme_option($name.'_option'), $id);
	echo '<div class="addoption '.$name.'-item"><span>'.$text.'</span><a href="javascript:void(0)" class="add-item';
	if($loc!==false) echo " disabled";
	echo '" key="'.$id.'" rel="'.$rel.'">Add</a></div>';
}

/**
 * Displays the toolbox color option input
 *
 * @since PressWork 1.0
 */
function pw_color_option($name, $id, $text, $rel) {
	 echo '<tr class="color-item '.$name.'-item"><th>'.$text.'</th><td><input type="text" class="colorpicker" name="'.$id.'" rel="'.$rel.'" size="7" value="'.theme_option($id).'" /><a href="javascript:void(0)" class="colorwheel" rel="'.$name.'"></a></td></tr>';
}

/**
 * Displays the toolbox font options
 *
 * @since PressWork 1.0
 */
function pw_font_option($name, $text, $rel) {
	 echo '<tr ><th>'.$text.'</th><td>'.font_select($name."_font", $rel).'</td></tr>';
}

function font_select($valueID, $rel) {
    global $pw_google_fonts;
    $ret = '<div class="styled-select"><select class="fontselect" name="'.$valueID.'" rel="'.$rel.'">';
        foreach($pw_google_fonts as $font) {
            $ret .= '<option value="'.$font.'"';
            if(stripslashes(theme_option($valueID)) == $font) $ret .= ' selected="selected"';
            $ret .= '>'.$font.'</option>'."\n";
        
        }
    $ret .= '</select></div>';
	return $ret;
}

function search_url_rewrite_rule() {
	if ( is_search() && !empty($_GET['s'])) {
		wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
		exit();
	}
	
}
add_action('template_redirect', 'search_url_rewrite_rule');