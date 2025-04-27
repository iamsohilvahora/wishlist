<?php
$fields[] = array(
    'type'        => 'select',
    'settings'    => 'blog_sidebar',
    'label'       => esc_html__( 'Blog Sidebar Position', 'charitious' ),
    'section'     => 'blog_section',
    'default'     => 3,
    'choices'     => array(
        '1'      => esc_html__('Full Width','charitious'),
        '2'      => esc_html__('Left Sidebar','charitious'),
        '3'      => esc_html__('Right Sidebar','charitious'),
    ),
);
