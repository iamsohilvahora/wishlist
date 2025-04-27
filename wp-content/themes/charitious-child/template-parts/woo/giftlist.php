<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// If we have access to /vendor/autoload.php then initialize it.
require_once(ABSPATH . 'vendor/autoload.php');

// Retrieve the Stripe secret key from the theme mod
$stripe_secret_key = get_theme_mod('stripe_secret_key', '');

$current_user = wp_get_current_user();
$user_id = $current_user->ID; // get current user id.

// Set up Stripe client
if(!empty($stripe_secret_key)){
    $stripe = new \Stripe\StripeClient($stripe_secret_key);
}

$stripe_account_id = get_user_meta($user_id, 'creator_stripe_account_id', true);

if (!empty($stripe_account_id) && !empty($stripe_secret_key)) {
    // Retrieve the account from Stripe
    try {
        $account = $stripe->accounts->retrieve($stripe_account_id, []);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $has_error = true;
        $error_msg = $e->getMessage();
    }
}

$user_giftlist = get_user_meta( $user_id, 'user_giftlist', true );
$placeholder_img = get_option('charitious_theme_image_setting'); // placeholder image

// Validate giftlist URL
$giftlist_url = !empty(get_user_meta($user_id, 'giftlist_url', true )) ? get_user_meta($user_id, 'giftlist_url', true ) : "";

// Validate twitter_link
$twitter_link = !empty(get_user_meta($user_id, 'twitter_link', true )) ? get_user_meta($user_id, 'twitter_link', true ) : "";

$my_account_url = wc_get_account_endpoint_url( 'edit-account' );

if(!empty($giftlist_url) && !empty($stripe_account_id) && !($account->requirements->currently_due || $account->requirements->past_due) && !$has_error) { ?>
    <p class="add-gift">
        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addGiftModal">
            Add Gift <i class="fa-solid fa-plus"></i>
        </button>
    </p>
<?php } else { 
    if($has_error) {
        echo ' <p style="margin-top: 100px;" class="no-giftlist">' . $error_msg . '</p>';
    }
    else {
    ?>
    <p class="add-gift">
        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#showGiftModal">
            Add Gift <i class="fa-solid fa-plus"></i>
        </button>
    </p>
    <div class="modal fade" id="showGiftModal" tabindex="-1" aria-labelledby="showGiftModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showGiftModalLabel">eGifter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Kindly complete your Profile Details & Setup Withdrawal Account to start creating your Giftlist.</p>
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
<?php } }

get_template_part( 'template-parts/woo/add-gift' ); // add gift form
if ( $user_giftlist && is_array( $user_giftlist ) ) : ?>
    <div class="row">
    <?php
    foreach ( $user_giftlist as $product_id ) :
        $product = wc_get_product( $product_id );
        if ( $product ) : ?>
            <div class="col-6 col-lg-4 mb-5">
                <div class="card">
                    <div class="card-img-top">
                        <?php
                        // Check for featured image and display it if available
                        if ( has_post_thumbnail( $product->get_id() ) ) :
                            $thumbnail_url = get_the_post_thumbnail_url( $product->get_id(), '' ); // Get URL for any image size
                            ?>
                            <a href="<?php echo $thumbnail_url; ?>" target="_blank">
                                <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_the_title( $product->get_id() ); ?>" class="img-fluid" />
                            </a>
                        <?php else :
                            // Display placeholder image if featured image is not available ?>
                            <a href="<?php echo $placeholder_img; ?>" target="_blank">
                                <img src="<?php echo $placeholder_img; ?>" alt="<?php echo get_the_title( $product->get_id() ); ?>" class="img-fluid" />
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a> <?php echo $product->get_name(); ?></a>
                        </h5>
                         <p class="card-text"><?php echo $product->get_price_html(); ?></p>
                        <form id="edit-product-form-<?php echo $product_id; ?>">
                            <button type="button" name="edit_product" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProductModal-<?php echo $product_id; ?>"><i class="fa-solid fa-pen"></i></button>
                        </form>
                        <form id="delete-product-form-<?php echo $product_id; ?>" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="button" class="btn btn-danger btn-sm delete-product-btn" data-product-id="<?php echo $product_id; ?>"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        endif;
    endforeach; ?>
  </div>
  <?php
else :
  echo '<p>No gift in your giftlist.</p>';
endif;

// Show edit gift popup form.
foreach ( $user_giftlist as $product_id ) :
    // Pass the product ID to the template part using an associative array
    get_template_part( 'template-parts/woo/edit-gift', null, array( 'product_id' => $product_id ) );
endforeach;
