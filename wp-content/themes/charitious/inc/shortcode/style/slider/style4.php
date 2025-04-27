<?php if(is_array($sliders) && !empty($sliders)): ?>
    <section class="xs-welcome-slider">
        <div class="xs-banner-slider owl-carousel">
        <?php foreach($sliders as $slider): ?>
            <?php
            $btn_link_one = (! empty( $slider['btn_link_one']['url'])) ? $slider['btn_link_one']['url'] : '';

            $btn_target_one = ( $slider['btn_link_one']['is_external']) ? '_blank' : '_self';

            $btn_link_two = (! empty( $slider['btn_link_two']['url'])) ? $slider['btn_link_two']['url'] : '';

            $btn_target_two = ( $slider['btn_link_two']['is_external']) ? '_blank' : '_self';

            $text_align = ( $slider['text_align']) ? 'mx-auto' : '';

            $image = \xs_resize($slider['image']['url']);
            ?>


            <div class="xs-welcome-content banner-verion-3" style="background-image: url(<?php echo esc_url($image);?>);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 <?php echo esc_attr($text_align);?>">
                            <div class="xs-welcome-wraper">
                                <?php if(!empty($slider['sub_title'])): ?>
                                    <p class="xs-slider-subtitle"><?php echo wp_kses( $slider['sub_title'], array('br' => array()) ); ?></p>
                                <?php endif;?>
                                <?php if(!empty($slider['title'])): ?>
                                    <h2><?php echo wp_kses( $slider['title'], array('br' => array()) ); ?></h2>
                                <?php endif;?>
                                <div class="xs-btn-wraper">
                                    <?php if(!empty($slider['btn_label_one'])): ?>
                                        <a href="<?php echo esc_url( $btn_link_one ); ?>" target="<?php echo esc_html( $btn_target_one ); ?>" class="btn btn-danger"><?php echo esc_html( $slider['btn_label_one'] ); ?><span></span></a>
                                    <?php endif;?>
                                    <?php if(!empty($slider['btn_label_two'])): ?>
                                        <a href="<?php echo esc_url( $btn_link_two ); ?>" target="<?php echo esc_html( $btn_target_two ); ?>" class="btn btn-outline-danger"><?php echo esc_html( $slider['btn_label_two'] ); ?> <span></span></a>
                                    <?php endif;?>
                                </div><!-- .xs-btn-wraper END -->
                            </div><!-- .xs-welcome-wraper END -->
                        </div>
                    </div><!-- .row end -->
                </div>
                <div class="xs-black-overlay"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>