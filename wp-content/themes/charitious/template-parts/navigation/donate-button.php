<?php

$show_donate_btn = charitious_option('show_donate_btn', charitious_defaults('show_donate_btn'));
$donate_text = charitious_option('donate_button_text');
$donate_btn_link = charitious_option('donate_button_link');
if($show_donate_btn):

     if('' != $donate_btn_link){
        ?>
         <a class="btn btn-primary" href="<?php echo esc_url( home_url('/') . $donate_btn_link ); ?>">
             <?php echo esc_html($donate_text); ?>
         </a>
   <?php
     }

endif;
