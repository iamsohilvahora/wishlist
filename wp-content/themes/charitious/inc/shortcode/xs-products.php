<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Products_Widget extends Widget_Base {

    public $base;

    public function get_name() {
        return 'xs-products';
    }

    public function get_title() {
        return esc_html__( 'Charitious Products', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Products element', 'charitious'),
            ]
        );


        $this->add_control(
            'product_ids',
            [
                'label' => __( 'Select Product', 'charitious' ),
                'type' => Controls_Manager::SELECT2,
                'options' => charitious_wc_get_product_list(),
                'multiple' => true,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'extra_link',
            [
                'label'         => __( 'Active Extra Link', 'charitious' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'charitious' ),
                'label_off'     => __( 'No', 'charitious' ),
            ]
        );
        $this->add_control(
            'image',
            [
                'label' =>esc_html__( 'Extra Image', 'charitious' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                       'extra_link' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' =>esc_html__( 'Image Size', 'charitious' ),
                'default' => 'full',
                'condition' => [
                    'extra_link' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'link_label',
            [

                'label' =>esc_html__('Extra link label', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   =>esc_html__('All Product', 'charitious'),
                'condition' => [
                    'extra_link' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => __( 'Extra Link', 'charitious' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __('http://your-link.com','charitious' ),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'extra_link' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();
        $link_label = $settings['link_label'];
        $btn_link = (! empty( $settings['btn_link']['url'])) ? $settings['btn_link']['url'] : '';
        $btn_target = ( $settings['btn_link']['is_external']) ? '_blank' : '_self';
        $product_ids = implode(',' ,$settings['product_ids']);
       
        
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => 5,
            'post__in'    => $product_ids,
        );


        $xs_query = new \WP_Query( $args );
        $post_count = $xs_query->post_count;
        ?>
            <?php
            $xs_count = 1;
            if($xs_query->have_posts()):
                ?>
                <div class="row">
                <?php
                    while ($xs_query->have_posts()) :
                        $xs_query->the_post();
                        $xs_product = wc_get_product(get_the_id());
                        $img_link = xs_resize( get_post_thumbnail_id(), 255, 260,true );
                        $img_featured = xs_resize( get_post_thumbnail_id(), 540, 550,true );
                        $terms = get_the_terms(get_the_ID(), 'product_cat');
                        $cat = '';
                        if ( $terms && ! is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $cat .= "<a href = '" . get_category_link($term->term_id) . "'>" . $term->name . "</a>  ";
                            }
                        }
                        ?>

                        <div class="col-md-6">
                            <?php if($settings['extra_link']): ?>
                                <?php if( $xs_count != $post_count ): ?>
                                    <div class="xs-feature-product">
                                        <?php
                                             echo wp_get_attachment_image(get_post_thumbnail_id($xs_query->ID), array(255, 260), false, array(
                                                 'class' =>'xs_image_load',
                                                 'alt'   => get_the_title(),
                                                 'data-echo'   => get_the_post_thumbnail_url($xs_query->ID)
                                             ));
                                        ?>
                                        <div class="xs-feature-product-info">
                                            <h4 class="product-title-v2 xs-cat"><?php echo charitious_return($cat); ?></h4>
                                            <h4 class="product-title-v2"><strong><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title(); ?></a></strong></h4>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="xs-feature-product">
                                      <?php 
                                      
                                             echo wp_get_attachment_image(get_post_thumbnail_id($xs_query->ID), array(255, 260), false, array(
                                                'class' =>'xs_image_load',
                                                'alt'   => get_the_title(),
                                                'data-echo'   => get_the_post_thumbnail_url($xs_query->ID)
                                            ));
                                        ?>
                                        
                                    <div class="xs-feature-product-info">
                                        <h4 class="product-title-v2 xs-cat"><?php echo charitious_return($cat); ?></h4>
                                        <h4 class="product-title-v2"><strong><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title(); ?></a></strong></h4>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php
                        $xs_count++;
                    endwhile;
                endif;
                wp_reset_postdata();
            ?>
                </div>
<?php
    }

    protected function content_template() { }
}