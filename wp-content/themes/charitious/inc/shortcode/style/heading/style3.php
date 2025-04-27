<div class="xs-heading">
    <?php if(!empty($sub_title)): ?>
        <h2 class="xs-subtitle"><?php echo wp_kses( $sub_title, array('br' => array(),'span' => array()) ); ?></h2>
    <?php endif; ?>
    <?php if(!empty($title)): ?>
        <h3 class="xs-title" data-title="<?php echo esc_html( $water_title ); ?>"><?php echo wp_kses( $title, array('br' => array(),'span' => array()) ); ?></h3>
    <?php endif; ?>
    <?php if($show_separator): ?>
        <span class="xs-separetor bg-bondiBlue"></span>
    <?php endif; ?>

</div>