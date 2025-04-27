<?php

 $header_social_links = charitious_option('social_links');
 $show_topbar = charitious_option('show_topbar', charitious_defaults('show_topbar'));
 $top_bar_email = charitious_option('top_bar_email');
 $top_bar_email_icon = charitious_option('top_bar_email_icon');
 $top_bar_phone		 = charitious_option( 'top_bar_phone');
 $top_bar_phone_icon		 = charitious_option( 'top_bar_phone_icon');

 ?>

<?php if($show_topbar): ?>
    <div class="xs-top-bar clearfix">
        <ul class="xs-top-social sdd">
            <?php if($header_social_links) {
                foreach($header_social_links as $social){
                    ?><li><a href="<?php echo esc_url($social['social_url']); ?>" target="_blank"><i class="<?php echo esc_attr($social['social_icon']); ?>"></i></a></li><?php
                }
            } ?>
        </ul>
        
        <?php if ( $top_bar_phone != '' ) { ?>
                <span class="top-bar-info"><i class="<?php echo esc_attr( $top_bar_phone_icon ); ?>"></i><?php echo esc_attr( $top_bar_phone ); ?></span>
            <?php } ?>
            
            <?php if ( $top_bar_email != '' ) { ?>
                <a href="mailto:<?php echo sanitize_email( $top_bar_email ); ?>" class="xs-top-bar-mail" target="_blank"><span class="<?php echo esc_attr( $top_bar_email_icon ); ?>"></span> <?php echo sanitize_email( $top_bar_email ); ?></a>
            <?php } ?>
    </div>
<?php endif; ?>
