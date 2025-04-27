<?php

/* ---------------------------------------------------
* Theme: Charitious - WordPress Theme
* Author: XpeedStudio
* Author URI: http://www.xpeedstudio.com
  -------------------------------------------------- */

function charitious_theme_enqueue_styles()
{

	$parent_style = 'parent-style';

	// Generate a unique version string using the current timestamp
	$version = time();

	if(!wp_style_is( $parent_style, $list = 'enqueued' )){
		wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', array());
	}
	wp_enqueue_style('child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array($parent_style),
		$version
	);

	wp_enqueue_style('font-awesome-latest-style',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
		array(),
		$version
	);
	
	wp_enqueue_script('child-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), $version, true);

	wp_localize_script(
		'child-custom-script',
		'gift_object',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'site_url' => get_site_url(),
		)
	);

}

add_action('wp_enqueue_scripts', 'charitious_theme_enqueue_styles', 99);

function charitious_theme_enqueue_user_edit_script($hook_suffix) {
    global $pagenow;

    // Check if we're on the user edit page
    if (in_array($pagenow, array('user-edit.php', 'profile.php'))) {
        // Get the user ID being edited
        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

        // Get the user object based on the user ID
        $user = get_user_by('id', $user_id);

        // Check if the user exists and has the 'creator' role
        if ($user && in_array('creator', (array) $user->roles)) {
            // Enqueue script only for users with 'creator' role being edited
            wp_enqueue_script('user-edit-script', get_stylesheet_directory_uri() . '/assets/js/user-edit.js', array('jquery'), '', true);
        }
    }
}
add_action('admin_enqueue_scripts', 'charitious_theme_enqueue_user_edit_script');

/**
 *  Load woocommerce hooks
 */
require get_stylesheet_directory() . '/inc/woo-functions.php';

/**
 *  Elementor custom widget for FAQ post type
 */
function charitious_theme_register_xs_faqs_widget_child() {
    if (class_exists('Elementor\Widget_Base')) {
        require_once get_stylesheet_directory() . '/widgets/xs-faqs-widget.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CharitiousChild\Xs_FAQs_Widget());
    }
}
add_action('init', 'charitious_theme_register_xs_faqs_widget_child', 999);
