<div class="xs-heading">
    <div class=" mx-auto text-center">
        <?php if(!empty($title)): ?>
            <h2 class="xs-title" data-title="<?php echo esc_html( $water_title ); ?>"><?php echo wp_kses( $title, array('br' => array(),'span' => array()) ); ?></h2>
        <?php endif; ?>
        <?php if(!empty($sub_title)): ?>
            <p><?php echo wp_kses( $sub_title, array('br' => array(),'span' => array()) ); ?></p>
        <?php endif; ?>
        <?php if($show_separator): ?>
            <span class="xs-separetor v3"></span>
        <?php endif; ?>
    </div>
</div>