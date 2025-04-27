<div class="col-lg-6">
    <div class="event-box">
        <?php the_title('<a href="'.esc_url(get_the_permalink()).'" class="event-title">', '</a>');  
        
        if(!empty($open_hour)): 
        ?>
        <p class="event-time"><strong><?php _e('Date :', 'charitious'); ?></strong>   <?php echo esc_attr($open_hour); ?></p>
        <?php endif; 
        
         if(!empty($event_map)):
        ?>
        <p class="event-location"><strong><?php _e('Location :', 'charitious'); ?></strong> <span><?php echo esc_attr($event_map); ?></span></p>
        <?php endif; ?>
    </div><!-- ..event-box END -->
</div>
