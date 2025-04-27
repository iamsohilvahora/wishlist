<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

// Get user email address
$user = get_user_by('login', $user_login );

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>

<p>We are delighted to have you join us at eGifter. Your registration means a lot to us!</p>

<p>Your login information is as follows: <br />
Username: <?php echo esc_html( $user_login ); ?><br/>
Email: <?php echo esc_html( $user->user_email ); ?></p>

<p>Now that your account is set up, feel free to log in and personalize your profile while creating your very own Giftlist. <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' )); ?>">eGifter</a></p>

<p>Get ready to experience the joy of receiving gifts with eGifter. <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' )); ?>">eGifter</a></p>

<p>Best wishes, <br />
eGifter Team
<p>

<?php

do_action( 'woocommerce_email_footer', $email );
