<?php

//  get customizer option


//  remove default setting

add_filter('wfp_single_foundamount_hide', '_hide_title');
add_filter('wfp_single_goalcounter_hide', '_hide_title');
add_filter('wfp_single_raisedamount_hide', '_hide_title');
add_filter('wfp_single_raisedamount_hide', '_hide_title');
add_filter('wfp_single_date_left_hide', '_hide_title');
add_filter('wfp_single_userinfo_hide', '_hide_title');
add_filter('wfp_single_social_hide', '_hide_title');

function _hide_title(){
    return false;
}

//  count down timer add
add_action('wfp_single_backers_middle', '_count_downtimmer');

function _count_downtimmer( $arr ){
    $date = date("Y/m/d", strtotime($arr['target_date']));
    ?>
    <div class="countdown-container xs-countdown-timer-v2" data-date="<?php echo esc_attr($date); ?>"></div>
    <?php
}

//  Pie size increase
add_filter('wfp_pie_bar_attr', 'wp_fund_pie_size');
function wp_fund_pie_size($aa){
    $aa['data-size'] = '120';
     return $aa;
}

//  add title after gole

add_action('wfp_single_goal_progress_after', '_after_goal');

// fund raised
function _after_goal( $aa){

    $fund_raise  = charitious_option('wp_fund_raised', 'Fund Raised');
   ?>
    <div class="xs-after-goel <?php echo esc_attr($aa->bar_style); ?>">
        <span class="check"><?php echo esc_html($fund_raise); ?></span>
    </div>
<?php
}

// Pledged title

//  goal amount fillter wfp_single_target_amount

add_filter('wfp_single_target_amount', 'text_wfp_single_target_amount');

function text_wfp_single_target_amount ($data) {

    $data_backers = charitious_option('wp_fund_goal', 'Goal ');

    if($data_backers != '') {

        $data  = $data_backers;
    }else{
        $data = esc_html__('Goal', 'charitious');
    }

    return $data;

}

// backers //  wfp_single_backers_title

add_filter('wfp_single_backers_title', 'text_wfp_single_backers_title');


function text_wfp_single_backers_title ($data) {

    $data_goal = charitious_option('wp_fund_backers', 'Backers');

    if($data_goal != '') {

        $data  = $data_goal;
    }else{
        $data = esc_html__('Backers', 'charitious');
    }

    return $data;

    return "";

}


//  Continue button text change

add_filter('wfp_single_continue_title', 'wp_fund_change_btn_text');

function wp_fund_change_btn_text( $data ) {

    $button_label = charitious_option('wp_fund_buttn_label', 'Continue');

    if($button_label != '') {

        $data  = $button_label;
    }else{
        $data = esc_html__('Continue', 'charitious');
    }

    return $data;
    
}

function _ratting_view_star_point($rat = 0, $max = 5){
    $tarring = '';
    $tarring .= '<ul class="xs_review_stars">';
    //$tarring .= '<span class="screen-rattting-text"> '.esc_html(round($rat, 1)).' </span>';
    $halF = 0;
    for($ratting = 1; $ratting <= $max; $ratting++ ):
        $rattingClass = 'dashicons-star-empty';
        if($halF == 1){
            $rattingClass = 'dashicons-star-half';
            $halF = 0;
        }
        if( $ratting <= $rat ){
            $rattingClass = 'dashicons-star-filled';
            if($ratting == floor($rat) ):
                $expLode = explode('.', $rat);
                if(is_array($expLode) && sizeof($expLode) > 1){
                    $halF = 1;
                }

            endif;
        }

        $tarring .= '<li class="star-li star selected"> <i class="xs-star dashicons-before '. esc_html($rattingClass).'" aria-hidden="true"></i> </li>';
    endfor;
    $tarring .= '</ul>';
    return $tarring;
}

// pie attr

add_action('wfp_pie_bar_attr', 'single_wfp_pie_bar_attr');

function single_wfp_pie_bar_attr($data) {
    $header_layout = charitious_option('primary_color');

    $border_color = '#4CC899';

    if($header_layout != '') {

        $border_color  = $header_layout;
    }

   $data['data-bordercolor'] = $border_color;

   return $data;
}

//  add single page banner  fundrising


function xs_fundarising_inline_css() {

    wp_enqueue_style(
        'fundrising-style',
        CHARITIOUS_CSS . '/custom_script.css'
    );
    $single_page_banner = charitious_option('wp_fundraising_banner', '');
    if($single_page_banner == '' ) {
        $single_page_banner = CHARITIOUS_IMAGES_URI.'/backgrounds/blog-bg.jpg';
    }
   $single_page_banner_overly = charitious_option('wp_fundraising_banner_overly', '');
        $custom_css = "
                .wfp-title-section{
                    background:  url({$single_page_banner});
                }
                .wfp-title-section{
                    background: linear-gradient({$single_page_banner_overly}, {$single_page_banner_overly}), url({$single_page_banner});

                }";
        wp_add_inline_style( 'fundrising-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'xs_fundarising_inline_css' );