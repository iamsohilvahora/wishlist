<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( !function_exists( 'charitious_widget_init' ) ) {

	function charitious_widget_init() {
		if ( function_exists( 'register_sidebar' ) ) {
			register_sidebar(
				array(
					'name'			 => esc_html__( 'Blog Widget Area', 'charitious' ),
					'id'			 => 'sidebar-1',
					'description'	 => esc_html__( 'Appears on posts.', 'charitious' ),
					'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
					'after_widget'	 => '</div><!-- end widget -->',
					'before_title'	 => '<h3 class="widget-title xs-widget-title">',
					'after_title'	 => '</h3>',
				)
			);
            register_sidebar(
                array(
                    'name'			 => esc_html__( 'Page Widget Area', 'charitious' ),
                    'id'			 => 'sidebar-2',
                    'description'	 => esc_html__( 'Appears on Pages.', 'charitious' ),
                    'before_widget'	 => '<div id="%1$s" class="sidebar xs-single-sidebar border xs-content-padding %2$s">',
                    'after_widget'	 => '</div><!-- end widget -->',
                    'before_title'	 => '<h3 class="widget-title xs-widget-title">',
                    'after_title'	 => '</h3>',
                )
            );
            register_sidebar(
                array(
                    'name'			 => esc_html__( 'Shop Widget Area', 'charitious' ),
                    'id'			 => 'sidebar-3',
                    'description'	 => esc_html__( 'Appears on Shop.', 'charitious' ),
                    'before_widget'	 => '<div id="%1$s" class="sidebar xs-single-sidebar border xs-content-padding %2$s">',
                    'after_widget'	 => '</div><!-- end widget -->',
                    'before_title'	 => '<h3 class="widget-title xs-widget-title">',
                    'after_title'	 => '</h3>',
                )
            );

            $show_footer_widget = charitious_option( 'show_footer_widget',charitious_defaults('show_footer_widget') );

            $footer_columns = charitious_option( 'footer_widget_layout',charitious_defaults('footer_widget_layout') );

            if($show_footer_widget){
                for ( $i = 1; $i <= $footer_columns; $i++ ) {
                    $args_sidebar = array(
                        'name'           => esc_html__( 'Footer Widget ', 'charitious' ).$i,
                        'id'             => 'footer-widget-'.$i,
                        'description'    => esc_html__( 'Appears on posts and pages.', 'charitious' ),
                        'before_widget'  => '<div class="footer-widget">',
                        'after_widget'   => '</div>',
                        'before_title'   => '<h3 class="widget-title">',
                        'after_title'    => '</h3>',
                    );

                    register_sidebar( $args_sidebar );
                }
            }



		}
	}

	add_action( 'widgets_init', 'charitious_widget_init' );
}


