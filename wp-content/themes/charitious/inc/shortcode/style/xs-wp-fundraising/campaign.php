
<?php
$feature = new \WfpFundraising\Apps\Featured(false);
$content = new \WfpFundraising\Apps\Content(false);

// page limit
$limit = isset($wfp_fundraising_content__show_post)  ? (int) $wfp_fundraising_content__show_post : 9;
$limit = ($limit > 0) ? $limit : 9;

// order by
$orderby = isset($wfp_fundraising_content__orderby)  ?  $wfp_fundraising_content__orderby : 'post_date';
$orderby = (strlen($orderby) > 2) ? $orderby : 'post_date';

// order
$order = isset($wfp_fundraising_content__order)  ?  $wfp_fundraising_content__order : 'DESC';
$order = (strlen($order) > 1) ? $order : 'DESC';


// categories query data
$cate_data = isset($wfp_fundraising_content__categories) ? $wfp_fundraising_content__categories : '';

$args['post_status'] = 	'publish';
$args['post_type'] = \WfpFundraising\Apps\Content::post_type();

if( is_array($cate_data) && sizeof($cate_data) > 0){
    $subQuery = [
        [
            'taxonomy' => 'wfp-categories',
            'field'    => 'term_id',
            'terms'    => $cate_data,
        ],
        'relation' => 'AND',
    ];
    $args['tax_query'] = $subQuery;
}

$args['meta_query'] = [
    'relation' => 'AND',
    array(
        'key' => '__wfp_campaign_status',
        'value' => 'Ends',
        'compare' => '!='
    ),
];

$args['orderby'] = $orderby;
$args['posts_per_page'] = $limit;
$args['order'] = $order;
$args['suppress_filters'] = true;

$the_query = new \WP_Query( $args );

// layout style

$layout_style = isset($wfp_fundraising_content__layout_style) ? $wfp_fundraising_content__layout_style : 'wfp-layout-grid';
$layout_row = isset($wfp_fundraising_content__column_grid) ? $wfp_fundraising_content__column_grid : 'xs-col-md-4';
if($layout_style == 'wfp-layout-list'){
    $layout_row = 'xs-col-lg-12';
}

$column = '';
if($layout_style == 'wfp-layout-masonary'){
    if($layout_row == 'xs-col-lg-6'){
        $column = 'wfp-column-2';
    }else if($layout_row == 'xs-col-lg-4'){
        $column = 'wfp-column-3';
    }else if($layout_row == 'xs-col-lg-3'){
        $column = 'wfp-column-4';
    }
}

?>
<div class="wfp-view wfp-view-public">
    <div class="wfp-list-campaign wfp-content-padding <?php echo isset($className) ? esc_attr($className) : '';?>" id="<?php echo isset($idName) ? esc_attr($idName) : '';?>">
        <div class="list-campaign-body <?php echo esc_attr($layout_style)?> <?php echo esc_attr($column);?>">

            <?php if ( $the_query->have_posts() ) : ?>
                <div class="xs-row">
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                        $categories = get_the_terms( get_the_ID(), 'wfp-categories' );

                        $metaKey = 'wfp_form_options_meta_data';
                        $metaDataJson = get_post_meta( get_the_ID(), $metaKey, false );
                        $getMetaData = json_decode(json_encode(end($metaDataJson)));

                        $formGoalData = isset($getMetaData->goal_setup) ? $getMetaData->goal_setup : (object)[ 'enable' => 'No', 'goal_type' => 'terget_goal'];

                        $goalStatus = 'No';
                        $goalDataAmount = 0;
                        $goalMessage = '';

                        $category_info = isset($wfp_fundraising_content__category_enable) ? $wfp_fundraising_content__category_enable : 'Yes';
                        $user_info = isset($wfp_fundraising_content__user_enable) ? $wfp_fundraising_content__user_enable : 'Yes';
                        $title_info = isset($wfp_fundraising_content__title_enable) ? $wfp_fundraising_content__title_enable : 'Yes';
                        $title_limit = isset($wfp_fundraising_content__title_limit) ? $wfp_fundraising_content__title_limit : 40;
                        $excerpt_info = isset($wfp_fundraising_content__excerpt_enable) ? $wfp_fundraising_content__excerpt_enable : 'Yes';
                        $excerpt_limit = isset($wfp_fundraising_content__excerpt_limit) ? $wfp_fundraising_content__excerpt_limit : 60;
                        $featured = isset($wfp_fundraising_content__featured_enable) ? $wfp_fundraising_content__featured_enable : 'Yes';


                        if(isset($formGoalData->enable)){
                            $goalStatus = isset($wfp_fundraising_content__goal_enable) ? $wfp_fundraising_content__goal_enable : 'Yes';

                            $goal_type = isset($formGoalData->goal_type) ? $formGoalData->goal_type : 'terget_goal';
                            $where = " AND form_id = '".get_the_ID()."' AND status = 'Active' ";

                            $total_rasied_amount = charitious_wfp_get_sum('', 'donate_amount', $where);

                            $total_rasied_count = charitious_wfp_get_count('', 'donate_id', $where);

                            $to_date = date("Y-m-d");
                            $time = time();
                            $persentange = 0;
                            $target_amount = 0;
                            $target_amount_fake = 0;
                            $target_date = date("Y-m-d");

                            $total_rasied_amount_fake = $total_rasied_amount;
                            $total_rasied_count_fake = $total_rasied_count;

                            if( in_array($goal_type, ['terget_goal', 'terget_goal_date', 'campaign_never_end', 'terget_date']) ){
                                $target_amount = isset($formGoalData->terget->terget_goal->amount) ? $formGoalData->terget->terget_goal->amount : 0;
                                $target_amount_fake = isset($formGoalData->terget->terget_goal->fake_amount) ? $formGoalData->terget->terget_goal->fake_amount : 0;
                                $target_date = isset($formGoalData->terget->terget_goal->date) ? $formGoalData->terget->terget_goal->date : date("Y-m-d");

                                $target_time = strtotime($target_date);

                                $total_rasied_amount_fake = $total_rasied_amount + $target_amount_fake;
                                // check amount with data
                                if($total_rasied_amount_fake >= $target_amount){
                                    $total_rasied_amount_fake = $total_rasied_amount;
                                }
                                if($target_amount > 0){
                                    $persentange = ($total_rasied_amount_fake * 100 ) / $target_amount;
                                }

                                if($total_rasied_amount >= $target_amount){
                                    //$goalStatus = 'No';
                                }
                                if( $goal_type == 'terget_goal_date' || $goal_type == 'terget_date' ){
                                    if($time > $target_time){
                                        //$goalStatus = 'No';
                                    }
                                }else if( $goal_type == 'campaign_never_end'){
                                    //$goalStatus = 'Yes';
                                }

                            }

                            $campaign_status = ($goalStatus == 'Yes') ? 'Publish' : 'Ends';


                        }


                        ?>

                        <div class="xs-col-md-6 <?php echo esc_attr($layout_row);?> single-campaign-blog">
                            <div class="campaign-blog">
                                <?php if($featured == 'Yes'):?>
                                    <?php do_action('wfp_campaign_list_thumbnil_before');?>

                                    <div class="wfp-campaign-container">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if( $feature->has_featured_video( get_the_ID() ) ) {?>
                                                <div class="wfp-feature-video" style="background-image: url('<?php echo esc_url($feature->get_video_thumbnail( get_the_ID() )); ?>')">
                                                </div>
                                            <?php }else{?>
                                                <div class="wfp-post-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail', ['class' => 'wfp-feature wfp-full-image', 'title' => 'Feature image']); ?>')">
                                                </div>
                                            <?php }?>
                                        </a>
                                    </div>

                                    <?php do_action('wfp_campaign_list_thumbnil_after');?>
                                <?php endif;?>

                                <div class="wfp-compaign-contents">
                                    <div class="wfp-campaign-content">
                                        <?php
                                        if( $category_info == 'Yes'){
                                            if ( ! empty( $categories ) ) {?>
                                                <div class="wfp-campaign-content--cat">
                                                    <?php

                                                    $separator = '&nbsp;&nbsp;&nbsp;';
                                                    $outputCate = '';
                                                    foreach( $categories as $category ) {
                                                        $outputCate .= '<a class="wfp-campaign-content--cat__link" href="' . esc_url( get_category_link( $category->term_id ) ) . '" >' . esc_html( $category->name ) . '</a>' . $separator;
                                                    }
                                                    $outputCate = trim( $outputCate, $separator );
                                                    ?>
                                                    <?php echo charitious_kses($outputCate); ?>
                                                </div>
                                                <?php
                                            }
                                        }

                                        if($title_info == 'Yes'):?>
                                            <h3 class="wfp-campaign-content--title" ><a class="wfp-campaign-content--title__link" href="<?php echo get_permalink();?>"><?php
                                                    $ext = '';
                                                    if(strlen(get_the_title()) >= $title_limit){
                                                        $ext = '...';
                                                    }
                                                    echo substr( get_the_title(), 0, $title_limit) . $ext;
                                                    ?></a></h3>
                                        <?php endif;
                                        if( $excerpt_info == 'Yes'):
                                            ?>
                                            <p class="wfp-campaign-content--short-description"><?php
                                                $ext = '';
                                                if(strlen(get_the_title()) >= $excerpt_limit){
                                                    $ext = '...';
                                                }
                                                echo substr(get_the_excerpt(), 0, $excerpt_limit) . $ext;
                                                ?> </p>
                                        <?php
                                        endif;
                                        if($goalStatus == 'Yes'): ?>
                                            <?php include( CHARITIOUS_SHORTCODE_DIR_STYLE.'/xs-wp-fundraising/goal-content.php'); ?>
                                        <?php endif;?>
                                    </div>
                                    <?php if( $user_info == 'Yes' ):?>
                                        <div class="wfp-campign-user">
                                            <?php
                                            $author_id = get_the_author_meta('ID');
                                            $profileImage = get_the_author_meta( 'avatar' , $author_id );
                                            if(strlen($profileImage) < 5){
                                                $profileImage = get_the_author_meta( 'wfp_author_profile_image' , $author_id );
                                            }
                                            ?>
                                            <div class="profile-image">
                                                <?php if(strlen($profileImage) > 5){
                                                    echo wp_get_attachment_image(get_the_author_meta( 'url', $author_id ), 'full', false, array(
                                                        'class'   => 'avatar wfp-profile-image',
                                                        'alt'     => the_author_meta( 'display_name' , $author_id )
                                                    ));
                                                    ?>
                                                <?php }else{?>
                                                    <?php echo get_avatar( $author_id, 35 );?>
                                                <?php }?>
                                            </div>

                                            <div class="profile-info">
                                                <span class="display-name"><?php esc_html_e( 'Created by', 'charitious' ); ?> <strong class="display-name__author"><?php the_author_meta( 'display_name' , $author_id ); ?></strong></span>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <p class="xs-alert xs-alert-danger"><?php _e( 'Sorry, not found any campaign.', 'charitious' ); ?></p>
            <?php endif; ?>



        </div>
    </div>
</div>