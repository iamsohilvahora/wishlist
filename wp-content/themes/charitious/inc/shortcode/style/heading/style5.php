<div class="xs-heading heading-v2 v4">
    <?php if(!empty($title)): ?>
        <h2 class="xs-title" data-title="<?php echo esc_html( $water_title ); ?>"><?php echo wp_kses( $title, array('br' => array(),'span' => array()) ); ?></h2>
    <?php endif; ?>
    <?php if($show_separator): ?>
        <span class="xs-separetor"></span>
    <?php endif; ?>
    <?php if(!empty($sub_title)): ?>
        <p><?php echo wp_kses( $sub_title, array('br' => array(),'span' => array()) ); ?></p>
    <?php endif; ?>
</div>