<?php

if (!defined('ABSPATH'))
    die('Direct access forbidden.');
/**
 * Include static files: javascript and css for backend
 */
wp_enqueue_style('xs-admin', CHARITIOUS_CSS . '/xs_admin.css', null, CHARITIOUS_VERSION);
wp_enqueue_style( 'themify-icons', CHARITIOUS_CSS . '/iconfont.css', null, CHARITIOUS_VERSION );
