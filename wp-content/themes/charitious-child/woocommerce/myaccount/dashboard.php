<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

$user_id = $current_user->ID; // get current user id.

if ( $user_id && in_array( 'creator', (array) $current_user->roles ) ) {
	$edit_account_url = wc_get_endpoint_url( 'edit-account', '', wc_get_page_permalink( 'myaccount' ) );
	if(!empty(get_user_meta( $user_id, 'giftlist_url', true ))) {
		$giftlist_url_name = get_user_meta( $user_id, 'giftlist_url', true );
		$giftlist_url = get_site_url() . '/giftlist/' . $giftlist_url_name;
	} else {
		$giftlist_url_name = "yourname";
		$giftlist_url = $edit_account_url;
	}
}

?>

<p>
	<?php
		if ( $user_id && in_array( 'creator', (array) $current_user->roles ) ) {
			printf(
				/* translators: 1: user display name 2: logout url */
				wp_kses( __( 'Hello %1$s Giftlist URL: <a href="%2$s">@%3$s</a>', 'woocommerce' ), $allowed_html ),
				'<strong>' . esc_html( $current_user->display_name ) . ',</strong><br />',
				esc_url( $giftlist_url ),
				$giftlist_url_name
			); 
		} else {
			printf(
				/* translators: 1: user display name 2: logout url */
				wp_kses( __( 'Hello %1$s', 'woocommerce' ), $allowed_html ),
				'<strong>' . esc_html( $current_user->display_name ) . '</strong>'
			);
		}
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
