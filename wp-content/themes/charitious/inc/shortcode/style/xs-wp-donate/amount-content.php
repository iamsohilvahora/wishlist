<?php
if($donation_type == 'multi-lebel'):
	$displayStyle = isset($formDonation->display) ? $formDonation->display : 'boxed';
	$limitAmount = isset($formDonation->set_limit) ? $formDonation->set_limit : '';
?>
<div class="wfdp-donation-input-form xs-multi-lebel" >

	<?php if($displayStyle == 'boxed' OR $displayStyle == ''){?>
		<ul class="wfp-bdage-list">
	<?php }else if($displayStyle == 'radio'){?>
		<ul class="xs-donate-option wfp-radio-input-style-2 wfp-bdage-list">
	<?php }else if($displayStyle == 'dropdown'){ ?>
		<div class="xs-dropdown_style_wraper">
			<select name="" class="xs-dropdown_style" onchange="xs_donate_amount_set(this.value, <?php echo esc_attr($post->ID);?>);">
	<?php } ?>
   <li>
       <div class="xs-donate-field-wrap-group">
           <div class="xs-donate-field-wrap">
               <label for="xs_donate_amount" class="xs-money-symbol xs-money-symbol-before"><?php echo esc_html($symbols);?></label>
               <input type="number" required min="0" onkeyup="xs_additional_fees(this.value, <?php echo esc_attr($post->ID);?>)" onblur="xs_additional_fees(this.value, <?php echo esc_attr($post->ID);?>)" name="xs_donate_data_submit[donate_amount]" id="xs_donate_amount" value="" placeholder="<?php echo esc_attr_e('Amount', 'charitious') ?>" class="xs-field xs-money-field xs-text_small">
           </div>
       </div>
   </li>
	  <li><?php echo esc_html_e('Select Amount:', 'charitious'); ?></li>
		<?php 
		foreach($multiData as $mul_level):
		 $lebelName = $mul_level->lebel;
		 $priceData = $mul_level->price;
		 $default_set = isset($mul_level->default_set) ? $mul_level->default_set : 'No';
		 
		 if($default_set == 'Yes'){
			$defaultData = $priceData;
		 }
		?>
		<?php if($displayStyle == 'boxed' OR $displayStyle == ''){?>
			<li class="wfp-bdage" onclick="xs_donate_amount_set(<?php echo esc_html($priceData);?>, <?php echo esc_attr($post->ID);?>);" data-value="<?php echo esc_attr($priceData);?>" class="<?php echo esc_attr(($default_set == 'Yes') ? 'donate-active' : '');?>"><?php echo esc_html($lebelName);?></li>
		<?php }else if($displayStyle == 'radio'){?>
			<li>
				<input type="radio" id="wfp___<?php echo esc_attr(strtolower($lebelName)) ?>_<?php echo esc_html($priceData);?>_<?php echo esc_attr($post->ID);?>" class="xs_radio_filed" onchange="xs_donate_amount_set(<?php echo esc_html($priceData);?>, <?php echo esc_attr($post->ID);?>);" <?php if($default_set == 'Yes'){ echo 'checked';}?> 	name="xs-dimention-amount" value="<?php echo esc_html($priceData);?>"/>
				<label for="wfp___<?php echo esc_attr(strtolower($lebelName)) ?>_<?php echo esc_html($priceData);?>_<?php echo esc_attr($post->ID);?>"><?php echo esc_html($lebelName);?></label>
			</li>
		<?php }else if($displayStyle == 'dropdown'){ ?>
			<option value="<?php echo esc_html($priceData);?>" <?php if($default_set == 'Yes'){ echo 'selected';}?> > <?php echo esc_html($lebelName);?></option>
		<?php } ?>
	<?php endforeach; ?>
	
<?php if($displayStyle == 'boxed' OR $displayStyle == ''){?>
	</ul>
<?php }else if($displayStyle == 'radio'){?>
	</ul>
<?php }else if($displayStyle == 'dropdown'){ ?>
		</select>
	</div>
<?php } ?>
</div>
<?php
else:
$defaultData = isset($fixedData->price) ? $fixedData->price : 0;
$customFiedEnable = (isset($fixedData->custom_enable) && $fixedData->custom_enable == 'Yes') ? 'show' : 'hide'; 
?>
<div class="wfdp-donation-input-form ">
	<div class="wfdp-input-payment-field xs-fixed-lebel oka">
		<div class="xs-donate-field-wrap-group">
			<div class="xs-donate-field-wrap">
				<label class="xs-money-symbol xs-money-symbol-before"><?php echo esc_html($symbols);?></label>
				<input type="number" required min="0" <?php echo esc_attr(($customFiedEnable == 'hide') ? 'readonly' : '');?> onkeyup="xs_additional_fees(this.value, <?php echo esc_attr($post->I);?>)" onblur="xs_additional_fees(this.value, <?php echo esc_attr($post->ID);?>)"  name="xs_donate_data_submit[donate_amount]" id="xs_donate_amount" value="<?php echo isset($fixedData->price) ? $fixedData->price : 0;?>" placeholder="1.00" class="xs-field xs-money-field xs-text_small <?php echo esc_attr(($customFiedEnable == 'hide') ? 'input-hidden' : '');?>">
			</div>
		</div>
		
	</div>
</div>
<?php
endif;
		
		