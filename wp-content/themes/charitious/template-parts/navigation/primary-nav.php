<?php

if ( has_nav_menu( 'primary' ) ) {

    $defaults = array(
        'theme_location'  => 'primary',
        'container'       => 'ul',
        'depth'           => 3,
        'menu_class'      => 'nav-menu',
        'menu_id'         => 'main-menu',
        'walker'          =>  '',
		'fallback_cb'		 => false
    );

    wp_nav_menu( $defaults );

}