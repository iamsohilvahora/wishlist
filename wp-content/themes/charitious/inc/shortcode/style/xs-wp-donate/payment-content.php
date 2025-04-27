<div class="wfdp-donation-input-form wfdp-input-payment-field-wraper <?php echo esc_attr($enableDisplayField);?>">
	<div class="wfdp-input-payment-field">
		<?php echo do_action('wfp_donate_forms_payment_method_headding_before');?>
		<span class=""> <?php echo apply_filters('wfp_donate_forms_payment_method_headding', esc_html__('Select Payment Method:', 'charitious'));?></span>
		<?php echo do_action('wfp_donate_forms_payment_method_headding_after');?>
		<ul class="xs-donate-display-amount wfp-radio-input-style-2">
		<?php
		$optionsData = isset($gateWaysData['services']) ? $gateWaysData['services'] : [];
		
		if( is_array($optionsData) && sizeof($optionsData) > 0){
			$m = 0;
			foreach($optionsData AS $key=>$payment):
				if(isset($optionsData[$key]['enable']) && $optionsData[$key]['enable'] == 'Yes'):
					$defultCheck = '';
					if($m == 0){
						$defultCheck = 'checked';
					}
					
					$infoData = isset($optionsData[$key]['setup']) ? $optionsData[$key]['setup'] : [];
					
					?>
						<li>
							<input class="xs_radio_filed" id="wfp_<?php echo isset($infoData['title']) ? str_replace(" ", "_", strtolower($infoData['title'])) : '';?>" type="radio" name="xs_donate_data_submit[payment_method]" <?php echo esc_attr($defultCheck);?> value="<?php echo esc_attr($key);?>" onchange="xs_show_hide_multiple_div('.payment_method_info', '.method-<?php echo esc_attr($key);?>');">
							<label for="wfp_<?php echo isset($infoData['title']) ? str_replace(" ", "_", strtolower($infoData['title'])) : '';?>"><?php echo isset($infoData['title']) ? $infoData['title'] : '';?></label>
						</li>
					<?php
					$m++;
				endif;
			endforeach;	
		}else{
			echo '<p> '.__('Set Payment Method', 'charitious').' </p>';
		}
		?>
		</ul>
	</div>
</div>
<div class="wfdp-input-payment-field wfdp-donation-payment-details <?php echo esc_attr($enableDisplayField);?>">
	<div class="xs-donate-display-amount">
	<?php
	$m = 0;
	foreach($optionsData AS $key=>$payment):
		if(isset($optionsData[$key]['enable']) && $optionsData[$key]['enable'] == 'Yes'):
			$defultCheck = '';
			if($m == 0){
				$defultCheck = 'yes';
			}
			
			$infoData = isset($optionsData[$key]['setup']) ? $optionsData[$key]['setup'] : [];
			
			?>
			<div class="payment_method_info method-<?php echo esc_attr($key);?> xs-donate-hidden <?php echo esc_attr(($defultCheck == 'yes') ? 'xs-donate-visible' : ''); ?>" id="">
				<h2 class="wfp-payment-method-title fdas"><?php echo isset($infoData['title']) ? $infoData['title'] : '';?> </h2>
			<?php 
			if($key == 'bank_payment'){
				$setupData = isset($arrayPayment[$key]['setup']['account_details']) ? $arrayPayment[$key]['setup']['account_details'] : [];
				//print_r($infoData);
			?>
			<div> <strong> <?php echo esc_html__('Account Details:', 'charitious');?></strong></div>
				<?php 
				if(isset($infoData['account_details'])){
					?>
					<div class="xs-table-responsive wfdp-table-design">
						<table class="form-table wc_gateways widefat payment-details">
							<thead>
								<tr>
									<th>SL.</th>
							<?php
							foreach($setupData AS $subKeyHead=>$setupDetails):
								$labelNameSub = ucfirst(str_replace(['_', '-'],' ', $subKeyHead) );
								?>
								<th class="name"> <?php echo esc_html__($labelNameSub, 'charitious'); ?></th>
								<?php
							endforeach;
							?>
								</tr>
							</thead>
							<tbody>
							
							<?php
							$mm = 1;
							foreach($infoData['account_details'] AS $account):
								?>
								<tr>
									<td><?php echo esc_html($mm.'. ');?></td>
									<?php foreach($setupData AS $subKeyHead=>$setupDetails):?>
										<td>
											<?php echo esc_html($account[$subKeyHead]); ?>
										</td>
									<?php endforeach; ?>
								</tr>
								<?php
							$mm++;	
							endforeach;
							?>
							</tbody>
						</table>
					</div>
					<?php
				}
				?>
			
			
			<?php } 
			 if(isset($infoData['description']) && strlen($infoData['description']) > 4): ?>
				<div class="wfp-payment-method-acc-details"> <strong class="wfp-payment-method-acc-details--title"><?php echo apply_filters('wfp_donate_forms_payment_method_details', esc_html__('Details:', 'charitious'));?></strong>
					<span class="wfp-payment-method-acc-details--description"><?php echo isset($infoData['description']) ? $infoData['description'] : '';?></span>
				</div>
			<?php endif;
			 if(isset($infoData['instructions']) && strlen($infoData['instructions']) > 4): ?>
				<div class="wfp-payment-method-acc-details"> <strong class="wfp-payment-method-acc-details--title"><?php echo apply_filters('wfp_donate_forms_payment_method_instructions', esc_html__('Instructions:', 'charitious'));?></strong>
					<span class="wfp-payment-method-acc-details--description"><?php echo isset($infoData['instructions']) ? $infoData['instructions'] : '';?></span>
				</div>
			<?php endif; ?>
			</div>
			<?php
			$m++;
		endif;
	endforeach;	
	?>
	</div>
</div>