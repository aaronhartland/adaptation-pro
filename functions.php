<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Adaptation Theme', 'adaptation' ) );
define( 'CHILD_THEME_URL', 'http://www.aaronhartland.com/themes/adaptation' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'adaptation_enqueue_scripts' );
function adaptation_enqueue_scripts() {
	wp_enqueue_script( 'adaptation-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}

//* Add new featured image size
add_image_size( 'grid-featured', 415, 175, TRUE );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'				=> 320,
	'height'			=> 84,
	'header-selector'	=> '.site-title a',
	'header-text'		=> false
) );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/** Filter the footer creds text */
add_filter('genesis_footer_creds_text', 'ah_custom_footer_creds_text');
function ah_custom_footer_creds_text($creds) {

	$creds = 'Copyright &copy; &nbsp;' . date('Y') . '&nbsp;' . get_bloginfo('name') . ' &middot; All Rights Reserved &middot; [footer_loginout]
		<div class="powered-by"><p>Powered by <a href="http://www.studiopress.com/" target="_blank" title="Genesis Framework" rel="nofollow">Genesis </a>and the <a href="'. esc_url( CHILD_THEME_URL ) .'" title="'. esc_attr( CHILD_THEME_NAME ) .' - Free Genesis Child Theme" target="_blank">'.esc_attr( CHILD_THEME_NAME ).'</a></p></div> ';
	return  $creds;
	
}

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar 
unregister_sidebar( 'sidebar-alt' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'adaptation_secondary_menu_args' );
function adaptation_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Hook after entry widget after the entry content
add_action( 'genesis_after_entry', 'adaptation_after_entry', 5 );
function adaptation_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry" class="widget-area">',
			'after'  => '</div>',
		) );

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'adaptation' ),
	'description' => __( 'This is the widget that appears after the entry on single posts.', 'adaptation' ),
) );



