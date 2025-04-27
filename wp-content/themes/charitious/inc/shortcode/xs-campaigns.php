<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Campaigns_Widget extends Widget_Base {

  public $base;

    public function get_name() {
        return 'xs-campaigns-grid';
    }

    public function get_title() {
        return esc_html__( 'Charitious Campaigns Grid', 'charitious' );
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
                'label' => esc_html__('Product element', 'charitious'),
            ]
        );

        $this->add_control(
            'donation',
            [
                'label' =>esc_html__( 'Show Only Charitable Campaigns', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' =>esc_html__( 'Show', 'charitious' ),
                'label_off' =>esc_html__( 'Hide', 'charitious' ),
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
                    '4'     => esc_html__( 'style 4', 'charitious' ),
                ],
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
            'count_col',
            [
                'label'     => esc_html__( 'Select Column', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 4,
                'options'   => [
                        '2'     => esc_html__( '2 Column', 'charitious' ),
                        '3'     => esc_html__( '3 Column', 'charitious' ),
                        '4'     => esc_html__( '4 Column', 'charitious' ),
                    ],
            ]
        );

        $this->add_control(
            'xs_post_cat', [
                'label'			 =>esc_html__( 'Category', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'label_block'	 => true,
                'placeholder'	 =>esc_html__('design,fashion', 'charitious' ),
                'desc'          => esc_html__('add you multiple category use comma separator', 'charitious')
            ]
        );
        $this->add_control(
            'show_author',
            [
                'label' =>esc_html__( 'Show Author', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' =>esc_html__( 'Show', 'charitious' ),
                'label_off' =>esc_html__( 'Hide', 'charitious' ),
            ]
        );
        $this->add_control(
            'show_filter',
            [
                'label' =>esc_html__( 'Show Filter', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' =>esc_html__( 'Show', 'charitious' ),
                'label_off' =>esc_html__( 'Hide', 'charitious' ),
            ]
        );

        $this->add_control(
            'status',
            [
                'label'     => esc_html__( 'Status', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 4,
                'options'   => [
                    'Success'     => esc_html__( 'successful', 'charitious' ),
                    'expired'     => esc_html__( 'expired', 'charitious' ),
                    'valid'     => esc_html__( 'valid', 'charitious' ),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();

        $xs_post_cat = $settings['xs_post_cat'];
        $count_col = $settings['count_col'];
        $post_count = $settings['post_count'];
        $style = $settings['style'];
        $show_filter = $settings['show_filter'];
        $author = $settings['show_author'];
        $status = $settings['status'];
        $donation = $settings['donation'];

        ?>
        <div class="xs-wp-fundraising-listing-style-<?php echo esc_attr($style);?>">
            <?php
                echo do_shortcode('[wfp-campaign cat="'.$xs_post_cat.'" number="' . $post_count . '" col="'.$count_col.'" style="'.$style.'" filter="'.$show_filter.'" author="'.$author.'" donation="'.$donation.'" status="'.$status.'"]');
            ?>
        </div>
    <?php
    }

    protected function content_template() { }
}