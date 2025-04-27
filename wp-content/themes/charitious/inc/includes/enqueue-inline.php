<?php

function charitious_action_xs_hook_css() {
    if ( defined( 'FW' ) ) {
        $main_color = fw_get_db_settings_option( 'main_color' );
        //custom css
        $custom_css	 = charitious_get_option( 'custom_css' );
        $output		 = $custom_css;
        if(!empty($output)){
            wp_add_inline_style( 'fundpress-style', $output );
        }
    }
}

add_action( 'wp_enqueue_scripts', 'charitious_action_xs_hook_css', 90 );


