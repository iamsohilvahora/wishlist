<?php
$fields[] = array(
    'type'        => 'select',
    'settings'    => 'page_sidebar',
    'label'       => esc_html__( 'Page Sidebar Position', 'charitious' ),
    'section'     => 'page_section',
    'default'     => '1',
    'choices'     => array(
      '1'      => esc_html__('Full Width','charitious'),
      '2'      => esc_html__('Left Sidebar','charitious'),
      '3'      => esc_html__('Right Sidebar','charitious'),
    ),
);
