<div class="event-heading">
    <?php if(!empty($sub_headding)): ?>
    <span class="xs-sub-title"><?php echo wp_kses( $sub_headding, array('br' => array(),'span' => array()) ); ?></span>
    <?php endif; ?>
    <div class="border-animation">
        <span class="first"></span>
        <span class="second"></span>
    </div>
    <div class="clearfix">
        <?php if(!empty($title)) :  ?>
        <div class="float-left">
            <h2 class="xs-title"><?php echo wp_kses( $title, array('br' => array(),'span' => array()) ); ?></h2>
        </div>
        <?php endif; ?>
    </div>
    <?php if(!empty($sub_title)) : ?>
    <p><?php echo wp_kses( $sub_title, array('br' => array(),'span' => array()) ); ?></p>
    <?php endif;  ?>
</div>