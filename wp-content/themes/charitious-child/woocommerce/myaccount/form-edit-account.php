<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

// Get current user meta data.
$user_id = $user->ID; // get current user id.
$giftlist_url = !empty(get_user_meta( $user_id, 'giftlist_url', true )) ? get_user_meta( $user_id, 'giftlist_url', true ) : "";
$description = !empty(get_user_meta( $user_id, 'description', true )) ? get_user_meta( $user_id, 'description', true ) : ""; 
$countries = WC()->countries->get_allowed_countries();
$profile_image = get_user_meta($user_id, 'profile_image', true );

// Check if the current user has the role "creator"
$current_user = wp_get_current_user();

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> enctype="multipart/form-data">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<!-- Display Name -->
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo ( ! empty( $user->display_name ) ) ? esc_attr( wp_unslash( $user->display_name ) ) : ''; ?>" required />
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<?php
		$profile_image_url = get_user_meta( $user_id, 'profile_image', true );
		$attachment_id = attachment_url_to_postid( $profile_image_url );
		if ( ! empty( $profile_image_url ) && ! empty( $attachment_id ) ) :
		?>
		<div id="profile-image-container">
		    <a href="<?php echo esc_url( $profile_image_url ); ?>" target="_blank"><img src="<?php echo esc_url( $profile_image_url ); ?>" alt="Profile Image" width="100" height="100" /></a>
			<a href="#" class="profile-image-delete">Delete Profile Image</a>      
		</div>
		<?php endif; ?>
	    <label for="profile_image"><?php esc_html_e('Profile Image', 'woocommerce'); ?></label><br />
	    <input type="file" name="profile_image" id="profile_image" accept="image/*" /><br />
	    <p>[Note: Please make sure that the attached image does not contain any form of nudity.]</p>
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	    <label for="description">Bio</label>
	    <textarea name="description" id="description" rows="5" cols="30" maxlength ="100"><?php echo esc_html( $description ); ?></textarea>
	</p>

	<?php if ( in_array( 'creator', (array) $current_user->roles ) ) : ?>
	
	<!-- Giftlist URL Field -->
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	  	<label for="giftlist_url"><?php esc_html_e('GiftList URL', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
	  	<div class="woocommerce-input-wrapper">
	      	<span class="woocommerce-input-prefix"><?php echo esc_attr(get_site_url()) . '/giftlist/' . $giftlist_url; ?></span>
	      	<div class="giftlist-url">
	      		<span>@</span>
	      		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="giftlist_url" id="giftlist_url" placeholder="<?php esc_attr_e('yourname', 'woocommerce'); ?>" value="<?php echo esc_attr($giftlist_url); ?>" required />
	  	  	</div>
	      	<span class="status-message"></span>
	  </div>
	</p>
	<div class="clear"></div>

	<?php endif; ?>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	    <label for="twitter_link"><?php esc_html_e('Twitter Link (Optional)', 'woocommerce'); ?></label>
	    <input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="twitter_link" id="twitter_link" value="<?php echo esc_attr( get_user_meta( $user_id, 'twitter_link', true ) ); ?>" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	    <label for="instagram_link"><?php esc_html_e('Instagram Link (Optional)', 'woocommerce'); ?></label>
	    <input type="url" class="woocommerce-Input woocommerce-Input--text input-text" name="instagram_link" id="instagram_link" value="<?php echo esc_attr( get_user_meta( $user_id, 'instagram_link', true ) ); ?>" />
	</p>

	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" required />
	</p>

	<?php
		/**
		 * Hook where additional fields should be rendered.
		 *
		 * @since 8.7.0
		 */
		do_action( 'woocommerce_edit_account_form_fields' );
	?>

	<?php
		/**
		 * My Account edit account form.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_edit_account_form' );
	?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
