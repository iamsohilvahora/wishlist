<div class="media xs-single-funFact-v3">
    <?php if($use == 'image'): ?>
        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
    <?php else: ?>
        <span class="funfact-icon <?php echo esc_attr($settings['icon']); ?>"></span>
    <?php endif; ?>
    <div class="media-body">
        <span class="number-percentage-count number-percentage" data-value="<?php echo esc_html($number_count);?>" data-animation-duration="3500">0</span><?php if(!empty($scale)): ?><small><?php echo esc_html($scale) ?></small><?php endif; ?>
        <?php if(!empty($title)): ?>
            <small><?php echo esc_html($title) ?></small>
        <?php endif; ?>
    </div>
</div>