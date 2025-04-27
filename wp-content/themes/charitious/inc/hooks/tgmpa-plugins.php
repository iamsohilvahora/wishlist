<?php

/*
 * TGM REQUIRE PLUGIN
 * require or recommend plugins for your WordPress themes
 */

/** @internal */
function _action_charitious_register_required_plugins() {
	$plugins	 = array(
		array(
			'name'		 => esc_html__( 'Unyson Custom', 'charitious' ),
			'slug'		 => 'unyson',
			'required'	 => true,
			'version'    => '2.8.0',
			'source'     => CHARITIOUS_UNYSON_URL . '/unyson.zip'
		),
		array(
			'name'		 => esc_html__( 'Elementor', 'charitious' ),
			'slug'		 => 'elementor',
			'required'	 => true,
		),
		array(
			'name'		 => esc_html__( 'Kirki', 'charitious' ),
			'slug'		 => 'kirki',
			'required'	 => true,
		),
		array(
			'name'		 => esc_html__( 'Contact Form 7', 'charitious' ),
			'slug'		 => 'contact-form-7',
			'required'	 => true,
		),
        array(
            'name'		 => esc_html__( 'WooCommerce', 'charitious' ),
            'slug'		 => 'woocommerce',
            'required'	 => true,
        ),
		array(
			'name'		 => esc_html__( 'Charitious Assistance', 'charitious' ),
			'slug'		 => 'charitious-assistance',
			'required'	 => true,
            'version'	 => '1.2',
			'source'	 =>  CHARITIOUS_REMOTE_URL . '/charitious-assistance.zip' ,
		), 
		array(
			'name'		 => esc_html__( 'WP MailChimp', 'charitious' ),
			'slug'		 => 'wp-mailchimp',
			'required'	 => true,
			'source'	 =>  CHARITIOUS_REMOTE_URL . '/wp-mailchimp.zip' ,
		),
		array(
			'name'		 => esc_html__( 'WP Fundraising Donation', 'charitious' ),
			'slug'		 => 'wp-fundraising-donation',
			'required'	 => true,
		),
        array(
            'name'		 => esc_html__( 'Metform Elementor Addon', 'charitious' ),
            'slug'		 => 'metform',
            'required'	 => true,
        ),
        array(
            'name'		 => esc_html__( 'Elements Kit', 'charitious' ),
            'slug'		 => 'elementskit-lite',
        ),
		
	);

	$config = array(
		'id'			 => 'charitious', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path'	 => '', // Default absolute path to bundled plugins.
		'menu'			 => 'charitious-install-plugins', // Menu slug.
		'parent_slug'	 => 'themes.php', // Parent menu slug.
		'capability'	 => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'	 => true, // Show admin notices or not.
		'dismissable'	 => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'	 => '', // If 'dismissable' is false, this message will be output at top of nag.
		'message'		 => '', // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', '_action_charitious_register_required_plugins' );