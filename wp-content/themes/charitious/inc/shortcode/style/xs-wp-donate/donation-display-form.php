<?php
$cont = new \WfpFundraising\Apps\Content(false);

include WFP_Fundraising::plugin_dir().'country-module/country-info.php';

/*currency information*/
$metaGeneralKey = 'wfp_general_options_data';
$getMetaGeneralOp = get_option( $metaGeneralKey );
$getMetaGeneral = isset($getMetaGeneralOp['options']) ? $getMetaGeneralOp['options'] : [];

$defaultCurrencyInfo = isset($getMetaGeneral['currency']['name']) ? $getMetaGeneral['currency']['name'] : 'US-USD';
$explCurr = explode('-', $defaultCurrencyInfo);
$currCode = isset($explCurr[1]) ? $explCurr[1] : 'USD';
$countCode = isset($explCurr[0]) ? $explCurr[0] : 'US';
$symbols = isset($countryList[$countCode]['currency']['symbol']) ? $countryList[$countCode]['currency']['symbol'] : '';
$symbols = strlen($symbols) > 0 ? $symbols : $currCode;


$symbols = apply_filters('wfp_donate_amount_symbol', $symbols, $countryList, $countCode);

$defaultThou_seperator = isset($getMetaGeneral['currency']['thou_seperator']) ? $getMetaGeneral['currency']['thou_seperator'] : ',';

$defaultDecimal_seperator = isset($getMetaGeneral['currency']['decimal_seperator']) ? $getMetaGeneral['currency']['decimal_seperator'] : '.';

$defaultNumberDecimal = isset($getMetaGeneral['currency']['number_decimal']) ? $getMetaGeneral['currency']['number_decimal'] : '2';
if($defaultNumberDecimal < 0){
    $defaultNumberDecimal = 0;
}

$defaultUse_space = isset($getMetaGeneral['currency']['use_space']) ? $getMetaGeneral['currency']['use_space'] : 'off';

/*Custom class design data*/
$customClass = isset($getMetaData->form_design->custom_class) ? $getMetaData->form_design->custom_class : '';
$customIdData = isset($getMetaData->form_design->custom_id) ? $getMetaData->form_design->custom_id : '';

$customClass = isset($atts['class']) ? $atts['class'] : $customClass;
$customIdData = isset($atts['id']) ? $atts['id'] : $customIdData;

$format_style = isset($atts['format-style']) ? $atts['format-style'] : $format_style;

// payment method setup
$metaSetupKey = 'wfp_setup_services_data';
$getSetUpData =  get_option( $metaSetupKey );
$setupData = isset($getSetUpData['services']) ? $getSetUpData['services'] : [];
$gateCampaignData = isset($setupData['payment']) ? $setupData['payment'] : 'default';

$urlCheckout = get_site_url().'/wfp-checkout?wfpout=true';
if($gateCampaignData == 'woocommerce'){
    $urlCheckout = get_site_url().'/cart/?wfpout=true';
}
?>
<div class="wfp-view wfp-view-public">
    <div class="wfdp-donation-form <?php echo esc_attr($customClass);?>" id="<?php echo esc_attr($customIdData);?>">
        <form method="post" class="wfdp-donationForm" id="wfdp-donationForm-<?php echo esc_attr($post->ID);?>" wfp-data-url="<?php echo esc_url($urlCheckout);?>" wfp-payment-type="<?php echo esc_html($gateCampaignData);?>">

            <?php
            $defaultData = 0;

            $donation_type = isset($getMetaData->donation->type) ? $getMetaData->donation->type : 'multi-lebel';

            $fixedData = isset($getMetaData->donation->fixed) ? $getMetaData->donation->fixed : [];

            $multiData = isset($getMetaData->donation->multi->dimentions) && sizeof($getMetaData->donation->multi->dimentions) ? $getMetaData->donation->multi->dimentions : [ ];

            $displayData = isset($getMetaData->donation->display) ? $getMetaData->donation->display : 'boxed';
            $donationLimit = isset($getMetaData->donation->set_limit) ? $getMetaData->donation->set_limit : 'No';

            // form donation data
            $formDonation = isset($getMetaData->donation) ? $getMetaData->donation : [];

            // form design data
            $formDesignData = isset($getMetaData->form_design) ? $getMetaData->form_design : (object)[ 'styles' => 'all_fields', 'continue_button' => 'Continue', 'submit_button' => 'Donate Now'];

            // form content data
            $formContentData = isset($getMetaData->form_content) ? $getMetaData->form_content : (object)[ 'enable' => 'No', 'content_position' => 'after-form'];

            // form goal data
            $formGoalData = isset($getMetaData->goal_setup) ? $getMetaData->goal_setup : (object)[ 'enable' => 'No', 'goal_type' => 'goal_terget_amount'];

            // form terms data
            $formTermsData = isset($getMetaData->form_terma) ? $getMetaData->form_terma : (object)[ 'enable' => 'No', 'content_position' => 'after-submit-button'];

            $add_fees = isset($getMetaData->donation->set_add_fees) ? $getMetaData->donation->set_add_fees : (object)[ 'enable' => 'No', 'fees_amount' => 0];

            // target goal check
            $goalStatus = 'Yes';
            $goalDataAmount = 0;
            $goalMessage = '';

            $campaign_status = 'Publish';

            if(isset($formGoalData->enable)){
                $goal_type = isset($formGoalData->goal_type) ? $formGoalData->goal_type : 'terget_goal';
                $where = " AND form_id = '".$post->ID."' AND status = 'Active' ";

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
                        $goalStatus = 'No';
                    }
                    if( $goal_type == 'terget_goal_date' || $goal_type == 'terget_date' ){
                        if($time > $target_time){
                            $goalStatus = 'No';
                        }
                    }else if( $goal_type == 'campaign_never_end'){
                        $goalStatus = 'Yes';
                    }

                }

                $campaign_status = ($goalStatus == 'Yes') ? 'Publish' : 'Ends';

                $goalMessageEmable = isset($formGoalData->terget->enable) ? $formGoalData->terget->enable : 'No';
                $goalMessage = isset($formGoalData->terget->message) ? $formGoalData->terget->message : '';


                update_post_meta( $post->ID , '__wfp_campaign_status', $campaign_status);
            }


            //if($goalStatus == 'Yes'){
            // terms show
            $termsContent = '';
            if(isset($formTermsData->enable)){
                $termsContent .= '<div class="xs-switch-button_wraper">
					<input type="checkbox" class="xs_donate_switch_button" name="xs-donate-terms-condition" id="xs-donate-terms-condition" value="Yes">
					<label class="xs_donate_switch_button_label small xs-round" for="xs-donate-terms-condition"></label><span class="xs-donate-terms-label">'. $formTermsData->level .'</span>
					<span class="xs-donate-terms"> '.$formTermsData->content.' </span>
				</div>';
            }

            $modalHow = isset($formDesignData->modal_show) ? $formDesignData->modal_show : 'No';

            $form_styles = isset($atts['form-style']) ?  $atts['form-style'] : $formDesignData->styles;

            $modal_status = isset($atts['modal']) ? $atts['modal'] : $modalHow;

            if($form_styles == 'all_fields'){
                $modal_status = 'No';
            }

            if($format_style == 'single_donation'){
                $modal_status = 'Yes';
                $form_styles = 'no_button';
                $formContentData->content_position = 'no_content';
            }

            // css code generate
            $continueCOlor = isset($formDesignData->continue_color) ? $formDesignData->continue_color : '#0085ba';
            $submitCOlor = isset($formDesignData->submit_color) ? $formDesignData->submit_color : '#0085ba';
            $barProgressCOlor = isset($formGoalData->bar_color) ? $formGoalData->bar_color : '#0085ba';


            // include files
            if( $modal_status == 'No'){
                echo "<div class='xs-modal-body wfp-donation-form-wraper'>";
                include( __DIR__ .'/doantion-form-include.php' );
                echo "</div>";
            }


            // button section
            if($form_styles == 'only_button'){
                if( $modal_status == 'Yes'):
                    ?>
                    <div class="wfdp-donation-input-form">
                        <button type="button" class="xs-btn btn-special submit-btn" name="submit-form-donation" data-type="modal-trigger" data-target="xs-donate-modal-popup"> <?php echo esc_html($formDesignData->continue_button ? $formDesignData->continue_button : 'Continue');?>
                        </button>
                    </div>
                <?php
                else:
                    ?>
                    <div class="wfdp-donation-input-form wfdp-donation-continue-btn  <?php echo esc_attr($enableDisplayField);?> xs-donate-visible">
                        <button type="button" class="xs-btn btn-special submit-btn" onclick="xs_show_hide_donate_font('.xs-show-div-only-button__<?php echo esc_attr($post->ID);?>');" ><i class="fa fa-heart"></i> <?php echo esc_html($formDesignData->continue_button ? $formDesignData->continue_button : 'Continue');?>
                        </button>
                    </div>


                    <div class="wfp-donate-form-footer">
                        <?php if(isset($formTermsData->enable) && $formTermsData->content_position == 'before-submit-button'){
                            ?>
                            <div class="xs-donate-display-amount <?php echo esc_attr($enableDisplayField);?>">
                                <?php echo esc_html($termsContent);?>
                            </div>
                        <?php }?>


                        <div class="wfdp-donation-input-form  <?php echo esc_attr($enableDisplayField);?> ">
                            <?php
                            if($campaign_status == 'Ends'){
                                echo '<p class="xs-alert xs-alert-success">'.esc_html($goalMessage).'</p>';
                            }else{
                                ?>
                                <button type="submit" class="xs-btn btn-special submit-btn" name="submit-form-donation" > <?php echo esc_html($formDesignData->submit_button ? $formDesignData->submit_button : 'Donate Now');?>
                                </button>
                            <?php }?>
                        </div>

                        <?php if(isset($formTermsData->enable) && $formTermsData->content_position == 'after-submit-button'){
                            ?>
                            <div class="xs-donate-display-amount <?php echo esc_attr($enableDisplayField);?>">
                                <?php echo esc_html($termsContent);?>
                            </div>
                        <?php }?>

                    </div>


                <?php
                endif;
                ?>

            <?php }else if($form_styles == 'all_fields'){?>
                <div class="wfp-donate-form-footer">

                    <?php if(isset($formTermsData->enable) && $formTermsData->content_position == 'before-submit-button'){
                        ?>
                        <div class="xs-donate-display-amount xs-radio_style <?php echo esc_attr($enableDisplayField);?>">
                            <?php echo esc_html($termsContent);?>
                        </div>
                    <?php }?>
                    <div class="wfdp-donation-input-form">
                        <?php
                        if($campaign_status == 'Ends'){
                            echo '<p class="xs-alert xs-alert-success">'.$goalMessage.'</p>';
                        }else{
                            ?>
                            <button type="submit" class="xs-btn btn-special submit-btn" name="submit-form-donation" > <?php echo esc_html($formDesignData->submit_button ? $formDesignData->submit_button : 'Donate Now');?>
                            </button>
                        <?php }?>
                    </div>
                    <?php if(isset($formTermsData->enable) && $formTermsData->content_position == 'after-submit-button'){
                        ?>
                        <div class="xs-donate-display-amount xs-radio_style <?php echo esc_attr($enableDisplayField);?>">
                            <?php echo charitious_kses($termsContent);?>
                        </div>
                    <?php }?>

                </div>
            <?php }?>

            <?php
            if($modal_status == 'Yes'):
                ?>
                <div class="xs-modal-dialog wfp-donate-modal-popup" id="xs-donate-modal-popup">
                    <div class="wfp-donate-modal-popup-wraper">
                        <div class="wfp-modal-content">
                            <div class="xs-modal-header">
                                <h4 class="xs-modal-header--title"><?php echo esc_html($post->post_title);?></h4>
                                <button type="button" class="xs-btn danger xs-modal-header--btn-close" data-modal-dismiss="modal"><i class="wfpf wfpf-close-outline xs-modal-header--btn-close__icon"></i></button>
                            </div>
                            <div class="xs-modal-body wfp-donation-form-wraper">
                                <?php
                                include( __DIR__ .'/doantion-form-include.php' );
                                ?>
                            </div>
                            <div class="wfp-donate-form-footer">
                                <?php if(isset($formTermsData->enable) && $formTermsData->content_position == 'before-submit-button'){
                                    ?>
                                    <div class="xs-donate-display-amount xs-radio_style <?php echo esc_attr($enableDisplayField);?> ">
                                        <?php echo charitious_kses($termsContent);?>
                                    </div>
                                <?php }
                                if($campaign_status == 'Ends'){
                                    echo '<p class="xs-alert xs-alert-success">'.charitious_kses($goalMessage).'</p>';
                                }else{
                                    ?>
                                    <button type="submit" name="submit-form-donation" class="xs-btn btn-special submit-btn"><?php echo esc_html($formDesignData->submit_button ? $formDesignData->submit_button : 'Donate Now');?></button>
                                    <?php
                                }
                                if(isset($formTermsData->enable) && $formTermsData->content_position == 'after-submit-button'){
                                    ?>
                                    <div class="xs-donate-display-amount xs-radio_style <?php echo esc_attr($enableDisplayField);?>">
                                        <?php echo charitious_kses($termsContent);?>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xs-backdrop wfp-modal-backdrop"></div>
            <?php
            endif;
            /*}else if($format_style != 'single_donation'){
                echo '<div class="wfdp-goal-target-message"> <p>'.$goalMessage.'</p></div>';
            }*/
            ?>
        </form>
    </div>
</div>

<script type='text/javascript'>
    xs_donate_amount_set(<?php echo esc_js($defaultData);?>,<?php echo esc_attr($post->ID);?>);
</script>
