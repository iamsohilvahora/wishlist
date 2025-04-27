<?php

if ( has_nav_menu( 'footer_menu' ) ) {

    $defaults = array(
        'theme_location'  => 'footer_menu',
        'container'       => 'ul',
    );

    wp_nav_menu( $defaults );

}