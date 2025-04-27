<div class="xs-single-funFact funFact-v2">

    <?php if($use == 'image'): ?>
        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
    <?php else: ?>
        <i class="funfact-icon <?php echo esc_attr($settings['icon']); ?>"></i>
    <?php endif; ?>
    <span class="number-percentage-count number-percentage" data-value="<?php echo esc_html($number_count);?>" data-animation-duration="3500">0</span><?php if(!empty($scale)): ?><span class="unit"><?php echo esc_html($scale) ?></span><?php endif; ?>
    <?php if(!empty($title)): ?>
        <small><?php echo esc_html($title) ?></small>
    <?php endif; ?>
</div>