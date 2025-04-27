<div class="col-lg-6 row xs-single-event">
    <div class="col-md-5">
        <?php if(has_post_thumbnail()): ?>
            <?php
            $months      = array(
                'Jan'   => esc_html__( 'Jan', 'charitious' ),
                'Feb'   => esc_html__( 'Feb', 'charitious' ),
                'Mar'   => esc_html__( 'Mar', 'charitious' ),
                'Apr'   => esc_html__( 'Apr', 'charitious' ),
                'May'   => esc_html__( 'May', 'charitious' ),
                'Jun'   => esc_html__( 'Jun', 'charitious' ),
                'Jul'   => esc_html__( 'Jul', 'charitious' ),
                'Sept'  => esc_html__( 'Sept', 'charitious' ),
                'Oct'   => esc_html__( 'Oct', 'charitious' ),
                'Nov'   => esc_html__( 'Nov', 'charitious' ),
                'Dec'   => esc_html__( 'Dec', 'charitious' ),
            );
            ?>
            <div class="xs-event-image">
                <?php echo wp_get_attachment_image(get_post_thumbnail_id( get_the_ID() ), 'full', false, array(
                    'class' => 'xs-ch__image',
                    'alt'  => get_the_title()
                )); ?>
                <div class="xs-entry-date">
                    <span class="entry-date-day"><?php echo date_format(date_create($event_date),"d"); ?></span>
                    <span class="entry-date-month"><?php echo date('M', strtotime($event_date)); ?></span>
                </div>
                <div class="xs-black-overlay"></div>
            </div>
        <?php endif; ?>
    </div> 
    <div class="col-md-7">
        <div class="xs-event-content">
            <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_title(); ?></a>
            <p><?php echo wp_kses_post(wp_trim_words(get_the_content(),10,'')) ?></p>
            <?php if(!empty($event_date)): ?>
                <div class="xs-countdown-timer"
                data-date-day="<?php esc_html_e('DAY','charitious');?>" 
                data-date-hour="<?php esc_html_e('HOUR','charitious');?>" 
                data-date-minute="<?php esc_html_e('MINUTE','charitious');?>" 
                data-date-second="<?php esc_html_e('SECOND','charitious');?>" 
                data-countdown="<?php echo esc_attr($event_date); ?>"></div>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-primary">
                <?php esc_html_e('Learn More','charitious');?>
            </a>
        </div>
    </div>
</div>
