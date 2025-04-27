<div class="xs-heading">
    <?php if(!empty($sub_title)): ?>
        <h2 class="xs-line-title"><?php echo wp_kses( $sub_title, array('br' => array(),'span' => array()) ); ?></h2>
    <?php endif; ?>
    <?php if(!empty($title)): ?>
    <h3 class="xs-title big" data-title="<?php echo esc_html( $water_title ); ?>"><?php echo wp_kses( $title, array('br' => array(),'span' => array()) ); ?></h3>
    <?php endif; ?>
</div>