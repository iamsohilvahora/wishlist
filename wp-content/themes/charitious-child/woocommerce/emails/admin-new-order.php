<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php

echo "<p>Exciting news! You've just been gifted on eGifter. Check out the details below:</p>";
echo '<p><strong>Order Number:</strong> ' . $order->get_order_number() . '</p>';
echo '<p><strong>Gifter Name:</strong> ' . get_post_meta($order->id, 'from_name', true) . '</p>';
echo '<p><strong>Gift Amount:</strong> ' . wc_price( $order->get_subtotal() ) . '</p>';
echo '<p>We hope this gift brings a smile to your face. Wishing you more wonderful surprises on eGifter in the days ahead.</p>';
echo '<p>Best wishes,<br />eGifter Support</p>';

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
