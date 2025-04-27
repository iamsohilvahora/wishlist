<?php
	if(isset($formGoalData->enable)){
		$width_per = $persentange;
		if($persentange > 100){
			$width_per = 100;
		}
		$displayStyle = $formGoalData->bar_display_sty;
		if( apply_filters('wfp_single_goal_style', $formGoalData->bar_style )  == 'pie_bar'){

			$attr = [ 'data-size' => '100', 'data-linewidth' => 20, 'data-percent' => round($width_per, 2), 'class' => 'xs_donate_chart'];
			$pie_data = apply_filters('wfp_pie_bar_attr', $attr);
			$data = '';
			foreach($pie_data as $k=>$v){
				$data .= $k.'="'.$v.'" ';
			}
			$progress_bar = '<div '.$data.'><div class="pie-counter"> <span class="pie-percent-number">'.round($width_per).'</span><span class="pie-percent">%</span></div></div>';
		}else{
			$roundClass = ($displayStyle == 'percentage') ? 'wfp-round-bar' : '';
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
				<?php if( $displayStyle == 'percentage' ) {?>
					<div class="raised">
						<?php if( apply_filters('wfp_single_foundamount_hide', true) ):?>
						<div class="target-date-goal raised-amount ">
							<span class="donate-percentage"><?php echo round($persentange);?>%</span> 
							<div class="wfp-inner-data">
								<?php echo esc_html__(apply_filters('wfp_single_foundamount_title', 'funded'), 'charitious');?>
							</div>
						</div>
						<?php endif;
						if( apply_filters('wfp_single_goalcounter_hide', true) ):
						?>
						<div class="target-date-goal  goal-amount">
							<?php echo esc_html__(apply_filters('wfp_single_goalcounter_title', 'Goal'), 'charitious');?>

							<div class="wfp-inner-data">
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><strong><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($target_amount); ?></strong><span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span> 
							</div>
						</div> 
					<?php 
					endif;
					if( $displayBackers == 'Yes'){?>
						<div class="target-date-goal  goal-donor">
							<?php echo esc_html__(apply_filters('wfp_single_donercounter_title', 'Donor'), 'charitious');?>
							<div class="wfp-inner-data">
								<?php echo round($total_rasied_count);?> 
							</div>
						</div>	
					<?php }?>	
					</div>
				<?php }else if( $displayStyle == 'amount_show' ) {?>
					<div class="raised">
						<?php if( apply_filters('wfp_single_raisedamount_hide', true) ):?>
						<div class="target-date-goal raised-amount">
							<?php echo esc_html__(apply_filters('wfp_single_raisedamount_title', 'Raised'), 'charitious');?>
							<div class="wfp-inner-data">
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><span class="donate-percentage"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($total_rasied_amount_fake);?></span>
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span> 
							</div>
						</div>
						<?php 
						endif;
						if( apply_filters('wfp_single_goalcounter_hide', true) ):?>
						<div class="target-date-goal  goal-amount">
							<?php echo esc_html__( apply_filters('wfp_single_goalcounter_title', 'Goal'), 'charitious');?>

							<div class="wfp-inner-data">
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><strong><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($target_amount); ?></strong>
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span> 
							</div>
						</div> 
						<?php endif;?>
						<?php if( $displayBackers == 'Yes'){?>
							<div class="target-date-goal  goal-donor"><?php echo esc_html__(apply_filters('wfp_single_donercounter_title', 'Donor'), 'charitious');?>

								<div class="wfp-inner-data">
									<?php echo round($total_rasied_count);?>
								</div>
								
							</div>
						<?php }?>	
					</div>
				<?php }else if( $displayStyle == 'both_show'){?>
					<?php if( apply_filters('wfp_single_raisedamount_hide', true) ):?>
					<div class="raised wfp-both-show-raised">
						<div class="target-date-goal raised-amount">
							<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><span class="donate-percentage"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($total_rasied_amount_fake);?></span><span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span> <?php echo esc_html__(apply_filters('wfp_single_raisedamount_title', 'raised'), 'charitious');?>
							<div class="wfp-inner-data">
								<?php echo esc_html__('of', 'charitious');?>
								<span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><strong><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($target_amount); ?></strong><span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span>
							</div>
						</div>
						
						<?php if( $displayBackers == 'Yes-1'){?>
							<span class="number_donation_count"><?php echo esc_html__(apply_filters('wfp_single_donercounter_title', 'Donor'), 'charitious');?>  <strong class="wfp-goal-sp"><?php echo round($total_rasied_count);?></strong> </span>
						<?php }?>	
					</div>
					<?php endif;?>
				<?php }?>
				<?php 
				if( apply_filters('wfp_single_goalbar_hide', true) ):
					echo charitious_kses($progress_bar);
				endif;
				?>
				<?php if( $displayStyle == 'both_show__00'){?>
					<div class="raised">
						<span style="font-weight:bold;"><?php echo round($persentange);?>%</span> <?php echo esc_html__('of', 'charitious');?> <span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('left', $defaultUse_space); ?></span><strong><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency($target_amount); ?></strong><span class="wfp-currency-symbol"><?php echo WfpFundraising\Apps\Settings::wfp_number_format_currency_icon('right', $defaultUse_space); ?></span>
					</div>
				<?php }
				if( apply_filters('wfp_single_date_left_hide', true) ):
				?>
					<span class="number_donation_count"><span class="wfp-icon wfpf wfpf-time"><?php echo esc_attr($diff->format("%R%a"));?></span><?php echo esc_html__(apply_filters('wfp_single_date_left_title', 'days left'), 'charitious');?></span>
				<?php endif;
			}?>
		</div>
		<?php
	}