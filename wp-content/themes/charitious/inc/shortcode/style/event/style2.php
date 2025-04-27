<div class="col-lg-4 col-md-6">
    <div class="xs-single-event">
        <?php if(has_post_thumbnail()): ?>
            <div class="xs-event-image">
                <?php echo wp_get_attachment_image(get_post_thumbnail_id( get_the_ID() ), 'full', false, array(
                    'class' => 'xs-ch__image',
                    'alt'  => get_the_title()
                )); ?>
                <div class="event-date-wraper">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 112 112" preserveAspectRatio="none" width="112" height="112">
                        <path fill-rule="evenodd" d="M0.000,112.000 L112.000,0.000 L0.000,0.000 L0.000,112.000 Z"/>
                    </svg>
                    <div class="event-date">
                        <strong><?php echo date_format(date_create($event_date),"d"); ?></strong> <?php echo date_format(date_create($event_date),"M"); ?>
                    </div>
                </div>
                <?php if(!empty($event_date)): ?>
                    <div class="xs-countdown-timer" 
                    data-date-day="<?php esc_html_e('DAY','charitious');?>" 
                    data-date-hour="<?php esc_html_e('HOUR','charitious');?>" 
                    data-date-minute="<?php esc_html_e('MINUTE','charitious');?>" 
                    data-date-second="<?php esc_html_e('SECOND','charitious');?>" 
                    data-countdown="<?php echo esc_attr($event_date); ?>"></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="xs-event-content">
            <h5 class="xs-title">
                <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_title(); ?></a>
            </h5>
            <ul class="xs-event-list">
                <?php if(!empty($open_hour)): ?>
                    <li>
                        <div class="media">
                            <i class="icon-clock2"></i> <?php echo esc_attr($open_hour); ?>
                        </div>
                    </li>
                <?php endif; ?>
                
                <?php if(!empty($event_map)): ?>
                <li>
                    <div class="media">
                        <i class="icon-map-marker2"></i><?php echo esc_attr($event_map); ?>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>