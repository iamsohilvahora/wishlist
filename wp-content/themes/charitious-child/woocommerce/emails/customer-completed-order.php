<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php

if ( $order instanceof WC_Order ) {
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();

        // Get the product post object
        $product_post = get_post( $product_id );

        // Get author ID using the post object
        $author_id = $product_post->post_author;

        // Get author display name and email
        $creator_name = !empty(get_user_meta($author_id, 'giftlist_url', true )) ? get_user_meta($author_id, 'giftlist_url', true ) : "creatorname";
        $creator_url = get_author_posts_url($author_id);
        break;
    }
}

echo "<p>Thank you for choosing to send a gift through eGifter. Check out the details below:</p>";
echo '<p><strong>Order Number:</strong> ' . $order->get_order_number() . '</p>';
echo '<p><strong>Creator Name:</strong> <a href="' . $creator_url . '" target="_blank">' . $creator_name . '</a></p>';
echo '<p><strong>Gift Amount:</strong> ' . wc_price( $order->get_total() ) . '</p>';
echo '<p>We appreciate your support and hope that you continue to use eGifter for all your gifting needs.</p>';
echo '<p>Best wishes,<br />eGifter Support</p>';

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
