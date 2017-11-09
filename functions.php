<?php
/**
 * Savant Video functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Savant_Video
 */

if ( ! function_exists( 'savant_video_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function savant_video_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Savant Video, use a find and replace
		 * to change 'savant-video' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'savant-video', get_template_directory() . '/languages' );

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
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'savant-video' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'savant_video_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

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
add_action( 'after_setup_theme', 'savant_video_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function savant_video_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'savant_video_content_width', 640 );
}
add_action( 'after_setup_theme', 'savant_video_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function savant_video_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page', 'savant-video' ),
		'id'            => 'front-page-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'savant-video' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'savant_video_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function savant_video_scripts() {
	wp_enqueue_style( 'savant-video-style', get_stylesheet_uri(), '', '1.0.7' );

	wp_enqueue_script( 'savant-video-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'buffalo-covenant-theme-base', get_template_directory_uri() . '/js/savant.js', array( 'jquery' ), '107', true);

	wp_enqueue_script( 'savant-video-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'savant_video_scripts' );

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

function savant_customize_register( $wp_customize ) {
   $wp_customize->add_section( 'header_video_section_name' , array(
        'title'    => __( 'Header Video', 'savant-video-theme' ),
        'priority' => 50
    ) );

    $wp_customize->add_setting( 'header_video_mp4');
    $wp_customize->add_setting( 'header_video_webm');
    $wp_customize->add_setting( 'header_video_ogv');
    $wp_customize->add_setting( 'header_video_poster');
    $wp_customize->add_setting( 'header_mobile_poster');

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_video_mp4', array(
        'label'    => __( 'Header Video MP4', 'savant-video-theme' ),
        'section'  => 'header_video_section_name',
        'settings' => 'header_video_mp4',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_video_webm', array(
        'label'    => __( 'Header Video WEBM', 'savant-video-theme' ),
        'section'  => 'header_video_section_name',
        'settings' => 'header_video_webm',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_video_ogv', array(
        'label'    => __( 'Header Video OGV', 'savant-video-theme' ),
        'section'  => 'header_video_section_name',
        'settings' => 'header_video_ogv',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_video_poster', array(
        'label'    => __( 'Header Video Poster', 'savant-video-theme' ),
        'section'  => 'header_video_section_name',
        'settings' => 'header_video_poster',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_mobile_poster', array(
        'label'    => __( 'Header Mobile Poster', 'savant-video-theme' ),
        'section'  => 'header_video_section_name',
        'settings' => 'header_mobile_poster',
    ) ) );
}
add_action( 'customize_register', 'savant_customize_register' );

function addUploadMimes($mimes) {
    $mimes['webm'] = 'video/webm';
	$mimes['ogv'] = 'video/ogv';    
    return $mimes;
}
add_filter('mime_types', 'addUploadMimes');
?>