<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_FAQs_Widget extends Widget_Base {

    public $base;

    public function get_name() {
        return 'xs-faqs';
    }

    public function get_title() {
        return esc_html__( 'Charitious FAQs', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-text-field';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('FAQs Post', 'charitious'),
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

        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();
        $post_count = $settings['post_count'];
        $query = array(
            'post_type'      => 'faq',
            'post_status'    => 'publish',
            'posts_per_page' => $post_count,
        );
        $faq_cat_args = array(
            'taxonomy' => 'faq_cat',
        );

        $categories = get_terms( $faq_cat_args );
        $xs_query = new \WP_Query( $query );
        if($xs_query->have_posts()):
            ?>


            <section class="xs-content-section-padding">
                <div class="container">
                    <div class="row col-md-11 mx-auto">
                        <div class="col-lg-3">
                            <ul class="nav flex-column xs-nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php
                                $i = 1;
                                foreach($categories as $category) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($i==1) echo 'active';?>" href="#<?php echo esc_attr($category->slug); ?>" role="tab" data-toggle="pill"><?php echo esc_html($category->name); ?></a>
                                    </li>
                                <?php $i++; } ?>
                            </ul>
                        </div>
                        <div class="col-lg-9">
                            <?php

                            $i = 1;
                            ?><div class="tab-content" id="v-pills-tabContent"><?php
                                foreach($categories as $category) { ?>
                                <div class="tab-pane slideUp <?php if($i==1) echo ' active show';?>" id="<?php echo esc_attr($category->slug); ?>" role="tabpanel">

                                        <?php

                                        $query_args = array(
                                            'post_type'     => 'faq',
                                            'tax_query'     => array(
                                                array(
                                                    'taxonomy'  => 'faq_cat',
                                                    'field'     => 'slug',
                                                    'terms'     => $category->slug,
                                                ),
                                            ),
                                            'posts_per_page' => $post_count,
                                        );

                                        $xs_post = new \WP_Query($query_args);
                                        if ($xs_post->have_posts()): ?>
                                            <div class="row">
                                                <?php while ($xs_post->have_posts()) : $xs_post->the_post(); ?>
                                                    <div class="col-md-6">
                                                        <div class="xs-tab-content">
                                                            <h5><?php the_title();?></h5>
                                                            <p><?php the_excerpt();?></p>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            </div>
                                            <?php
                                            wp_reset_postdata();
                                        endif;
                                        ?> </div>
                                    <?php $i++; } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <?php endif;
                }
    protected function content_template() { }
}