<?php

// Set up PressWork Framework information
if(!function_exists('pw_init')):
	function pw_init() {
		$presswork_theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
		define('PW_THEME_NAME', $presswork_theme_data['Name']);
		define('PW_THEME_HOMEPAGE', $presswork_theme_data['URI']);
		define('PW_THEME_VERSION', trim($presswork_theme_data['Version']));
		define('PW_THEME_URL', get_template_directory_uri());
		define('PW_THEME_FILE', 'presswork');
		define('PW_THEME_CODE', 'pwk');
	}
	pw_init();
endif;

/**
 * Single save theme option
 *
 * @since PressWork 1.0
 */	
if(!function_exists('pw_single_save')) :
	function pw_single_save($option, $value) {
		$savevalues = get_option(PW_THEME_FILE);
		$savevalues[$option] = esc_attr($value);
		update_option(PW_THEME_FILE, $savevalues);
	}
endif;

/**
 * Redirect to theme page upon theme activation
 *
 * @since PressWork 1.0
 */	
if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {
	global $pw_welcome;
	//delete_option(PW_THEME_FILE); die;
	$pw_welcome = false;
	header( 'Location: '.home_url("/")."?action=pw-activate");
}

/**
 * This is where the default themes options are set for PressWork.
 *
 * var $pw_default_options
 *
 * @since PressWork 1.0
 */	
if(empty($pw_default_options)) {
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
		"hooks" => "off",
		"functions" => "off",
		"header_logo" => PW_THEME_URL."/admin/images/logo_front.png",
		"favicon" => PW_THEME_URL."/admin/images/favicon.ico",
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
		"footernav_color" => "#222222",
		"footernav_color_hover" => "#222222",
		"footernav_background_color" => "#FFFFFF",
		"footernav_background_color_hover" => "#EEEEEE",
		"category_header_color" => "#222222",
		"post_title_color" => "#222222",
		"post_title_color_hover" => "#222222",
		"post_meta_color" => "#888888",
		"page_background_color" => "#FFFFFF",
		"body_font" => "Open Sans",
		"headers_font" => "Quattrocento",
		"body_font_size" => "12"
	);
}

// Call theme options
function pw_theme_option($var) {
	global $pw_default_options, $pw_welcome;
	$pw_values = get_option(PW_THEME_FILE);
	if(empty($pw_values)) { pw_reset_options(); $pw_values = $pw_default_options; $pw_welcome = false; }
	$val = pw_get_index($pw_values, $var);
	return $val;
}

// all the includes
if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($pw_welcome)) 
	include(TEMPLATEPATH.'/admin/inc/welcome.php');
include(TEMPLATEPATH."/admin/inc/stylesheet.php");
include(TEMPLATEPATH.'/admin/actions.php');
include(TEMPLATEPATH.'/admin/inc/toolbox.php');
include(TEMPLATEPATH.'/admin/inc/footer-scripts.php');
include(TEMPLATEPATH.'/admin/inc/action-blocks.php');
include(TEMPLATEPATH.'/admin/inc/slideshows.php');
include(TEMPLATEPATH.'/admin/inc/fullwidth.php');
include(TEMPLATEPATH.'/admin/inc/columns.php');
include(TEMPLATEPATH.'/admin/inc/google-fonts.php');
include(TEMPLATEPATH.'/admin/inc/widget-twitter.php');
include(TEMPLATEPATH.'/admin/inc/widget-featured.php');
include(TEMPLATEPATH.'/admin/inc/widget-slideshows.php');
include(TEMPLATEPATH.'/admin/inc/widget-flickr.php');

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
	add_action("wp_print_styles", "pw_add_custom_css_file");

function pw_add_custom_css_file() {
	wp_register_style('pw_custom_css', CSS_DISPLAY);
    wp_enqueue_style( 'pw_custom_css');
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
		register_nav_menu('primary', __('Primary Nav Menu', "presswork"));
		register_nav_menu('secondary', __('Secondary Nav Menu', "presswork"));
		register_nav_menu('footer', __('Footer Nav Menu', "presswork"));
	}
	// The default message if no primary menu is set in the wp-admin
	function pw_menu_default() {
		?>
			<ul id="menu-main" class="menu">
				<li><a href="<?php echo home_url("/"); ?>">Home</a></li>
				<?php wp_list_categories('title_li=&depth=1&number=5'); ?>
			</ul>
		<?php
		if(current_user_can('edit_theme_options')) {
			echo '<div class="warning clear fl" style="margin-bottom: 5px;"><p>';
			printf(__("Customize your Primary nav menu %shere%s", "presswork"), '<a href="'.admin_url('nav-menus.php').'">', '</a>');
			echo '</p></div>';
		}
	}

	// The default message if no secondary menu is set in the wp-admin
	function pw_sub_menu_default() {
		if(current_user_can('edit_theme_options')) {
			echo '<div class="warning clear fl"><p>';
			printf(__("Create your Secondary nav menu %shere%s", "presswork"), '<a href="'.admin_url('nav-menus.php').'">', '</a>');
			echo '</p></div>';
		}
	}

	// The default message if no footer menu is set in the wp-admin
	function pw_footer_menu_default() {
		if(current_user_can('edit_theme_options')) {
			echo '<div class="warning clear fl"><p>';
			printf(__("Create your Footer nav menu %shere%s", "presswork"), '<a href="'.admin_url('nav-menus.php').'">', '</a>');
			echo '</p></div>';
		}
	}
	
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain(PW_THEME_FILE, TEMPLATEPATH . '/admin/languages');
	
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
		add_image_size( 'sticky', pw_theme_option('content_width'), 240, true );
		
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
	$content_width = (pw_theme_option('content_width'));

// Add the theme admin
add_action('admin_menu', 'pw_add_admin'); 

if(!function_exists('pw_add_admin')) :
/**
 * This is where we initialize the theme using the admin_menu hook.
 *
 * Adds the PressWork admin page into the Appearance panel.
 */
	function pw_add_admin() {
		global $pw_themelayout;
		wp_register_script('pw_admin_effects_js', PW_THEME_URL.'/admin/js/admin-effects.js', array( 'jquery' ),'',true);
		wp_localize_script( 'pw_admin_effects_js', 'presswork', array( 'front_url' => home_url("/") ) );
		
		$pw_themelayout = add_theme_page("presswork", "PressWork", 'edit_theme_options', "PressWork", 'pw_admin_page');
		add_action( "admin_print_scripts-$pw_themelayout", 'pw_admin_css' );
	}
endif;

if(!function_exists('pw_admin_css')) :
// load the js and css on theme options page
	function pw_admin_css() {
		echo '<link rel="stylesheet" href="'.PW_THEME_URL.'/admin/css/admin-style.css" />'."\n";
		wp_enqueue_script('pw_admin_effects_js');
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
	<div id="wrap">
	<div id="presswork">
        <img src="<?php echo PW_THEME_URL; ?>/admin/images/logo_pw.png" width="557" height="122" alt="" class="pw-logo" />
	    <?php echo '<div id="message" class="updated fade" style="display: none;"><p><strong>PressWork '.__("Toolbox Deactivated.", "presswork").'</strong></p></div>'."\n"; ?>
	    <?php
	    echo '<p>';
	    printf(__("If you've got mad skills when it comes to WordPress and you want to join the %s community, find us on %s and contribute. Together we can make %s the ultimate WordPress framework.", "presswork"), "<strong>PressWork</strong>", "<a href='https://github.com/digibomb/PressWork' target='_blank'>GitHub</a>", "<strong>PressWork</strong>");
	    echo '</p><p>';
	    printf(__("Click on the button below to activate/deactivate the %s front-end toolbox.", "presswork"), "<strong>PressWork</strong>");
		echo '</p>';
	    $toolbox = pw_theme_option('toolbox'); 
		if($toolbox=="on") { $class = "deactivate"; } else { $class = ''; }
		?>
  	  	<div id="active-button">
  	  		<img src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" alt='' />
        	<a href="javascript:void(0)" class="active <?php echo $class; ?>"></a>
        </div>
        <?php 
 	    echo '<p>';
      	printf(__("If you have any questions or feedback, please check out our %s.", "presswork"), '<a href="http://support.presswork.me/">Support Forum</a>');
		echo '</p>';
		?>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="QJ36XLEYC4J2S">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		<?php
		if(function_exists('pw_check_for_update')) {
			$presswork_version_check = pw_check_for_update();
			if(!empty($presswork_version_check)) {
				set_site_transient('update_themes', null);
				echo '<p class="pw-newversion">';
				printf(__('Version %1$s of %2$s is now available. Go to %3$s page.', "presswork"), $presswork_version_check, '<strong>'.PW_THEME_NAME.'</strong>', '<a href="'.admin_url('update-core.php').'">Updates</a>');
				echo '</p>';
			}
		}
		?>
		</div> <!-- end of #presswork -->	
		<p class="pw-twitter"><a href="http://twitter.com/pressworkwp">@PressWorkWP</a></p>
        <p class="pw-briefcase">Want more functionality? Get <a href="http://presswork.me/briefcase/"></a></p>
	</div> <!-- end of #wrap -->
	<?php
	}
endif;

if(!function_exists('pw_help')) :
/**
 * Adds content to the help panel.
 *
 * @since PressWork 1.0.1
 */	
	function pw_help($contextual_help, $screen_id, $screen) {
		global $pw_themelayout;
		if ($screen_id == $pw_themelayout) {
			$contextual_help = '';
			$contextual_help .= '<h3>'.__("Resources", "presswork").'</h3><ul>';
			$contextual_help .= '<li><a href="http://presswork.me" target="_blank">PressWork.me</a></li>';
			$contextual_help .= '<li><a href="http://support.presswork.me" target="_blank">'.__("Support Forum", "presswork").'</a></li>';
			$contextual_help .= '<li><a href="https://github.com/digibomb/PressWork" target="_blank">'.__("PressWork on Github", "presswork").'</a></li>';
			$contextual_help .= '<li><a href="http://twitter.com/pressworkwp" target="_blank">'.__("Find us on Twitter", "presswork").'</a></li>';
			$contextual_help .= '<li><a href="http://presswork.me/category/themes/" target="_blank">'.__("Browse Our Themes", "presswork").'</a></li>';
			$contextual_help .= '</ul>';
		}
		return $contextual_help;
	}
endif;
add_filter('contextual_help', 'pw_help', 10, 3);


// The pw_get_index function
function pw_get_index($array, $index) {
  return isset($array[$index]) ? $array[$index] : null;
}

// Reset theme option function
function pw_reset_options() {
	global $pw_default_options, $pw_welcome;
	update_option(PW_THEME_FILE, $pw_default_options);
	$pw_welcome = true;
}

// Reset theme ajax function
function pw_reset_theme_options() {
	pw_reset_options();
	die();
}
add_action('wp_ajax_reset_theme_options', 'pw_reset_theme_options');

// Ajax save option function
function pw_save_option() {
	$option = $_POST['option'];
	$id = $_POST['id'];
	pw_single_save($id, $option);
	die();
}
add_action('wp_ajax_save_option', 'pw_save_option');

// Turn on toolbox function
function pw_turn_on_toolbox() {
	$option = $_POST['option'];
	pw_single_save('toolbox', $option);
	die();
}
add_action('wp_ajax_turn_on_toolbox', 'pw_turn_on_toolbox');

// Ajax save function
function pw_save_theme_callback() {
	if (!wp_verify_nonce($_POST['nonce'], 'presswork_nonce'))
		return;

	$savevalues = get_option(PW_THEME_FILE);
	
	$items = explode("&", $_POST['option']);
	foreach ($items as $value) {
		$key_value = explode("=",$value);
		$key = urldecode($key_value[0]);
		$value = esc_attr(urldecode($key_value[1]));
		$savevalues[$key] = $value; 
	}
	update_option(PW_THEME_FILE, $savevalues);
	die();
}
add_action('wp_ajax_save_theme_options', 'pw_save_theme_callback');

// Remove welcome screen function
function pw_remove_welcome_screen() {
	global $pw_welcome;
	if (!wp_verify_nonce($_POST['nonce'], 'presswork_nonce'))
		return;

	$pw_welcome = true;
	die();
}
add_action('wp_ajax_remove_welcome_screen', 'pw_remove_welcome_screen');

if(!function_exists('pw_widgets_init')) :
/**
 * This is where the widgetized areas and the scripts are initialized and 
 * registered
 *
 * @since PressWork 1.0
 */	
	function pw_widgets_init() {
		if(pw_theme_option('toolbox')=="on" && current_user_can( "edit_theme_options" )) 
			wp_register_script('pw_effects_js', PW_THEME_URL.'/admin/js/effects.js', array( 'jquery', 'jquery-ui-sortable' ),'',true);
		else
			wp_register_script('pw_effects_js', PW_THEME_URL.'/admin/js/effects.js', array( 'jquery' ),'',true);
		wp_register_script('pw_sliderota_js', PW_THEME_URL.'/admin/js/sliderota.js', array( 'jquery' ),'',true);
		wp_register_script('pw_scrollerota_js', PW_THEME_URL.'/admin/js/scrollerota.js', array( 'jquery' ),'',true);
		wp_register_script('pw_faderota_js', PW_THEME_URL.'/admin/js/faderota.js', array( 'jquery' ),'',true);
		
		// Initiating the sidebars
		register_sidebar(array(
			'name' => __('Top Main Content on Index', "presswork"),
			'id' => 'top-index-area',
			'description' => __( "The area above the main content on the index page. Perfect spot for a slideshow.", "presswork" ),
			'before_widget' => '<aside id="%1$s" class="content-widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h1 class="catheader">',
			'after_title' => '</h1></header>',
		));

		register_sidebar(array(
			'name' => __('Header Area', "presswork"),
			'id' => 'header-area',
			'description' => __( "The header area appears on every page of your site if it has been placed in the header.", "presswork" ),
			'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h3>',
			'after_title' => '</h3></header>',
		));
		
		register_sidebar(array(
			'name' => __('First Sidebar', "presswork"),
			'id' => 'first-sidebar',
			'description' => __( "The first sidebar appears on every page of your site, unless you have selected full width for a post or page.", "presswork" ),
			'before_widget' => '<aside id="%1$s" class="side-widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h3>',
			'after_title' => '</h3></header>',
		));
		
		register_sidebar(array(
			'name' => __('Second Sidebar', "presswork"),
			'id' => 'second-sidebar',
			'description' => __( "The second sidebar appears on every page of your site, unless you have selected full width for a post or page.", "presswork" ),
			'before_widget' => '<aside id="%1$s" class="side-widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h3>',
			'after_title' => '</h3></header>',
		));

		register_sidebar(array(
			'name' => __('Extended Footer', "presswork"),
			'id' => 'extended-footer',
			'description' => __( "The extended footer appears at the bottom of your site if it has been placed in the footer.", "presswork" ),
			'before_widget' => '<aside id="%1$s" class="bottom-widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<header><h3>',
			'after_title' => '</h3></header>',
		));
	}
endif;
add_action( 'init', 'pw_widgets_init' );

if(!function_exists('pw_widget_first_last_classes')) :
/**
 * Adds a unique ordered class to widgets
 *
 * @since PressWork 1.0
 */
 	function pw_widget_first_last_classes($params) {
		global $my_widget_num;
		$this_id = $params[0]['id'];
		if($this_id == 'extended-footer') {
			$arr_registered_widgets = wp_get_sidebars_widgets();
		
			if(!$my_widget_num)
				$my_widget_num = array();
		
			if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) 
				return $params;
		
			if(isset($my_widget_num[$this_id]))
				$my_widget_num[$this_id] ++;
			else
				$my_widget_num[$this_id] = 1;
			
			if($my_widget_num[$this_id]==4)
				$my_widget_num[$this_id] = 1;
		
			$class = 'class="widget' . $my_widget_num[$this_id] . ' ';
			$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);
		}
		return $params;
	}
endif;
add_filter('dynamic_sidebar_params','pw_widget_first_last_classes');

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
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>     
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link()." "; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf(__('%1$s at %2$s', "presswork"), get_comment_date(),get_comment_time()); 
						edit_comment_link(__('(edit)', "presswork"),'  ','');
						?>
					</div>
					<div class="comment-text">
						<?php if ($comment->comment_approved == '0') { echo '<em>'.__('Your comment is awaiting moderation.', "presswork").'</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if($args['max_depth']!=$depth && comments_open() && $comment->comment_type!="pingback") { ?>
					<div class="reply">
						<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
					<?php } ?>
				</div>
			</div>
	
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="pingback">
			<p><?php _e( 'Pingback:', "presswork" ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', "presswork" ), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

/**
 * Adds HTML5 fields to comment form
 *
 * @since PressWork 1.0
 */
function pw_html5_fields($fields) {
	$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" required value="" size="30" placeholder="'.__("Your name", "presswork").' *" aria-required="true" /></p>';
	$fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email" required value="" size="30" placeholder="'.__("Your email", "presswork").' *" aria-required="true" /></p>';
	$fields['url'] = '<p class="comment-form-url"><input id="url" name="url" type="url" value="" size="30" placeholder="'.__("Your website", "presswork").'" /></p>';
	return $fields;
}
add_filter('comment_form_default_fields','pw_html5_fields');

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
			'base' => @add_query_arg('paged','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => false,
			'type' => 'plain',
			'next_text' => '&raquo;',
			'prev_text' => '&laquo;'
			);
		
		if( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		
		if( !empty($wp_query->query_vars['s']) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		
		echo '<nav id="page-numbers">';
		echo '<h3 class="assistive-text">Page navigation</h3>';
		echo paginate_links( $pagination );
		echo '</nav>';
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
		global $pw_site;
		$headerimage = get_header_image();
		if(!empty($headerimage)) {
		?>
<style type="text/css">
#header_image { background: url(<?php header_image(); ?>); height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; width: <?php echo $pw_site; ?>px; }
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
#headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; }
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
	function pw_excerpt($limit = 55, $readmore = false) {
		if($readmore) {
			$link = '<br /><a href="'.get_permalink().'" class="more-link">Read More &rarr;</a>';
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
endif;

/**
 * Adds links into the new WordPress 3.1 admin bar
 *
 * @since PressWork 1.0
 */
function pw_add_menu_admin_bar() {
    global $wp_admin_bar, $wpdb;

    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;

    /* Add the main siteadmin menu item */
    $wp_admin_bar->add_menu( array( 'id' => 'presswork-menu', 'title' => "PressWork", 'href' => admin_url('themes.php')."?page=PressWork" ) );
    $wp_admin_bar->add_menu( array( 'parent' => 'presswork-menu', 'id' => 'presswork-admin', 'title' => __("PW Admin", "presswork"), 'href' => admin_url('themes.php')."?page=PressWork" ) );
    $wp_admin_bar->add_menu( array( 'parent' => 'presswork-menu', 'id' => 'presswork-themes', 'title' => __("Browse Our Themes", "presswork"), 'href' => 'http://presswork.me/category/themes/' ) );

}
add_action( 'admin_bar_menu', 'pw_add_menu_admin_bar', 1000 );

function pw_get_sidebar($id, $name, $action, $class = null) {
	if(!empty($class)) $class = ' class="'.$class.'"';
	echo '<li id="'.$id.'" role="complementary"'.$class.'> <!-- begin '.$id.' -->'."\n"; 
	$handle = pw_handles($name);
	if(!empty($handle)) echo pw_handles($name,$id,true);
	pw_actionBlock($action); // calling the Sidebar
	echo '</li> <!-- end '.$id.' -->'."\n"; 
}

function pw_handles($name, $id = null, $delete = null, $parent = 'layout') {
	$handle_on = pw_theme_option('dragdrop');
	if(current_user_can('edit_theme_options') && $handle_on=="on" && pw_theme_option('toolbox')=="on") {
		if(!empty($delete)) $anchor = '<a href="javascript:void(0)" class="delete_element" key="'.$id.'" rel="'.$parent.'_option"></a>'; else $anchor = '';
		if($handle_on=="on") $handle = '<div class="handle"><span></span>'.$name.$anchor.'</div>'; else $handle = '';
		return $handle;
	}
}

function pw_function_handle($function) {
	if(pw_theme_option('functions')=="on" && current_user_can('edit_theme_options')) 
		return '<div class="handle clear">'.$function.'</div>';
	else
		return;
}

if(current_user_can('edit_theme_options') && pw_theme_option('toolbox')=="on") {
	add_action('pw_body_bottom', 'pw_toolbox');
	if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($pw_welcome)) 
		add_action('wp_footer', 'pw_welcome_screen', 1);
	add_action('wp_footer', 'pw_footer_scripts');

}

function pw_add_element() {
	if (!wp_verify_nonce($_POST['nonce'], 'presswork_nonce'))
		exit();
	
	$element = $_POST['element'];
	$option = $_POST['option'];
	pw_get_element($element);
	die();	
}
add_action('wp_ajax_add_element', 'pw_add_element');

function pw_delete_element() {
	if (!wp_verify_nonce($_POST['nonce'], 'presswork_nonce'))
		exit();

	$element = $_POST['element'];
	$option = $_POST['option'];

	$all_options = get_option(PW_THEME_FILE);
	$three = explode(',', $all_options[$option]);
	$i = 0;
	foreach($three as $one) {
		if($one==$element) { unset($three[$i]); }
		$i++;
	}
	$all_options[$option] = implode(",", $three);
	die(0);	
}
add_action('wp_ajax_delete_element', 'pw_delete_element');

function pw_get_element($name, $class = null) {
	if($name=="maincontent") {
		$handle = pw_handles('Main Content'); ?>
	    <li id="maincontent" role="main"<?php if(!empty($class)) echo ' class="'.$class.'"'; ?>> <!-- begin maincontent -->
    	<?php 
    	echo $handle; 
    	if(!have_posts()) : 
       		pw_actionBlock('pw_404');
    	elseif(is_category()) :
        	pw_actionBlock('pw_category');	
   		elseif(is_author()) :
        	pw_actionBlock('pw_author');	
    	elseif(is_archive()) :
        	pw_actionBlock('pw_archive');
    	elseif(is_search()) :
        	pw_actionBlock('pw_search');
    	elseif(is_page()) :
        	pw_actionBlock('pw_page');
			comments_template( '', true );
		elseif(is_single()) :
        	pw_actionBlock('pw_single');
			comments_template( '', true );
		else :	 
        	pw_actionBlock('pw_index');
    	endif; 
    	?>
    	</li> <!-- end #maincontent -->
    	<?php
	}
	if($name=="firstsidebar") {
		pw_get_sidebar('firstsidebar', 'First Sidebar', 'pw_sidebar', $class);
	}
	if($name=="secondsidebar") {
    	pw_get_sidebar('secondsidebar', 'Second Sidebar', 'pw_second_sidebar', $class);
	}
	if($name=="headerarea") {
    	echo '<li id="headerarea" class="mainl" role="complementary">'."\n"; 
		$handle = pw_handles('Widgetized Area', 'headerarea', true, 'header');
		echo $handle;
	   	if(!dynamic_sidebar("header-area") && current_user_can('edit_theme_options')) :
			echo '<div class="warning clear fl"><p>';
			printf(__("Add widgets to the Header Area %shere%s", "presswork"), '<a href="'.admin_url('widgets.php').'">', '</a>');
			echo '</p></div>';
		endif;
		echo '</li>'."\n"; 
	}
	if($name=="blogname") {
		$handle = pw_handles('Blog Name', 'blogname', true, 'header'); 
	   	?>
	   	<li id="blogname" class="mainl">
            <?php echo $handle; ?>
            <h1 id="site-title" class="siteheader"><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
        </li>
		<?php
	}
	if($name=="header_logo") {
		$handle = pw_handles('Header Logo', 'header_logo', true, 'header'); 
	   	$logo = pw_theme_option("header_logo");
	   	if(!empty($logo)) {
	   	?>
	   	<li id="header_logo" class="mainl">
            <?php echo $handle; ?>
            <div id="site-logo" class="siteheader"><h1><?php bloginfo('name'); ?></h1><a href="<?php echo home_url(); ?>/"><img src="<?php echo $logo; ?>" alt="<?php bloginfo("name"); ?>" title="<?php bloginfo("name"); ?>" /></a></div>
        </li>
		<?php
		}
	}
	if($name=="header_image") {
		$handle = pw_handles('Header Image', 'header_image', true, 'header'); 
	   	?>
	   	<li id="header_image" class="mainl"><?php echo $handle; ?></li>
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
		$handle = pw_handles('Primary Nav Menu', 'nav', true, 'header'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="nav" class="mainl">';
    		echo $handle;
    		echo '<nav class="clear fl" role="navigation">';
    		echo '<h3 class="assistive-text">Main menu</h3>';
			 wp_nav_menu( array( 'theme_location' => 'primary', 'sort_column' => 'menu_order', 'container' => '', 'fallback_cb' => 'pw_menu_default' ) ); 
			echo '</nav>';
			echo '</li>';
		}	
	}
	if($name=="subnav") {
		$handle = pw_handles('Secondary Nav Menu', 'subnav', true, 'header'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="subnav" class="mainl">';
    		echo $handle;
     		echo '<nav class="clear fl" role="navigation">';
   		echo '<h3 class="assistive-text">Sub menu</h3>';
			 wp_nav_menu( array( 'theme_location' => 'secondary', 'sort_column' => 'menu_order', 'container' => '', 'fallback_cb' => 'pw_sub_menu_default' ) ); 
			echo '</nav>';
			echo '</li>';
		}	
	}
	if($name=="footernav") {
		$handle = pw_handles('Footer Nav Menu', 'footernav', true, 'footer'); 
		if(function_exists('wp_nav_menu')) {
    		echo '<li id="footernav" class="foot">';
    		echo $handle;
     		echo '<nav class="clear fl" role="navigation">';
   		echo '<h3 class="assistive-text">Footer menu</h3>';
			wp_nav_menu( array( 'theme_location' => 'footer', 'sort_column' => 'menu_order', 'container' => '', 'fallback_cb' => 'pw_footer_menu_default' ) ); 
			echo '</nav>';
			echo '</li>';
		}	
	}
	if($name=="extendedfooter") {
		$handle = pw_handles('Extended Footer', 'extendedfooter', true, 'footer');
		echo '<li id="extendedfooter" class="foot" role="complementary">';
    	echo $handle;
		if(!dynamic_sidebar("extended-footer") && current_user_can('edit_theme_options')) :
			echo '<div class="warning clear fl"><p>';
			printf(__("Add widgets to the Extended Footer %shere%s", "presswork"), '<a href="'.admin_url('widgets.php').'">', '</a>');
			echo '</p></div>';
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
		printf(__('Created using %s.', "presswork"), '<a href="http://presswork.me">PressWork</a>'); 
		echo '</li>';
	}
}

/**
 * Gathers the posts displayed in the featured posts widget
 *
 * @since PressWork 1.0
 */
function pw_notin() {
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
	$loc = strpos(pw_theme_option($name.'_option'), $id);
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
	 echo '<tr class="color-item '.$name.'-item"><th>'.$text.'</th><td><input type="text" class="colorpicker" name="'.$id.'" rel="'.$rel.'" size="7" maxlength="7" value="'.pw_theme_option($id).'" /><a href="javascript:void(0)" class="colorwheel" rel="'.$name.'"></a></td></tr>';
}

/**
 * Displays the toolbox font options
 *
 * @since PressWork 1.0
 */
function pw_font_option($name, $text, $rel) {
	 echo '<tr ><th>'.$text.'</th><td>'.pw_font_select($name."_font", $rel).'</td></tr>';
}

function pw_font_select($valueID, $rel) {
    global $pw_google_fonts;
    $ret = '<div class="styled-select"><select class="fontselect" name="'.$valueID.'" rel="'.$rel.'">';
        foreach($pw_google_fonts as $font) {
            $ret .= '<option value="'.$font.'"';
            $ret .= selected(pw_theme_option($valueID), $font, false);
            $ret .= '>'.$font.'</option>'."\n";
        
        }
    $ret .= '</select></div>';
	return $ret;
}

function pw_social_option($name, $text, $placeholder) {
	echo '<tr><th>'.$text.'</th><td><input type="text" placeholder="'.$placeholder.'" name="'.$name.'" value="'.pw_theme_option($name).'" /></td></tr>';
}

/**
 * Replacing the default search form with an HTML5 version
 *
 * @since PressWork 1.0
 */
function pw_html5_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="assistive-text" for="s">' . __('Search for:', "presswork") . '</label>
    <input type="search" placeholder="'.__("Search...", "presswork").'" value="' . get_search_query() . '" name="s" id="s" />
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'pw_html5_search_form' );

/**
 * Converts audio5 shortcode to HTML5 audio tag
 *
 * @since PressWork 1.0
 */
function pw_html5_audio($atts, $content = null) {
	extract(shortcode_atts(array(
		"src" => ''
	), $atts));
	return '<audio src="'.$src.'" controls autobuffer>';
}
add_shortcode('audio5', 'pw_html5_audio');

/**
 * Converts video5 shortcode to HTML5 video tag
 *
 * @since PressWork 1.0
 */
function pw_html5_video($atts, $content = null) {
	extract(shortcode_atts(array(
		"src" => '',
		"width" => '',
		"height" => ''
	), $atts));
	return '<video src="'.$src.'" width="'.$width.'" height="'.$height.'" controls autobuffer>';
}
add_shortcode('video5', 'pw_html5_video');


/**
 * Adds "odd" class to all odd posts.
 *
 * @since PressWork 1.0.1
 */
global $current_class;
$current_class = 'odd';

function pw_my_post_class ( $classes ) { 
   if(!is_singular()) {
	   global $current_class;
	   $classes[] = $current_class;
	
	   $current_class = ($current_class == 'odd') ? 'even' : 'odd';
	
   }
   return $classes;
}
add_filter ( 'post_class' , 'pw_my_post_class' );