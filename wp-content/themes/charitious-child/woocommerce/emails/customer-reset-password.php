<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>

<p>We wanted to inform you that there has been a password reset request for your eGifter account. If you did not initiate this request, please ignore this email and make sure to keep your account secure. If you did request a password reset, you can follow the link provided below to set a new password.</p>

<p>Reset your password here <a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"><?php // phpcs:ignore ?><?php esc_html_e( 'Click here to reset your password', 'woocommerce' ); ?></a></p>

<p>Thank you for your attention to this matter.</p>

<p>Warm regards,<br />
eGifter Support </p>

<?php

do_action( 'woocommerce_email_footer', $email );
