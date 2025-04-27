<?php
    // Check the user
    if ( isset( $args['user'] ) ) {
        // Retrieve the product ID
        $user = $args['user'];
    } else {
        $user = "";
    }

    // $total_amount = !empty(get_user_meta( $user->ID, 'total_amount', true )) ? get_user_meta( $user->ID, 'total_amount', true ) : "";
    $total_amount = get_total_product_orders_amount($user->ID);
    // $total_gift = !empty(get_user_meta( $user->ID, 'total_no_gift', true )) ? get_user_meta( $user->ID, 'total_no_gift', true ) : "N/A";
    // Count the total number of product orders each user received within the specified period
    $total_gift = get_total_product_orders($user->ID);

    $giftlist_url = !empty( get_user_meta($user->ID, 'giftlist_url', true) ) ? get_user_meta($user->ID, 'giftlist_url', true) : "yourname";

    // Get profile image URL
    $profile_image_url = get_user_meta($user->ID, 'profile_image', true);
    $attachment_id = attachment_url_to_postid( $profile_image_url );
    $required = empty($profile_image_url) ? 'required' : '';
    
    // Get list of countries
    $countries = WC()->countries->get_countries(); 

    $nsfw_creator = !empty(get_user_meta( $user->ID, 'nsfw_creator', true )) ? get_user_meta( $user->ID, 'nsfw_creator', true ) : "N/A";
    $creator_stripe_id = !empty(get_user_meta( $user->ID, 'creator_stripe_account_id', true )) ? get_user_meta( $user->ID, 'creator_stripe_account_id', true ) : "N/A"; ?>
    
    <h3><?php _e('Creator profile details', 'woocommerce'); ?></h3>

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
                <?php echo get_woocommerce_currency_symbol() . "" . esc_html( $total_amount ); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Total Gifts', 'woocommerce'); ?></th>
            <td>
                <?php echo esc_html( $total_gift ); ?>
            </td>
        </tr>
        <tr>
            <th><label for="giftlist_url"><?php _e('GiftList URL', 'woocommerce'); ?></label></th>
            <td>
                <p><?php echo get_site_url() . '/giftlist/' . $giftlist_url; ?></p>
                <input type="text" name="giftlist_url" id="giftlist_url" value="<?php echo "@" . esc_attr($giftlist_url); ?>" class="regular-text" placeholder="yourname" disabled />
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
        <tr>
            <th><label for="nsfw_creator"><?php _e('NSFW', 'woocommerce'); ?></label></th>
            <td>
                <input type="text" name="nsfw_creator" id="nsfw_creator" value="<?php echo esc_attr($nsfw_creator); ?>" class="regular-text" disabled />
            </td>
        </tr>
        <tr>
            <th><label for="creator_stripe_id"><?php _e('Creator stripe account ID', 'woocommerce'); ?></label></th>
            <td>
                <input type="text" name="creator_stripe_id" id="creator_stripe_id" value="<?php echo esc_attr($creator_stripe_id); ?>" class="regular-text" disabled />
            </td>
        </tr>
    </table>
