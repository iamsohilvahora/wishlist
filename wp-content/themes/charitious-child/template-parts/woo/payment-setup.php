<?php
// If we have access to /vendor/autoload.php then initialize it.
require_once(ABSPATH . 'vendor/autoload.php');

// Retrieve the Stripe secret key from the theme mod
$stripe_secret_key = get_theme_mod('stripe_secret_key', '');

$current_user = wp_get_current_user();
$user_id = $current_user->ID; // get current user id.

// Set up Stripe client
if(!empty($stripe_secret_key)){
    $stripe = new \Stripe\StripeClient($stripe_secret_key);
}

$stripe_account_id = get_user_meta($user_id, 'creator_stripe_account_id', true);

if (!empty($stripe_account_id) && !empty($stripe_secret_key)) {
	// Retrieve the account from Stripe
	try {
	    $account = $stripe->accounts->retrieve($stripe_account_id, []);
	} catch (\Stripe\Exception\ApiErrorException $e) {
	    $has_error = true;
	    $error_msg = $e->getMessage();
	}

	// Check if the account setup is complete
	if(!$has_error){
		if ($account->requirements->currently_due || $account->requirements->past_due) { ?>
			<button type="button" id="finish-stripe-setup" class="btn btn-primary">Finish Stripe Setup</button>
	    <?php
		} else { $loginLink = $stripe->accounts->createLoginLink($stripe_account_id); ?>
			<h3>Your Stripe account setup is complete.</h3>
			<a href="<?php echo esc_url($loginLink->url); ?>" target="_blank" class="btn btn-primary">Stripe Dashboard</a><br />
		<?php	
		}
		?>
		<button type="button" id="delete-stripe-account" class="btn btn-danger">Delete Stripe Account</button>
<?php } }

if ( $user_id && in_array( 'creator', (array) $current_user->roles ) && (empty($stripe_account_id)) && !empty($stripe_secret_key) && !$has_error): ?>
<p>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#accountSetup">
	    Set Up Withdrawals
	</button>
</p>

<div class="modal fade" id="accountSetup" tabindex="-1" aria-labelledby="accountSetupLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="accountSetupLabel">NSFW Creators</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modal-body-content">
				<form id="accountSetupForm" method="post" enctype="multipart/form-data">
				  	<div class="form-group">
				    	<input type="radio" id="nsfw_creator_no" name="nsfw_creator" value="nsfw_creator_no" required />
				    	<label for="nsfw_creator_no">I am not a NSFW creator (I do not create explicit content)</label>
				  	</div>
				  	<div class="form-group">
				    	<input type="radio" id="nsfw_creator_yes" name="nsfw_creator" value="nsfw_creator_yes" required />
				    	<label for="nsfw_creator_yes">I am a NSFW creator (I do create explicit content)</label>
				  	</div>
				  	<button type="submit" class="btn btn-primary next-button">Next <i class="fa-solid fa-arrow-right"></i></button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
else: 
	if($has_error) {
		echo ' <p style="margin-top: 100px;" class="no-giftlist">' . $error_msg . '</p>';
	}
endif;
