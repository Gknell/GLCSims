<?php
/**
 * Custom Sims functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Custom_Sims
 */

if ( ! function_exists( 'customsims_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function customsims_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Custom Sims, use a find and replace
		 * to change 'customsims' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'customsims', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		

		/*
		 * Enable support for Post Thumbnails on posts and pages. This is the featured image support.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'customsims-full-bleed', 2000, 500, true);
		

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'customsims' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature. Works with customizer -- allows admin to add these
		add_theme_support( 'custom-background', apply_filters( 'customsims_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		
		// Add theme support for custom logo
		add_theme_support( 'custom-logo', array(
			'width' => 144,
			'height' => 144,
			'flex-width' => true,
		) );


		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'customsims_setup' );

/**
 * Register custom fonts.
 */
function customsims_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Cinzel and Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 * https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,400i,700
	 */
	$cinzel = _x( 'on', 'Cinzel font: on or off', 'customsims' );
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'customsims' );
	
	$font_families = array();
	
	if ( 'off' !== $cinzel) {
		$font_families[] = 'Cinzel:400,700';
	}

	if ( 'off' !== $open_sans) {
		$font_families[] = 'Open+Sans:400,400i,700';
	}
	
	if ( in_array ('on', array($cinzel, $open_sans) ) ) {
		
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function customsims_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'customsims-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'customsims_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function customsims_content_width() {
	// This variable is intended to be overruled from themes. Max width for things like YouTube videos.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'customsims_content_width', 640 );
}
add_action( 'after_setup_theme', 'customsims_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function customsims_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'customsims' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'customsims' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'customsims_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function customsims_scripts() {
	
	//Enqueue Google Fonts Cinzel + Open Sans https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,400i,700'
	wp_enqueue_style( 'customsims-fonts', customsims_fonts_url() );
	
	wp_enqueue_style( 'customsims-style', get_stylesheet_uri() );

	wp_enqueue_script( 'customsims-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'customsims-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'customsims_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

