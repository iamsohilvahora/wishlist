<?php
if(isset($formGoalData->enable)){
    $width_per = $persentange;
    if($persentange > 100){
        $width_per = 100;
    }

     $displayStyle =$wfp_fundraising_content_raised_sytle;
   // $displayStyle = $formGoalData->bar_display_sty;
    if( apply_filters('wfp_single_goal_style', $displayStyle )  == 'pie_bar'){

        $attr = ['data-trackcolor' => $wfp_fundraising_style_trackcolor == '' ? '#f2f2f2': $wfp_fundraising_style_trackcolor,'data-barColor' => $wfp_fundraising_style_border_color == '' ? '#ef1e25' :$wfp_fundraising_style_border_color, 'data-size' => '100', 'data-linewidth' => 20, 'data-percent' => round($width_per, 2), 'class' => 'xs_donate_chart_shotcode'];
        $pie_data = apply_filters('wfp_pie_bar_attr', $attr);
        $data = '';
        foreach($pie_data as $k=>$v){
            $data .= $k.'="'.$v.'" ';
        }
        $progress_bar = '<div '.$data.'><div class="pie-counter"> <span class="pie-percent-number">'.round($width_per).'</span><span class="pie-percent">%</span></div></div>';
    }else{
        $roundClass = ($displayStyle == 'progressbar') ? 'wfp-round-bar' : '';
        $progress_bar = '<div class="wfdp-progress-bar '.$roundClass.'" >
								<div class="xs-progress">
									<div class="xs-progress-bar" role="progressbar" data-counter="'.round($width_per).'%" style="width: '.round($width_per, 2).'%" aria-valuemin="0" aria-valuemax="100"><div  style="left: calc('.round($width_per).'% - 15px)" class="wfp-round-bar-data">'.round($width_per).'%</div></div>
								</div>
							</div>';
    }

    $metaDisplayKey = 'wfp_display_options_data';
    $getMetaDisplayOp = get_option( $metaDisplayKey );
    $formDisplayData = isset($getMetaDisplayOp['goal_setup']) ? $getMetaDisplayOp['goal_setup'] : [];
    $defaultBackres = !isset($getMetaDisplayOp['goal_setup']) ? 'Yes' : 'No';
    $displayBackers = isset($formDisplayData['backers']) ? 'Yes' : $defaultBackres;

    $displayBackers = apply_filters('wfp_single_display_backers_hide', $displayBackers);

    ?>
    <div class="wfdp-donate-goal-progress">
        <?php if( in_array($goal_type, ['terget_goal', 'terget_goal_date', 'campaign_never_end', 'terget_date']) ){
            $date1 = date_create($to_date);
            $date2 = date_create($target_date);
            $diff  = date_diff($date1, $date2);
            ?>
            <div class="target-date-goal  goal-amount">
                <div class="wfp-inner-data">
                    <?php
                    $goal_icon = (
                            is_array($wfp_fundraising_goal_title_icon)
                            && !empty($wfp_fundraising_goal_title_icon)
                            && $wfp_fundraising_goal_title_icon['value'] != ''
                    ) ? $wfp_fundraising_goal_title_icon['value'] : 'icon-consult';
                    ?>
                    <i class="<?php echo esc_attr($goal_icon); ?>"></i>
                    <strong><?php echo esc_html($wfp_fundraising_goal_title); ?></strong>
                    <span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><span><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($target_amount); ?></span>
                    <span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span>
                </div>
            </div>
            <!--  Goal end-->
            <div class="raised">

                    <div class="target-date-goal raised-amount">
                        <div class="wfp-inner-data">
                            <?php
                            $raised_icon = (
                                is_array($wfp_fundraising_raised_title_icon)
                                && !empty($wfp_fundraising_raised_title_icon)
                                && $wfp_fundraising_raised_title_icon['value'] != ''
                            ) ? $wfp_fundraising_raised_title_icon['value'] : 'icon-chart22';
                            ?>
                            <i class="<?php echo esc_attr($raised_icon); ?>"></i>
                            <strong><?php echo esc_html($wfp_fundraising_raised_title); ?></strong>
                            <span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><span class="donate-percentage"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($total_rasied_amount_fake);?></span>
                            <span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span>
                        </div>
                    </div>

            </div>
            <?php  echo charitious_kses($progress_bar);

        } ?>
    </div>
    <?php
}