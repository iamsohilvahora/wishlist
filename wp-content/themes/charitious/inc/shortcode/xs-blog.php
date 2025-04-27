<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Post_Widget extends Widget_Base {

  public $base;

    public function get_name() {
        return 'xs-blog';
    }

    public function get_title() {
        return esc_html__( 'Charitious Post', 'charitious' );
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
                'label' => esc_html__('Post', 'charitious'),
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
                      '6'     => esc_html__( '2 Column', 'charitious' ),
                      '4'     => esc_html__( '3 Column', 'charitious' ),
                ],
            ]
        );

        $this->add_control(
          'xs_post_cat',
          [
             'label'    =>esc_html__( 'Select category', 'charitious' ),
             'type'     => Controls_Manager::SELECT,
             'options'  => xs_category_list( 'category' ),
             'default'  => '0'
          ]
        );

        $this->add_control(
          'show_pagination',
          [
            'label' =>esc_html__( 'Pagination', 'charitious' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' =>esc_html__( 'Show', 'charitious' ),
            'label_off' =>esc_html__( 'Hide', 'charitious' ),
          ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {
          $settings = $this->get_settings();
          $xs_post_cat = $settings['xs_post_cat'];
          $count_col = $settings['count_col'];
          $post_count = $settings['post_count'];
          $show_pagination = $settings['show_pagination'];
          $style = $settings['style'];
          $paged = get_query_var('page') ? get_query_var('page') : 1;

        $query = array(
              'post_type'      => 'post',
              'post_status'    => 'publish',
              'posts_per_page' => $post_count,
              'cat' => $xs_post_cat,
              'paged' => $paged,
          );
          
          $wp_query = new \WP_Query( $query );
          if($wp_query->have_posts()):
          ?>
              <?php if($style == '1'){ ?><div class="row xs-blog-grid"><?php }else{ ?>
              <div class="row journal-v2"><?php } ?>
                <?php
                while ($wp_query->have_posts()) :
                    $wp_query->the_post();
                    $terms  = get_the_terms( get_the_ID(), 'category' );
                    if ( $terms && ! is_wp_error( $terms ) ) :
                      $cat_temp = '';
                      foreach ( $terms as $term ) {
                          $cat_temp .= '<a href="'.get_category_link($term->term_id).'" class="xs-blog-meta-tag green-bg bold color-white xs-border-radius" rel="category tag">'.$term->name.'</a>';
                      }
                    endif;

                    $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

                        if ( $num_comments == 0 ) {
                            $comments = esc_html__('No Comments','charitious');
                        } elseif ( $num_comments > 1 ) {
                            $comments = $num_comments . esc_html__(' Comments','charitious');
                        } else {
                            $comments = esc_html__('1 Comment','charitious');
                        }

                    switch ( $style ) {
                        case '1':
                            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/blog/style1.php';
                            break;

                        case '2':
                            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/blog/style2.php';
                            break;

                    }
              
                endwhile;
                ?>
              </div>
            <?php
            if($show_pagination == 'yes'){
                ?>
                <div class="pagination justify-content-center xs-pagination xs-pagination-shortcode">
             <?php
                $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('page') ),
                    'total' => $wp_query->max_num_pages,
                    'next_text' => '<i class="fa fa-angle-right"></i>',
                    'prev_text' => '<i class="fa fa-angle-left"></i>',
                ) );
                
            }
            ?>
              </div>
            <?php
          endif;
          wp_reset_postdata();
    }
    protected function content_template() { }
}