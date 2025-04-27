<?php
// WooCommerce support inside the theme.
function charitious_theme_setup_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action( 'after_setup_theme', 'charitious_theme_setup_woocommerce_support' );

// Add term and conditions check box on registration form.
function charitious_theme_add_terms_and_conditions_to_registration() {
    if ( wc_get_page_id( 'terms' ) > 0 && is_account_page() ) {
        ?>
        <p class="form-row terms wc-terms-and-conditions">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" /> <span><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" class="woocommerce-terms-and-conditions-link">terms &amp; conditions</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
            </label>
            <input type="hidden" name="terms-field" value="1" />
        </p>

        <p class="woocommerce-form-row form-row">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="over_18" id="over_18" />
                <?php esc_html_e( 'I am over the Age of 18 Yrs', 'woocommerce' ); ?> <span class="required">*</span>
            </label>
        </p>
    <?php
    }
}
add_action( 'woocommerce_register_form', 'charitious_theme_add_terms_and_conditions_to_registration', 20 );

// Validate required term and conditions check box.
function charitious_theme_terms_and_conditions_validation( $username, $email, $validation_errors ) {
    if(!is_checkout()){
        if ( ! isset( $_POST['terms'] ) ) {
            $validation_errors->add( 'terms_error', __( 'Terms and condition are not checked!', 'woocommerce' ) );
        }

        if ( ! isset( $_POST['over_18'] ) || $_POST['over_18'] !== 'on' ) {
            $validation_errors->add( 'over_18_error', __( 'You must confirm that you are over 18.', 'woocommerce' ) );
        }
    }

    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'charitious_theme_terms_and_conditions_validation', 20, 3 );

// Show terms & condition checkbox only on myaccount signup page.
add_filter( 'woocommerce_checkout_show_terms', '__return_false' );

// Remove registration_privacy_policy_text from myaccount signup page.
remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

// Add Creator role.
function charitious_theme_create_creator_role() {
  add_role(
    'creator',
    __( 'Creator' ),
    array(
      'publish_posts' => false,  // Creators cannot publish posts (optional)
      'edit_posts' => false,      // Creators cannot edit posts (optional)
      'delete_posts' => false,      // Creators cannot delete posts (optional)
      'manage_categories' => false, // Creators cannot manage categories (optional)
      'upload_files' => true,       // Creators can upload files (required for product images)
      'edit_products' => false,     // Creators cannot edit products (optional)
      'create_products' => true,    // Creators can create products
      'delete_products' => false,   // Creators cannot delete products (optional)
      'manage_woocommerce' => false, // Creators cannot manage WooCommerce settings (optional)
    )
  );
}
add_action( 'admin_init', 'charitious_theme_create_creator_role' );

// Add custom fields to the WooCommerce registration form
function charitious_theme_add_custom_registration_fields() {
    // Get the selected value if it's already submitted.
    $selected_value = isset( $_POST['account_type'] ) ? sanitize_text_field( $_POST['account_type'] ) : '';
    ?>
    <p class="form-row form-row-wide">
        <label for="account_type"><?php _e( 'I am using eGifter as', 'woocommerce' ); ?> <span class="required">*</span></label>
        <select class="input-text" name="account_type" id="account_type" required>
            <option value="creator" <?php selected( $selected_value, 'creator' ); ?>><?php _e( 'Creator', 'woocommerce' ); ?></option>
            <option value="customer" <?php selected( $selected_value, 'customer' ); ?>><?php _e( 'Gifter', 'woocommerce' ); ?></option>
        </select>
    </p>
    <?php
}
add_action( 'woocommerce_register_form_start', 'charitious_theme_add_custom_registration_fields' );

// Update user role after registration.
function charitious_theme_update_user_role_after_registration( $user_id ) {
    if ( isset( $_POST['account_type'] ) ) {
        $account_type = sanitize_text_field( $_POST['account_type'] );

        // Determine role based on selected account type.
        $role = ( $account_type === 'creator' ) ? 'creator' : 'customer';

        // Assign role to user.
        $new_user_role = $role;

        // Update user role.
        $user = new WP_User( $user_id );
        $user->set_role( $new_user_role );
    }
}
add_action( 'woocommerce_created_customer', 'charitious_theme_update_user_role_after_registration' );

// Update user approve message
function charitious_theme_update_user_approve_message(){
    $sitename =  get_bloginfo( 'name' ); // get sitename.
    $message = __( 'You have been approved to access {sitename}.', 'woocommerce' ) . "\r\n\r\n";
    return $message;
}
add_filter( 'new_user_approve_approve_user_message_default', 'charitious_theme_update_user_approve_message' );

// Update admin subject message.
function charitious_theme_user_approve_subject(){
    $subject = sprintf( __( '[%s] Creator Approval', 'new-user-approve' ), wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ) );
    return $subject;
}
add_filter( 'new_user_approve_request_approval_subject', 'charitious_theme_user_approve_subject' );

// Update admin body message.
function charitious_theme_user_approve_message(){
    $message = __( 'Creator: {username}, Email: ({user_email}) has requested a email at {sitename}', 'new-user-approve' ) . "\n\n";
    $message .= "{site_url}\n\n";
    $message .= __( 'To approve or deny this user access to {sitename} go to', 'new-user-approve' ) . "\n\n";
    $message .= "{admin_approve_url}\n\n";

    return $message;
}
add_filter( 'new_user_approve_request_approval_message_default', 'charitious_theme_user_approve_message', 999 );

// Remove wp_authenticate_user filter from new_user_approve plugin.
$plugin_instance = pw_new_user_approve::instance(); // Plugin class name.
remove_filter( 'wp_authenticate_user', array( $plugin_instance, 'authenticate_user' ) );

// Allow users to log in regardless of approval status.
function charitious_theme_allow_login_for_unapproved_users( $user ) {
    if ( is_a( $user, 'WP_User' ) && ! is_wp_error( $user ) ) {
        // Check if the user is unapproved (status set by New User Approve plugin)
        $user_approved = get_user_meta( $user->ID, 'pw_user_status', true );

        if ( $user_approved !== 'approved' ) {
            update_user_meta( $user->ID, 'pw_user_status', 'approved' ); // Set by default user status to approve.
            // Allow user to log in regardless of approval status.
            return $user; // Return the user object without altering authentication
        }
    }
    return $user;
}
add_filter( 'wp_authenticate_user', 'charitious_theme_allow_login_for_unapproved_users', 100, 1 );

// Add custom required fields for account details update.
function charitious_theme_custom_add_account_details_required_fields($required_fields) {// Unset first name and last name from required fields.
    unset($required_fields['account_first_name']);
    unset($required_fields['account_last_name']);

    // Get the current URL
    $current_url = esc_url( add_query_arg( NULL, NULL ) );

    // Compare the URLs
    if ( $current_url === "/my-account/edit-password/" ) {
        unset($required_fields['account_display_name']);
        unset($required_fields['account_email']);
        unset($required_fields['giftlist_url']);
    } else {
        // Check if the current user has the role "creator".
        $current_user = wp_get_current_user();

        if ( in_array( 'creator', (array) $current_user->roles ) ) :
            // Add 'giftlist_url' as a required field
            $required_fields['giftlist_url'] = __('GiftList URL', 'woocommerce');
        endif;
    }

    return $required_fields;
}
add_filter('woocommerce_save_account_details_required_fields', 'charitious_theme_custom_add_account_details_required_fields');

// Validate user nicename.
function charitious_theme_validate_user_nicename($username) {
    // Allowed characters (alphanumeric, underscores, hyphens)
    $pattern = '/^[a-zA-Z0-9_-]+$/';
    if (!preg_match($pattern, $username)) {
        return false; // Nicename can only contain letters, numbers, underscores, and hyphens
    }

    // Sanitize the username
    $sanitized_nicename = sanitize_title_with_dashes($username);

    return $sanitized_nicename;
}

// Save custom fields data when user account details are saved.
function charitious_theme_save_custom_user_account_fields($user_id) {
    if (isset($_POST['save_account_details'])) {
        // Validate bio info field.
        $description = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';

        // Validate giftlist URL
        $giftlist_url = isset($_POST['giftlist_url']) ? sanitize_text_field($_POST['giftlist_url']) : '';

        // Validate twitter_link
        $twitter_link = isset($_POST['twitter_link']) ? wc_clean($_POST['twitter_link']) : '';

        // Validate instagram_link
        $instagram_link = isset($_POST['instagram_link']) ? wc_clean($_POST['instagram_link']) : '';
        
        // If there are no empty fields, update user meta
        if (!empty($description)) {
            update_user_meta($user_id, 'description', $description);
        } else{
            update_user_meta($user_id, 'description', $description);
        }

        if (!empty($giftlist_url)) {
            $current_user = wp_get_current_user();

            // Get user by nicename (user_nicename)
            $existing_user = get_user_by('slug', sanitize_title($giftlist_url));
            $login_username = get_user_by('login', sanitize_title($giftlist_url));

            // Check if another user already has the same username.
            if ((!$existing_user || $existing_user->ID == $current_user->ID) && (!$login_username || $login_username->ID == $current_user->ID)) {
                // Custom validation function.
                $sanitized_nicename = charitious_theme_validate_user_nicename($giftlist_url);
                if ($sanitized_nicename) {
                    // Update user meta with giftlist_url.
                    update_user_meta($user_id, 'giftlist_url', $sanitized_nicename);

                    // Update user nicename
                    wp_update_user(array(
                        'ID'           => $current_user->ID,
                        'user_nicename' => $sanitized_nicename,
                    ));                  
                } else {
                  // Handle invalid giftlist URL name
                  wc_add_notice(__('GiftList URL name can only contain letters, numbers, underscores, and hyphens.', 'woocommerce'), 'error');
                }
            } else {
                // Display error message if username already exists.
                wc_add_notice(__('GiftList URL name already exists. Please choose a different name.', 'woocommerce'), 'error');
            }
        }

        if (!empty($twitter_link)) {
            update_user_meta($user_id, 'twitter_link', $twitter_link);
        } else {
            update_user_meta($user_id, 'twitter_link', $twitter_link);
        }
        if (!empty($instagram_link)) {
            update_user_meta($user_id, 'instagram_link', $instagram_link);
        } else {
            update_user_meta($user_id, 'instagram_link', $instagram_link);
        }

        // Handle profile image upload and update user meta.
        if ( isset( $_FILES['profile_image'] ) && ! empty( $_FILES['profile_image']['name'] ) ) {
            $uploaded_image = $_FILES['profile_image'];

            // Check for upload errors using WP upload error codes
            if ( $uploaded_image['error'] !== 0 ) {
                // Handle error
                wc_add_notice( 'Error in uploading the image', 'error' );
            } else {
                // Validate image file size and extension
                $file_size = $uploaded_image['size'];
                $file_tmp = $uploaded_image['tmp_name'];
                $file_type = $uploaded_image['type'];

                // Get image file extension
                $file_extension = strtolower( pathinfo( $uploaded_image['name'], PATHINFO_EXTENSION ) );

                // Allowed file extensions
                $allowed_extensions = array( 'jpg', 'jpeg', 'png', 'webp' );

                // Maximum file size in bytes (5000KB)
                $max_file_size = 5000 * 1024;

                // Check if file extension is not allowed
                if ( ! in_array( $file_extension, $allowed_extensions ) ) {
                    wc_add_notice( 'Only image files (jpg, jpeg, png, webp) are allowed', 'error' );
                }

                // Check if file size exceeds maximum allowed size
                if ( $file_size > $max_file_size ) {
                    wc_add_notice( 'Maximum image file size allowed is 5MB', 'error' );
                }

                // If no errors, proceed with further processing.
                if ( empty( wc_get_notices( 'error' ) ) ) {
                   // Include required files
                   require_once( ABSPATH . 'wp-admin/includes/image.php' );
                   require_once( ABSPATH . 'wp-admin/includes/file.php' );
                   require_once( ABSPATH . 'wp-admin/includes/media.php' );

                   // Upload the image
                   $upload_dir = wp_upload_dir();
                   $uploadfile = $upload_dir['path'] . '/' . basename( $uploaded_image['name'] );
                   $movefile = move_uploaded_file( $uploaded_image['tmp_name'], $uploadfile );

                   if ( $movefile ) {
                       // Set image data
                       $wp_filetype = wp_check_filetype( basename( $uploadfile ), null );
                       $attachment = array(
                           'post_mime_type' => $wp_filetype['type'],
                           'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $uploadfile ) ),
                           'post_content' => '',
                           'post_status' => 'inherit'
                       );

                       // Add the image to the media library
                       $attach_id = wp_insert_attachment( $attachment, $uploadfile );
                       require_once( ABSPATH . 'wp-admin/includes/media.php' );
                       $attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
                       wp_update_attachment_metadata( $attach_id, $attach_data );

                       // Get the image URL
                       $image_url = wp_get_attachment_url( $attach_id );

                       // Update user meta with the uploaded image URL
                       update_user_meta( $user_id, 'profile_image', $image_url );

                       // echo 'Profile image uploaded and updated successfully!';
                   } else {
                       wc_add_notice( 'Error moving the uploaded file.', 'error' );
                   }
                }
            }            
        }

        // Check if there are no WooCommerce error notices
        if ( ! wc_notice_count( 'error' ) ) {
            // Get the current URL
            $current_url = esc_url( add_query_arg( NULL, NULL ) );

            // Compare the URLs
            if ( $current_url === "/my-account/edit-password/" ) {
                // Add success notice
                wc_add_notice( __( 'Password updated successfully.', 'woocommerce' ), 'success' );

                // Get the My Account page URL
                $my_account_url = wc_get_account_endpoint_url( 'edit-password' );

                // Redirect to the My Account page
                wp_safe_redirect( $my_account_url );
            } else {
                // Get the My Account page URL
                $my_account_url = wc_get_account_endpoint_url( 'my-account' );

                // Redirect to the My Account page
                wp_safe_redirect( $my_account_url );

                // Add success notice
                wc_add_notice( __( 'Profile details updated successfully.', 'woocommerce' ), 'success' );
            }

            exit;
        }
    }
}
add_action('woocommerce_save_account_details', 'charitious_theme_save_custom_user_account_fields', 10, 1);

// Display GiftList URL, Bank Account Country, and Display Name on My Account page
function display_account_details_on_account_page() {
    // Check if the current user has the role "creator".
    $current_user = wp_get_current_user();

    $user_id = get_current_user_id();
    $site_url = get_site_url();
    $giftlist_url = get_user_meta($user_id, 'giftlist_url', true);
    $description = get_user_meta($user_id, 'description', true);
    $twitter_link = get_user_meta($user_id, 'twitter_link', true);
    $instagram_link = get_user_meta($user_id, 'instagram_link', true);

    // Retrieve the user data to get the display name
    $user_data = get_userdata($user_id);
    $display_name = $user_data->display_name;

    if ( in_array( 'creator', (array) $current_user->roles ) ) {
        $total_gift = get_total_product_orders($user_id);
        $total_amount = get_total_product_orders_amount($user_id);
    } else {
        $total_gift = !empty(get_user_meta( $user_id, 'total_no_gift', true )) ? get_user_meta( $user_id, 'total_no_gift', true ) : "";
        $total_amount = !empty(get_user_meta( $user_id, 'total_amount', true )) ? get_user_meta( $user_id, 'total_amount', true ) : "";
    }
    
    $largest_amount = !empty(get_user_meta( $user_id, 'largest_amount', true )) ? get_user_meta( $user_id, 'largest_amount', true ) : "";
    $largest_amount_product_name = !empty(get_user_meta( $user_id, 'largest_amount_product_name', true )) ? get_user_meta( $user_id, 'largest_amount_product_name', true ) : "";

    $profile_image_url = get_user_meta( $user_id, 'profile_image', true );
    $attachment_id = attachment_url_to_postid( $profile_image_url ); 
    $placeholder_img_url = get_option('charitious_theme_profile_image_setting'); ?>

    <div class="dashboard-content">
        <div class="left-content">
            <?php if ( ! empty( $profile_image_url ) && ! empty( $attachment_id ) ) : ?>
                <a href="<?php echo esc_url( $profile_image_url ); ?>" target="_blank"><img src="<?php echo esc_url( $profile_image_url ); ?>" alt="<?php echo esc_attr( wp_unslash( $display_name ) ); ?>" width="100" height="100" /></a>
            <?php else: ?>
                <a href="<?php echo esc_url( $placeholder_img_url ); ?>" target="_blank"><img src="<?php echo esc_url( $placeholder_img_url ); ?>" alt="<?php echo esc_attr( wp_unslash( $display_name ) ); ?>" width="100" height="100" /></a>
            <?php endif;

            if (!empty($twitter_link)) {
                echo '<p><a href="' . esc_url($twitter_link) . '" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></p>';
            }

            if (!empty($instagram_link)) {
                echo '<p><a href="' . esc_url($instagram_link) . '" target="_blank"><i class="fa-brands fa-instagram"></i></a></p>';
            } 
            ?>
        </div>
        <div class="right-content">
        <?php
            // Get total amount
            if (!empty($total_amount)) {
                echo '<p><strong>Gifts Worth: </strong>' . get_woocommerce_currency_symbol() .''. esc_html( $total_amount ) . '</p>';
            }

            // Get total gift
            if (!empty($total_gift)) {
                echo '<p><strong>Total Gifts: </strong>' . esc_html( $total_gift ) . '</p>';
            }

            // Get largest amount
            if (!empty($largest_amount)) {
                echo '<p><strong>Largest amount: </strong>' . esc_html( $largest_amount_product_name ) . ' - ' . esc_html( $largest_amount ) . '</p>';
            }

            if (!empty($description)) {
                echo '<p>' . esc_html($description) . '</p>';
            }
        ?>
        </div>
    </div>
    <?php
    // Get My Account URL
    $my_account_url = wc_get_account_endpoint_url( 'edit-account' );

    // Output Edit Account button.
    echo '<p><a href="' . esc_url( $my_account_url ) . '" class="btn btn-primary">Edit Profile Details</a></p>';

    if ( in_array( 'creator', (array) $current_user->roles ) ) :
        get_template_part( 'template-parts/woo/add-gift' ); // add gift form
        get_template_part( 'template-parts/woo/giftlist' ); // Load template file for displaying GiftList
    endif;
}
add_action('woocommerce_account_dashboard', 'display_account_details_on_account_page');

// Register new endpoint for GiftList on my-acoount page.
function charitious_theme_custom_register_giftlist_endpoint() {
    // Check if the current user has the role "creator".
    $current_user = wp_get_current_user();

    if ( in_array( 'creator', (array) $current_user->roles ) ) :
        add_rewrite_endpoint( 'giftlist', EP_PAGES );
        add_rewrite_endpoint( 'gifts', EP_PAGES );
        add_rewrite_endpoint( 'payment-setup', EP_PAGES );
    endif;
    add_rewrite_endpoint( 'edit-password', EP_PAGES );
}
add_action( 'init', 'charitious_theme_custom_register_giftlist_endpoint' );

// Update my-account details.
function charitious_theme_custom_my_account_menu_items( $items ) {
    // Check if the current user has the role "creator"
    $current_user = wp_get_current_user();

    // Define the order of menu items.
    $new_items = array(
        'dashboard'   => __( 'Dashboard', 'woocommerce' ),
        'payment-setup'   => __( 'Setup Withdrawals', 'woocommerce' ),
        'giftlist'    => __( 'My GiftList', 'woocommerce' ),
        'gifts'      => __( 'Gifts Received', 'woocommerce' ),
        'orders'      => __( 'Orders', 'woocommerce' ),
        'edit-account' => __( 'Account Details', 'woocommerce' ),
        'edit-password' => __( 'Change Password', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),
    );

    $items['edit-account'] = 'My Profile'; // Rename the account detail tab.
    unset( $items['edit-address'] ); // Remove the address tab.
    unset( $items['downloads'] ); // Remove the Downloads tab.
    unset( $items['payment-methods'] ); // Remove the payment-method tab.

    if ( ! ( in_array( 'creator', (array) $current_user->roles ) ) ) :
        unset( $new_items['gifts'] ); // Remove the gifts tab.
        unset( $new_items['giftlist'] ); // Remove the GiftList tab.
        unset( $new_items['payment-setup'] ); // Remove the payment-setup tab.
    else :
        unset( $new_items['orders'] ); // Remove the orders tab.
        unset( $items['orders'] ); // Remove the orders tab.
    endif;

    // Merge new order with existing items, preserving keys
    $items = array_merge( $new_items, $items );

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'charitious_theme_custom_my_account_menu_items', 10, 1 );

// Display content for payment-setup endpoint.
function charitious_theme_custom_payment_setup_endpoint_content() {
    // Load template file for displaying giftlist
    get_template_part( 'template-parts/woo/payment-setup' );
}
add_action( 'woocommerce_account_payment-setup_endpoint', 'charitious_theme_custom_payment_setup_endpoint_content' );

// Display content for edit-password endpoint.
function charitious_theme_custom_edit_password() {
    // Load the template for the edit-password page
    get_template_part( 'template-parts/woo/edit-password' );
}
add_action( 'woocommerce_account_edit-password_endpoint', 'charitious_theme_custom_edit_password' );

// Display content for GiftList endpoint.
function charitious_theme_custom_giftlist_endpoint_content() {
    // Load template file for displaying giftlist
    get_template_part( 'template-parts/woo/giftlist' );
}
add_action( 'woocommerce_account_giftlist_endpoint', 'charitious_theme_custom_giftlist_endpoint_content' );

// Show signup/myaccount page WooCommerce.
function charitious_theme_custom_add_menu_item( $items, $args ) {
    $myaccount_page_url = get_permalink(get_option('woocommerce_myaccount_page_id')); // get myaccount page url.
    if( is_user_logged_in() ) {
        $myaccount_page_title = 'My Account';
    } else {
        $myaccount_page_title = 'Register Now';
    }
    if ( $args->theme_location == 'primary' ) {
        if( !is_user_logged_in() ) {
            // My account page login url
            $my_account_login = '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="' . $myaccount_page_url . '">Login</a></li>';
            $items .= $my_account_login;
        }
        // My account page url
        $my_account_item = '<li class="menu-item menu-item-type-custom menu-item-object-custom account-register"><a href="' . $myaccount_page_url . '">' . $myaccount_page_title . '</a></li>';
        $items .= $my_account_item;

        $current_user = wp_get_current_user();
        if ( ! in_array( 'creator', $current_user->roles ) ):
            // Cart page url, cart count
            $cart_count = WC()->cart->get_cart_contents_count();
            $cart_url = '<li class="menu-item menu-item-type-custom menu-item-object-custom nav-cart">';
            $cart_url .= '<a href="' . wc_get_cart_url() . '">';
            $cart_url .= '<i class="fa-solid fa-cart-shopping"></i>';
            $cart_url .= '<span class="cart-count">' . $cart_count . '</span>';
            $cart_url .= '</a></li>';
            $items .= $cart_url;
        endif;    
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'charitious_theme_custom_add_menu_item', 10, 2 );

// Add AJAX action for adding gift list item
function charitious_theme_add_gift_item() {
    // Security check (verify nonce)
    if ( !wp_verify_nonce( $_POST['add_gift_nonce'], 'add_gift_item' ) ) {
        die( 'Invalid nonce' );
    }

    // Get and sanitize user input
    $current_user = wp_get_current_user();
    $creator_name = get_the_author_meta( 'user_login', $current_user->ID );
    $gift_name = sanitize_text_field( $_POST['gift_name'] );
    $gift_desc = sanitize_textarea_field( $_POST['gift_desc'] );
    $gift_price = floatval( $_POST['gift_price'] );

    // Create gift product
    $product_id = wp_insert_post( array(
        'post_title'   => $gift_name,
        'post_name'   => $gift_name.'_'.$creator_name,
        'post_content' => $gift_desc,
        'post_type'    => 'product',
        'post_status'  => 'publish',
        'post_author'  => $current_user->ID, // Set current user as author
    ) );

    // Handle file upload for featured image
    if ( ! empty( $_FILES['gift_image']['name'] ) ) {
        // Include required files
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        // Handle file upload
        $uploaded_image = $_FILES['gift_image'];

        // Check for errors using WP upload error codes
        if ( $uploaded_image['error'] !== 0 ) {
            // Handle specific error based on the error code (refer to WordPress documentation)
            wp_send_json_error( 'Error in uploading the image.' );
            exit;
        }

        // Upload the image
        $upload_dir = wp_upload_dir();
        $uploadfile = $upload_dir['path'] . '/' . basename( $uploaded_image['name'] );
        $movefile = move_uploaded_file( $uploaded_image['tmp_name'], $uploadfile );

        if ( $movefile ) {
            // Set image data
            $wp_filetype = wp_check_filetype( basename( $uploadfile ), null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $uploadfile ) ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            // Add the image to the media library
            $attach_id = wp_insert_attachment( $attachment, $uploadfile );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // Set the image as featured image for the product
            set_post_thumbnail( $product_id, $attach_id );
        } else {
            wp_send_json_error( 'Error moving the uploaded file.' );
            exit;
        }
    }

    if ( ! is_wp_error( $product_id ) ) {
        // Set product price
        update_post_meta( $product_id, '_price', $gift_price );
        update_post_meta( $product_id, '_regular_price', $gift_price );

        // Set featured image if uploaded
        if ( ! is_wp_error( $image_attachment_id ) ) {
            set_post_thumbnail( $product_id, $image_attachment_id );
        }

        // Store product ID in user's meta data for giftlist
        $user_giftlist = get_user_meta( $current_user->ID, 'user_giftlist', true );
        if ( empty( $user_giftlist ) ) {
            $user_giftlist = array();
        }
        $user_giftlist[] = $product_id;
        update_user_meta( $current_user->ID, 'user_giftlist', $user_giftlist );
        
        // Success response
        wp_send_json_success( 'Gift item added successfully!' );
        exit;
    }
}
add_action( 'wp_ajax_add_gift_item_ajax', 'charitious_theme_add_gift_item' );
add_action( 'wp_ajax_nopriv_add_gift_item_ajax', 'charitious_theme_add_gift_item' );

// Add AJAX action for editing the gift list item
function charitious_theme_edit_gift_item() {
    // Security check (verify nonce)
    if ( !wp_verify_nonce( $_POST['edit_gift_nonce'], 'edit_gift_item' ) ) {
        die( 'Invalid nonce' );
    }

    // Get and sanitize user input
    $current_user = wp_get_current_user();
    $creator_name = get_the_author_meta( 'user_login', $current_user->ID );
    $product_id = sanitize_text_field( $_POST['product_id'] );
    $gift_name = sanitize_text_field( $_POST['gift_name'] );
    $gift_desc = sanitize_textarea_field( $_POST['gift_desc'] );
    $gift_price = floatval( $_POST['gift_price'] );

    // Update post data
    $post_data = array(
        'ID'           => $product_id,
        'post_title'   => $gift_name,
        'post_name'   => $gift_name."_".$creator_name,
        'post_content' => $gift_desc,
        'post_type'    => 'product',
        'post_status'  => 'publish',
    );

    // Update the post
    wp_update_post( $post_data );

    // Update gift price
    update_post_meta( $product_id, '_price', $gift_price );
    update_post_meta( $product_id, '_regular_price', $gift_price );

    // Handle file upload for featured image
    if ( isset( $_FILES['gift_image'] ) && ! empty( $_FILES['gift_image']['tmp_name'] ) ) {
        $file = $_FILES['gift_image'];
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attachment_id = media_handle_upload( 'gift_image', 0 );
        if ( is_wp_error( $attachment_id ) ) {
           wp_send_json_error( 'Error in uploading the image.' );
        } else {
           update_post_meta( $product_id, '_thumbnail_id', $attachment_id );
        }
    }

    // Return success message (optional)
    wp_send_json_success( 'Gift Item updated successfully!' );
    exit;
}
add_action( 'wp_ajax_edit_gift_item_ajax', 'charitious_theme_edit_gift_item' );
add_action( 'wp_ajax_nopriv_edit_gift_item_ajax', 'charitious_theme_edit_gift_item' );

// Add author support for product type.
function charitious_theme_add_author_support_to_products() {
    add_post_type_support( 'product', 'author' ); 
} 
add_action( 'init', 'charitious_theme_add_author_support_to_products' );

// Handler for delete gift item
function charitious_theme_delete_gift_item() {
    // Get data from POST request
    $action = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';
    $product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';

    if ( $action === 'delete_gift_item' ) {
        $current_user = wp_get_current_user();
        $user_giftlist = get_user_meta( $current_user->ID, 'user_giftlist', true );

        if ( $user_giftlist && is_array( $user_giftlist ) ) {
            $updated_giftlist = array_diff( $user_giftlist, array( $product_id ) );
            update_user_meta( $current_user->ID, 'user_giftlist', $updated_giftlist );

            // Delete product post from the database.
            wp_trash_post( $product_id ); // don't hard delete.

            wp_send_json_success( 'Gift item deleted successfully!' );
        }
    } else {
        wp_send_json_error( 'There was an error to delete the gift list item.' );
    }
}
add_action( 'wp_ajax_delete_gift_item', 'charitious_theme_delete_gift_item' );
add_action( 'wp_ajax_nopriv_delete_gift_item', 'charitious_theme_delete_gift_item' );


// Add custom column gift for customer only. (For Gifter)
function charitious_theme_gift_column_heading( $columns ) {
    // Check user role before adding the column
    if ( !current_user_can( 'creator' ) ) {
        $columns['gifts'] = __( 'Gifts', 'woocommerce' );
    }
    return $columns;
}
add_filter( 'woocommerce_account_orders_columns', 'charitious_theme_gift_column_heading' );

// Populate custom column with content (For Gifter)
function charitious_theme_custom_gifts_column_content( $order ) {
    // Check user role before displaying content (assuming 'customer' is a custom role)
    if ( !current_user_can( 'creator' ) ) {
        $creator_links = array();

        if ( ! $order ) {
            return;
        }

        // Loop through order items
        foreach ( $order->get_items() as $item ) {
            $product_id = $item->get_product_id();

            // Get the product post object
            $product_post = get_post( $product_id );

            // Get author ID using the post object
            $author_id = $product_post->post_author;

            // Validate creator ID and add link if exists
            if ( $author_id && user_can( $author_id, 'creator' ) ) {
                // Get author display name
                $author_name = get_the_author_meta( 'user_login', $author_id );

                // Get author giftlist url
                $author_giftlist_url = get_user_meta( $author_id, 'giftlist_url', true );

                // Get author profile URL
                $author_url = get_author_posts_url( $author_id );

                // Build author link
                $author_link = '<a href="' . esc_url( $author_url ) . '">' . "@" . esc_html( $author_giftlist_url ) . '</a>';

                // Add author link to array
                $creator_links[] = $author_link;
            }
        }

        // Filter out duplicate creator links
        $unique_creator_links = array_unique( $creator_links );

        // Display comma-separated list of unique creator links or "N/A" if none found
        if ( ! empty( $unique_creator_links ) ) {
            echo implode( ', ', $unique_creator_links );
        } else {
            echo __( 'N/A', 'woocommerce' ); // Display "N/A" if no creators found
        }
    }
}
add_action( 'woocommerce_my_account_my_orders_column_gifts', 'charitious_theme_custom_gifts_column_content' );

// Display content for Gifts endpoint. (For Gifter)
function charitious_theme_custom_gifts_endpoint_content() {
    // Load template file for displaying giftlist
    get_template_part( 'template-parts/woo/gifts' );
}
add_action( 'woocommerce_account_gifts_endpoint', 'charitious_theme_custom_gifts_endpoint_content' );

// Custome footer text of email template in WooCommerce
function charitious_theme_custom_email_footer_text( $default_text ) {
    return 'eGifter';
}
add_filter( 'woocommerce_email_footer_text', 'charitious_theme_custom_email_footer_text' );

// Add custom user meta fields for creator role.
function charitious_theme_custom_creator_user_profile_fields($user) {
    // Check if the current user has the 'creator' role
    if (in_array('creator', (array) $user->roles)) {
        get_template_part( 'template-parts/woo/admin-creator', null, array( 'user' => $user ) ); // Creator form at admin side.
    } else {
        get_template_part( 'template-parts/woo/admin-customer', null, array( 'user' => $user ) ); // Creator form at admin side.
    }
}
add_action('show_user_profile', 'charitious_theme_custom_creator_user_profile_fields');
add_action('edit_user_profile', 'charitious_theme_custom_creator_user_profile_fields');

// Save custom user meta fields for creator role
function charitious_theme_save_custom_creator_user_profile_fields($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        // Check if the current user has the 'creator' role
        $user = get_userdata($user_id);
        // Sanitize and update user meta fields
        if (isset($_POST['giftlist_url'])) {
            update_user_meta($user_id, 'giftlist_url', sanitize_text_field($_POST['giftlist_url']));
        }
        if (isset($_POST['twitter_link'])) {
            update_user_meta($user_id, 'twitter_link', sanitize_text_field($_POST['twitter_link']));
        }
        if (isset($_POST['instagram_link'])) {
            update_user_meta($user_id, 'instagram_link', sanitize_text_field($_POST['instagram_link']));
        }

        // Handle profile image upload and update user meta.
        if ( isset( $_FILES['profile_image'] ) && ! empty( $_FILES['profile_image']['name'] ) ) {
            $uploaded_image = $_FILES['profile_image'];

            // Check for upload errors using WP upload error codes
            if ( $uploaded_image['error'] !== 0 ) {
                // Handle error
                wc_add_notice( 'Error in uploading the image', 'error' );
            } else {
                // Validate image file size and extension
                $file_size = $uploaded_image['size'];
                $file_tmp = $uploaded_image['tmp_name'];
                $file_type = $uploaded_image['type'];

                // Get image file extension
                $file_extension = strtolower( pathinfo( $uploaded_image['name'], PATHINFO_EXTENSION ) );

                // Allowed file extensions
                $allowed_extensions = array( 'jpg', 'jpeg', 'png', 'webp' );

                // Maximum file size in bytes (5000KB)
                $max_file_size = 5000 * 1024;

                // Check if file extension is not allowed
                if ( ! in_array( $file_extension, $allowed_extensions ) ) {
                    wc_add_notice( 'Only image files (jpg, jpeg, png, webp) are allowed', 'error' );
                }

                // Check if file size exceeds maximum allowed size
                if ( $file_size > $max_file_size ) {
                    wc_add_notice( 'Maximum image file size allowed is 5MB', 'error' );
                }

                // If no errors, proceed with further processing.
                if ( empty( wc_get_notices( 'error' ) ) ) {
                    // Include required files
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );

                    // Upload the image
                    $upload_dir = wp_upload_dir();
                    $uploadfile = $upload_dir['path'] . '/' . basename( $uploaded_image['name'] );
                    $movefile = move_uploaded_file( $uploaded_image['tmp_name'], $uploadfile );

                    if ( $movefile ) {
                        // Set image data
                        $wp_filetype = wp_check_filetype( basename( $uploadfile ), null );
                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $uploadfile ) ),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        // Add the image to the media library
                        $attach_id = wp_insert_attachment( $attachment, $uploadfile );
                        require_once( ABSPATH . 'wp-admin/includes/media.php' );
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
                        wp_update_attachment_metadata( $attach_id, $attach_data );

                        // Get the image URL
                        $image_url = wp_get_attachment_url( $attach_id );

                        // Update user meta with the uploaded image URL
                        update_user_meta( $user_id, 'profile_image', $image_url );

                        // echo 'Profile image uploaded and updated successfully!';
                    } else {
                        wc_add_notice( 'Error moving the uploaded file.', 'error' );
                    }
                }
            }
        }
    }
}
add_action('personal_options_update', 'charitious_theme_save_custom_creator_user_profile_fields');
add_action('edit_user_profile_update', 'charitious_theme_save_custom_creator_user_profile_fields');

function charitious_theme_change_author_base() {
    global $wp_rewrite;
    $author_slug = 'giftlist';
    $wp_rewrite->author_base = $author_slug;
}
add_action('init', 'charitious_theme_change_author_base');

// Remove paragraph tags from Contact Form 7 form fields
add_filter('wpcf7_autop_or_not', '__return_false');

// Change WooCommerce minimum password length.
function charitious_theme_wc_password_strength_meter_settings( $args, $handle ) {
    if ( $handle === 'wc-password-strength-meter' ) {
        $args['min_password_strength'] = 3; // Set to 3 for at least 8 characters
    }
    return $args;
}
add_filter( 'woocommerce_get_script_data', 'charitious_theme_wc_password_strength_meter_settings', 20, 2 );

// Diable shop page, product and order detail page.
function charitious_theme_disable_product_order_detail_page() {
    if ( is_shop() ) {
        wp_redirect( home_url() ); // Redirect to home page
        exit;
    }
    if ( is_product() ) {
        wp_redirect( home_url() ); // Redirect to home page
        exit;
    }
    if ( is_wc_endpoint_url( 'view-order' ) ) {
        wp_redirect( home_url() ); // Redirect to home page
        exit;
    }
    if ( is_cart() || is_checkout() ) {
        $current_user = wp_get_current_user();
        if ( in_array( 'creator', $current_user->roles ) ):
            wp_redirect( home_url() ); // Redirect to home page
            exit;
        endif;
    }
}
add_action( 'template_redirect', 'charitious_theme_disable_product_order_detail_page' );

// Disbaled link for order number, remove action on my-account-orders page.
function custom_my_account_orders_columns( $columns ) {
    // Remove the "view" column
    unset( $columns['order-actions'] );

    // Modify the "order" column to display only the order number without a link
    $columns['order-number'] = __( 'Order Number', 'woocommerce' );

    // Display purchased product.
    $columns['order-products'] = __( 'Purchased Gifts', 'woocommerce' );

    return $columns;
}
add_filter( 'woocommerce_account_orders_columns', 'custom_my_account_orders_columns' );

// Show order column data.
function charitious_theme_myaccount_order_column( $order ) {
    echo $order->get_order_number();
}
add_action( 'woocommerce_my_account_my_orders_column_order-number', 'charitious_theme_myaccount_order_column' );

// show product column data.
function charitious_theme_myaccount_product_column( $order ) {
    $product_names = array(); // Initialize an empty array to store product names

    if ( ! $order ) {
        return;
    }

    foreach ( $order->get_items() as $item_id => $item ) {
      $product = $item->get_product();
      $product_names[] = $product->get_name(); // Add product name to the array
    }

    // Add commas and handle last item
    $product_string = implode(', ', $product_names);
    $product_string = rtrim($product_string, ', '); // Remove comma from the last item

    echo $product_string . '<br>';
}
add_action( 'woocommerce_my_account_my_orders_column_order-products', 'charitious_theme_myaccount_product_column' );

// Automatically change order status to "Complete" after successful checkout.
function charitious_theme_auto_complete_orders( $order_id ) {
    // Get the order object.
    $order = wc_get_order( $order_id );

    if ( ! $order ) {
        return;
    }

    // Check if the order status is not already "Complete".
    if ( $order && ! $order->has_status( 'completed' ) ) {
        // Change the order status to "Complete"
        $order->update_status( 'completed' );
    }

    // Loop through order items.
    if($order->has_status( 'completed' )) {
        foreach ( $order->get_items() as $item ) {
            // Get product data
            $product_id = $item->get_product_id();
            $product = wc_get_product( $product_id );

            // Get author of the product
            $author_id = get_post_field( 'post_author', $product_id );

            // Check if the author has the "creator" role
            $author_role = get_userdata( $author_id )->roles;
            if ( in_array( 'creator', $author_role, true ) ) {
                // Get existing user meta for total gifts and total amount
                $total_gifts = (int) get_user_meta( $author_id, 'total_no_gift', true );
                $total_amount = (float) get_user_meta( $author_id, 'total_amount', true );

                // Calculate new total gifts and total amount
                $new_gifts = $total_gifts + $item->get_quantity();
                $new_amount = $total_amount + ( $product->get_price() * $item->get_quantity() );

                // Update user meta
                update_user_meta( $author_id, 'total_no_gift', $new_gifts );
                update_user_meta( $author_id, 'total_amount', $new_amount );
            } 

            $user_id = get_current_user_id();
            if ( !empty( $user_id ) ) {
                $customer_role = get_userdata( $user_id )->roles;
                if ( !in_array( 'creator', $customer_role, true ) ) {
                    // Get existing user meta for total gifts and total amount
                    $total_gifts = (int) get_user_meta( $user_id, 'total_no_gift', true );
                    $total_amount = (float) get_user_meta( $user_id, 'total_amount', true );
                    $largest_amount = (float) get_user_meta($user_id, 'largest_amount', true);

                    // Calculate new total gifts and total amount
                    $new_gifts = $total_gifts + $item->get_quantity();
                    $new_amount = $total_amount + ($product->get_price() * $item->get_quantity());

                    // Update largest amount if the current purchase is larger
                    $current_purchase_amount = $product->get_price() * $item->get_quantity();
                    $current_product_name = $product->get_name();
                    if ($current_purchase_amount > $largest_amount) {
                        update_user_meta( $user_id, 'largest_amount', $current_purchase_amount );
                        update_user_meta($user_id, 'largest_amount_product_name', $current_product_name);
                    }

                    // Update user meta
                    update_user_meta( $user_id, 'total_no_gift', $new_gifts );
                    update_user_meta( $user_id, 'total_amount', $new_amount );
                }
            } else {
                // Check if it's a guest order or not
                $from_email = $order->get_meta('from_email');

                if ( ! empty( $from_email ) ) {
                    $user = get_user_by( 'email', $from_email );

                    if ( $user ) {
                        // Existing user
                        $user_id = $user->ID;
                        // Get existing user meta for total gifts and total amount
                        $total_gifts = (int) get_user_meta( $user_id, 'total_no_gift', true );
                        $total_amount = (float) get_user_meta( $user_id, 'total_amount', true );
                        $largest_amount = (float) get_user_meta($user_id, 'largest_amount', true);

                        // Calculate new total gifts and total amount
                        $new_gifts = $total_gifts + $item->get_quantity();
                        $new_amount = $total_amount + ($product->get_price() * $item->get_quantity());

                        // Update largest amount if the current purchase is larger
                        $current_purchase_amount = $product->get_price() * $item->get_quantity();
                        $current_product_name = $product->get_name();
                        if ($current_purchase_amount > $largest_amount) {
                            update_user_meta( $user_id, 'largest_amount', $current_purchase_amount );
                            update_user_meta($user_id, 'largest_amount_product_name', $current_product_name);
                        }

                        // Update user meta
                        update_user_meta( $user_id, 'total_no_gift', $new_gifts );
                        update_user_meta( $user_id, 'total_amount', $new_amount );
                    } else {
                        // Guest customer
                        $user_id = md5($from_email);

                        $total_gifts = (int) get_user_meta( $user_id, 'total_no_gift', true );
                        $total_amount = (float) get_user_meta( $user_id, 'total_amount', true );
                        $largest_amount = (float) get_user_meta($user_id, 'largest_amount', true);

                        // Calculate new total gifts and total amount
                        $new_gifts = $total_gifts + $item->get_quantity();
                        $new_amount = $total_amount + ($product->get_price() * $item->get_quantity());

                        // Update largest amount if the current purchase is larger
                        $current_purchase_amount = $product->get_price() * $item->get_quantity();
                        $current_product_name = $product->get_name();
                        if ($current_purchase_amount > $largest_amount) {
                            update_user_meta( $user_id, 'largest_amount', $current_purchase_amount );
                            update_user_meta($user_id, 'largest_amount_product_name', $current_product_name);
                        }

                        // Update user meta
                        update_user_meta( $user_id, 'total_no_gift', $new_gifts );
                        update_user_meta( $user_id, 'total_amount', $new_amount );
                    }
                }
            }
        }
    }
}
add_action( 'woocommerce_thankyou', 'charitious_theme_auto_complete_orders', 10, 1 );

function charitious_theme_check_giftlist_url() {
    $giftlist_url = $_POST['giftlist_url'];

    if (!empty($giftlist_url)) {
        $current_user = wp_get_current_user();

        // Get user by nicename (user_nicename)
        $existing_user = get_user_by('slug', sanitize_title($giftlist_url));
        $login_username = get_user_by('login', sanitize_title($giftlist_url));

        // Check if another user already has the same username.
        if ((!$existing_user || $existing_user->ID === $current_user->ID) && (!$login_username || $login_username->ID === $current_user->ID)) {
            // Custom validation function.
            $sanitized_nicename = charitious_theme_validate_user_nicename($giftlist_url);
            if ($sanitized_nicename) {
                // Update user meta with giftlist_url.
                update_user_meta($user_id, 'giftlist_url', $sanitized_nicename);

                // Update user nicename
                wp_update_user(array(
                    'ID'           => $current_user->ID,
                    'user_nicename' => $sanitized_nicename,
                ));

                wp_send_json_success( 'Valid name' );
            } else {
                // Handle invalid giftlist URL name
                wp_send_json_error( 'GiftList URL name can only contain letters, numbers, underscores, and hyphens.' );
            }
        } else {
            // Display error message if username already exists.
            wp_send_json_error( 'GiftList URL name already exists. Please choose a different name.' );
        }
    }
    wp_die();
}
add_action('wp_ajax_check_giftlist_url', 'charitious_theme_check_giftlist_url');
add_action('wp_ajax_nopriv_check_giftlist_url', 'charitious_theme_check_giftlist_url');

// Function to handle AJAX request for loading more creators.
function charitious_theme_load_more_creators() {
    // Get the current page
    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $searchQuery = isset($_POST['search_query']) ? sanitize_text_field($_POST['search_query']) : '';
    $period = isset($_POST['period']) ? sanitize_text_field($_POST['period']) : '';

    // Define the arguments for WP_User_Query to fetch creators
    $per_page = get_theme_mod('theme_ppp_setting', 10); // Default to 10 if not set - Number of creators per page

    $offset = ( $paged - 1 ) * $per_page; // offset
    $counter = $offset;

    // Soritng active users
    $args = array();
    $args = array(
        'role'     => 'creator', // Filter users by role.
        'meta_query'   => array(
            'relation' => 'AND',
            array(
                'key'     => 'pw_user_status',
                'value'   => 'approved',
                'compare' => '='
            ),
            array(
                'key'     => 'user_giftlist',
                'value'   => 'a:0:{}',
                'compare' => '!=',  // Ensure the 'user_giftlist' is not an empty array
            ),
            array(
                'key'     => 'giftlist_url',
                'value'   => '',
                'compare' => '!=',
            ),
            array(
                'key'     => 'creator_stripe_account_id',
                'value'   => '',
                'compare' => '!=',
            ),
            array(
                'key'     => 'creator_stripe_account_link',
                'value'   => '',
                'compare' => '!=',
            )
        )
    );

    // Initialize an array to store creators and their product order counts.
    $users_with_orders = array();

    // Query the users
    $users_query = new WP_User_Query( $args );
    $users = $users_query->get_results();

    // Loop through the fetched users
    foreach ($users as $user) {
        // Count the total number of product orders each user received within the specified period
        $total_product_orders = get_total_product_orders($user->ID);

        // Store the user ID and their total product order count in the array
        $users_with_orders[$user->ID] = $total_product_orders;
    }

    // Sort the users array based on the total product order count in descending order
    arsort($users_with_orders);

    // Extract the sorted user IDs
    $sorted_user_ids = array_keys($users_with_orders);

    // Query parameter.
    $args['orderby'] = "include";
    $args['order'] = "ASC";
    $args['include'] = $sorted_user_ids;

    $args['number'] = $per_page;
    $args['offset'] = $offset;

    // Search creator parameter.
    if($searchQuery && !empty($searchQuery)) {
        $args['search'] = '*' . $searchQuery . '*';
        $args['search_columns'] = array('giftlist_url');
        $args['offset'] = $offset;
    }

    // Query the users
    $users_query = new WP_User_Query( $args );
    $users = $users_query->get_results();

    // Prepare the HTML for displaying users
    ob_start();
    if ( $users ) {
        foreach ( $users as $user ) { ?>
            <tr onclick="window.location='<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>'">
                <td><?php echo "#" . esc_html( ++$counter ); ?></td>
                <td>
                    <div>
                        <?php
                        // Get profile image URL.
                        $profile_image_url = get_user_meta($user->ID, 'profile_image', true);
                        $attachment_id = attachment_url_to_postid( $profile_image_url );
                        if (!empty($profile_image_url) && !empty($attachment_id)) : ?>
                            <a href="javascript:void(0);"><img src="<?php echo esc_url($profile_image_url); ?>" alt="<?php echo esc_html( $user->display_name ); ?>" class="img-fluid" /></a>
                        <?php else:
                            $placeholder_img = get_option('charitious_theme_profile_image_setting'); // placeholder image ?>
                            <a href="javascript:void(0);"><img src="<?php echo esc_url($placeholder_img); ?>" alt="<?php echo esc_html( $user->display_name ); ?>" class="img-fluid" /></a>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p><?php echo esc_html( $user->display_name ); ?></p>
                        <?php
                        // Get wisher url
                        $giftlist_url = !empty(get_user_meta( $user->ID, 'giftlist_url', true )) ? get_user_meta( $user->ID, 'giftlist_url', true ) : $user->user_nicename;
                        ?>
                        <a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
                            <?php echo "@" . esc_html( $giftlist_url ); ?>
                        </a>    
                    </div>
                </td>
                <!-- <td> -->
                    <!-- <p style="width: 100%"> -->
                        <?php
                            // Get gift according to order duration.
                            // $total_gift = $users_with_orders[$user->ID];
                            // echo esc_html( $total_gift ) . " gifts";
                        ?>
                    <!-- </p> -->
                <!-- </td> -->
            </tr>
        <?php
        }
    } else { ?>
        <p>No Creators Found.</p>
    <?php
    }
    $users_html = ob_get_clean();

    // Pagination
    $pagination_html = '';
    $total_users = $users_query->get_total(); // Total number of users
    $total_pages = ceil( ( $total_users ) / $per_page ); // Total number of pages

    if ( $total_pages > 1 ) {
        $pagination_html .= '<div class="pagination justify-content-center" data-current-page="' . $paged . '" data-total-pages="' . $total_pages . '">';
        if ( $paged > 1 ) {
            $pagination_html .= '<li class="page-item"><a class="page-link creator-page" href="' . get_pagenum_link( $paged - 1 ) . '" data-page="' . ( $paged - 1 ) . '"><i class="fa fa-solid fa-chevron-left"></i></a></li>';
        } else {
            $pagination_html .= '<li class="page-item"><span class="page-link disabled"><i class="fa fa-solid fa-chevron-left"></i></span></li>';
        }
        for ( $i = 1; $i <= $total_pages; $i++ ) {
            $pagination_html .= '<li class="page-item ' . ( $paged === $i ? 'active' : '' ) . '"><a class="page-link creator-page" href="' . get_pagenum_link( $i ) . '" data-page="' . $i . '">' . $i . '</a></li>';
        }
        if ( $paged < $total_pages ) {
            $pagination_html .= '<li class="page-item"><a class="page-link creator-page" href="' . get_pagenum_link( $paged + 1 ) . '" data-page="' . ( $paged + 1 ) . '"><i class="fa fa-solid fa-chevron-right"></i></a></li>';
        } else {
            $pagination_html .= '<li class="page-item"><span class="page-link disabled"><i class="fa fa-solid fa-chevron-right"></i></span></li>';
        }
        $pagination_html .= '</div>';
    }

    // Send JSON response
    wp_send_json( array(
        'users' => $users_html,
        'pagination' => $pagination_html,
    ) );
    wp_die();
}
add_action( 'wp_ajax_load_more_creators', 'charitious_theme_load_more_creators' );
add_action( 'wp_ajax_nopriv_load_more_creators', 'charitious_theme_load_more_creators' );

// Get the total number of product orders for a creator within the specified period.
function get_total_product_orders($user_id) {
    // Initialize total product orders count
    $total_product_orders = 0;

    // WooCommerce orders to count product orders for the user within the specified period
    $args = array(
        'post_type'      => 'shop_order',
        'posts_per_page' => -1,
        'post_status'    => 'wc-completed', // Get all order statuses
    );

    $orders = new WP_Query($args);

    // Count the number of orders for the creator.
    if ($orders->have_posts()) {
        while ($orders->have_posts()) {
            $orders->the_post();
            $order = wc_get_order(get_the_ID());
            if ( $order instanceof WC_Order ) {
                // Count the number of products in the order
                foreach ($order->get_items() as $item_id => $item) {
                    $product = $item->get_product(); // Get product object
                    $product_id = $item->get_product_id(); // Get product ID

                    // Get the product post object
                    $product_post = get_post( $product_id );

                    // Get the product author ID using the post object
                    $product_author_id = intval( $product_post->post_author );

                    if ( $product_author_id === $user_id ) {
                         $total_product_orders += $item->get_quantity(); // Increment total gift count
                         // continue;
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    return $total_product_orders;
}

// Get the total number of product orders for a creator within the specified period.
function get_total_product_orders_amount($user_id) {
    // Initialize total product orders count
    $total_product_orders = 0;

    // WooCommerce orders to count product orders for the user within the specified period
    $args = array(
        'post_type'      => 'shop_order',
        'posts_per_page' => -1,
        'post_status'    => 'wc-completed', // Get all order statuses
    );

    $orders = new WP_Query($args);

    // Count the number of orders for the creator.
    if ($orders->have_posts()) {
        while ($orders->have_posts()) {
            $orders->the_post();
            $order = wc_get_order(get_the_ID());
            if ( $order instanceof WC_Order ) {
                // Count the number of products in the order
                foreach ($order->get_items() as $item_id => $item) {
                    $product = $item->get_product(); // Get product object
                    $product_id = $item->get_product_id(); // Get product ID

                    // Get the product post object
                    $product_post = get_post( $product_id );

                    // Get the product author ID using the post object
                    $product_author_id = intval( $product_post->post_author );

                    if ( $product_author_id === $user_id ) {
                         // $total_product_orders += $item->get_quantity(); // Increment total gift count
                         $total_product_orders += $product->get_price() * $item->get_quantity();
                         // continue;
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    return $total_product_orders;
}

// Show product list on product detail page.
function charitious_theme_update_product_list() {
    $selected_sort = sanitize_text_field( $_POST['sort'] );
    $author_id = intval( $_POST['author_id'] );
    $current_user = wp_get_current_user();

    $args = array(
        'post_type' => 'product',
        'author' => $author_id,
        'posts_per_page' => -1, // Show all products (adjust if needed)
        'orderby' => $selected_sort, // Use selected sorting option
        'order' => 'DESC', // Default descending order for most options
    );

    // Adjust order for price sorting
    if ( in_array( $selected_sort, array( 'price-desc', 'price' ) ) ) {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_price';
        $args['order'] = ( $selected_sort === 'price' ) ? 'ASC' : 'DESC';
    } else if($selected_sort === "date_asc") {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    $author_products = new WP_Query( $args );
    $custom_class = (in_array('creator', $current_user->roles)) ? "no-pointer" : "";

    ob_start();
    $output = '';
    while ( $author_products->have_posts() ) : $author_products->the_post(); ?>
        <div class="col-6 col-lg-4 mb-5 <?php echo $custom_class; ?>">
            <div class="product-item">
                <div data-toggle="modal" data-target="#product-details-modal-<?php echo get_the_ID(); ?>">
                <?php
                    if ( has_post_thumbnail(get_the_ID()) ) {
                        // Get the URL of the post thumbnail
                        $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), '' );

                        // Check if the thumbnail URL is not empty
                        if ( ! empty( $thumbnail_url ) ) {
                            // Output the image tag
                            echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid" />';
                        }
                    } else {
                        // Display placeholder image if featured image is not available
                        $placeholder_img = get_option('charitious_theme_image_setting'); // placeholder image ?>
                        <img src="<?php echo $placeholder_img; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" />
                    <?php }
                    $title = get_the_title();
                    if ( ! empty( $title ) ) {
                        echo '<h3 class="mt-3">' . esc_html( $title ) . '</h3>';
                    }
                    global $product;
                    $price = $product->get_price_html();
                    if ( ! empty( $price ) ) {
                        echo '<p class="product-price">' . $price . '</p>';
                    }
                     ?>
                </div>
                <?php
                    if ( ! in_array( 'creator', $current_user->roles ) ):
                        echo '<i class="copy-link-btn fa fa-link fa-1x" data-product-id="' . get_the_ID() . '"></i>';
                    endif;
                ?>
            </div>
            <?php if ( ! in_array( 'creator', $current_user->roles ) ): ?>
            <div class="modal fade" id="product-details-modal-<?php echo get_the_ID(); ?>" tabindex="-1" aria-labelledby="product-details-modal-label" aria-hidden="true" style="margin-top: 300px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addGiftModalLabel">Add To Cart</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                                if ( has_post_thumbnail(get_the_ID()) ) {
                                    // Get the URL of the post thumbnail
                                    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), '' );

                                    // Check if the thumbnail URL is not empty
                                    if ( ! empty( $thumbnail_url ) ) {
                                        // Output the image tag
                                        echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid" />';
                                    }
                                } else {
                                    // Display placeholder image if featured image is not available
                                    $placeholder_img = get_option('charitious_theme_image_setting'); // placeholder image ?>
                                    <img src="<?php echo $placeholder_img; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" />
                                <?php }
                                $title = get_the_title();
                                if ( ! empty( $title ) ) {
                                    echo '<h3 class="mt-3">' . esc_html( $title ) . '</h3>';
                                }
                                global $product;
                                $price = $product->get_price_html();
                                if ( ! empty( $price ) ) {
                                    echo '<p class="product-price">' . $price . '</p>';
                                }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary add-to-cart-keep-shopping-btn" id="add-to-cart-keep-shopping-btn" data-product-id="<?php echo get_the_ID(); ?>">Add To Cart And Keep Shopping</button>
                            <button type="button" class="btn btn-primary add-to-cart-checkout-btn" id="add-to-cart-checkout-btn" data-product-id="<?php echo get_the_ID(); ?>">Add To Cart And Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php
    endwhile;
    $products_html = ob_get_clean();

    wp_reset_postdata(); // Reset post data

    // Send JSON response
    wp_send_json( array(
        'data' => $products_html,
    ) );
    wp_die();
}
add_action( 'wp_ajax_update_product_list', 'charitious_theme_update_product_list' );
add_action( 'wp_ajax_nopriv_update_product_list', 'charitious_theme_update_product_list' ); // Allow non-logged-in users

// Allow SVG upload.
function charitious_theme_add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}
add_filter('upload_mimes', 'charitious_theme_add_file_types_to_uploads');

function charitious_theme_get_product_details(){
    // Retrieve product ID from AJAX request
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

        // Check if the product ID is valid
        if ($product_id > 0) {
            // Get product object based on product ID
            $product = wc_get_product($product_id);

            // Check if the product exists
            if ($product) {
                // Get product title
                $product_title = $product->get_name();

                // Get featured image URL
                $featured_image_url = get_the_post_thumbnail_url( $product_id, '' );

                // Get product price
                $product_price = $product->get_price_html(); 

                ob_start();
                ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="addGiftModalLabel">Add To Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                        if ( has_post_thumbnail($product_id) ) {
                            // Get the URL of the post thumbnail
                            $thumbnail_url = get_the_post_thumbnail_url( $product_id, '' );

                            // Check if the thumbnail URL is not empty
                            if ( ! empty( $thumbnail_url ) ) {
                                // Output the image tag
                                echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid" />';
                            }
                        } else {
                            // Display placeholder image if featured image is not available
                            $placeholder_img = get_option('charitious_theme_image_setting'); // placeholder image ?>
                            <img src="<?php echo $placeholder_img; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" />
                        <?php }
                        if ( ! empty( $product_title ) ) {
                            echo '<h3 class="mt-3">' . esc_html( $product_title ) . '</h3>';
                        }
                        if ( ! empty( $product_price ) ) {
                            echo '<p class="product-price">' . $product_price . '</p>';
                        }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary add-to-cart-keep-shopping-btn" id="add-to-cart-keep-shopping-btn" data-product-id="<?php echo $product_id; ?>">Add To Cart And Keep Shopping</button>
                    <button type="button" class="btn btn-primary add-to-cart-checkout-btn" id="add-to-cart-checkout-btn" data-product-id="<?php echo $product_id; ?>">Add To Cart And Checkout</button>
                </div>

                <?php
                $products_html = ob_get_clean();

                // Send product details as the AJAX response
                wp_send_json_success($products_html);
            } else {
                // Product not found
                wp_send_json_error('Gifts not found.');
            }
        } else {
            // Invalid product ID
            wp_send_json_error('Invalid gift ID.');
        }
}
add_action( 'wp_ajax_get_product_details', 'charitious_theme_get_product_details' );
add_action( 'wp_ajax_nopriv_get_product_details', 'charitious_theme_get_product_details' ); // Allow non-logged-in users

// Using AJAX add-to-cart product item.
function charitious_theme_add_product_to_cart() {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($product_id > 0) {
        $existing_author_id = null;

        // Check if any products in the cart already have an author
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            $existing_author_id = get_post_field( 'post_author', $cart_item['data']->get_id() );

            if ( $existing_author_id ) {
                break;
            }
        }

        // If there's an existing author and the new product has a different author, prevent adding
        if ( $existing_author_id && $existing_author_id !== get_post_field( 'post_author', $product_id ) ) {
            wp_send_json_error( [ 'message' => 'You can only add gift from one creator to the cart.' ] );
        }

        // Add the product to the cart (only if author matches or no author in cart yet)
        WC()->cart->add_to_cart($product_id);

        // Get cart count
        $cart_count = WC()->cart->get_cart_contents_count();

        // Return success response with cart count.
        wp_send_json_success( [ 'message' => 'Gift Item added to the cart.', 'cart_count' => $cart_count ] );
    } else {
        // Return error response
        wp_send_json_error('Invalid gift ID.');
    }

    wp_die(); // Exit after sending the response
}
add_action('wp_ajax_add_product_to_cart', 'charitious_theme_add_product_to_cart');
add_action('wp_ajax_nopriv_add_product_to_cart', 'charitious_theme_add_product_to_cart');

// Add custom fields to cart and checkout pages
function charitious_theme_add_custom_fields_to_checkout() {
    // Get values filled on the cart page
    $from_name = WC()->session->get('from_name');

    // Add from and Email Address fields with the values filled on the cart page
    echo '<div class="email-fields">';
        woocommerce_form_field('from_name', array(
            'type' => 'text',
            'class' => array('email-form-row form-row-wide'),
            'label' => __('Nick Name', 'woocommerce'),
            'placeholder' => __('Enter Name', 'woocommerce'),
            'default' => $from_name, // Set default value
            'required' => true, // Make field required
        ), $from_name); // Pass value as the third argument
    echo '</div>';
}
add_action('woocommerce_after_order_notes', 'charitious_theme_add_custom_fields_to_checkout');

// Checkout Process - add the custom email validation
function charitious_theme_validate_custom_checkout_emails() {
    $custom_errors = array();

    // Validate the 'Nick Name' field
    if (empty($_POST['from_name'])) {
        $custom_errors[] = __('<strong>Nick Name</strong> is a required field.', 'woocommerce');
    }

    // Add custom errors to WooCommerce notices array after all other messages
    if (!empty($custom_errors)) {
        foreach ($custom_errors as $error) {
            wc_add_notice($error, 'error');
        }
    }
}
add_action('woocommerce_checkout_process', 'charitious_theme_validate_custom_checkout_emails');

// Save custom fields when order is placed
function charitious_theme_save_custom_fields_on_checkout($order_id) {
    $from_name = isset($_POST['from_name']) ? sanitize_text_field($_POST['from_name']) : '';

    // Save values in session to pass them to the checkout page
    WC()->session->set('from_name', $from_name);

    $order = wc_get_order($order_id); // Get the WC_Order object

    // Get order items
    $items = $order->get_items();
    
    foreach ( $items as $item ) {
        $product = $item->get_product();
        $author_id = $product->post->post_author;
        $author_email = get_the_author_meta( 'user_email', $author_id );
    }

    if ($order) {
        $order->update_meta_data("from_name", $from_name);
        $order->update_meta_data("creator_email", $author_email);
        $order->save(); // Save the updated order data
    }
}
add_action('woocommerce_checkout_update_order_meta', 'charitious_theme_save_custom_fields_on_checkout');

// Display custom fields on the order edit page.
function charitious_theme_display_custom_fields_on_order_edit_page($order) {
    echo '<p><strong>' . __('Nick Name') . ':</strong> ' . get_post_meta($order->id, 'from_name', true) . '</p>';
    echo '<p><strong>' . __('Creator Email') . ':</strong> ' . get_post_meta($order->id, 'creator_email', true) . '</p>';
}
add_action('woocommerce_admin_order_data_after_billing_address', 'charitious_theme_display_custom_fields_on_order_edit_page');

// Add admin menu - commission management
function charitious_theme_custom_checkout_charge_menu() {
    add_menu_page(
        'Commission management',
        'Commission management',
        'manage_options',
        'custom-checkout-charge',
        'charitious_theme_custom_checkout_charge_page',
        'dashicons-money',
        56
    );
}
add_action('admin_menu', 'charitious_theme_custom_checkout_charge_menu');

// Display admin settings page
function charitious_theme_custom_checkout_charge_page() {
    ?>
    <div class="wrap">
        <h2>Commission management</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('custom_checkout_charge_settings');
            do_settings_sections('custom_checkout_charge_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define admin settings
function charitious_theme_custom_checkout_charge_init() {
    register_setting('custom_checkout_charge_settings', 'custom_checkout_charge_settings', 'charitious_theme_custom_checkout_charge_validate');

    add_settings_section('custom_checkout_charge_main', 'Commission Management', 'charitious_theme_custom_checkout_charge_section_text', 'custom_checkout_charge_settings');

    add_settings_field('custom_checkout_charge_type', 'Fee Type', 'charitious_theme_custom_checkout_charge_type_setting', 'custom_checkout_charge_settings', 'custom_checkout_charge_main');
    add_settings_field('custom_checkout_charge_value', 'Platform Fee', 'charitious_theme_custom_checkout_charge_value_setting', 'custom_checkout_charge_settings', 'custom_checkout_charge_main');
}
add_action('admin_init', 'charitious_theme_custom_checkout_charge_init');

// Section text
function charitious_theme_custom_checkout_charge_section_text() {
    echo '<p>Set fee for gifter during checkout.</p>';
}

// Charge type setting
function charitious_theme_custom_checkout_charge_type_setting() {
    $options = get_option('custom_checkout_charge_settings');
    $type = isset($options['type']) ? $options['type'] : 'percentage';
    ?>
    <select name="custom_checkout_charge_settings[type]">
        <option value="percentage" <?php selected('percentage', $type); ?>>Percentage</option>
        <option value="amount" <?php selected('amount', $type); ?>>Amount</option>
    </select>
    <?php
}

// Charge value setting
function charitious_theme_custom_checkout_charge_value_setting() {
    $options = get_option('custom_checkout_charge_settings');
    $value = isset($options['value']) ? $options['value'] : '';
    ?>
    <input type="text" name="custom_checkout_charge_settings[value]" value="<?php echo esc_attr($value); ?>" />
    <?php
}

// Validation callback
function charitious_theme_custom_checkout_charge_validate($input) {
    $valid_input = array();

    // Validate charge type
    if (isset($input['type'])) {
        $valid_input['type'] = sanitize_text_field($input['type']);
    }

    // Validate charge value
    if (isset($input['value'])) {
        $valid_input['value'] = floatval($input['value']);
    }

    return $valid_input;
}

// Apply additional charge during purchase the item.
function charitious_theme_custom_checkout_apply_charge( $cart ) {
  if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
    return;
  }

  $options = get_option( 'custom_checkout_charge_settings' );

  $type = isset( $options['type'] ) ? $options['type'] : 'percentage';
  $value = isset( $options['value'] ) ? $options['value'] : 0;

  if ( $type === 'percentage' ) {
    $charge = $cart->subtotal * ( $value / 100 );
    $charge_label = sprintf( __( 'Fees + Taxes', 'woocommerce' ), $value );
  } else {
    $charge = $value;   
    $charge_label = __('Fees + Taxes', 'woocommerce');
  }

  // Add charge fee with label
  $cart->add_fee( $charge_label, $charge );
}
add_action( 'woocommerce_cart_calculate_fees', 'charitious_theme_custom_checkout_apply_charge' );

// Disable coupon field in cart and checkout pages
function charitious_theme_disable_coupon_field($enabled) {
    if (is_cart() || is_checkout()) {
        $enabled = false;
    }
    return $enabled;
}
add_filter('woocommerce_coupons_enabled', 'charitious_theme_disable_coupon_field');

// Remove billing and shipping fields from checkout page.
function charitious_theme_remove_checkout_fields($fields) {
    // Update placeholder - billing email
    $fields['billing']['billing_email']['placeholder'] = 'Private';

    // Remove all billing fields except email
    $allowed_fields = array( 'billing_email' );

    foreach ( $fields['billing'] as $key => $field ) {
        if ( !in_array( $key, $allowed_fields ) ) {
            unset( $fields['billing'][$key] );
        }
    }
    unset( $fields['shipping'] ); // Remove shipping fields
    unset( $fields['order'] ); // Remove order fields
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'charitious_theme_remove_checkout_fields');

// Hide billing and shippping from admin backend
function charitious_theme_hide_shipping_billing( $show_fields ) {
    unset( $show_fields['shipping'] );
    unset( $show_fields['billing'] );
    return $show_fields;
}
add_filter( 'woocommerce_customer_meta_fields', 'charitious_theme_hide_shipping_billing' );

// Creating a user column
function charitious_theme_modify_user_table( $columns ) {
    // Remove the 'Name' column
    unset($columns['name']);
    $new_columns = array();
    // Loop through the existing columns and add them to the new_columns array
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        // Add the Display Name column after the Email column
        if ($key === 'email') {
            $new_columns['display_name'] = 'Display Name';
        }
    }
    $new_columns[ 'registration_date' ] = 'Registration date'; // add new column
    return $new_columns;
}
add_filter( 'manage_users_columns', 'charitious_theme_modify_user_table' );

// Fill user column with registration dates.
function charitious_theme_modify_user_table_row( $row_output, $column_id_attr, $user ) {
    $date_format = 'j M, Y H:i';
    switch( $column_id_attr ) {
        case 'display_name' : {
            $user = get_userdata( $user );
            return $user->display_name;
            break;
        }
        case 'registration_date' : {
            return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
            break;
        }
        default : {
            break;
        }
    }
    return $row_output;
}
add_filter( 'manage_users_custom_column', 'charitious_theme_modify_user_table_row', 10, 3 );

// Make "Registration date" column sortable.
function charitious_theme_make_registered_column_sortable( $columns ) {
    return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}
add_filter( 'manage_users_sortable_columns', 'charitious_theme_make_registered_column_sortable' );

// Enable content editor for FAQ post type
function charitious_theme_enable_content_editor_faq() {
    add_post_type_support( 'faq', 'editor' );
}
add_action( 'init', 'charitious_theme_enable_content_editor_faq' );

// Enable t&c checkbox on checkout page.
add_filter( 'woocommerce_checkout_show_terms', '__return_true' );

// Add product author's email as a recipient for new order email.
function add_product_author_email_as_recipient( $recipient, $order ) {
    // Check if $order is a valid object
    if ( ! is_a( $order, 'WC_Order' ) ) {
        return $recipient;
    }

    // Get order items
    $items = $order->get_items();
    
    foreach ( $items as $item ) {
        $product = $item->get_product();
        $author_id = $product->post->post_author;
        $author_email = get_the_author_meta( 'user_email', $author_id );
        
        // Add product author's email as a recipient
        $recipient .= ', ' . $author_email;
    }
    
    return $recipient;
}
add_filter( 'woocommerce_email_recipient_new_order', 'add_product_author_email_as_recipient', 10, 2 );

// Fetch order data of creators.
function charitious_theme_filter_orders() {
    // Get selected time range from AJAX request
    $range = $_POST['range'];

    // Get the current user
    $current_user = wp_get_current_user();
    $counter = 1;

    ob_start();
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
            $order_args = array(
              'status' => array('completed'),
              'limit' => -1,
              'orderby' => 'date',
              'order' => 'DESC',
            );

            // Modify order arguments based on the selected filter
            switch ($range) {
                case 'Day':
                    $order_args['date_before'] = date('Y-m-d', strtotime('tomorrow'));
                    $order_args['date_after'] = date('Y-m-d');
                    break;
                case 'Week':
                    $order_args['date_before'] = date('Y-m-d');
                    $order_args['date_after'] = date('Y-m-d', strtotime('-6 days'));
                    break;
                case 'Month':
                    $order_args['date_before'] = date('Y-m-d');
                    $order_args['date_after'] = date('Y-m-d', strtotime('-29 days'));
                    break;
                case 'Year':
                    $order_args['date_before'] = date('Y-m-d');
                    $order_args['date_after'] = date('Y-m-d', strtotime('-364 days'));
                    break;
            }

            // Get orders based on the filtered arguments
            $orders = wc_get_orders($order_args);

            if ( $orders && !empty($orders) ) {
                $show_table_heading = false;
                $row_count = 1;
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
            } else {
                echo '<p>No orders found for your giftlist.</p>';
            }
        }
    }     
    $html = ob_get_clean();   

    // Send JSON response
    wp_send_json( array(
        'order_data' => $html,
    ) );
    wp_die();
}
add_action('wp_ajax_filter_orders', 'charitious_theme_filter_orders');
add_action('wp_ajax_nopriv_filter_orders', 'charitious_theme_filter_orders');

// Customize the login, lost password error message to mention only the email address.
function charitious_theme_custom_wc_login_lost_password_error_messages($translated_text, $text, $domain) {
    if ($domain === 'woocommerce' && $text === 'Invalid username or email.') {
        $translated_text = __('Invalid email address.', 'woocommerce');
    }
    if ($text === 'Unknown email address. Check again or try your username.') {
        $translated_text = __('Unknown email address. Check again.', 'woocommerce');
    }
    if ($text === 'Lost password') {
        $translated_text = __('Forgot Password', 'woocommerce');
    }
    if ($text === 'Lost your password?') {
        $translated_text = __('Forgot your password?', 'woocommerce');
    }
    return $translated_text;
}
add_filter('gettext', 'charitious_theme_custom_wc_login_lost_password_error_messages', 10, 3);

function charitious_theme_customize_register($wp_customize) {
    // Add a section for the control posts_per_page on leaderboard for creators.
    $wp_customize->add_section('theme_ppp_section', array(
        'title' => __('Active Users - Creators List', 'woocommerce'), // Section title
        'priority' => 30, // Section priority
    ));

    // Add a setting for the number input
    $wp_customize->add_setting('theme_ppp_setting', array(
        'default' => 10,
        'type' => 'theme_mod', // Type of the setting
        'capability' => 'edit_theme_options', // Capability required to edit this setting
        'sanitize_callback' => 'absint', // Sanitization callback to ensure the value is an integer
    ));

    // Add a control to the Customizer
    $wp_customize->add_control('theme_ppp_number_control', array(
        'label' => __('Number of creators on the list', 'woocommerce'), // Label for the control
        'section' => 'theme_ppp_section', // Section to add the control to
        'settings' => 'theme_ppp_setting', // Associated setting
        'type' => 'number', // Control type
        'input_attrs' => array(
            'min' => 1, // Minimum value
            'max' => 100, // Maximum value
            'step' => 1, // Step value
        ),
    ));

    // Add a setting for the image upload for wishlist placeholder.
    $wp_customize->add_setting('charitious_theme_image_setting', array(
        'default'           => '',
        'type' => 'theme_mod', // Type of the setting
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'giftlist_image_upload', array(
        'label'    => __('Gift Placeholder Image', 'woocommerce'),
        'section'  => 'theme_ppp_section',
        'settings' => 'charitious_theme_image_setting',
    )));

    // Add a setting for the image upload for creator/fan placeholder.
    $wp_customize->add_setting('charitious_theme_profile_image_setting', array(
        'default'           => '',
        'type' => 'theme_mod', // Type of the setting
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'creator_image_upload', array(
        'label'    => __('Creator Placeholder Image', 'woocommerce'),
        'section'  => 'theme_ppp_section',
        'settings' => 'charitious_theme_profile_image_setting',
    )));

    // Add setting for Stripe secret key
    $wp_customize->add_setting('stripe_secret_key', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    // Add control for Stripe secret key
    $wp_customize->add_control('stripe_secret_key_control', array(
        'label' => __('Stripe Secret Key', 'woocommerce'),
        'section' => 'theme_ppp_section',
        'settings' => 'stripe_secret_key',
        'type' => 'text',
    ));
}
add_action('customize_register', 'charitious_theme_customize_register');

function charitious_theme_custom_fields_in_new_order_email( $order, $sent_to_admin, $plain_text, $email ) {
    // Remove the order details table (with items ordered, quantity and prices).
    remove_action( 'woocommerce_email_order_details', array( WC()->mailer(), 'order_details' ), 10, 4 );
    // Remove order meta
    remove_action( 'woocommerce_email_order_meta', array( WC()->mailer(), 'order_meta' ), 20, 4 ); 
    // Remove customer addresses (billing and shipping).
    remove_action( 'woocommerce_email_customer_details', array(  WC()->mailer(), 'email_addresses' ), 20, 3 );
}
add_action( 'woocommerce_email_order_details', 'charitious_theme_custom_fields_in_new_order_email', 5, 4 );

// Disable message on footer.
function charitious_theme_disable_mobile_messaging( $mailer ) {
    remove_action( 'woocommerce_email_footer', array( $mailer->emails['WC_Email_New_Order'], 'mobile_messaging' ), 9 );
}
add_action( 'woocommerce_email', 'charitious_theme_disable_mobile_messaging' );

// Change return_to_shop text on shop page.
function charitious_theme_return_to_shop_text( $default_text ) {
    $new_text = 'RETURN TO LEADERBOARD';
    return $new_text;
}
// add_filter( 'woocommerce_return_to_shop_text', 'charitious_theme_return_to_shop_text' );

// Redirect to the customer leaderboard page if the cart is empty
function charitious_theme_return_to_shop_redirect() {
    if (WC()->cart->is_empty()) {
        $leaderboard_page_url = get_permalink( get_page_by_path( 'active-users' ) );
        return $leaderboard_page_url;
    }
}
// add_filter('woocommerce_return_to_shop_redirect', 'charitious_theme_return_to_shop_redirect');

// Remove product permalink from the order table
add_filter( 'woocommerce_order_item_permalink', '__return_false' );

// Actions for handling product trashing and restoration for creators.
function update_giftlist_on_trash_product( $post_id ) {
    if (get_post_type($post_id) !== 'product') {
        return;
    }

    // Get the product post object
    $product_post = get_post( $post_id );

    // Get author ID using the post object
    $author_id = $product_post->post_author;

    $user_giftlist = get_user_meta( $author_id, 'user_giftlist', true );

    // Convert to array if not already
    $user_giftlist = (array) $user_giftlist;

    // Remove product ID from gift list if author's list
    if ( in_array( $post_id, $user_giftlist ) ) {
        $key = array_search( $post_id, $user_giftlist );
        unset( $user_giftlist[$key] );

        // Update user meta with the modified gift list
        update_user_meta( $author_id, 'user_giftlist', array_values( $user_giftlist ) );
    }
}
add_action( 'trashed_post', 'update_giftlist_on_trash_product', 10, 1 );

function update_giftlist_on_restore_product( $post_id ) {
    if (get_post_type($post_id) !== 'product') {
        return;
    }

    // Get the product post object
    $product_post = get_post( $post_id );

    // Get author ID using the post object
    $author_id = $product_post->post_author;

    $user_giftlist = get_user_meta( $author_id, 'user_giftlist', true );

    // Convert to array if not already
    $user_giftlist = (array) $user_giftlist;

    // Add product ID back to gift list if author's list (if not already present)
    if ( ! in_array( $post_id, $user_giftlist ) ) {
        $user_giftlist[] = $post_id;

        // Update user meta with the modified gift list
        update_user_meta( $author_id, 'user_giftlist', $user_giftlist );
    }
}
add_action( 'untrashed_post', 'update_giftlist_on_restore_product', 10, 1 );

function remove_billing_keyword_error( $error ) {
    if ( strpos( $error, 'Billing ' ) !== false ) {
        $error = str_replace("Billing ", "", $error);
    }
    if ( strpos( $error, 'billing ' ) !== false ) {
        $error = str_replace("billing ", "", $error);
    }
    return $error;
}
add_filter( 'woocommerce_add_error', 'remove_billing_keyword_error' );

// Add class on body tag for pages.
function add_terms_of_service_class( $classes ) {
    if ( is_page('terms-of-service') ) {
        $classes[] = 'terms-of-service';
    }
    return $classes;
}
add_filter( 'body_class', 'add_terms_of_service_class' );

// Step 1: Create the Admin Menu Page (Gift Details)
function create_gift_details_menu() {
    add_menu_page(
        'Gift Details', // Page Title
        'Gift Details', // Menu Text
        'manage_options', // Capability (admins only)
        'gift-details', // Unique menu slug
        'charitious_theme_render_gift_details_page', // Callback function
        'dashicons-heart',
        57
    );
}
add_action( 'admin_menu', 'create_gift_details_menu' );
add_action( 'admin_init', 'charitious_save_gift_details' );

// Step 2: Enqueue Scripts and Styles
function charitious_enqueue_admin_scripts() {
    wp_enqueue_script('charitious-admin-script', get_stylesheet_directory_uri() . '/assets/js/admin-script.js', array('jquery'), time(), true);
    wp_enqueue_style('charitious-admin-style', get_stylesheet_directory_uri() . '/assets/css/admin-style.css', array(), time());
}
add_action('admin_enqueue_scripts', 'charitious_enqueue_admin_scripts');

// Step 3: Render the Admin Page
function charitious_theme_render_gift_details_page() { ?>
    <div class="wrap">
        <h1><?php esc_html_e('Gift Details', 'charitious'); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field('charitious_save_gift_details', 'charitious_gift_details_nonce'); ?>
            <div id="charitious-gift-details-container">
                <?php
                $gift_details = get_option('charitious_gift_details', array());
                if (!empty($gift_details)) {
                    foreach ($gift_details as $detail) {
                        ?>
                        <div class="charitious-gift-detail-row">
                            <input type="text" name="charitious_gift_details[]" value="<?php echo esc_attr($detail); ?>" class="regular-text charitious-gift-detail-input">
                            <button type="button" class="button charitious-remove-gift-detail">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="charitious-add-gift-detail">Add Gift</button>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Step 4: Save and Retrieve Data
function charitious_save_gift_details() {
    if (isset($_POST['charitious_gift_details_nonce']) && wp_verify_nonce($_POST['charitious_gift_details_nonce'], 'charitious_save_gift_details')) {
        if (isset($_POST['charitious_gift_details'])) {
            $gift_details = array_filter(array_map('sanitize_text_field', $_POST['charitious_gift_details']));
            update_option('charitious_gift_details', $gift_details);
        } else {
            delete_option('charitious_gift_details');
        }
    }
}

// Function to get the cart-count for cart page.
function charitious_theme_get_cart_count() {
    $cart_count = WC()->cart->get_cart_contents_count();
    wp_send_json_success(['cart_count' => $cart_count]);
}
add_action('wp_ajax_get_cart_count', 'charitious_theme_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'charitious_theme_get_cart_count');

// Creator/gifter profile image delete functionality.
function charitious_theme_profile_image_delete(){
    // Check for required actions and nonces
    if ( ! empty( $_POST['action'] ) && $_POST['action'] === 'profile_image_delete' ) {
        // Get current user id
        $user_id = get_current_user_id();

        // Get the profile image URL from user meta
        $profile_image_url = get_user_meta($user_id, 'profile_image', true);

        if (!empty($profile_image_url)) {
            // Get the attachment ID from the URL
            $attachment_id = attachment_url_to_postid( $profile_image_url );

            if ($attachment_id) {
                // Delete the attachment from the media library
                $deleted = wp_delete_attachment($attachment_id, true);

                if ($deleted) {
                    // Delete the profile image URL from user meta
                    delete_user_meta($user_id, 'profile_image');
                    wp_send_json_success(array('message' => __('Profile image deleted successfully.', 'woocommerce')));
                } else {
                    wp_send_json_error(array('message' => __('Failed to delete profile image. Please try again later.', 'woocommerce')));
                }
            } else {
                wp_send_json_error(array('message' => __('Attachment ID not found.', 'woocommerce')));
            }
        } else {
            wp_send_json_error(array('message' => __('No profile image found.', 'woocommerce')));
        }
    } else {
        // Handle invalid requests or missing nonces
        wp_send_json_error( array( 'message' => 'An error occurred. Please try again later.' ) );
    }
    exit;
}
add_action('wp_ajax_profile_image_delete', 'charitious_theme_profile_image_delete');
add_action('wp_ajax_nopriv_profile_image_delete', 'charitious_theme_profile_image_delete');

// Get Stripe Account ID by User Email
function get_stripe_account_id_by_email($email) {
    $user = get_user_by('email', $email);
    if ($user) {
        return get_user_meta($user->ID, 'creator_stripe_account_id', true);
    }
    return null;
}

// Creator stripe account setup
function charitious_theme_stripe_account_setup() {
    // Get data from POST request
    $action = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';
    $selectedValue = isset( $_POST['selectedValue'] ) ? sanitize_text_field( $_POST['selectedValue'] ) : '';

    if($action === "stripe_account_setup"){
        // If we have access to /vendor/autoload.php then initialize it.
        require_once(ABSPATH . 'vendor/autoload.php');

        // Retrieve the Stripe secret key from the theme mod
        $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

        // Set up Stripe client
        if(!empty($stripe_secret_key)){
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
        }

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $user_email = $current_user->user_email;
        update_user_meta($user_id, 'nsfw_creator', $selectedValue);

        try {
            // Check if the user already has a Stripe account
            $stripe_account_id = get_stripe_account_id_by_email($user_email);

            if (!$stripe_account_id) {
                // Create a connected account
                $account = $stripe->accounts->create([
                    'type' => 'express',
                    'country' => "GB",
                    'default_currency' => 'gbp',
                    'email' => $user_email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                    'business_type' => 'individual',
                       'individual' => [
                       'email' => $user_email,
                    ],
                ]);

                // Save the Stripe account ID to user meta
                update_user_meta($user_id, 'creator_stripe_account_id', $account->id);
                $stripe_account_id = $account->id;
            }
            $site_url = get_site_url();

            // Create an account link
            $accountLink = $stripe->accountLinks->create([
                'account' => $stripe_account_id,
                'refresh_url' => $site_url . '/my-account/payment-setup/', // URL to redirect to if the user needs to refresh the onboarding
                'return_url' => $site_url . '/my-account/payment-setup/', // URL to redirect to after the user completes the onboarding
                'type' => 'account_onboarding',
            ]);

            // Save the Stripe account link
            update_user_meta($user_id, 'creator_stripe_account_link', $accountLink->url);

            wp_send_json_success([
                'message' => 'Connect account link created successfully.', 
                'account_url' => $accountLink->url,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API error
            wp_send_json_error( 'Error creating account: ' . $e->getMessage() );
        } catch (Exception $e) {
            // Handle other errors
            wp_send_json_error( 'Error: ' . $e->getMessage() );
        }
    }
    wp_die();
}
add_action('wp_ajax_stripe_account_setup', 'charitious_theme_stripe_account_setup');
add_action('wp_ajax_nopriv_stripe_account_setup', 'charitious_theme_stripe_account_setup');

// Handle the AJAX request to finish Stripe setup.
function charitious_theme_finish_stripe_setup() {
    // Get data from POST request
    $action = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';

    if($action === "finish_stripe_setup"){
        // If we have access to /vendor/autoload.php then initialize it.
        require_once(ABSPATH . 'vendor/autoload.php');

        // Retrieve the Stripe secret key from the theme mod
        $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

        // Set up Stripe client
        if(!empty($stripe_secret_key)){
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
        }

        $current_user = wp_get_current_user(); // get current user
        $user_id = $current_user->ID;
        $user_email = $current_user->user_email;

        $stripe_account_id = get_user_meta($user_id, 'creator_stripe_account_id', true);
        $site_url = get_site_url();

        if (!$stripe_account_id) {
            wp_send_json_error(array('message' => __('No Stripe account found for this user.', 'woocommerce')));
        }

        try {
            // Retrieve the account from Stripe
            $account = $stripe->accounts->retrieve($stripe_account_id, []);

            // Check if the account setup is complete
            if ($account->requirements->currently_due || $account->requirements->past_due) {
                // Create a new account link to complete the setup
                $accountLink = $stripe->accountLinks->create([
                    'account' => $stripe_account_id,
                    'refresh_url' => $site_url . '/my-account/payment-setup/', // URL to redirect to if the user needs to refresh the onboarding
                    'return_url' => $site_url . '/my-account/payment-setup/', // URL to redirect to after the user completes the onboarding
                    'type' => 'account_onboarding',
                ]);

                // Save the Stripe account link
                update_user_meta($user_id, 'creator_stripe_account_link', $accountLink->url);

                wp_send_json_success(array('url' => $accountLink->url));
            } else {
                wp_send_json_success(array('message' => __('Your Stripe account setup is already complete.', 'woocommerce')));
            }

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API error
            wp_send_json_error(array('message' => $e->getMessage()));
        } catch (Exception $e) {
            // Handle other errors
            wp_send_json_error(array('message' => $e->getMessage()));
        }
    }
    wp_die();
}
add_action('wp_ajax_finish_stripe_setup', 'charitious_theme_finish_stripe_setup');
add_action('wp_ajax_nopriv_finish_stripe_setup', 'charitious_theme_finish_stripe_setup');

// Handle the AJAX request to delete Stripe account.
function charitious_theme_delete_stripe_account() {
    // Get data from POST request
    $action = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';

    if($action === "delete_stripe_account"){
        // If we have access to /vendor/autoload.php then initialize it.
        require_once(ABSPATH . 'vendor/autoload.php');

        // Retrieve the Stripe secret key from the theme mod
        $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

        // Set up Stripe client
        if(!empty($stripe_secret_key)){
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
        }

        $current_user = wp_get_current_user(); // get current user
        $user_id = $current_user->ID;
        $user_email = $current_user->user_email;

        $stripe_account_id = get_user_meta($user_id, 'creator_stripe_account_id', true);
        $site_url = get_site_url();

        if (!$stripe_account_id) {
            wp_send_json_error(array('message' => __('No Stripe account found for this user.', 'woocommerce')));
        }

        try {
            // Delete the account from Stripe
            $stripe->accounts->delete($stripe_account_id, []);

            // Remove the Stripe account ID from user meta
            delete_user_meta($user_id, 'creator_stripe_account_id');
            delete_user_meta($user_id, 'creator_stripe_account_link');

            wp_send_json_success();

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API error
            wp_send_json_error(array('message' => $e->getMessage()));
        } catch (Exception $e) {
            // Handle other errors
            wp_send_json_error(array('message' => $e->getMessage()));
        } 
    }
    wp_die();
}
add_action('wp_ajax_delete_stripe_account', 'charitious_theme_delete_stripe_account');
add_action('wp_ajax_nopriv_delete_stripe_account', 'charitious_theme_delete_stripe_account');

// Make test payment to stripe connect user (creators)
function charitious_theme_make_payment_to_vendor() {
    // Retrieve necessary data from AJAX request
    $vendor_stripe_account_id = "acct_1PP1xcPpRowrOgwB56113132";
    $vendor_amount = 0.5;

    // If we have access to /vendor/autoload.php then initialize it.
    require_once(ABSPATH . 'vendor/autoload.php');

    // Retrieve the Stripe secret key from the theme mod
    $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

    // Set up Stripe client
    if(!empty($stripe_secret_key)){
        $stripe = new \Stripe\StripeClient($stripe_secret_key);
    }

    // Perform the transfer and handle exceptions
    try {
        // Assuming you have a dynamic currency variable $currency_value
        $currency_value = $stripe->accounts->retrieve($vendor_stripe_account_id)->default_currency;

        // Create a Transfer to the creator's Stripe account.
        // $vendor_transfer = $stripe->transfers->create([
        //     'amount' => $vendor_amount * 100,
        //     'currency' => $currency_value,
        //     'destination' => $vendor_stripe_account_id,
        // ]);

        // Create a Transfer to the main stripe account and creator's stripe account.
        $total_amount = 976 * 100;
        $subtotal_amount = 888 * 100;
        $admin_amount = $total_amount - $subtotal_amount;  
              
        // Create a PaymentIntent
        $payment_intent = $stripe->paymentIntents->create([
           'amount' => $total_amount,
           'currency' => $currency_value,
           'payment_method_types' => ['card'],
           'application_fee_amount' => $admin_amount,
           'transfer_data' => [
               'destination' => $vendor_stripe_account_id,
           ],
        ]);

        // Confirm the PaymentIntent
        $payment_intent = $stripe->paymentIntents->confirm(
           $payment_intent->id,
           ['payment_method' => 'pm_card_visa'] // The payment method should be dynamically determined in a real application
        );

        echo 'Payment transferred successfully. Payment ID: ' . $payment_intent->id;
       
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle Stripe API errors
        echo 'Error in transferring payment to vendor: ' . $e->getMessage();
    } catch (Exception $e) {
        // Handle other errors
        echo 'Error in transferring payment to vendor: ' . $e->getMessage();
    }

    // Always exit to avoid further execution
    wp_die();
}
add_action('wp_ajax_make_payment_to_vendor', 'charitious_theme_make_payment_to_vendor');
add_action('wp_ajax_nopriv_make_payment_to_vendor', 'charitious_theme_make_payment_to_vendor');

// Customize stripe payment_intent to split payment to main stripe account and connect user.
function customize_stripe_payment_intent_request($payment_request, $order, $prepared_source) {
    // Load the Stripe PHP library
    require_once(ABSPATH . 'vendor/autoload.php');

    // Retrieve the Stripe secret key from the theme mod
    $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

    // Set up Stripe client
    if (!empty($stripe_secret_key)) {
        $stripe = new \Stripe\StripeClient($stripe_secret_key);
    }

    // Get total amount and currency
    $total_amount = $order->get_total() * 100; // Stripe expects the amount in cents
    $subtotal_amount = $order->get_subtotal() * 100; // Stripe expects the amount in cents
    $currency_value = strtolower($order->get_currency()); // Stripe expects lowercase currency codes

    // Assume we have a function to get the vendor Stripe account ID
    $vendor_stripe_account_id = get_vendor_stripe_account_id_from_order($order);

    // Calculate admin fee (10% of subtotal amount)
    $admin_amount = intval($total_amount - $subtotal_amount);

    if ($vendor_stripe_account_id) {
        // Override the default payment request
        $payment_request['amount'] = $total_amount;
        $payment_request['currency'] = $currency_value;
        $payment_request['payment_method_types'] = ['card'];
        $payment_request['application_fee_amount'] = $admin_amount;
        $payment_request['transfer_data'] = [
            'destination' => $vendor_stripe_account_id,
        ];

        // Add metadata to PaymentIntent if needed
        $payment_request['metadata'] = array_merge($payment_request['metadata'], [
            'creator_email' => get_post_meta($order->get_id(), 'creator_email', true),
            'creator_amount' => $subtotal_amount,
        ]);

        return $payment_request;
    }
    return $payment_request;
}
add_filter('wc_stripe_generate_create_intent_request', 'customize_stripe_payment_intent_request', 10, 3);

function get_vendor_stripe_account_id_from_order($order) {
    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        $author_id = get_post_field('post_author', $product_id);
        $vendor_stripe_account_id = get_user_meta($author_id, 'creator_stripe_account_id', true);
        if ($vendor_stripe_account_id) {
            return $vendor_stripe_account_id;
        }
    }
    return null;
}

// Disable new user approve/deny email.
add_filter('nua_disable_welcome_email', function($disable, $user_id) {
    return true;
}, 10, 2);
