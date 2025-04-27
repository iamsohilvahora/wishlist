<?php
function get_meta_page_feild($feild){
  if($feild){
    return array(

        'navigation_style'    => array(
            'label'      => esc_html__( 'Menu Style', 'charitious' ),
            'type'       => 'image-picker',
            'value'      => '5',
            'desc'       => esc_html__( 'Select Menu style.', 'charitious' ),
            'choices'    => array(
                '5' => array(
                    'small'  => array(
                        'height' => 30,
                        'width' => 150,
                        'src'    =>  get_template_directory_uri() . '/assets/images/header/5.jpg',
                    ),
                ),
                '1' => array(
                    'small'  => array(
                        'height' => 30,
                        'width' => 150,
                        'src'    =>  get_template_directory_uri() . '/assets/images/header/header_1.png',
                    ),
                ),
                '2' => array(
                    'small'  => array(
                        'height' => 30,
                        'width' => 150,
                        'src'    =>  get_template_directory_uri() . '/assets/images/header/header_2.png',
                    ),
                ),
                '3' => array(
                    'small'  => array(
                        'height' => 30,
                        'width' => 150,
                        'src'    =>  get_template_directory_uri() . '/assets/images/header/header_3.png',
                    ),
                ),
                '4' => array(
                    'small'  => array(
                        'height' => 30,
                        'width' => 150,
                        'src'    =>  get_template_directory_uri() . '/assets/images/header/header_4.png',
                    ),
                ),
            ),
        ),

        'custom_logo'	 => array(
            'label'	 => esc_html__( ' Custom Logo', 'charitious' ),
            'desc'	 => esc_html__( 'Upload logo only for this page', 'charitious' ),
            'type'	 => 'upload'
        ),
      );
  }else{
      return array();
  }
}