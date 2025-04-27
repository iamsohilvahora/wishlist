<?php
// Get the current user
$current_user = wp_get_current_user();
$counter = 1;

// Check if the current user has the 'creator' role
if ( in_array( 'creator', (array) $current_user->roles ) ) {
    // Get products created by the current user
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'author'         => $current_user->ID,
    );
    $creator_products = get_posts( $args );

    if ( $creator_products ) {
        $product_ids = wp_list_pluck( $creator_products, 'ID' );

        // Get orders containing the creator's products
        $orders = wc_get_orders( array(
            'status'    => array( 'completed' ),
            'limit'     => -1,
            'orderby'   => 'date',
            'order'     => 'DESC',
        ) );

        if ( $orders && !empty($orders) ) {
            $show_table_heading = false;
            $row_count = 1;
            echo '<h2>Orders for your gift</h2>'; ?>

            <div id="filter-buttons">
                <button id="day-filter">Day</button>
                <button id="week-filter">Week</button>
                <button id="month-filter">Month</button>
                <button id="year-filter">Year</button>
                <button id="year-filter">Reset</button>
                <div id="spinner" class="d-none">
                    <i class="fa fa-spinner fa-spin fa-3x" style="color: #007bff"></i>
                </div>
            </div>
            <div id="order-table-container">
                <?php
                foreach ( $orders as $order ) {
                    foreach ( $order->get_items() as $item_id => $item ) {
                        $product = $item->get_product(); // Get product object
                        $product_id = $item->get_product_id(); // Get product ID

                        if (!in_array($product_id, $product_ids)) {
                            continue;
                        }

                        // Get the product post object
                        $product_post = get_post( $product_id );

                        // Get the product author ID using the post object
                        $product_author_id = intval( $product_post->post_author );

                        if ( $product_author_id === $current_user->ID ) {
                            $product_name = $product->get_name(); // Get product name
                            $product_price = wc_price( $product->get_price() ); // Get product price
                            $product_quantity = $item->get_quantity(); // Get product quantity

                            // Get customer (order user) information
                            $customer_id = $order->get_customer_id(); // Get customer/user ID

                            if ( $customer_id ) {
                                $show_table_heading = true;
                                if ( $show_table_heading === true && $row_count === 1 ) {
                                   echo '<table border="1">';
                                   echo '<tr><th>Sr. No</th><th>Orders No</th><th>Gift</th><th>Price</th><th>Quantity</th><th>Amount</th><th>Gifter</th><th>Date</th></tr>';
                                   $row_count++;
                                }
                                $customer_data = get_userdata( $customer_id ); // Get user data
                                if ( $customer_data ) {
                                    $customer_name = get_post_meta($order->id, 'from_name', true); // Get customer name
                                    $customer_email = $customer_data->user_email; // Get customer login email

                                    // Generate customer email link
                                    $customer_email_link = '<a href="mailto:' . $customer_email . '" target="_blank">' . $customer_email . '</a>';

                                    // Get and format the order date
                                    $order_date = $order->get_date_created();
                                    $formatted_order_date = $order_date ? $order_date->date_i18n( get_option( 'date_format' ) ) : '';

                                    // Output order details in table row
                                    echo '<tr>';
                                    echo '<td>' . $counter++ . '</td>';
                                    echo '<td>' . $order->get_order_number() . '</td>';
                                    echo '<td>' . $product_name . '</td>';
                                    echo '<td>' . $product_price . '</td>';
                                    echo '<td>' . $product_quantity . '</td>';
                                    echo '<td>' . wc_price(floatval($product->get_price()) * $product_quantity) . '</td>';
                                    echo '<td>' . $customer_name . '</td>';
                                    echo '<td>' . $formatted_order_date . '</td>'; // Output formatted order date
                                    echo '</tr>';
                               }
                            } else {
                                $show_table_heading = true;
                                if ( $show_table_heading === true && $row_count === 1 ) {
                                   echo '<table border="1">';
                                   echo '<tr><th>Sr. No</th><th>Orders No</th><th>Gift</th><th>Price</th><th>Quantity</th><th>Amount</th><th>Gifter</th><th>Date</th></tr>';
                                   $row_count++;
                                }

                                $customer_name = get_post_meta($order->id, 'from_name', true);
                                $customer_email = $order->get_billing_email();

                                // Get and format the order date
                                $order_date = $order->get_date_created();
                                $formatted_order_date = $order_date ? $order_date->date_i18n( get_option( 'date_format' ) ) : '';

                                // Generate customer email link
                                $customer_email_link = '<a href="mailto:' . $customer_email . '" target="_blank">' . $customer_email . '</a>';

                                // Output order details in table row
                                echo '<tr>';
                                echo '<td>' . $counter++ . '</td>';
                                echo '<td>' . $order->get_order_number() . '</td>';
                                echo '<td>' . $product_name . '</td>';
                                echo '<td>' . $product_price . '</td>';
                                echo '<td>' . $product_quantity . '</td>';
                                echo '<td>' . wc_price(floatval($product->get_price()) * $product_quantity) . '</td>';
                                echo '<td>' . $customer_name . '</td>';
                                echo '<td>' . $formatted_order_date . '</td>'; // Output formatted order date
                                echo '</tr>';
                            }
                        }
                    }
                }
                if( $show_table_heading === true ) {
                    echo '</table>';
                } else {
                    echo '<p>No orders found for your giftlist.</p>';
                } 
                ?>
            </div>    
        <?php
        } else {
            echo '<p>No orders found for your giftlist.</p>';
        }
    } else {
        echo '<p>No giftlist found.</p>';
    }
} else {
    echo '<p>You do not have permission to view this content.</p>';
}
