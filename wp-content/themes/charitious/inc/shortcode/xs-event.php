<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Event_Widget extends Widget_Base {

    public $base;

    public function get_name() {
        return 'xs-event';
    }

    public function get_title() {
        return esc_html__( 'Charitious Events', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Event Post', 'charitious'),
            ]
        );
        $this->add_control(
            'style',
            [
                'label'     => esc_html__( 'Style', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 1,
                'options'   => [
                    '1'     => esc_html__( 'style 1', 'charitious' ),
                    '2'     => esc_html__( 'style 2', 'charitious' ),
                    '3'     => esc_html__( 'style 3', 'charitious' ),
                ],
            ] 
        ); 
        $this->add_control(
            'xs_event_cat',
            [
                'label'     => esc_html__( 'Category', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'all',
                'options'   => xs_category_list_slug(),
            ] 
        ); 
       
        $this->add_control(
            'post_count',
            [
                'label'         => esc_html__( 'Post count', 'charitious' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => esc_html__( '3', 'charitious' ),

            ]
        );
        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC'     => esc_html__( 'Descending', 'charitious' ),
                    'ASC'     => esc_html__( 'Ascending', 'charitious' ),
                ],
            ] 
        ); 
        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();
        $post_count = $settings['post_count'];
        $style = $settings['style'];
        $order = $settings['order'];
        $xs_event_cat = $settings['xs_event_cat'];
        $xs_event_cat = explode(', ', $xs_event_cat);


        if(empty($xs_event_cat) || $xs_event_cat[0] =='all'){
            $query = array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $post_count,
                'orderby'           => 'event_date',
                'order'           => $order,

            );
        }else{
            $query = array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $post_count,
                'orderby'           => 'event_date',
                'order'           => $order,
                'tax_query'     => array(
                    array(
                        'taxonomy'  => 'event_cat',
                        'field'     => 'name',
                        'terms'     => $xs_event_cat,
                    ),
                ),
            );
        }


        $xs_query = new \WP_Query( $query );
        if($xs_query->have_posts()):
            ?>
            <?php if($style == '1'){ ?><div class="row"><?php }else{ ?>
              <div class="row event-v2"><?php } ?>
                <?php
                while ($xs_query->have_posts()) :
                    $xs_query->the_post();
                    if(defined('FW')){
                        $event_date = fw_get_db_post_option( get_the_ID(), 'event_date' );
                        $open_hour = fw_get_db_post_option( get_the_ID(), 'open_hour' );
                        $event_map = fw_get_db_post_option( get_the_ID(), 'event_map' );
                    }


                    switch ( $style ) {
                        case '1':
                            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/event/style1.php';
                            
                            break;

                        case '2':
                            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/event/style2.php';
                            break;
                        case '3':
                            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/event/style3.php';
                            break;

                    }
                    ?>
                    
                    <?php endwhile;
                    ?>
                    </div>
                    <?php
                endif;
                    wp_reset_postdata();
                }
    protected function content_template() { }
}