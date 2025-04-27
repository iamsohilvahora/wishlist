<?php
    // Check the user
    if ( isset( $args['user'] ) ) {
        // Retrieve the product ID
        $user = $args['user'];
    } else {
        $user = "";
    }

    $total_amount = !empty(get_user_meta( $user->ID, 'total_amount', true )) ? get_user_meta( $user->ID, 'total_amount', true ) : "";
    $total_gift = !empty(get_user_meta( $user->ID, 'total_no_gift', true )) ? get_user_meta( $user->ID, 'total_no_gift', true ) : "N/A";

    $largest_amount = !empty(get_user_meta( $user->ID, 'largest_amount', true )) ? get_user_meta( $user->ID, 'largest_amount', true ) : "N/A";
    $largest_amount_product_name = !empty(get_user_meta( $user->ID, 'largest_amount_product_name', true )) ? get_user_meta( $user->ID, 'largest_amount_product_name', true ) : "";

    // Get profile image URL
    $profile_image_url = get_user_meta($user->ID, 'profile_image', true); 
    $attachment_id = attachment_url_to_postid( $profile_image_url ); ?>
    
    <h3><?php _e('Customer profile details', 'woocommerce'); ?></h3>

    <table class="form-table">
        <!-- Profile Image Field -->
        <tr>
            <th><label for="profile_image"><?php esc_html_e('Profile Image', 'woocommerce'); ?></label></th>
            <td>
                <?php if (!empty($profile_image_url) && !empty($attachment_id)) : ?>
                    <div>
                        <h3>Profile Image:</h3>
                        <a href="<?php echo esc_url($profile_image_url); ?>" target="_blank"><img src="<?php echo esc_url($profile_image_url); ?>" alt="Profile Image" width="100" height="100" /></a>
                    </div>
                <?php else : ?>
                    <p>Profile image is not available.</p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Gifts Worth: ', 'woocommerce'); ?></th>
            <td>
                <?php echo get_woocommerce_currency_symbol() ."" . esc_html( $total_amount ); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Total Gifts', 'woocommerce'); ?></th>
            <td>
                <?php echo esc_html( $total_gift ); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Largest Amount', 'woocommerce'); ?></th>
            <td>
                <?php echo esc_html( $largest_amount_product_name ) . ' - ' . esc_html( $largest_amount ); ?>
            </td>
        </tr>
        <tr>
            <th><label for="twitter_link"><?php _e('Twitter Link', 'woocommerce'); ?></label></th>
            <td>
                <input type="url" name="twitter_link" id="twitter_link" value="<?php echo esc_url(get_user_meta($user->ID, 'twitter_link', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instagram_link"><?php _e('Instagram Link', 'woocommerce'); ?></label></th>
            <td>
                <input type="url" name="instagram_link" id="instagram_link" value="<?php echo esc_url(get_user_meta($user->ID, 'instagram_link', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
